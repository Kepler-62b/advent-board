<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  /**
   *
   * @return static
   */
  public function setParams(array $params);

  /**
   * 
   * @return string
   */
  public function __toString();

  /**
   * rendering widget tamplates
   * 
   * @return string
   */
  public function render();

}