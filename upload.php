<?php

include_once __DIR__ . '/header.php';

if (!empty($_FILES["images"])) {
  // https://prowebmastering.ru/sqlite3-php.html
  $db = new SQLite3("23items.db");
  $result = [];
  foreach ($_FILES["images"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
      $filename = $_FILES["images"]["name"][$key];
      $extension = mb_strtolower(substr(strrchr($filename, '.'), 1));
      $filename_new = $key.'.'.$extension;
      move_uploaded_file( $_FILES["images"]["tmp_name"][$key], "uploads/$filename_new");
      $uuid = guidv4($filename_new);
      $db->exec("INSERT OR IGNORE INTO images (uuid, name, dt) VALUES ('{$uuid}', '{$filename_new}', CURRENT_TIMESTAMP) ");
      // $db->lastInsertRowID() - получить вставленный id
      $result[$uuid] = $key;
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