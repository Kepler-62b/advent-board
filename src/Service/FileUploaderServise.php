<?php

namespace App\Service;

class FileUploaderServise
{

  private const USER_IMAGE_DIR = 'public/img/user/';


  // public function addRow($item, $description, $price, $image)
  // {
  //   $add = new Advents();

  //   if ($add->pdoCreateRow($item, $description, $price, $image)) {
  //     // return;
  //   }
  //   $this->row_id = $add->insert_id;
  // }

  public function updateImage(int $id, $image)
  {

    if ((new Advents)->pdoUpdateRow($id, $image)) {
      print 'картинка добавлена';
    }

  }

  public function add()
  {
        

    $tmpDir = $_FILES['userfile']['tmp_name'];

    $newDir = self::USER_IMAGE_DIR . basename($_FILES['userfile']['name']);
    
    // START test code block  --------------------------------------
    var_dump($tmpDir);
    var_dump($newDir);
    var_dump(is_uploaded_file($tmpDir));

    var_dump(getimagesize($tmpDir));

    
    die;
    // END test code block    --------------------------------------


    if (move_uploaded_file($tmpDir, $newDir)) {
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