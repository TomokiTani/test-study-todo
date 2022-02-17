<?php
session_start();

try {

    //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

    //エラーが起きた時のモードを指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST['is_completed'])) {
        $sql = 'UPDATE todo_items SET is_completed = 1 WHERE id = :item_id';
    } else {
        $sql = 'UPDATE todo_items SET is_deleted = 1 WHERE id = :item_id';
    }


    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':item_id', $_POST['item_id'], PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();

    //リダイレクト
    header('Location: ./todo_items.php');
    exit;
} catch (Exception $e) {
    //エラーメッセージを表示して終了
    var_dump($e);
    exit();
}
