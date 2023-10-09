<?php

namespace App\Service\Widgets;

use App\Service\ViewRenderService;
use App\Service\RenderViewService;

use App\Service\RenderTemplateService;
use App\Service\Template;

class NavigationWidget implements WidgetInterface
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

    // @TODO устанавливать templateName как в TableWidget (возможность выбора файла шаблона)
    public function getTemplate(): Template
    {
        return new Template($this->templateName, 'widgets');
    }

    /** @deprecated  */
    public function render(): RenderViewService
    {
        return new RenderViewService(['widgets' => 'navigation']);
    }

}