<?php

namespace App\Service;

class TemplateNavigator
{
  private const VIEW_PATH_MAP = [
    'layouts' => 'src/View/templates/layouts/',
    'content' => 'src/View/templates/content/',
    'exceptions' => 'src/View/templates/exceptions/',
    'widgets' => 'src/View/templates/widgets/',
  ];

  public string $templateType;
  public string $templateName;
  public string $templateDirectory;
  public string $templateExtantion = '.php';
  public ?array $templateParams;

  public function __construct(string $templateName, string $templateDirectory, array $templateParams = null)
  {
    $this->templateType = $templateDirectory;
    $this->templateName = $templateName;
    $this->templateDirectory = self::VIEW_PATH_MAP[$templateDirectory];
    $this->templateParams = $templateParams;
  }


}