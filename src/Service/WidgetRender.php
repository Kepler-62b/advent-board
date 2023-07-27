<?php

namespace App\Service;

class WidgetRender
{

  public static function renderWidget(string $widget): void
  {
    require "src/View/widgets/$widget.php";
    echo $widget;
  }
}