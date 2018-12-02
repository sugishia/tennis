<?php
include 'includes/login.php';

$fp = fopen ("info.txt", "r");
$line = array();

if ($fp) {
  while(!feof($fp)) {
    $line[] = fgets($fp);
  }
  fclose($fp);
}
?>
<html la="ja">
<head>
  <meta charset="utf-8">
  <title>テニスサークル交流サイト</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body>
  <h1>テニスサークル交流サイト</h1>
  <p class="gohome"><a href="index.php">トップページへ戻る</a></p> 
  <h2 class="backgroundcolor">◇お知らせ◇</h2>
  <?php
 if (count($line) > 0) {
   for ($i = 0; $i < count($line); $i++) {
     if ($i == 0) {
       echo '<h3>' . $line[0] . '</h3>';
     } else {
       echo $line[$i] . '<br>';
     }
   }
 } else {
   echo 'お知らせはありません。';
 }
   ?>
</body>
</html>
