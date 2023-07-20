<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Repository\AdventRepository;
use App\Service\RenderViewService;

class AdventController extends RenderViewService
{
  public function showAll(AdventRepository $repository): Response
  {
    $pagination = $this->paginationRender($repository);
    $navigation = $this->navigationRender();
    $rows = $repository->getAllRows();
    return $this->contentRender("show", $rows, $pagination, $navigation);
  }
  public function showById(AdventRepository $repository, int $id): Response
  {
    $row = $repository->findById($id);
    return $this->contentRender("get", $row);
  }

  public function create(): Response
  {
   return $this->contentRender('create');
  }
}