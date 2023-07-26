<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\AdventRepository;
use App\Service\RenderViewService;

use App\Service\LinkManager;

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
    $renderView = new RenderViewService();
    $rows = $repository->getAllRows($page);
    $pagination = $renderView->paginationRender($repository);
    $navigation = $renderView->navigationRender();
    return $renderView->contentRender("show", $rows, $pagination, $navigation);
  }
  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $row = $repository->findById($id);
    $navigation = $renderView->navigationRender();
    return $renderView->contentRender("get", $row, $navigation);
  }

  public function showByMin(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $rows = $repository->getMin($page, $filter);
    $pagination = $renderView->paginationRender($repository);
    $navigation = $renderView->navigationRender();

    return $renderView->contentRender("show", $rows, $pagination, $navigation);
  }

  public function showByMax(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $rows = $repository->getMax($page, $filter);
    $pagination = $renderView->paginationRender($repository);
    $navigation = $renderView->navigationRender();

    return $renderView->contentRender("show", $rows, $pagination, $navigation);
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