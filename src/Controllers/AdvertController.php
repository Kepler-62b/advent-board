<?php

namespace App\Controllers;

use App\Models\Advert;
use App\Models\ViewModels\AdvertView;
use App\Repository\AdvertRepository;
use Dev\Tests\Services\ActionParamsValidation;
use Framework\Services\Helpers\LinkManager;
use Framework\Services\HydratorService;
use Framework\Services\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AdvertController extends DefaultController
{
    private AdvertRepository $repository;

    public function __construct(AdvertRepository $repository)
    {
        $this->repository = $repository;
    }

    public function showAll(): Response
    {
        //        if ($page = filter_input(INPUT_GET, 'page')) {
        //            $adverts = $sqlRepository->findAllWithOffest($page) ?? throw new NoDBConnectionException('No database connection');
        //        } else {
        //            $adverts = $sqlRepository->findAllWithOffest(1) ?? throw new NoDBConnectionException('No database connection');
        //        }

        $sqlRepository = $this->repository;

        $page = filter_input(INPUT_GET, 'page');

        $adverts = $this->repository->find('1');
        var_dump($adverts);
        die;

        if (!empty($adverts = $sqlRepository->findAll())) {
            //            $redisRepository->mSet($adverts);
            //            $redisRepository->mSetNx($adverts);

            foreach ($adverts as $key => $model) {
                //            $redisRepository->hMSet("advert: $key", json_decode((json_encode($model)), JSON_OBJECT_AS_ARRAY));
                $redisRepository->set("adverts:$key", json_encode($model));
            }
        } else {
            $adverts = $redisRepository->findAll();
        }

        $view = (new AdvertView())->displayAll([
            'data' => $adverts,
            'count' => 27,
        ]);

        return (new Response($view))->send();
    }

    /**
     * @TODO принимать не весь массив из query string, а указанное значение в аргументе
     *
     * @throws NotFoundHttpException
     */
    public function showById(int $id): Response
    {
        // @TODO то не валидация - переделать класс
        //        $id = (int)$actionParams->validateKey('id');

        $advert = $this->repository->find($id) ?? throw new NotFoundHttpException('Not found item ID ', $id);

        $view = (new AdvertView())->displayById(['data' => $advert]);

        return (new Response($view))->send();
    }

    public function showByMin(ActionParamsValidation $actionParams): Response
    {
        $repository = $this->repository;
        //        extract($actionParams, EXTR_OVERWRITE);

        $page = $actionParams->validateKey('page');
        $filter = $actionParams->validateKey('filter');

        $adverts = $repository->getMin($page, $filter);

        $view = (new AdvertView())->displayAll([
            'data' => $adverts,
            'count' => $repository->getCount(),
        ]);

        return (new Response($view))->send();
    }

    public function showByMax(ActionParamsValidation $actionParams): Response
    {
        $repository = $this->repository;
        //        extract($actionParams, EXTR_OVERWRITE);

        $page = $actionParams->validateKey('page');
        $filter = $actionParams->validateKey('filter');
        $adverts = $repository->getMax($page, $filter);

        $view = (new AdvertView())->displayAll([
            'data' => $adverts,
            'count' => $repository->getCount(),
        ]);

        return (new Response($view))->send();
    }

    public function createForm(): Response
    {
        $view = (new AdvertView())->displayForm('c_create_form_bootstrap');

        return (new Response($view))->send();
    }

    public function createAction(): Response
    {
        $repository = $this->repository;

        $data = filter_input_array(
            INPUT_POST,
            [
                'item' => FILTER_SANITIZE_SPECIAL_CHARS,
                'description' => FILTER_SANITIZE_SPECIAL_CHARS,
                'price' => FILTER_VALIDATE_INT,
                'image' => FILTER_SANITIZE_SPECIAL_CHARS,
            ]
        );

        $hydrator = new HydratorService();
        $model = $hydrator->hydrate(Advert::class, $data);

        if ($repository->save($model)) {
            return (new RedirectResponse(LinkManager::link('/show')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        }
    }

    public function updateForm(): Response
    {
        $view = (new AdvertView())->displayForm('c_update_form_bootstrap');

        return (new Response($view))->send();
    }

    public function update_action(): Response
    {
        $repository = $this->repository;
        $data = filter_input_array(
            INPUT_POST,
            [
                'id' => FILTER_VALIDATE_INT,
                'item' => FILTER_SANITIZE_SPECIAL_CHARS,
                'description' => FILTER_SANITIZE_SPECIAL_CHARS,
                'price' => FILTER_VALIDATE_INT,
                'image' => FILTER_SANITIZE_SPECIAL_CHARS,
            ]
        );

        $model = (new HydratorService())->hydrate(Advert::class, $data);

        if ($repository->update($model)) {
            return (new RedirectResponse(LinkManager::link('/show')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/update')))->send();
        }
    }
}
