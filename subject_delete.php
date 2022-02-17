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

    //データを削除するsql文
    $sql = 'UPDATE subjects SET is_deleted = 1 WHERE id = :subject_id';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':subject_id', $_POST['subject_id'], PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();

    //リダイレクト
    header('Location: ./subject.php');
    exit;
} catch (Exception $e) {
    //エラーメッセージを表示して終了
    var_dump($e);
    exit();
}
