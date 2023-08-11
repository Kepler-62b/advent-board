<?php

namespace App\Controllers;

use App\Service\LinkRender;

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
   * 
   * @return Response
   */
  public function showAll(): Response
  {
    $repository = $this->repository;
    if ($page = filter_input(INPUT_GET, 'page')) {
      $rows = $repository->getAllRows($page);
    } else {
      $rows = $repository->getAllRows();
    }
    // $page = filter_input(INPUT_GET, 'page');
    // $rows = $repository->getAllRows($page);

    $linkRender = new LinkRender();

    $paginationWidget = (new PaginationWidget($linkRender))->widget;
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $getFormWidget = (new GetFormWidget($linkRender))->widget;

    // $sortPriceWidget = (new SortWidget($linkRender, 'Price', 'price'))->widget;
    // $sortDateWidget = (new SortWidget($linkRender, 'Date', 'created_date'))->widget;

    $tableWidget = new TableWidget(
      $linkRender,
      $rows,
      [
        'id' => 'Id',
        'item' => 'Item',
        'description' => 'Description',
        'price' => (new SortWidget($linkRender, 'Price', 'price'))->widget,
        'image' => 'Image',
        'created_date' => (new SortWidget($linkRender, 'Date', 'created_date'))->widget
      ],
      ['image']
    );

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "show_widgets",
      null,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );

    return (new Response($content))->send();
  }

  /**
   * @todo метод занимается валидацией входящих данных - подумать, куда ее убрать
   */
  public function showById(array $id): Response
  {
    // $id = filter_input(INPUT_GET, 'id');
    $id = $id['id'];
    $repository = $this->repository;
    $row = $repository->findById($id);

    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $getFormWidget = (new GetFormWidget($linkRender))->widget;

    $tableWidget = new TableWidget(
      $linkRender,
      $row,
      [
        'id' => 'Id',
        'item' => 'Item',
        'description' => 'Description',
        'price' => 'Price',
        'image' => 'Image',
        'created_date' => 'Date'
      ],
      ['image']
    );

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "get_widgets",
      null,
      [
        'table' => $tableWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );
    return (new Response($content))->send();
  }

  public function showByMin(array $param): Response
  {
    $repository = $this->repository;
    extract($param, EXTR_OVERWRITE);
    $rows = $repository->getMin($page, $filter);

    $linkRender = new LinkRender();

    $paginationWidget = (new PaginationWidget($linkRender))->widget;
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $getFormWidget = (new GetFormWidget($linkRender))->widget;

    $sortPriceWidget = (new SortWidget($linkRender, 'Price', 'price'))->widget;
    $sortDateWidget = (new SortWidget($linkRender, 'Date', 'created_date'))->widget;

    $tableWidget = new TableWidget(
      $linkRender,
      $rows,
      [
        'id' => 'Id',
        'item' => 'Item',
        'description' => 'Description',
        'price' => $sortPriceWidget,
        'image' => 'Image',
        'created_date' => $sortDateWidget
      ],
      ['image']
    );

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "show_widgets",
      null,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );

    return (new Response($content))->send();

  }

  public function showByMax(array $param): Response
  {
    $repository = $this->repository;
    extract($param, EXTR_OVERWRITE);
    $rows = $repository->getMax($page, $filter);

    $linkRender = new LinkRender();

    $paginationWidget = (new PaginationWidget($linkRender))->widget;
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $getFormWidget = (new GetFormWidget($linkRender))->widget;

    $sortPriceWidget = (new SortWidget($linkRender, 'Price', 'price'))->widget;
    $sortDateWidget = (new SortWidget($linkRender, 'Date', 'created_date'))->widget;

    $tableWidget = new TableWidget(
      $linkRender,
      $rows,
      [
        'id' => 'Id',
        'item' => 'Item',
        'description' => 'Description',
        'price' => $sortPriceWidget,
        'image' => 'Image',
        'created_date' => $sortDateWidget
      ],
      ['image']
    );

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "show_widgets",
      null,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );

    return (new Response($content))->send();
  }

  public function create(): Response
  {
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender('create', null, ['navigation' => $navigationWidget]);
    return (new Response($content))->send();

  }

  public function update(): Response
  {
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender('update', null, ['navigation' => $navigationWidget]);
    return (new Response($content))->send();
  }
}