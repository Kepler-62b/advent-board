<?php

class ShowController
{

  // public function __construct($table)
  // {
  //   $this->table = $table;
  // }

  public function showRows()
  {
    return (new PDOLocal('php_advent_board'))->pdoGetRows();
  }

  public function showRow($id)
  {
    return (new PDOLocal('php_advent_board'))->pdoGetRow($id);
  }

  public function showSortRow($sort, $page)
  {
    return (new PDOLocal('php_advent_board'))->pdoSortRow($sort, $page);
  }
}
