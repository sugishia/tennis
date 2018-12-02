<?php
include 'includes/login.php';

 $images = array();
 $num = 4;

 // 画像フォルダから画像ファイル名を読み込む
 if ($handle = opendir('./album')) {
   while ($entry = readdir($handle)) {
     // 「.」、「..」でないときとサムネイルをファイル名の配列に追加
     if ($entry != "." && $entry != ".." && strpos($entry, 'thumbs_') !== false) {
       $images[] = $entry;
     }
   }
   closedir($handle);
 }
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>アルバム</title>
    <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  </head>
  <body>
    <h2 class="backgroundcolor"><i class="fas fa-images fa-fw"></i> 交流サイト：アルバム</h2>
    <p>
      <a href="index.php">トップページに戻る</a> ／ 
      <a href="upload.php">写真をアップロードする</a>
    </p>
    <?php
    if (count($images) > 0) {
      $images = array_chunk($images, $num);
      $page = 0;
      if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = intval($_GET['page']) -1;
        if (!isset($images[$page])) {
          $page = 0;
        }
      }

      //画像の表示
      foreach ($images[$page] as $img) {
        echo '<img src="./album/' .$img . '">';
      }

      //ページ数リンク
      echo '<p>';
      for ($i = 1; $i <= count($images); $i++) {
        echo '<a href="album.php?page=' .$i .'">' . $i .'</a>&nbsp;';
      }
      echo '</p>';
    } else {
      echo '<p>画像名はまだありません。</p>';
    }
    ?>
  </body>
</html>
