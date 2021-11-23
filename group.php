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
    <button type="button" onclick="controlItem('product', 'product_name', 'create', false, '<?= $_GET['u']; ?>')">Добавить</button>
  </div>

  <div>
    <ul id="product_list" class="items_list">
      <?php
        $uuid = $db->escapeString($_GET['u']);
        $result = $db->query("
          SELECT COUNT(images.uuid) AS cnt, products.* 
          FROM products 
          LEFT JOIN images ON images.product_uuid = products.uuid 
          WHERE group_uuid = '{$uuid}' AND products.status = 0
          GROUP BY products.uuid
        ");
        while ($row = $result->fetchArray()) :
      ?>
        <li data-uuid="<?= $row['uuid']; ?>">
          <?= !empty($row['cnt']) ? "[{$row['cnt']}]" : ''; ?>
          <a href="/product.php?u=<?= $row['uuid']; ?>"><?= $row['title']; ?></a>
          <span class='rename' onclick="renameItem('product', '<?= $row['uuid']; ?>')"></span>
          <span class='delete' onclick="controlItem('product', false, 'delete', '<?= $row['uuid']; ?>', false)"></span>
        </li>
      <?php endwhile; ?>
    </ul>
  </div>
</section>

<script src="script.js"></script>
</body>
</html>