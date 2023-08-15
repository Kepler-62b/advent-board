<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  /**
   * rendering widget via tamplates widgets
   * 
   * @todo подумать над названием
   */
  public function render(): string;

}