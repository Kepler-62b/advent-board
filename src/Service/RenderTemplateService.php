<?php

namespace App\Service;

class RenderTemplateService
{
    // @TODO сделать класс для всех путей и расширений
    private array $templateRenderStorage = [];
    private array $templateObjectsStorage = [];

    public function __construct(array $templateObjects)
    {
        $this->templateObjectsStorage = $templateObjects;
    }

    /** returns a string with the rendered template */
    public function renderFromListTemplates(): string
    {
        krsort($this->templateObjectsStorage, SORT_REGULAR);
        foreach ($this->templateObjectsStorage as $templateObject) {
            // @TODO разобраться с проверкой
            if ($templateObject->templateType === 'widgets') {
                $template = $templateObject->templateName;
            } else {
                $template = $templateObject->templateType;
            }

            if (!is_null($templateObject->templateParams)) {
                $scope = extract($templateObject->templateParams);
            }
            ob_start();
            require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
            $$template = ob_get_clean();
        }
        return $$template;
    }
}