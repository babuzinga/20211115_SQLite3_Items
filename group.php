<?php include_once __DIR__ . '/header.php'; ?>
<?php if (empty($_GET['u'])) page404(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<section id="container">
  <h1>Товары</h1>

  <div>
    <a href="/">Groups</a> > <?= $_GET['u']; ?>
  </div>

  <div>
    <input type="text" name="product_name" value="" placeholder="Название нового товара">
    <button type="button" onclick="addItem('product', 'product_name', '<?= $_GET['u']; ?>')">Добавить</button>
  </div>

  <div>
    <ul id="product_list" class="items_list">
      <?php
        $uuid = $db->escapeString($_GET['u']);
        $result = $db->query("
          SELECT COUNT(images.uuid) AS cnt, products.* 
          FROM products 
          LEFT JOIN images ON images.product_uuid = products.uuid 
          WHERE group_uuid = '{$uuid}'
          GROUP BY products.uuid
        ");
        while ($row = $result->fetchArray()) :
      ?>
        <li>
          <a href="/product.php?u=<?= $row['uuid']; ?>"><?= $row['title'], !empty($row['cnt']) ? " ({$row['cnt']})" : ''; ?></a>
          <span class='delete' onclick="deleteItem('product', '<?= $row['uuid']; ?>')">[ Удалить ]</span>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>

<script src="script.js"></script>
</body>
</html>