<h3>Navigation</h3>
<hr>

<ul>
  <li><a href='<?= $linkRender->getRootPath('/') ?>'>Home page</a></li>
  <ul>
    <li><a href='<?= $linkRender->getRootPath('/show', [$linkRender::DEFAULT_PARAM]) ?>'>Show</a></li>
    <li><a href='<?= $linkRender->getRootPath('/create') ?>'>Create</a></li>
    <li><a href='<?= $linkRender->getRootPath('/update') ?>'>Update</a></li>
  </ul>
</ul>