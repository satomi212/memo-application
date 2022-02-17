<?php
try {
    // DB接続
    $db['user_name'] = "root";
    $db['password'] = "password";
    $pdo = new PDO("mysql:host=mysql; dbname=memo; charset=utf8", $db['user_name'], $db['password']);

    // index.phpのaタグで指定したURLの?以降で渡される値をキャッチ
    $id = filter_input(INPUT_GET, 'id');

    if (empty($id)) {
        // idが空だったらトップページにリダイレクト
        header("Location: index.php");
        exit;
    }
    elseif (!empty($id)) {
        // SQL
        $sql = 'SELECT * FROM pages WHERE id = :id';

        $statement = $pdo->prepare($sql);

        // 値をバインド
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        // execute:実行
        $statement->execute();

        // 結果取得
        $pages = $statement->fetch(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "データベースに接続できませんでした。" . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集ページ</title>
</head>

<body>
    <h2>編集</h2>

    <form action="update.php" method="post">
        <div class="id">
            <!-- hidden:ブラウザには表示されないがサーバには送信される -->
            <input type="hidden" name="id" value="<?php if (!empty($pages['id'])) echo (htmlspecialchars($pages['id'], ENT_QUOTES, 'UTF-8')); ?>">
        </div>

        <div class="title">
            <label for="title">タイトル</label>
            <br>
            <input type="text" name="title" id="title" value="<?php if (!empty($pages['title'])) echo (htmlspecialchars($pages['title'], ENT_QUOTES, 'UTF-8')); ?>">
        </div>

        <div class="content">
            <br>
            <label for="text">本文</label>
            <br>
            <input type="text" name="content" id="content" value="<?php if (!empty($pages['content'])) echo (htmlspecialchars($pages['content'], ENT_QUOTES, 'UTF-8')); ?>">
        </div>

        <div class="button">
            <br>
            <button type="submit" name="submit">更新</button>
        </div>
    </form>

</body>
</html>
