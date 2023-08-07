<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class NavigationWidget implements WidgetInterface
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
    require "src/View/widgets/navigation.php";
    $navigation = ob_get_clean();
    return $navigation;
  }

}