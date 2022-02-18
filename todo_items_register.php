<?php
//セッションの開始
session_start();

//サニタイズ
$post = array();
foreach ($_POST as $key => $value) {
    $post[$key] = htmlspecialchars(preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $value), ENT_QUOTES, 'UTF-8');
}

$error = false;
$_SESSION['item_name_error'] = "";
$_SESSION['deadline_error'] = "";

//やらなければならないことチェック
if (empty($post['item_name'])) {
    $_SESSION['item_name_error'] = 'やらなければならないことが入力されていません';
    $error = true;
}
//締切チェック
if (empty($post['deadline'])) {
    $_SESSION['deadline_error'] = '締切が入力されていません';
    $error = true;
}

if ($error) {
    header('Location: ./todo_items_register_form.php');
    exit;
}

try {

    //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

    //エラーが起きた時のモードを指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データを追加するsql文
    $sql = 'INSERT INTO todo_items (item_name, deadline, user_id, subject_id) VALUES (:item_name, :deadline, :user_id, :subject_id)';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':item_name', $post['item_name'], PDO::PARAM_STR);
    $stmt->bindValue(':deadline', $post['deadline'], PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':subject_id', $_SESSION['subject_id'], PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();

    //リダイレクト
    header('Location: ./todo_items.php');
    exit();
} catch (Exception $e) {
    //エラーメッセージを表示して終了
    var_dump($e);
    exit();
}
