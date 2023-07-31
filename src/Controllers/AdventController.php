<?php

namespace App\Controllers;

use App\Service\LinkRender;
use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\PaginationWidget;
use App\Service\Widgets\TableWidget;
use App\Service\Widgets\NavigationWidget;
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

  public function showAll(mixed $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $rows = $repository->getAllRows($page);

    $link = new LinkRender();
    $navigation = new NavigationWidget($link);
    $pagination = new PaginationWidget($link);
    $getForm = new GetFormWidget($link);
    $table = (new TableWidget($rows))
      ->setColumns(['id', 'item', 'description', 'price', 'image', 'created_date']);

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show",
      $rows,
      [
        'pagination' => $pagination,
        'navigation' => $navigation,
        'table' => $table,
        'getForm' => $getForm
      ]
    );
  }
  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $row = $repository->findById($id);
    var_dump($row);
    $renderView = new RenderViewService();
    return $renderView->contentRender("get", $row);
  }

  public function showByMin(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $rows = $repository->getMin($page, $filter);

    $link = new LinkRender();
    $navigation = new NavigationWidget($link);
    $pagination = new PaginationWidget($link);
    $getForm = new GetFormWidget($link);

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show",
      $rows,
      [
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

    $link = new LinkRender();
    $navigation = new NavigationWidget($link);
    $pagination = new PaginationWidget($link);
    $getForm = new GetFormWidget($link);

    $renderView = new RenderViewService();
    return $renderView->contentRender(
      "show",
      $rows,
      [
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
    return $renderView->contentRender('create', ['navigation' => $navigation]);
  }

  public function update(): Response
  {
    $link = new LinkRender();
    $navigation = new NavigationWidget($link);

    $renderView = new RenderViewService();
    return $renderView->contentRender('update', ['navigation' => $navigation]);
  }
}