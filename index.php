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
    <button type="button" onclick="addItem('group', 'group_name', 0)">Добавить</button>
  </div>

  <div>
    <ul id="group_list" class="items_list">
      <?php
        $result = $db->query('
          SELECT COUNT(products.uuid) AS cnt, groups.* 
          FROM groups 
          LEFT JOIN products ON products.group_uuid = groups.uuid 
          GROUP BY groups.uuid
          ORDER BY groups.dt
        ');
        while ($row = $result->fetchArray()) :
      ?>
        <li>
          <a href="/group.php?u=<?= $row['uuid']; ?>"><?= $row['title'], !empty($row['cnt']) ? " ({$row['cnt']})" : ''; ?></a>
          <span class='delete' onclick="deleteItem('group', '<?= $row['uuid']; ?>')">[ Удалить ]</span>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>

<script src="script.js"></script>
</body>
</html>