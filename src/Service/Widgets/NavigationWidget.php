<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;

use App\Service\RenderTemplateService;
use App\Service\Template;

class NavigationWidget implements WidgetInterface
{

    public function __construct()
    {
    }

    public function __toString(): string
    {
        return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
    }

    public function getTemplate(): Template
    {
        return new Template('navigation', 'widgets');
    }

    public function render(): RenderViewService
    {
        return new RenderViewService(['widgets' => 'navigation']);
    }

}