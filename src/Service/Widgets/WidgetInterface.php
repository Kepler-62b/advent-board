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
   *
   * @return string
   */
  public function render();
  
}