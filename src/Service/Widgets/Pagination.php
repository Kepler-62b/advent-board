<?php

namespace App\Service\Widgets;

use App\Service\RenderViewService;
use App\Service\ControllerContainer;
use App\Service\Helpers\LinkManager;


/** 
 * @todo может соеденить пагинацию с таблицей
 */


class Pagination implements WidgetInterface
{
  // private array $paginationParams;
  private string $pageParam = 'page';
  private string $filterParam = '';
  private int $totalCount;
  private int $sampleLimit;
  public array $storage = [];
  public \ArrayIterator $iterator;


  public function __construct(array $totalCount, array $sampleLimit = ['sampleLimit' => 2])
  {
    $this->totalCount = $totalCount['totalCount'];
    $this->sampleLimit = $sampleLimit['sampleLimit'];
  }

  public function __toString()
  {
    $template = $this->render();
    return $template->renderView();
  }

  private function count(): int
  {
    return ceil($this->totalCount / $this->sampleLimit);
  }

  public function createLink(): \Traversable
  {

    for ($i = 1; $i <= $this->count(); $i++) {
      $link = "<a href=\"{link}\" class=\"{class}\">{number}</a>";
      $replace['{link}'] = LinkManager::link('/show', [$this->pageParam => $i], [$this->filterParam]);
      $replace['{number}'] = $i;
      $replace['{class}'] = 'btn';
      $link = strtr($link, $replace);
      $storageLinks[] = $link;
    }

    // for ($i = 1; $i <= $this->count(); $i++) {
    //   $link = LinkManager::link('/show', [$this->pageParam => $i], [$this->filterParam]);
    //   $storageLinks[] = "<a href=\"${link}\">${i}</a>";
    // }

    return new \ArrayIterator($storageLinks);

  }

  public function render(): RenderViewService
  {
    // @TODO подумать как можно использовать
    // extract($this->paginationParams);
    // var_dump(get_defined_vars());

    return new RenderViewService(['widgets' => 'pagination_object'], [
      'storage' => $this->createLink(),
    ]);
  }






}