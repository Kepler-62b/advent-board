<?php

namespace App\Controllers;

class SortController
{

  public function createSort($param = null)
  {
    $filename = 'config\sort.txt';
    $resourse = fopen($filename, "w+");
    fwrite($resourse, $param, 3);
    $result = file_get_contents($filename);
    fclose($resourse);
    return $result;
  }

  public function getSort()
  {
    $filename = 'config\sort.txt';
    if (file_exists($filename)) {
      $result = file_get_contents($filename);
      return $result;
    }
  }
}
