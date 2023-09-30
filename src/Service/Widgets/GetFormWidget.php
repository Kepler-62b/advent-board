<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateService;
use App\Service\Template;
use App\Service\ViewRenderService;
use App\Service\RenderViewService;

class GetFormWidget implements WidgetInterface
{

  public function __construct()
  {
    // empty
  }

  public function __toString(): string
  {
   return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'form_get']);
  }

  public function getTemplate(): Template
  {
   return new Template('getForm', 'widgets');
  }

}