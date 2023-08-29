<?php

namespace App\Controllers;

use App\Service\RenderViewService;
use App\Service\ViewRenderService;
use App\Service\Widgets\NavigationWidget;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{


  public function homePage(): Response
  {
    $navigationWidget = (new NavigationWidget())->render();

    $content = (new ViewRenderService(
      ['content' => 'home_page'],
      ['navigation' => $navigationWidget]
      ))->contentRender();

    return (new Response())
      ->setContent($content)
      ->setStatusCode(Response::HTTP_OK)
      ->send();
  }

  /**
   * @todo добавить картинку в контент страницы
   */

  public function notFound(): Response
  {
    $navigationWidget = (new NavigationWidget())->render();

    $content = (new RenderViewService(null, ['navigation' => $navigationWidget]))->contentRender('not_found');

    return (new Response())
      ->setContent($content)
      ->setStatusCode(Response::HTTP_NOT_FOUND)
      ->send();
  }

  public function apiRaw($data = null): Response
  {
    $data = json_encode($data);

    $response = new Response(
      $data,
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
    return $response->send();

  }

}