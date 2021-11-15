<?php

foreach ($_FILES["images"]["error"] as $key => $error) {
  if ($error == UPLOAD_ERR_OK) {
    $name = $_FILES["images"]["name"][$key];
    $filename = $_FILES['images']['name'][$key];
    $extension = substr(strrchr($filename,'.'), 1);
    move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "uploads/" . $key . "." . $extension);
  }
}

echo "Successfully Uploaded Images";