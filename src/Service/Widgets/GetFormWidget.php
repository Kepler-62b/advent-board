<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class GetFormWidget implements WidgetInterface
{
  private LinkRender $linkRender;

  public function __construct(LinkRender $linkRender)
  {
   $this->linkRender = $linkRender;
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/form_get.php";
    $navigation = ob_get_clean();
    return $navigation;
  }

}