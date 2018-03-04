<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PDOでデータベースに接続する</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<div>
    <?php
    // DB情報
    $user = 'testuser';
    $password = 'pw4testuser';
    $dbName = 'testdb';
    $host = 'localhost:8889';
    $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

    // DB接続
    // try-catch構文で接続エラー(例外処理)を検知して表示できる
    try {
        // PDOクラスのインスタンス生成
        $pdo = new PDO($dsn, $user, $password);
        // プリペアドステートメントのエミュレーションを無効にする
        // PDOで静的プレースホルダを使用する場合，少なくともMySQLではfalseにすべき
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        // 例外をスローにする設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ATTR_ERRMODE_EXCEPTION);
        echo "データベース{$dbName}に接続しました";
        $pdo = NULL;
    } catch (Exception $e) {
        // 接続に失敗すると例外処理が実行
        echo '<span class="error">エラーがありました。</span><br>';
        echo $e->getMessage();
        exit();
    }
    ?>
</div>
</body>
</html>
