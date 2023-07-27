<?php

namespace App\Controllers;

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
    $renderView = new RenderViewService();
    $rows = $repository->getAllRows($page);
    return $renderView->contentRender("show", $rows);
  }
  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $renderView = new RenderViewService();
    $row = $repository->findById($id);
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