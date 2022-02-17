<?php
//セッションの開始
session_start();
$_SESSION['item_name_error'] = "";
$_SESSION['deadline_error'] = "";

try {
    //データベースに接続
    $dsn = getenv('DATA_SOURSE_NAME');
    $dbuser = getenv('DB_USERNAME');
    $dbpass = getenv('DB_PASSWORD');
    $dbh = new PDO($dsn, $dbuser, $dbpass);

    //エラーが起きた時のモードを指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //データを取ってくるsql文
    $sql = 'SELECT * FROM todo_items WHERE user_id = :user_id AND subject_id = :subject_id AND is_deleted = 0';

    //sqlを実行する準備
    $stmt = $dbh->prepare($sql);

    //値をセット
    $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->bindValue(':subject_id', $_SESSION['subject_id'], PDO::PARAM_STR);

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
    <title>テスト勉強</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-3"><?php echo $_SESSION['subject_name']; ?>
        </h1>
        <p class="my-3"><?php echo $_SESSION['test_date']; ?></p>
        <?php if (count($list) > 0) : ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">やらなければならないこと</th>
                        <th scope="col">期限</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <?php foreach ($list as $value) : ?>
                    <tr>
                        <form action="./todo_action.php" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $value['id']; ?>">
                            <?php if ($value['is_completed'] == 1) : ?>
                                <td class="text-decoration-line-through"><?php echo $value['item_name']; ?></td>
                                <td class="text-decoration-line-through"><?php echo $value['deadline']; ?></td>
                            <?php else : ?>
                                <td><?php echo $value['item_name']; ?></td>
                                <td><?php echo $value['deadline']; ?></td>
                            <?php endif; ?>
                            <td><button type="submit" class="btn btn-success" name="is_completed" value="達成">達成</button></td>
                            <td><button type="submit" class="btn btn-warning" name="is_deleted" value="削除">削除</button></td>
                        </form>
                    </tr>

                <?php endforeach; ?>
            <?php else : ?><p>やらなければならないことはありません</p>
            <?php endif; ?>

            </table>


            <div class="my-2"><button class="btn btn-primary" onclick="location.href='./todo_items_register_form.php'">追加</button></div>
            <div class="my-2"><button class="btn btn-primary" onclick="location.href='./subject.php'">戻る</button></div>




    </div>

</body>

</html>