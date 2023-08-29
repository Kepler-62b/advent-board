<?php

namespace App\Controllers;

use Advents;
use App\Models\Advent;
use App\Models\AdventHydrate;
use App\Service\HydratorService;
use App\Service\ViewRenderService;
use App\Service\NotFoundHttpException;
use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\Pagination;
use App\Service\Widgets\PaginationWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\SortWidget;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\AdventRepository;
use App\Service\RenderViewService;

class AdventController extends DefaultController
{

  private AdventRepository $repository;
  public function __construct(AdventRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @todo метод занимается валидацией входящих данных - подумать, куда ее убрать
   */
  public function showAll(): Response
  {
    $repository = $this->repository;
    if ($page = filter_input(INPUT_GET, 'page')) {
      $data = $repository->fetchAll($page);
    } else {
      $data = $repository->fetchAll();
    }


    $pagination = (new Pagination(['totalCount' => $repository->getCount()], ['sampleLimit' => 5]))->render();

    $navigationWidget = (new NavigationWidget())->render();
    $getFormWidget = (new GetFormWidget())->render();
    $tableWidget = new TableWidget(
      ['Id', 'Item', 'Description', (new SortWidget('Price', 'price')), 'Image', (new SortWidget('Date', 'created_date'))],
      $data
    );

    $content = (
      new ViewRenderService(
        ['content' => 'show_widgets'],
        ['layouts' => 'main'],
        [
        'table' => $tableWidget,
        'pagination' => $pagination,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
        ]
      )
    )->contentRender();

    return (new Response($content))
      ->send();
  }

  /**
   * @todo принимать не весь массив из query string, а указанное значение в аргументе 
   */
  public function showById(array $actionParams = null, $interface = null): Response
  {
    // var_dump($actionParams);
    $id = $actionParams['id'];
    $repository = $this->repository;

    // @TODO сделать страницу 404
    $row = $repository->findById($id) ?? throw new NotFoundHttpException('Not found item ID ', $id);
    var_dump($row);
    if (isset($interface)) {
      return $this->apiRaw($row);
    }

    $navigationWidget = (new NavigationWidget())->render();
    $getFormWidget = (new GetFormWidget())->render();

    $tableWidget = new TableWidget(
      [
        'id' => 'Id',
        'item' => 'Item',
        'description' => 'Description',
        'price' => 'Price',
        'image' => 'Image',
        'created_date' => 'Date'
      ],
      $row,
    );

    $content = (
      new ViewRenderService(
        ['content' => 'get_widgets'],
        ['layouts' => 'main'],
        [
        'table' => $tableWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget,
        ]
      )
    )->contentRender();

    return (new Response($content))->send();
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
      new RenderViewService(
      null,
        [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
        ]
      )
    )->contentRender('show_widgets');

    return (new Response($content))->send();

  }

  public function showByMax(array $param): Response
  {
    $repository = $this->repository;
    extract($param, EXTR_OVERWRITE);
    $rows = $repository->getMax($page, $filter);

    $paginationWidget = (new PaginationWidget())->render();
    $navigationWidget = (new NavigationWidget())->render();
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
      $rows,
    );

    $content = (
      new RenderViewService(
      null,
        [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
        ]
      )
    )->contentRender('show_widgets');

    return (new Response($content))->send();
  }

  public function create_form(): Response
  {

    $navigationWidget = (new NavigationWidget())->render();

    $content = (
      new RenderViewService(
        ['layouts' => 'main'],
        [
        'content' => (
            new RenderViewService(
              ['content' => 'create_text'],
              ['navigation' => $navigationWidget]
            )
          )
        ]
      )
    )->renderView();

    return (new Response($content))->send();
  }

  public function create_action()
  {
    // $request = Request::createFromGlobals();
    // $files = $request->files;

    $post = filter_input_array(INPUT_POST);
    var_dump($post);
    $model = new AdventHydrate($post['item'], $post['description'], $post['price'], 'default.jpeg');
    var_dump($model);
    $hydrator = new HydratorService($model);
    
    
    // var_dump($hydrator->extract());
    $hydrator->hydrate($post, $model);
    


    // var_dump($repository->save($model));

    // return (new Response('hello'))->send();

  }

  public function update(): Response
  {
    $navigationWidget = (new NavigationWidget())->render();

    $content = (
      new RenderViewService(
        ['layouts' => 'main'],
        [
        'content' => new RenderViewService(
            ['content' => 'update'],
            ['navigation' => $navigationWidget]
          )
        ]
      )
    )->renderView();

    return (new Response($content))->send();
  }
}