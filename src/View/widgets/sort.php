<span><?= $this->columnName; ?></span>
<a href="<?= $linkRender->getRootPath('/show/date/min/?page=1', $this->filter); ?>">▲</a>
<a href="<?= $linkRender->getRootPath('/show/date/max/?page=1', $this->filter); ?>">▼</a>
<a href="<?= $linkRender->getRootPath('/show', '?page=1'); ?>">✘</a>