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

class AdventController
{

  private AdventRepository $repository;
  public function __construct(AdventRepository $repository)
  {
    $this->repository = $repository;
  }

  public function showAll(array $queryString): Response
  {
    $page = filter_input(INPUT_GET, 'page');
    $repository = $this->repository;
    $rows = $repository->getAllRows($page);

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
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );
  }

  public function showById(array $queryString): Response
  {
    $id = filter_input(INPUT_GET, 'id');
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
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "get_widgets",
      $row,
      [
        'table' => $tableWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );
  }

  public function showByMin(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
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
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );
  }

  public function showByMax(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
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
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $tableWidget,
        'pagination' => $paginationWidget,
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget
      ]
    );
  }

  public function create(): Response
  {
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;
    $renderView = new RenderViewService();
    return $renderView->contentRender('create', null, ['navigation' => $navigationWidget]);
  }

  public function update(): Response
  {
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;

    $renderView = new RenderViewService();
    return $renderView->contentRender('update', null, ['navigation' => $navigationWidget]);
  }
}