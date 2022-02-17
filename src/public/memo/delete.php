<?php
// DB接続
try {
    $db['user_name'] = "root";
    $db['password'] = "password";
    $pdo = new PDO("mysql:host=mysql; dbname=memo; charset=utf8", $db['user_name'], $db['password']);

    // 値を取得
    $id = filter_input(INPUT_GET, 'id');

    // SQL
    $sql = 'DELETE FROM pages WHERE id = :id';
    $statement = $pdo->prepare($sql);

    // 値受け取る
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // 実行
    $statement->execute();

    // index.phpへリダイレクト
    header('Location: index.php');
    exit();

} catch (PDOException $e) {
    echo "データベースに接続できませんでした。" . $e->getMessage();
    exit();
}
?>
