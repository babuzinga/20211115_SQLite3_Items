<?php

if (!file_exists("23items.db")) {
  echo json_encode([
    'result'  => "Missing database ",
    'files'   => [],
  ]);
} elseif (!empty($_FILES["images"])) {
  // https://prowebmastering.ru/sqlite3-php.html
  $db = new SQLite3("23items.db");
  $result = [];
  foreach ($_FILES["images"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
      $filename = $_FILES["images"]["name"][$key];
      $extension = substr(strrchr($filename, '.'), 1);
      $filename_new = $key.'.'.$extension;
      move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "uploads/$filename_new");
      $result[] = $key;
      $db->exec("INSERT OR IGNORE INTO images (name, dt) VALUES ('$filename_new', CURRENT_TIMESTAMP) ");
    }
  }
  $db->close();
  echo json_encode([
    'result'  => "Successfully uploaded Images",
    'files'   => $result,
  ]);
} else {
  echo json_encode([
    'result'  => "No Images",
    'files'   => [],
  ]);
}

exit;