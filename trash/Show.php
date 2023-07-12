<?php


function getRows() {
  $rows = pdoGetRows();
  return $rows;
}

function pagination() {
  $count=29;
  return ceil($count/10);
}
