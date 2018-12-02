<?php
include 'includes/login.php';

$num = 10;

$dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
$user = 'tennisuser';
$password = 'password';


$page = 0;
if (isset($_GET['page']) && $_GET['page'] > 0) {
  $page = intval($_GET['page']) -1;
}

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare (
    "SELECT * FROM bbs ORDER BY date DESC LIMIT :page, :num");
  $page = $page * $num;
  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);

  $stmt->execute();
} catch(PDOException $e) {
  echo "エラー：" . $e->getMessage();
}
?>

<html la="ja">
<head>
  <meta charset="utf-8">
  <title>掲示板</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body>
  <h2 class="backgroundcolor"><i class="fas fa-user-friends fa-fw"></i> 交流サイト：掲示板</h2>
  <p class="gohome"><a href="index.php">トップページに戻る</a></p>
  <form   class="form" action="write.php" method="post">
    <p>名前：<input type="text" name="name" 
      value="<?php isset($_COOKIE['name'])? $_COOKIE['name'] : "" ?>"></p>
    <p>タイトル：<input type="text" name="title"></p>
    <textarea class="comments" name="body"></textarea>
    <p>削除パスワード（半角 数字4文字）：<input type="text" name="pass"></p>
    <p><input type="submit" value="書き込む"></p>
  </form>
  <hr>

<?php
  while ($row = $stmt->fetch()):
    $title = $row['title'] ? $row['title'] : '（無題）';
?>
<p>名前：<?php echo $row['name'] ?></p>
<p>タイトル：<?php echo $title ?></p>
<p><?php echo nl2br($row['body'], false) ?></p>
<p><?php echo $row['date'] ?></p>

<form action="delete.php" method="post">
  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  削除パスワード：<input type="password" name="pass">
  <input type="submit" value="削除">
</form>

<?php
endwhile;

try {
   $stmt = $db->prepare("SELECT COUNT(*) FROM bbs");

   $stmt->execute();
 } catch (PDOException $e){
   echo "エラー：" . $e->getMessage();
 }

 $comments = $stmt->fetchColumn();

 $max_page = ceil($comments / $num);
 echo '<p>';
 for ($i = 1; $i <= $max_page; $i++) {
   echo '<a href="bbs.php?page=' . $i .'">' . $i .'</a>&nbsp;';
 }
 echo '</p>';
 ?>
</body>
</html>
