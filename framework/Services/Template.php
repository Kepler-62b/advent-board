<?php

namespace Framework\Services;

class Template
{
    private const VIEW_PATH_MAP = [
        'layouts' => '/app/src/View/templates/layouts/',
        'content' => '/app/src/View/templates/content/',
        'content/exceptions' => '/app/src/View/templates/content/exceptions/',
        'widgets' => '/app/src/View/templates/widgets/',
    ];

    public string $templateName;
    public string $templateType;
    public string $templateDirectory;
    // @TODO убрать зависимость от конкретного расширения
    public string $templateExtension = '.php';
    public ?array $templateParams;

    /**
     * @param string $templateName
     * @param string $templateType
     * @param array<string, string|int>|null $templateParams
     */
    public function __construct(string $templateName, string $templateType, array $templateParams = null)
    {
        $this->templateName = $templateName;
        $this->templateType = $templateType;
        $this->templateDirectory = self::VIEW_PATH_MAP[$templateType];
        $this->templateParams = $templateParams;
    }
}