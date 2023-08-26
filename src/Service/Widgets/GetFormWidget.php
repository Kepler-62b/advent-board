<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;

class GetFormWidget implements WidgetInterface
{

  public function __construct()
  {

  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'form_get']);
  }

}