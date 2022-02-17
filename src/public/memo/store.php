<?php
try {
    // DB接続
    $db['user_name'] = "root";
    $db['password'] = "password";
    $pdo = new PDO("mysql:host=mysql; dbname=memo; charset=utf8", $db['user_name'], $db['password']);

    // 変数に取得した値を格納
    $title = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');


    // SQL
    $sql = 'INSERT INTO pages (title, content) VALUES (:title, :content)';
    $statement = $pdo->prepare($sql);


    // 値受け取る
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':content', $content, PDO::PARAM_STR);

} catch (PDOException $e) {
    echo "データベースに接続できませんでした。" . $e->getMessage();
    exit();
}

// 送信方法バリデーション
$errors = [];
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $errors[] = 'post送信になっていません。';
}

// 入力バリデーション
if (empty($title)) {
    $errors[] = '「タイトル」を入力してください。';
}

if (empty($content)) {
    $errors[] = '「内容」を入力してください。';
}

// エラーがなければindex.phpへリダイレクト
if (!empty($errors)) {
    $links = '
    <a href="./create.php">
    <p>作成画面へ戻る</p>
    </a>';
} else {
    // エラーがなければSQL実行
    $statement->execute();

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認エラー画面</title>
</head>

<body>
    <div class="container">
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error . "\n"; ?></p>
            <?php endforeach; ?>
            <p><?php echo $links; ?><p>
        <?php endif; ?>
    </div>
</body>
</html>
