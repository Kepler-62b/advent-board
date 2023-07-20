<?php

namespace App\Controllers;

use App\Repository\AdventRepository;
use App\Service\RenderViewService;
use Symfony\Component\HttpFoundation\Response;

class AdventController extends RenderViewService
{
  public function showAll(AdventRepository $repository): Response
  {
    $rows = $repository->getAllRows();
    return $this->contentRender("show", $rows);
   
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