<?php
session_start();
$_SESSION['login_error'] = "";

//サニタイズ
$user_name = htmlspecialchars(trim($_POST['user_name']));

try {

    //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

    //エラーが起きた時のモードを指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データを取ってくるsql文
    $sql = 'SELECT * FROM users WHERE user_name = :user_name';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();

    //select文の結果を取り出す
    $list = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    //エラーメッセージを表示して終了
    var_dump($e);
    exit();
}

//パスワードがあっているかチェック
if (!empty($list) && password_verify($_POST['password'], $list['password'])) {
    //ユーザー情報をセッションに保存
    $_SESSION['user_id'] = $list['id'];
    //リダイレクト
    header('Location: ./subject.php');
    exit;
} else {
    $_SESSION['login_error'] = "ユーザー名もしくはパスワードが間違っています";
    //リダイレクト
    header('Location: ./index.php');
    exit;
}
