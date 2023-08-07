<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class GetFormWidget implements WidgetInterface
{
  private LinkRender $linkRender;

  public string $widget;

  public function __construct(LinkRender $linkRender)
  {
    $this->linkRender = $linkRender;
    $this->widget = self::renderWidget();

  }

  public function renderWidget(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/form_get.php";
    $formGet = ob_get_clean();
    return $formGet;
  }

}