<?php

namespace App\Service\Widgets;

use App\Service\LinkRender;

class GetFormWidget implements WidgetInterface
{
  private LinkRender $linkRender;

  public function __construct(LinkRender $linkRender)
  {
   $this->linkRender = $linkRender;
  }
  public function __toString()
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/form_get.php";
    $formGet = ob_get_clean();
    return $formGet;
  }
  public function setParams(array $params): static
  {
   return $this;
  }

  public function render(): string
  {
    $linkRender = $this->linkRender;
    ob_start();
    require "src/View/widgets/form_get.php";
    $formGet = ob_get_clean();
    return $formGet;
  }

}