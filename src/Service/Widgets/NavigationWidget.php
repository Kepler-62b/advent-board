<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;

use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;

class NavigationWidget implements WidgetInterface
{

  public function __construct()
  {
  }

  public function __toString(): string
  {
    return (new RenderTemplateServise([$this->getTemplate()]))->render();

    // $template = $this->render();
    // return $template->renderView();
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'navigation']);
  }

  public function getTemplate(): TemplateNavigator
  {
    return new TemplateNavigator('navigation', 'widgets');
  }

}