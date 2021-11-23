<?php include_once __DIR__ . '/header.php'; ?>
<?php if (empty($_GET['product'])) page404(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- https://www.codingnepalweb.com/drag-drop-file-upload-feature-javascript/ -->
<!-- https://github.com/gitdagray/drag_drop_file_input/blob/main/js/main.js -->
<section id="container">
  <div class="data-area">
    <button class="upload">Сохранить</button>
  </div>
  <div class="drag-area">
    <img src="/image/upload-102.svg" style="width: 200px;"/>
    <header>Перетащите и отпустите, чтобы загрузить изображение или</header>
    <button class="select">Нажмите чтобы выбрать файл</button>
    <input type="file" name="images" id="fileAjax" hidden multiple>
  </div>
  <div class="preview-area">
    <?php
    if (file_exists("23items.db")) {
      $result = $db->query('SELECT * FROM images');
      while ($row = $result->fetchArray()) {
        echo "<div class='success'><img src='/uploads/{$row['name']}'/><span class='delete' onclick='deleteImage(\"{$row['uuid']}\")'>Удалить</span></div>";
      }
    }
    ?>
  </div>
  <div class="response">

  </div>
</section >

<script src="upload.js"></script>
</body>
</html>