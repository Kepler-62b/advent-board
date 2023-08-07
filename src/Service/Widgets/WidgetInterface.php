<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  // /**
  //  * @TODO подумать, как убрать
  //  * @return string
  //  */
  // public function __toString();

  /**
   * rendering widget via tamplates widgets
   * 
   * @return string
   */
  public function renderWidget();

}