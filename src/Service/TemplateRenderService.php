<?php

namespace App\Service;

class TemplateRenderService
{
  //@TODO подумать над названием класса и методов в нем

  private string $template;
  
  private ?array $params = [];

  public function __construct(string $template, array $params = null)
  {
    $this->template = $template;
    $this->params = $params;
  }

  public function __toString(): string
  {
   return $this->contentRender();
  }

  public function contentRender(): string
  {
    $template = $this->template;
    
    if(isset($this->params)) {
      extract($this->params, EXTR_OVERWRITE);
    }
    
    ob_start();
    require "src/View/widgets/$template.php";
    $content = ob_get_clean();
    // var_dump($content);
    return $content;
  }

}