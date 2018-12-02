<?php
include 'includes/login.php';

$fp = fopen ("info.txt", "r");
 ?>
<html la="ja">
<head>
  <meta charset="utf-8">
  <title>テニスサークル交流サイト</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body class="index">
  <p class="logout"><a href="logout.php">ログアウト</a></p>
  <h1 class="chapter"> テニスサークル交流サイト</h1>
  <img src="picture/sports_tennis_racket_ball.jpg">
  <h2>メニュー</h2>
  <p><a href="album.php"><i class="fas fa-images fa-fw"></i> アルバム</a></p>
  <p><a href="bbs.php"><i class="fas fa-solar-panel fa-fw"></i> 掲示板</a></p>
  <h2>◇◇お知らせ◇◇</h2>

  <?php
if ($fp) {
  $title = fgets($fp); //ファイルから1行読み込む
  if ($title) {
    echo '<a href="info.php">' . $title .'</a>';
} else {
   //ファイルの中身が空だったとき
   echo "お知らせはありません。";
}
fclose($fp);  //ファイルを閉じる
} else {
  //ファイルが開けなかったとき
  echo "お知らせはありません。";
}
   ?>
</body>
</html>
