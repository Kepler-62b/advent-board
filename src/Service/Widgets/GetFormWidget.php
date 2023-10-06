<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateService;
use App\Service\Template;
use App\Service\ViewRenderService;
use App\Service\RenderViewService;

class GetFormWidget implements WidgetInterface
{
    private string $templateName;

  public function __construct(string $templateName)
  {
      $this->templateName = $templateName;
  }

  public function __toString(): string
  {
   return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
  }
  public function getTemplate(): Template
  {
   return new Template($this->templateName, 'widgets');
  }

  /** @deprecated */
  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'form_get']);
  }


}