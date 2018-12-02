<?php
include 'includes/login.php';

//データの受け取り
$name = $_POST['name'];
$title = $_POST['title'];
$body = $_POST['body'];
$pass = $_POST['pass'];

if ($name == '' || $body == '') {
  header('Location: bbs.php');
  exit();
}

if(!preg_match("/^[0-9]{4}$/", $pass)) {
  exit();
}

setcookie('name', $name, time() + 60 * 60 * 24 * 30);

//データベースに接続
$dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
$user = 'tennisuser';
$password = 'password';

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
//プリペアアドステートメントを作成
  $stmt = $db->prepare ("
  INSERT INTO bbs (name, title, body, date, pass)
  VALUES (:name, :title, :body, now(), :pass)"
);
//パラメータを割り当て
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':body', $body, PDO::PARAM_STR);
$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
//クエリの実行
$stmt->execute();

//bbs.phpに戻る
header('Location: bbs.php');
exit();
} catch(PDOException $e) {
  die ('エラー：' . $e->getMessage());
}
?>
