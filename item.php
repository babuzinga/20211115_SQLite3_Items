<?php

include_once __DIR__ . '/header.php';

if (!empty($_POST)) {
  $item_name    = !empty($_POST['item_name'])   ? trim($_POST['item_name']) : false;
  $item_type    = !empty($_POST['item_type'])   ? $_POST['item_type']       : false;
  $action       = !empty($_POST['action'])      ? $_POST['action']          : false;
  $parent_uuid  = !empty($_POST['parent_uuid']) ? $_POST['parent_uuid']     : false;

  if (!empty($item_name) && !empty($item_type) && !empty($action) && in_array($item_type, ['group', 'product'])) {
    switch ($action) {
      case 'create':
        $uuid = guidv4();
        $item_name = $db->escapeString($item_name);
        $parent_uuid = $db->escapeString($parent_uuid);
        if ($item_type == 'group')
          $db->exec("
            INSERT OR IGNORE INTO {$item_type}s (uuid, title, dt) 
            VALUES ('{$uuid}', '{$item_name}', CURRENT_TIMESTAMP)
          ");
        else
          $db->exec("
            INSERT OR IGNORE INTO {$item_type}s (uuid, group_uuid, title, dt) 
            VALUES ('{$uuid}', '{$parent_uuid}', '{$item_name}', CURRENT_TIMESTAMP)
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