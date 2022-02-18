<?php
try {
    // DB接続
    $db['user_name'] = "root";
    $db['password'] = "password";
    $pdo = new PDO("mysql:host=mysql; dbname=memo; charset=utf8", $db['user_name'], $db['password']);


    // あいまい検索
    $sql = "SELECT * FROM pages WHERE content LIKE '%".$_POST["search"]."%'";


    // ソート機能
    $sortMode = "";
    // $_GETにascかdescが入ってたら$sortModeに入れる
    if (!empty($_GET['order'])) $sortMode = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // $sortModeがascかdescだったらSQL実行
    if ($sortMode == "asc" || $sortMode == "desc") $sql = $sql . "order by created_at $sortMode";

    // 実行
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $pages = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    <title>トップページ</title>
</head>

<body>
    <!-- 検索フォーム -->
    <form action="index.php" method="post">
        <div class="search">
            <input type="search" name="search" placeholder="Search...">
            <button type="submit" name="submit">検索</button>
        </div>
    </form>

    <!-- ページタイトル -->
    <div class="title">
        <h2>メモ一覧</h2>
    </div>

    <!-- メモの追加 -->
    <div class="create-memo">
        <a href="create.php" style=text-decoration:none>メモを追加</a>
    </div>

    <!-- ソート -->
    <div class="sort" style="text-align: right">
        <br>
        <!-- order=◯◯ → $_GET['order']にascかdescを指定 -->
        <a href="./index.php?order=asc" style="text-decoration:none;">新しい順</a>
        <a href="./index.php?order=desc" style="text-decoration:none;">古い順</a>
    </div>

    <!-- テーブル表示 -->
    <div class="table">
        <table border="1" style=border-collapse:collapse>
            <br>
            <th width="25%">タイトル</th>
            <th width="40%">内容</th>
            <th width="25%">作成日時</th>
            <th width="5%">編集</th>
            <th width="5%">削除</th>

            <?php foreach ($pages as $page): ?>
                <tr>
                    <td><?=htmlspecialchars($page['title'],ENT_QUOTES,'UTF-8')?></td>
                    <td><?=htmlspecialchars($page['content'],ENT_QUOTES,'UTF-8')?></td>
                    <td><?=$page['created_at']; ?></td>
                    <td>
                        <!-- ?id=でidを渡す -->
                        <!-- 編集ページ -->
                        <a href="edit.php?id=<?php echo $page['id']; ?>" style=text-decoration:none>編集</a>
                    </td>
                    <td>
                        <!-- 削除機能 -->
                        <a href="delete.php?id=<?php echo $page['id']; ?>" style=text-decoration:none>削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
