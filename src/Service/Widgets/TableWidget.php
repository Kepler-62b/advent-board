<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateService;
use App\Service\Template;
use App\Service\ViewRenderService;

class TableWidget implements WidgetInterface
{
    private array $columnNames = [];
    private object|array $data;
    private ?array $linkImages = [];

    /**
     * @todo убрать из зависимостей LinkRender
     */
    public function __construct(array $columnNames, object|array $data = null, array $linkImages = null)
    {
        $this->columnNames = $columnNames;
        $this->data = $data;
        $this->linkImages = $linkImages;
    }

    public function __toString(): string
    {
        return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
    }

    public function getTemplate(): Template
    {
        return new Template('table_array_objects', 'widgets',
            [
                'columnNames' => $this->columnNames,
                'adverts' => $this->data
            ]);
    }

    /** @deprecated */
    public function render(): ViewRenderService
    {
        return new ViewRenderService(
            ['widgets' => 'table_array_objects'],
            null,
            [
                'columnNames' => $this->columnNames,
                'adverts' => $this->data,
                'linkImages' => $this->linkImages,
            ]
        );

    }


}