<?php

namespace App\Controllers;

use App\Service\LinkRender;
use App\Service\RenderViewService;
use App\Service\Widgets\NavigationWidget;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{


  public function homePage(): Response
  {
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "home_page",
      null,
      [
        'navigation' => $navigationWidget,
      ]
    );

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
    $linkRender = new LinkRender();
    $navigationWidget = (new NavigationWidget($linkRender))->widget;

    $renderView = new RenderViewService($linkRender);
    $content = $renderView->contentRender(
      "not_found",
      null,
      [
        'navigation' => $navigationWidget,
      ]
    );

    return (new Response())
      ->setContent($content)
      ->setStatusCode(Response::HTTP_NOT_FOUND)
      ->send();
  }

  public function apiRaw($data = null): Response
  {
    $data = json_encode($data);
    // var_dump($data);
    $response = new Response(
      $data,
      Response::HTTP_OK,
      ['content-type' => 'application/json']
    );
    // var_dump($response);
    return $response->send();

  }

}