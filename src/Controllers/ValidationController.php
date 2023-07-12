<?php

class ValidationController
{

  private $rows = [];

  public function lessValidation($row, $characters)
  {

    if (strlen($row) <= $characters) {
      return $row;
    } else {
      header("Location: src/View/create.php");
    }
  }

  public function filtrValidation($filtr)
  {

    if ($filtr === NULL) {
      return NULL;
    }
  }

  public function imageNotFoundValidation($file) {
    if(isset($file)) {
      return "user/" . $file;
    } else {
      return "system/image_not_found.png";
    }
   
  }
}
