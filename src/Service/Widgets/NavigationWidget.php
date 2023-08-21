<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;

class NavigationWidget implements WidgetInterface
{

  public function __construct()
  {
  }

  public function __toString(): string
  {
    $template = $this->render();
    return $template->renderView();
  }

  // public function render(): ViewRenderService
  // {
  //   return new ViewRenderService(['widgets' => 'navigation']);
  // }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'navigation']);
  }

}