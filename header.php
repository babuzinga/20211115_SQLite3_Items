<?php

if (!file_exists("23items.db")) { echo 'missing database'; exit; }
$db = new SQLite3("23items.db");

/**
 * 404 страница
 */
function page404() {
  http_response_code(404);
  //include('my_404.php'); // provide your own HTML for the error page
  echo '<h2>Error 404</h2>';
  die();
}

/**
 * @param array $array
 * @param bool $exit
 */
function print_array($array = array(), $exit = false) {
  echo "<pre>", print_r($array, true), "</pre>";
  if ($exit) exit();
}

/**
 * Генератор UUID v4
 * Генерирует 16 байтов (128 бит) случайных данных или используйте данные, переданные в функцию.
 *
 * Взято отсюда https://www.uuidgenerator.net/dev-corner/php
 * @param null $data
 * @return string
 * @throws Exception
 */
function guidv4($data = null) {
  $data = !empty($data) ? $data : random_bytes(16);
  assert(strlen($data) == 16);

  // Set version to 0100
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
  // Set bits 6-7 to 10
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

  // Output the 36 character UUID.
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}