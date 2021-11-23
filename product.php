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
  <h1>Товар</h1>

  <div>
    <a href="/">Groups</a> >
    <a href="/group.php?u=<?= $_GET['u']; ?>">Group</a> > <?= $_GET['u']; ?>
  </div>

  <div class="data-area">
    <input type="hidden" id="product_uuid" value="<?= $_GET['u']; ?>">
    <button class="upload">Сохранить</button>
  </div>

  <div class="preview-area">
    <?php
    if (file_exists("23items.db")) {
      $uuid = $db->escapeString($_GET['u']);
      $result = $db->query("SELECT * FROM images WHERE product_uuid = '{$uuid}'");
      while ($row = $result->fetchArray()) {
        echo "<div class='success'><img src='/uploads/{$row['filename']}'/><span class='delete' onclick='deleteImage(\"{$row['uuid']}\")'>Удалить</span></div>";
      }
    }
    ?>
  </div>

  <div class="drag-area">
    <img src="/image/upload-102.svg" style="width: 200px;"/>
    <header>Перетащите и отпустите, чтобы загрузить изображение или</header>
    <button class="select">Нажмите чтобы выбрать файл</button>
    <input type="file" name="images" id="fileAjax" hidden multiple>
  </div>

  <div class="response">

  </div>
</section >

<script src="upload.js"></script>
</body>
</html>