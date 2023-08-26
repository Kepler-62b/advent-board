<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  /**
   * return object - rendering widgets templates
   * 
   * @todo подумать над названием
   */
  public function render(): object;

}