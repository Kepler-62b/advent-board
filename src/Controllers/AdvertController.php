<?php

namespace App\Controllers;

use App\Models\Advert;
use App\Models\ViewModels\AdvertView;
use Dev\Service\ActionParamsValidation;
use App\Repository\AdvertRepository;
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

    /**
     * @TODO метод занимается валидацией входящих данных - подумать, куда ее убрать
     */
    public function showAll(): Response
    {
        $repository = $this->repository;

        if ($page = filter_input(INPUT_GET, 'page')) {
            $adverts = $repository->selectAllWithOffset($page);
        } else {
            $adverts = $repository->selectAllWithOffset();
        }

        $view = (new AdvertView())->displayAll([
            'data' => $adverts,
            'count' => $repository->getCount()
        ]);

        return (new Response($view))->send();
    }

    /**
     * @TODO принимать не весь массив из query string, а указанное значение в аргументе
     * @param ActionParamsValidation $actionParams
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

    /**
     * @param ActionParamsValidation $actionParams
     */
    public function showByMin(ActionParamsValidation $actionParams): Response
    {
        $repository = $this->repository;
//        extract($actionParams, EXTR_OVERWRITE);

        $page = $actionParams->validateKey('page');
        $filter = $actionParams->validateKey('filter');

        $adverts = $repository->getMin($page, $filter);

        $view = (new AdvertView())->displayAll([
            'data' => $adverts,
            'count' => $repository->getCount()
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
            'count' => $repository->getCount()
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
