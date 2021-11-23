<?php

include_once __DIR__ . '/header.php';

if (!empty($_POST)) {
  $item_name    = !empty($_POST['item_name'])   ? trim($db->escapeString($_POST['item_name'])) : false;
  $item_type    = !empty($_POST['item_type'])   ? $db->escapeString($_POST['item_type'] )      : false;
  $action       = !empty($_POST['action'])      ? $db->escapeString($_POST['action']  )        : false;
  $uuid         = !empty($_POST['uuid'])        ? $db->escapeString($_POST['uuid']   )         : false;
  $parent_uuid  = !empty($_POST['parent_uuid']) ? $db->escapeString($_POST['parent_uuid'])     : false;

  if (!empty($item_type) && !empty($action) && in_array($item_type, ['group', 'product'])) {
    switch ($action) {
      case 'create':
        $uuid = guidv4();
        $db->exec("
          INSERT OR IGNORE INTO {$item_type}s (uuid, group_uuid, title, dt) 
          VALUES ('{$uuid}', '{$parent_uuid}', '{$item_name}', CURRENT_TIMESTAMP)
        ");

        break;

      case 'rename':
        $db->exec("
          UPDATE {$item_type}s SET title = '{$item_name}'
          WHERE uuid = '{$uuid}'
        ");
        break;

      case 'delete':
        $db->exec("
          UPDATE {$item_type}s SET status = 1, dt = CURRENT_TIMESTAMP 
          WHERE uuid = '{$uuid}'
        ");
        break;

      default:
        break;
    }

    echo json_encode([
      'result'      => "success",
      'item_uuid'   => $uuid,
    ]);

    exit;
  }
}

echo json_encode([
  'result'  => "error",
]);

exit;