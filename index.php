<?php include_once __DIR__ . '/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="container">
  <h1>Группы</h1>

  <div>
    Groups
  </div>

  <div>
    <input type="text" name="group_name" value="" placeholder="Название новой группы">
    <button type="button" onclick="controlItem('group', 'group_name', 'create', false, false)">Добавить</button>
  </div>

  <div>
    <ul id="group_list" class="items_list">
      <?php
        $result = $db->query('
          SELECT COUNT(products.uuid) AS cnt, groups.* 
          FROM groups 
          LEFT JOIN products ON products.group_uuid = groups.uuid AND products.status = 0
          WHERE groups.status = 0
          GROUP BY groups.uuid
          ORDER BY groups.dt
        ');
        while ($row = $result->fetchArray()) :
      ?>
        <li data-uuid="<?= $row['uuid']; ?>">
          <?= !empty($row['cnt']) ? "[{$row['cnt']}]" : ''; ?>
          <a href="/group.php?u=<?= $row['uuid']; ?>"><?= $row['title']; ?></a>
          <span class='rename' onclick="renameItem('group', '<?= $row['uuid']; ?>')"></span>
          <span class='delete' onclick="controlItem('group', false, 'delete', '<?= $row['uuid']; ?>', false)"></span>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>

<script src="script.js"></script>
</body>
</html>