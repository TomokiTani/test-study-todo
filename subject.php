<?php
//セッションの開始
session_start();
$_SESSION['subject_error'] = "";
$_SESSION['test_date_error'] = "";


try {
    //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

    //エラーが起きた時のモードを指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データを取ってくるsql文
    $sql = 'SELECT * FROM subjects WHERE user_id = :user_id AND is_deleted = 0 ORDER BY test_date ASC';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);

    //sqlの実行
    $stmt->execute();

    //select文の結果を取り出す
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    //エラーメッセージを表示して終了
    var_dump($e);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>テスト勉強todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-3">テスト一覧</h1><?php if (count($list) > 0) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">テスト科目</th>
                        <th scope="col">テスト日</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php foreach ($list as $value) : ?><tr>

                        <td><?php echo $value['subject']; ?></h3>
                        <td><?php echo $value['test_date']; ?></p>
                        <td>
                            <form action="./subject_select.php" method="POST">
                                <input type="hidden" name="subject_id" value="<?php echo $value['id']; ?>">
                                <input type="hidden" name="subject_name" value="<?php echo $value['subject']; ?>">
                                <input type="hidden" name="test_date" value="<?php echo $value['test_date']; ?>">
                                <button class="btn btn-link" type="submit">todoリストへ</button>
                            </form>
                        </td>
                        <td>
                            <form action="./subject_delete.php" method="POST">
                                <input type="hidden" name="subject_id" value="<?php echo $value['id']; ?>">
                                <button class="btn btn-warning" type="submit">削除</button>
                            </form>
                        </td>


                    </tr>


                <?php endforeach; ?>
            </table>
        <?php else : ?><p>テストはありません</p>
        <?php endif; ?>
        <button class="btn btn-primary" onclick="location.href='./subject_register_form.php'">追加</button>
    </div>

</body>

</html>