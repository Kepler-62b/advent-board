<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  /**
   * return object - rendering widgets templates
   * 
   */
  public function render(): object;

}