<?php

namespace App\Service\Widgets;

use App\Service\TemplateRenderService;

class GetFormWidget implements WidgetInterface
{

  public function __construct()
  {

  }

  public function render(): TemplateRenderService
  {
    return new TemplateRenderService('form_get');
  }

}