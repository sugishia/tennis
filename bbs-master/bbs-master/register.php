<?php
if (isset($_POST['data'])) {
    $data = $_POST['data'];

    if (empty($data['login_name']) || empty($data['password']) || empty($data['name'])) {
        //$comment = "<strong>入力エラー</strong>";
        header ('Location: register.php');
        exit();
    }
    $dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
    $user = 'tennisuser';
    $password = 'password';

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $db->prepare(
        "INSERT INTO users (name, password) VALUES(:name, :password)");

        $stmt->bindParam(':name', $data['login_name'], PDO::PARAM_STR);
        $stmt->bindParam(':password', sha1($data['password']), PDO::PARAM_STR);
        $stmt->execute();

        $id = intval($db->lastInsertID());

        $stmt = $db->prepare(
            "INSERT INTO profiels (id, name, body, mail)
             VALUE(:id, :name, :body, :mail)"
        );

        $stmt->bindPAram(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':body', $data['body'], PDO::PARAM_STR);
        $stmt->bindParam(':mail', $data['mail'], PDO::PARAM_STR);
        $stmt->execute();

        header('Location: login.php');
        exit();
    } catch (PDOException $e) {
        die ('エラー：' . $e->getMessage());
    }
} else {
?>

<html la="ja">
    <head>
        <meta charset="utf-8">
        <title>テニスサークル交流サイト</title>
        <link rel="stylesheet" href="style.css">
        <body>
            <h1>テニスサークル交流サイト</h1>
            <h2 class="backgroundcolor">ユーザー新規登録</h2>

            <form action="register.php" method="post">
                <p>ログインユーザー名：<input type="text" name="data[login_name]"></p>
                <p>パスワード：<input type="password" name="data[password]"></p>
                <p>氏名：<input type="text" name="data[name]"></p>
                <p>自己紹介：<textarea name="data[body]"></textarea></p>
                <p>メールアドレス：<input type="text" name="data[mail]"></p>
                <p><input type="submit" value="登録"></p>
            </form>
            <?php #if(!$comment){ echo $comment; } ?>
        </body>
    </head>
</html>
<?php } ?>