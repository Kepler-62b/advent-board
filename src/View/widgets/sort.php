<span><?= $this->columnName; ?></span>
<a href="<?= $linkRender->getRootPath('/show/sort/min/', ['page=1',  $this->filter] ); ?>">▲</a>
<a href="<?= $linkRender->getRootPath('/show/sort/max/', ['page=1',  $this->filter]); ?>">▼</a>
<a href="<?= $linkRender->getRootPath('/show', ['page=1']); ?>">✘</a>