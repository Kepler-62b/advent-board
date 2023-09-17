<?php

namespace App\Controllers;

use App\Service\HydratorService;
use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;
use App\Service\ViewRenderService;
use App\Service\NotFoundHttpException;
use App\Service\Helpers\LinkManager;

use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\Pagination;
use App\Service\Widgets\PaginationWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\SortWidget;

use App\Models\Advent;
use App\Repository\AdventRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdventController extends DefaultController
{

    private AdventRepository $repository;

    public function __construct(AdventRepository $repository)
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

        $paginationWidget = (new Pagination(['totalCount' => $repository->getCount()], ['sampleLimit' => 5]))->getTemplate();
        $navigationWidget = (new NavigationWidget())->getTemplate();
        $getFormWidget = (new GetFormWidget())->getTemplate();
        $tableWidget = (
        new TableWidget(
            ['Id', 'Item', 'Description', new SortWidget('Price', 'price'), 'Image', new SortWidget('Date', 'created_date')],
            $adverts
        )
        )->getTemplate();
        $content = new TemplateNavigator('show_widgets', 'content');
        $layout = new TemplateNavigator('main', 'layouts');

        $view = (new RenderTemplateServise([$layout, $content, $tableWidget, $paginationWidget, $getFormWidget, $navigationWidget]))->renderFromListTemplates();

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

        $navigationWidget = (new NavigationWidget())->getTemplate();
        $getFormWidget = (new GetFormWidget())->getTemplate();

        $tableWidget = (
        new TableWidget(
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => 'Price',
                'image' => 'Image',
                'created_date' => 'Date'
            ],
            $advert,
        )
        )->getTemplate();

        $content = new TemplateNavigator('get_widgets', 'content');
        $layout = new TemplateNavigator('main', 'layouts');

        $template =
            (new RenderTemplateServise([$layout, $content, $tableWidget, $getFormWidget, $navigationWidget]))
                ->renderFromListTemplates();

        // @TODO старая функциональность по отрисовке шаблонов
        // $template = (
        //   new ViewRenderService(
        //     ['content' => 'get_widgets'],
        //     ['layouts' => 'main'],
        //     [
        //     'table' => $tableWidget,
        //     'navigation' => $navigationWidget,
        //     'getForm' => $getFormWidget,
        //     ]
        //   )
        // )->contentRender();

        return (new Response($template))->send();
    }

    public function showByMin(array $param): Response
    {
        $repository = $this->repository;
        extract($param, EXTR_OVERWRITE);
        $rows = $repository->getMin($page, $filter);

        $paginationWidget = (new PaginationWidget())->render();
        $navigationWidget = (new NavigationWidget())->render();
        $getFormWidget = (new GetFormWidget())->render();

        $sortPriceWidget = (new SortWidget('Price', 'price'))->render();
        $sortDateWidget = (new SortWidget('Date', 'created_date'))->render();

        $tableWidget = new TableWidget(
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => $sortPriceWidget,
                'image' => 'Image',
                'created_date' => $sortDateWidget
            ],
            $rows,
        );

        $content = (
        new ViewRenderService(
            ['layout' => 'main'],
            ['content' => 'show_widgets'],
            [
                'table' => $tableWidget,
                'pagination' => $paginationWidget,
                'navigation' => $navigationWidget,
                'getForm' => $getFormWidget
            ]
        )
        )->contentRender();

        return (new Response($content))->send();
    }

    public function showByMax(array $param): Response
    {
        $repository = $this->repository;
        extract($param, EXTR_OVERWRITE);
        $adverts = $repository->getMax($page, $filter);

        $paginationWidget = (new PaginationWidget())->getTemplate();
        $navigationWidget = (new NavigationWidget())->getTemplate();
        $getFormWidget = (new GetFormWidget())->render();

        $tableWidget = new TableWidget(
            [
                'id' => 'Id',
                'item' => 'Item',
                'description' => 'Description',
                'price' => (new SortWidget('Price', 'price'))->render(),
                'image' => 'Image',
                'created_date' => (new SortWidget('Date', 'created_date'))->render(),
            ],
            $adverts,
        );

        $content = (
        new ViewRenderService(
            ['layout' => 'main'],
            ['content' => 'show_widgets'],
            [
                'table' => $tableWidget,
                'pagination' => $paginationWidget,
                'navigation' => $navigationWidget,
                'getForm' => $getFormWidget
            ]
        )
        )->contentRender();

        return (new Response($content))->send();
    }

    public function create_form(): Response
    {
        $navigation = (new NavigationWidget())->getTemplate();
        $content = new TemplateNavigator('create_text_only', 'content');
        $layout = new TemplateNavigator('main', 'layouts');

        $view = (new RenderTemplateServise([$layout, $content, $navigation]))->renderFromListTemplates();

        // @TODO старая функциональность по отрисовке шаблонов
        // $content = (
        //   new RenderViewService(
        //     ['layouts' => 'main'],
        //     [
        //     'content' => (
        //         new RenderViewService(
        //           ['content' => 'create_upload_file'],
        //           ['navigation' => $navigationWidget]
        //         )
        //       )
        //     ]
        //   )
        // )->renderView();

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
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        }
    }

    public function update_form(): Response
    {
        $navigation = (new NavigationWidget())->getTemplate();
        $content = new TemplateNavigator('update', 'content');
        $layout = new TemplateNavigator('main', 'layouts');

        $template = (new RenderTemplateServise([$layout, $content, $navigation]))->renderFromListTemplates();

        // @TODO старая функциональность по отрисовке шаблонов
        // $content = (
        //   new RenderViewService(
        //     ['layouts' => 'main'],
        //     [
        //     'content' => new RenderViewService(
        //         ['content' => 'update_text_only'],
        //         ['navigation' => $navigationWidget]
        //       )
        //     ]
        //   )
        // )->renderView();

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
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        } else {
            // @TODO подумать куда редиректить
            return (new RedirectResponse(LinkManager::link('/create')))->send();
        }
    }
}
