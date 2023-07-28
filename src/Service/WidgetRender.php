<?php

namespace App\Service;

class WidgetRender
{

  public static function renderWidget(string $widget): void
  {
    ob_start();
    require "src/View/widgets/$widget.php";
    $widget = ob_get_clean();
    echo $widget;
  }
}