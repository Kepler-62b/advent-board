<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AdventRepository;
use App\Service\RenderViewService;

class AdventController extends RenderViewService
{

  private AdventRepository $repository;
  public function __construct(AdventRepository $repository)
  {
    $this->repository = $repository;
  }
  public function showAll(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $pagination = $this->paginationRender($repository);
    $navigation = $this->navigationRender();
    $rows = $repository->getAllRows($page);
    return $this->contentRender("show", $rows, $pagination, $navigation);
  }
  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $row = $repository->findById($id);
    $navigation = $this->navigationRender();
    return $this->contentRender("get", $row, $navigation);
  }

  public function create(): Response
  {
    return $this->contentRender('create');
  }

  public function update(): Response
  {
    return $this->contentRender('update');
  }
}