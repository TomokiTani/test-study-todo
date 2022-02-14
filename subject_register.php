<?php
    //セッションの開始
    session_start();

    //サニタイズ
    $post = array();
    foreach($_POST as $key => $value){
        $post[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    $error = false;
    $_SESSION['subject_error'] = "";
    $_SESSION['test_date_error'] = "";

    //教科名チェック
    if(empty($post['subject'])){
        $_SESSION['subject_error'] = '教科名が入力されていません';
        $error = true;
    }
    //日付チェック
    if(empty($post['test_date'])){
        $_SESSION['test_date_error'] = '日付が入力されていません';
        $error = true;
    }

    if($error){
        header('Location: ./subject_register_form.php');
        exit;
    }

    try{

        //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

        //エラーが起きた時のモードを指定
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //データを追加するsql文
        $sql = 'INSERT INTO subjects (subject, test_date, user_id) VALUES (:subject, :test_date, :user_id)';

        //sqlを実行する準備
        $stmt = $dbh->prepare($sql);

        //値をセット
        $stmt->bindValue(':subject', $post['subject'], PDO::PARAM_STR);
        $stmt->bindValue(':test_date', $post['test_date'], PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);

        //sqlの実行
        $stmt->execute();

        //リダイレクト
        header('Location: ./subject.php');
        exit();
    } catch(Exception $e){
        //エラーメッセージを表示して終了
        var_dump($e);
        exit();
    }
