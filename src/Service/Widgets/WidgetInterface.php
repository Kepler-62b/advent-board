<?php

namespace App\Service\Widgets;

interface WidgetInterface
{
  /**
   * @deprecated не использовать, удалить
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