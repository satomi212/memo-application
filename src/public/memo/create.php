<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録ページ</title>
</head>

<body>
    <h2>メモ登録</h2>

    <form action="store.php" method="post">
        <div>
            <label for="title">title</label>
            <br>
            <input type="text" name="title" id="title" placeholder="タイトル">
            <br>
            <br>
        </div>

        <div>
            <label for="content">本文</label>
            <br>
            <input type="text" name="content" id="content" placeholder="本文">
            <br>
            <br>
        </div>

        <div>
            <button type="submit" name="submit">登録</button>
        </div>
    </form>

</body>
</html>
