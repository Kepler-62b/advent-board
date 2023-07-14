<?php

namespace App\Controllers;

use App\Models\Advent;

class AddController
{

  public $files = [];
  public $row_id;



  public function addRow($item, $description, $price, $image)
  {
    $add = new Advent();

    if ($add->pdoCreateRow($item, $description, $price, $image)) {
      // return;
    }
    $this->row_id = $add->insert_id;
  }

  public function updateImage($id, $image)
  {

    if ((new Advent)->pdoUpdateRow($id, $image)) {
      print 'картинка добавлена';
    }
  }

  public function addFile()
  {
    $temp_dir = $_FILES['userfile']['tmp_name'];
    $new_dir = "public/img/user/" . $_FILES['userfile']['name'];

    if (move_uploaded_file($temp_dir, $new_dir)) {
      return $_FILES['userfile']['name'];
    } else {
      return NULL;
    }
  }

  public function addFiles(array $files)
  {
    foreach ($files as $file) {
      // var_dump($file);
      // var_dump($file['tmp_name']);
      // var_dump($file['name']);

      $temp_dir = $file['tmp_name'];
      $new_dir = "public/img/user/" . $file['name'];


      if (move_uploaded_file($temp_dir, $new_dir)) {
        array_push($this->files, $file['name']);
      } else {
        return NULL;
      }
    }
  }
}
