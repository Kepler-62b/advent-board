<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\AdventRepository;
use App\Service\RenderViewService;

use App\Service\LinkManager;

class AdventController extends RenderViewService
{

  private AdventRepository $repository;
  public function __construct(AdventRepository $repository)
  {
    $this->repository = $repository;
  }

  public function showAll(array $param): Response
  {
    $request = Request::createFromGlobals();
    // не инициализировать объект LinkManager, а передать зависимостью
    $linkManager = new LinkManager($request);
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $pagination = $this->paginationRender($repository, $linkManager);
    $navigation = $this->navigationRender($linkManager);
    $rows = $repository->getAllRows($page);
    return $this->contentRender($linkManager, "show", $rows, $pagination, $navigation);
  }
  public function showById(array $param): Response
  {
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $row = $repository->findById($id);
    $navigation = $this->navigationRender();
    return $this->contentRender("get", $row, $navigation);
  }

  public function showByMin(array $param): Response
  {
    $request = Request::createFromGlobals();
    $linkManager = new LinkManager($request);
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $rows = $repository->getMin($page, $filter);
    $pagination = $this->paginationRender($repository, $linkManager);
    $navigation = $this->navigationRender($linkManager);

    return $this->contentRender($linkManager, "show", $rows, $pagination, $navigation);
  }

  public function showByMax(array $param): Response
  {
    $request = Request::createFromGlobals();
    $linkManager = new LinkManager($request);
    extract($param, EXTR_OVERWRITE);
    $repository = $this->repository;
    $rows = $repository->getMax($page, $filter);
    $pagination = $this->paginationRender($repository, $linkManager);
    $navigation = $this->navigationRender($linkManager);

    return $this->contentRender($linkManager, "show", $rows, $pagination, $navigation);
  }

  public function create(): Response
  {
    $request = Request::createFromGlobals();
    $linkManager = new LinkManager($request);

    return $this->contentRender($linkManager, 'create');
  }

  public function update(): Response
  {
    $request = Request::createFromGlobals();
    $linkManager = new LinkManager($request);

    return $this->contentRender($linkManager, 'update');
  }
}