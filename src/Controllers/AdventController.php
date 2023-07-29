<?php

namespace App\Controllers;

use App\Service\TableWidget;
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
    $table = new TableWidget($rows);
    $table = $table->setColumns(['id', 'item', 'description', 'price', 'image', 'created_date'])->render();

    $renderView = new RenderViewService();
    return $renderView->contentRender("show", $table, $rows);
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
    return $renderView->contentRender("show", $rows);
  }

  public function showByMax(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $rows = $repository->getMax($page, $filter);
    return $renderView->contentRender("show", $rows);
  }

  public function create(): Response
  {
    $renderView = new RenderViewService();
    return $renderView->contentRender('create');
  }

  public function update(): Response
  {
    $renderView = new RenderViewService();
    return $renderView->contentRender('update');
  }
}