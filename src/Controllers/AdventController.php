<?php

namespace App\Controllers;

use App\Service\NotFoundHttpException;
use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\PaginationWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\SortWidget;

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
      $rows = $repository->getAllRows($page);
    } else {
      $rows = $repository->getAllRows();
    }

    $paginationWidget = new PaginationWidget();
    $navigationWidget = (new NavigationWidget())->render();

    $getFormWidget = (new GetFormWidget())->render();

    $tableWidget = new TableWidget(
      [
        'id' => 'Id',
        // @TODO сделать по примеру
        // 'id' => fn(Advent $advent): int => $advent->getId(),
        'item' => 'Item',
        'description' => 'Description',
        'price' => new SortWidget('Price', 'price'),
        'image' => 'Image',
        'created_date' => new SortWidget('Date', 'created_date'),
      ],
      $rows,
      ['image']
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

    return (new Response($content))
      ->send();
  }

  /**
   * @todo принимать не весь массив из query string, а указанное значение в аргументе 
   */
  public function showById(array $actionParams = null, $interface = null): Response
  {
    $id = $actionParams['id'];
    $repository = $this->repository;

    (empty($repository->findById($id))) ? throw new NotFoundHttpException('Not found item ID ', $id) : $row = $repository->findById($id);

    // @TODO сделать страницу 404
    // $row = $repository->findById($id) ?? throw new NotFoundHttpException(); 

    if (isset($interface)) {
      return self::apiRaw($row);
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
      new RenderViewService(
      $row,
        [
        'table' => $tableWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
        ]
      )
    )->contentRender('get_widgets');

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

  public function create(): Response
  {
    $navigationWidget = (new NavigationWidget())->render();
    $renderView = new RenderViewService(null, ['navigation' => $navigationWidget]);
    $content = $renderView->contentRender('create');
    return (new Response($content))->send();
  }

  public function update(): Response
  {
    $navigationWidget = (new NavigationWidget())->render();
    $renderView = new RenderViewService(null, ['navigation' => $navigationWidget]);
    $content = $renderView->contentRender('update');
    return (new Response($content))->send();
  }
}