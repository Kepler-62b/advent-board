<?php ob_start() ?>
<?php use App\Service\LinkManager; ?>

<h3>Navigation</h3>
<hr>

<ul>
  <li><a href='<?php LinkManager::getLink('/create'); ?>'>Create</a></li>
  <li><a href='<?php LinkManager::getLink('/update'); ?>'>Update</a></li>
  <li><a href='<?php LinkManager::getLink('/show', '?page=1'); ?>'>Show</a></li>
</ul>

<?php $widget = ob_get_clean(); ?>