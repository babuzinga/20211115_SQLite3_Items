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
  <div class="drag-area">
    <header>Перетащите и отпустите, чтобы загрузить изображение</header>
    <span>или</span>
    <button class="select">Нажмите чтобы выбрать файл</button>
    <span>а после</span>
    <button class="upload">Сохранить</button>
    <input type="file" name="images" id="fileAjax" hidden multiple>
  </div>
  <div class="preview-area">
    <?php
    if (file_exists("23items.db")) {
      $db = new SQLite3("23items.db");
      $result = $db->query('SELECT * FROM images');
      while ($row = $result->fetchArray()) {
        echo "<div class='success'><img src='/uploads/{$row['name']}'/></div>";
      }
    }
    ?>
  </div>
  <div class="response">

  </div>
</section >

<script src="script.js"></script>
</body>
</html>