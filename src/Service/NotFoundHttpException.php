<?php

namespace App\Service;

use App\Service\RenderViewService;
use App\Service\ViewRenderService;
use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\GetFormWidget;
use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpException extends \Exception
{
  private ?string $params;

  /**
   * @TODO передавать парраметры массивом
   */
  public function __construct(string $message, string $params = null)
  {
    parent::__construct($message . ' ' . $params);
    $this->params = $params;
    $this->notFound();
  }

  /**
   * @TODO настриивать надпись в шаблоне
   */
  public function notFound(): Response
  {
    // @TODO подумать, куда это убрать (в отдельный класс с конфигами?) или устанавливать константой
    ini_set('display_errors', 'Off');

    $content = (
      new RenderViewService(
        ['layouts' => 'main'],
        [
        'content' => (
            new RenderViewService(
              ['exceptions' => 'not_found'],
              [
              'navigation' => (new NavigationWidget())->render(),
              'getForm' => (new GetFormWidget())->render(),
              'id' => $this->params,
              ]
            )
          )->renderView(),
        ],
      )
    )->renderView();

    // var_dump($content);

    return (new Response())
      ->setContent($content)
      ->setStatusCode(Response::HTTP_NOT_FOUND)
      ->send();
  }


}