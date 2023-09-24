<?php

namespace App\Service\Widgets;

use App\Service\RenderTemplateService;
use App\Service\RenderViewService;
use App\Service\Helpers\LinkManager;
use App\Service\Template;


/** 
 * @todo может соеденить пагинацию с таблицей
 */


class Pagination implements WidgetInterface
{
  private string $divider = 'page';

  // @TODO подумать как пробрасывать пустой массив в LinkManager
  private array $filter = ['pagination'];
  private int $totalCount;
  private int $sampleLimit;

  public function __construct(array $totalCount, array $sampleLimit = ['sampleLimit' => 2])
  {
    $this->totalCount = $totalCount['totalCount'];
    $this->sampleLimit = $sampleLimit['sampleLimit'];
  }

  public function __toString()
  {
    return (new RenderTemplateService([$this->getTemplate()]))->renderFromListTemplates();
  }

  public function setDivider(string $divider): self
  {
    $this->divider = $divider;
    return $this;
  }

  public function setFilter(array $filter): self
  {
    $this->filter = $filter;
    return $this;
  }

  private function count(): float
  {
    return ceil($this->totalCount / $this->sampleLimit);
  }

  /**
   * returns an array of rendered links with each page number
   */
  private function create(): array
  {
    $pagination = [];

    for ($i = 1; $i <= $this->count(); $i++) {
      $link = "<a href=\"{link}\" class=\"{class}\">{number}</a>";
      $replace['{link}'] = LinkManager::link('/show', [$this->divider => $i], $this->filter);
      $replace['{number}'] = $i;
      $replace['{class}'] = 'btn';
      $link = strtr($link, $replace);
      $pagination[] = $link;
    }

    // for ($i = 1; $i <= $this->count(); $i++) {
    //   $link = LinkManager::link('/show', [$this->divider => $i], $this->filter);
    //   $storageLinks[] = "<a href=\"${link}\">${i}</a>";
    // }

    return ($pagination);
  }

  public function render(): RenderViewService
  {
    return new RenderViewService(
      ['widgets' => 'pagination_object'],
      [
        'pagination' => $this->create(),
      ]
    );
  }

  public function getTemplate(): Template
  {
    return new Template('pagination_object', 'widgets', ['pagination' => $this->create()]);
  }






}