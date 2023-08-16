<?php

namespace App\Service\Widgets;

use App\Service\TemplateRenderService;

class NavigationWidget implements WidgetInterface
{

  public function __construct()
  {
  }

  public function render(): TemplateRenderService
  {
    return new TemplateRenderService('navigation');
  }

}