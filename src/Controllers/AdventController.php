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

  public function showAll(mixed $queryString): Response
  {
    $page = filter_input(INPUT_GET, 'page');
    $repository = $this->repository;
    $rows = $repository->getAllRows($page);

    $linkRender = new LinkRender();

    $navigation = new NavigationWidget($linkRender);
    $pagination = new PaginationWidget($linkRender);
    $getForm = new GetFormWidget($linkRender);

    $sort = new SortWidget($linkRender);
    $sortPrice = $sort
      ->setParams(
        [
          'columnName' => 'Price',
          'filter' => 'price'
        ]
      )->render();
    $sortDate = $sort
      ->setParams(
        [
          'columnName' => 'Date',
          'filter' => 'created_date'
        ]
      )->render();

    $table = new TableWidget($linkRender);
    $table->setParams(
      [
        'rows' => $rows,
        'columns' => [
          'id' => 'Id',
          'item' => 'Item',
          'description' => 'Description',
          'price' => $sortPrice,
          'image' => 'Image',
          'created_date' => $sortDate
        ]
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $table,
        'pagination' => $pagination,
        'navigation' => $navigation,
        'getForm' => $getForm
      ]
    );
  }

  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $row = $repository->findById($id);

    $linkRender = new LinkRender();
    $navigation = new NavigationWidget($linkRender);
    $getForm = new GetFormWidget($linkRender);

    $table = new TableWidget($linkRender);
    $table->setParams(
      [
        'rows' => $row,
        'columns' => [
          'id' => 'Id',
          'item' => 'Item',
          'description' => 'Description',
          'price' => 'Price',
          'image' => 'Image',
          'created_date' => 'Date'
        ]
      ]
    );

    $renderView = new RenderViewService();

    return $renderView->contentRender(
      "get_widgets",
      $row,
      [
        'table' => $table,
        'navigation' => $navigation,
        'getForm' => $getForm
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

    $navigation = new NavigationWidget($linkRender);
    $pagination = new PaginationWidget($linkRender);
    $getForm = new GetFormWidget($linkRender);

    $sort = new SortWidget($linkRender);
    $sortPrice = $sort
      ->setParams(
        [
          'columnName' => 'Price',
          'filter' => 'price'
        ]
      )->render();
    $sortDate = $sort
      ->setParams(
        [
          'columnName' => 'Date',
          'filter' => 'created_date'
        ]
      )->render();

    $table = new TableWidget($linkRender);
    $table->setParams(
      [
        'rows' => $rows,
        'columns' => [
          'id' => 'Id',
          'item' => 'Item',
          'description' => 'Description',
          'price' => $sortPrice,
          'image' => 'Image',
          'created_date' => $sortDate
        ]
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $table,
        'pagination' => $pagination,
        'navigation' => $navigation,
        'getForm' => $getForm
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

    $navigation = new NavigationWidget($linkRender);
    $pagination = new PaginationWidget($linkRender);
    $getForm = new GetFormWidget($linkRender);

    $sort = new SortWidget($linkRender);
    $sortPrice = $sort
      ->setParams(
        [
          'columnName' => 'Price',
          'filter' => 'price'
        ]
      )->render();
    $sortDate = $sort
      ->setParams(
        [
          'columnName' => 'Date',
          'filter' => 'created_date'
        ]
      )->render();

    $table = new TableWidget($linkRender);
    $table->setParams(
      [
        'rows' => $rows,
        'columns' => [
          'id' => 'Id',
          'item' => 'Item',
          'description' => 'Description',
          'price' => $sortPrice,
          'image' => 'Image',
          'created_date' => $sortDate
        ]
      ]
    );

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show_widgets",
      $rows,
      [
        'table' => $table,
        'pagination' => $pagination,
        'navigation' => $navigation,
        'getForm' => $getForm
      ]
    );
  }

  public function create(): Response
  {
    $link = new LinkRender();
    $navigation = new NavigationWidget($link);
    $renderView = new RenderViewService();
    return $renderView->contentRender('create', null, ['navigation' => $navigation]);
  }

  public function update(): Response
  {
    $link = new LinkRender();
    $navigation = new NavigationWidget($link);

    $renderView = new RenderViewService();
    return $renderView->contentRender('update', null, ['navigation' => $navigation]);
  }
}