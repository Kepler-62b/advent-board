<?php

namespace App\Controllers;

use App\Service\HydratorService;
use App\Service\Relation;
use App\Service\RenderTemplateService;
use App\Service\Template;
use App\Service\ViewRenderService;
use App\Service\NotFoundHttpException;
use App\Service\Helpers\LinkManager;

use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\PaginationWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\SortWidget;

use App\Models\Advent;
use App\Repository\AdvertRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            $adverts = $repository->fetchAll($page);
        } else {
            $adverts = $repository->fetchAll();
        }

        $paginationWidget = (new PaginationWidget('pagination_object', ['totalCount' => $repository->getCount()], ['sampleLimit' => 10]))->getTemplate();
        $navigationWidget = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();
        $tableWidget = (new TableWidget(
            'table_adverts_dashboard_bootstrap',
            [
                'Id',
                'Item',
                'Description',
                new SortWidget('sort_dashboard_bootstrap', 'Price', 'price'),
                'Image',
                new SortWidget('sort_dashboard_bootstrap', 'Created', 'created_date')
            ],
            ['adverts' => $adverts]
        ))->getTemplate();
        $content = new Template('show_adverts_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $view = (new RenderTemplateService(
            [
                $layout, $content, $tableWidget, $paginationWidget, $getFormWidget, $navigationWidget
            ]
        ))->renderFromListTemplates();

        return (new Response($view))->send();
    }

    /**
     * @TODO принимать не весь массив из query string, а указанное значение в аргументе
     * @throws NotFoundHttpException
     */
    public function showById(array $actionParams = null, $interface = null): Response
    {
        $id = $actionParams['id'];
        $repository = $this->repository;

        $advert = $repository->findById($id) ?? throw new NotFoundHttpException('Not found item ID ', $id);

        if (isset($interface)) {
            return $this->apiRaw($advert);
        }

        $navigationWidget = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();

        $tableWidget = (
        new TableWidget(
            'table_adverts_dashboard_bootstrap',
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => 'Price',
                'image' => 'Image',
                'created_date' => 'Date'
            ],
            ['adverts' => $advert],
        ))->getTemplate();

        $content = new Template('get_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $template =
            (new RenderTemplateService([$layout, $content, $tableWidget, $getFormWidget, $navigationWidget]))
                ->renderFromListTemplates();

        return (new Response($template))->send();
    }

    public function showByMin(array $param): Response
    {
        $repository = $this->repository;
        extract($param, EXTR_OVERWRITE);
        $adverts = $repository->getMin($page, $filter);

        $paginationWidget = (new PaginationWidget('pagination_object', ['totalCount' => $repository->getCount()], ['sampleLimit' => 10]))->getTemplate();
        $navigationWidget = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();

        $sortPriceWidget = new SortWidget('sort_dashboard_bootstrap', 'Price', 'price');
        $sortDateWidget = new SortWidget('sort_dashboard_bootstrap', 'Created', 'created_date');

        $tableWidget = (new TableWidget(
            'table_adverts_dashboard_bootstrap',
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => $sortPriceWidget,
                'image' => 'Image',
                'created_date' => $sortDateWidget
            ],
            ['adverts' => $adverts],
        ))->getTemplate();
        $content = new Template('show_adverts_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $view = (new RenderTemplateService(
            [
                $layout, $content, $tableWidget, $paginationWidget, $getFormWidget, $navigationWidget
            ]
        ))->renderFromListTemplates();

        return (new Response($view))->send();
    }

    public function showByMax(array $param): Response
    {
        $repository = $this->repository;
        extract($param, EXTR_OVERWRITE);
        $adverts = $repository->getMax($page, $filter);

        $paginationWidget = (new PaginationWidget('pagination_object', ['totalCount' => $repository->getCount()], ['sampleLimit' => 10]))->getTemplate();
        $navigationWidget = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();

        $tableWidget = (new TableWidget(
            'table_adverts_dashboard_bootstrap',
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => (new SortWidget('sort_dashboard_bootstrap', 'Price', 'price')),
                'image' => 'Image',
                'created_date' => (new SortWidget('sort_dashboard_bootstrap', 'Created', 'created_date')),
            ],
            ['adverts' => $adverts],
        ))->getTemplate();
        $content = new Template('show_adverts_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $view = (new RenderTemplateService(
            [
                $layout, $content, $tableWidget, $paginationWidget, $getFormWidget, $navigationWidget
            ]
        ))->renderFromListTemplates();

        return (new Response($view))->send();
    }

    public function create_form(): Response
    {
        $navigation = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $formGet = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();
        $content = new Template('create_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $view = (new RenderTemplateService([$layout, $content, $formGet, $navigation]))->renderFromListTemplates();

        return (new Response($view))->send();
    }

    public function create_action(): Response
    {
        // $request = Request::createFromGlobals();
        // $files = $request->files;
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
        $model = $hydrator->hydrate(Advent::class, $data);

        if ($repository->save($model)) {
            return (new RedirectResponse(LinkManager::link('/show')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        }
    }

    public function update_form(): Response
    {
        $navigation = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $formGet = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();
        $content = new Template('update_dashboard_bootstrap', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $template = (new RenderTemplateService([$layout, $content, $formGet, $navigation]))->renderFromListTemplates();

        return (new Response($template))->send();
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

        $model = (new HydratorService())->hydrate(Advent::class, $data);

        if ($repository->update($model)) {
            return (new RedirectResponse(LinkManager::link('/show')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/update')))->send();
        }
    }

    public function notFound(): Response
    {
        $navigationWidget = new Template('navigation_dashboard_bootstrap', 'widgets');
        $content = new Template('not_found_page_advert_controller', 'content', ['navigation']);
        $layout = new Template('main_dashboard_bootstrap', 'layouts', ['content']);
        $view = (new RenderTemplateService([$layout, $content, $navigationWidget]))->renderFromListTemplates();

        return (new Response())
            ->setContent($view)
            ->setStatusCode(Response::HTTP_NOT_FOUND)
            ->send();
    }
}
