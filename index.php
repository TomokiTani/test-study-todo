<?php
session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>テスト勉強</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <form action="./login.php" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">ユーザー名</label>
                <input type="text" name="user_name" id="user_name" class="form-control  form-control-lg">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" value="" class="form-control  form-control-lg">
            </div>
            <div class="mt-5"><button type="submit" class="btn btn-primary">ログイン</button></div>
        </form>
        <div class="my-3"><button onclick="location.href='./signup.php'" class="btn btn-success">新規登録</button></div>
        <?php if (isset($_SESSION['login_error'])) echo  "<p>" . $_SESSION['login_error'] . "</p>"; ?>
    </div>
</body>
<?php
$_SESSION['login_error'] = "";
?>

</html>