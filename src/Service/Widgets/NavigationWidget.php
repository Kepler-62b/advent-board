<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;
use Dev\Tests\TemplateNavigation;

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

  public function render(): RenderViewService
  {
    return new RenderViewService(['widgets' => 'navigation']);
  }

  public function renderFromObject(): TemplateNavigation
  {
    return new TemplateNavigation('navigation', 'widgets');
  }

}