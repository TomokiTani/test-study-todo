<?php
session_start();
$_SESSION['user_name_error'] = "";
$_SESSION['password_error'] = "";
$error = null;

//文字の前後の空白を削除する
$user_name = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['user_name']);
$password = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $_POST['password']);

//空かチェック
if (empty($user_name)) {
    $_SESSION['user_name_error'] = "ユーザー名を入力してください";
    $error = 1;
}
if (empty($password)) {
    $_SESSION['password_error'] = "パスワードを入力してください";
    $error = 1;
}
if (!empty($error)) {
    //リダイレクト
    header('Location: ./signup.php');
    exit;
}

//サニタイズ
$user_name = htmlspecialchars($user_name);
//ハッシュ化
$password = password_hash($password, PASSWORD_DEFAULT);




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

//同じユーザー名がいるかチェック
if (!empty($list)) {
    $_SESSION['user_name_error'] = '同じユーザー名が存在します。';
    //リダイレクト
    header('Location: ./signup.php');
    exit;
} else {
    //データを追加するsql文
    $sql = 'INSERT INTO users (user_name, password) VALUES (:user_name, :password)';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();
    //リダイレクト
    header('Location: ./user_register_complete.php');
    exit;
}
