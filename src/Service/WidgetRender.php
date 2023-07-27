<?php

namespace App\Service;
// use App\Repository\AdventRepository;

class WidgetRender
{

  public static function renderWidget(string $widget): void
  {
    require "src/View/widgets/$widget.php";
    echo $widget;
  }
}