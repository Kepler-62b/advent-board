<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateService;
use App\Service\Template;
use App\Service\ViewRenderService;

class TableWidget implements WidgetInterface
{
    private string $templateName;
    private array $columnNames = [];
    private object|array $data;
    private ?array $linkImages = [];

    /**
     * @todo убрать из зависимостей LinkRender
     */
    public function __construct(string $templateName, array $columnNames, object|array $data = null, array $linkImages = null)
    {
        $this->templateName = $templateName;
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
        $dataName = key($this->data);
//        var_dump($this->data[$dataName]);
        return new Template($this->templateName, 'widgets',
            [
                'columnNames' => $this->columnNames,
                $dataName => $this->data[$dataName],
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