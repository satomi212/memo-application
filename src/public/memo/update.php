<?php
try {
    // DB接続
    $db['user_name'] = "root";
    $db['password'] = "password";
    $pdo = new PDO("mysql:host=mysql; dbname=memo; charset=utf8", $db['user_name'], $db['password']);

    // 編集画面の更新
    $sql = 'UPDATE pages SET title = :title, content = :content WHERE id = :id';
    $statement = $pdo->prepare($sql);

    // ？？bindValueだと受け取れない→配列型？なら受け取れる
    $statement->execute(array(':title' => $_POST['title'], ':content' => $_POST['content'], ':id' => $_POST['id']));

    // $statement->bindValue(':title', $title, PDO::PARAM_STR);
    // $statement->bindValue(':content', $content, PDO::PARAM_STR);
    // $statement->bindValue(':id', $id, PDO::PARAM_INT);
    // $statement->execute();


    // 編集内容が更新されたらindex.phpへリダイレクト
    if (empty($errors)) {
        header('Location: index.php');
        exit();
    }

} catch (Exception $e) {
    echo 'データベースに接続できませんでした。:' . $e->getMessage();
    exit();
}
?>
