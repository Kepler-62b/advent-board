<?php use App\Service\LinkManager; ?>

<h3>Navigation</h3>
<hr>

<ul>
  <li><a href='<?php LinkManager::getBasePath('/create'); ?>'>Create</a></li>
  <li><a href='<?php LinkManager::getBasePath('/update'); ?>'>Update</a></li>
  <li><a href='<?php LinkManager::getBasePath('/show', '?page=1'); ?>'>Show</a></li>
</ul>