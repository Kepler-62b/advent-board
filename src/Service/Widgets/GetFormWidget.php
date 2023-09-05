<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;
use App\Service\ViewRenderService;
use App\Service\RenderViewService;

class GetFormWidget implements WidgetInterface
{

  public function __construct()
  {

  }

  public function __toString(): string
  {
   return (new RenderTemplateServise([$this->getTemplate()]))->render();
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'form_get']);
  }

  public function getTemplate(): TemplateNavigator
  {
   return new TemplateNavigator('getForm', 'widgets');
  }

}