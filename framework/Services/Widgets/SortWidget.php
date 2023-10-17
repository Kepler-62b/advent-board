<?php

namespace Framework\Services\Widgets;

use Framework\Services\RenderTemplateService;
use Framework\Services\RenderViewService;
use Framework\Services\Template;

class SortWidget implements WidgetInterface
{
    private string $templateName;
    private string $columnName;
    private string $filter;

    public function __construct(string $templateName, string $columnName, string $filter)
    {
        $this->templateName = $templateName;
        $this->columnName = $columnName;
        $this->filter = $filter;
    }

    public function __toString(): string
    {
        return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
    }

    public function getTemplate()
    {
        return new Template($this->templateName, 'widgets', ['columnName' => $this->columnName, 'filter' => $this->filter]);
    }

    /** @deprecated */
    public function render(): RenderViewService
    {
        // @TODO  возвращать объект Template с названием шаблона и передавать его в Render
        return new RenderViewService(['widgets' => 'sort'], [
            'columnName' => $this->columnName,
            'filter' => $this->filter
        ]);
    }


}