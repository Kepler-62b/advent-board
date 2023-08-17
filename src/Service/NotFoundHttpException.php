<?php

namespace App\Service;

use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\GetFormWidget;
use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpException extends \Exception
{
  private ?string $params;

  /**
   * @TODO передавать массив параметров
   */
  public function __construct(string $message, string $params = null)
  {
    parent::__construct($message . ' ' . $params);
    $this->params = $params;
    $this->notFoundPage();
  }

  /**
   * @TODO настриивать надпись в шаблоне
   */
  public function notFoundPage(): Response
  {
    // @TODO подумать, куда это убрать (в отдельный класс с конфигами?)
    ini_set('display_errors', 'Off');

    $navigationWidget = (new NavigationWidget())->render();
    $getFormWidget = (new GetFormWidget())->render();

    $content = (new RenderViewService(
        [
        'navigation' => $navigationWidget,
        'getForm' => $getFormWidget,
        'id' => $this->params,
        ]
      )
    )->exceptionContent('not_found');

    return (new Response())
      ->setContent($content)
      ->setStatusCode(Response::HTTP_NOT_FOUND)
      ->send();
  }


}