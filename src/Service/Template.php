<?php

namespace App\Service;

class Template
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

  public function __construct(string $templateName, string $templateType, array $templateParams = null)
  {
    $this->templateType = $templateType;
    $this->templateName = $templateName;
    $this->templateDirectory = self::VIEW_PATH_MAP[$templateType];
    $this->templateParams = $templateParams;
  }


}