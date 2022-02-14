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
        <h1 class="mb-3">新規登録</h1>
        <form action="user_register.php" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">ユーザー名</label>
                <input type="text" name="user_name" id="user_name" class="form-control  form-control-lg">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control  form-control-lg" value="">
            </div>
            <button type="submit" class="btn btn-primary mt-4 mb-3">新規登録</button>
        </form>
        <?php if (isset($_SESSION['user_name_error'])) echo  "<p>".$_SESSION['user_name_error']."</p>"; ?>
        <?php if (isset($_SESSION['password_error'])) echo  "<p>".$_SESSION['password_error']."</p>"; ?>
    </div>

</body>
<?php
$_SESSION['user_name_error'] = "";
$_SESSION['password_error'] = "";
?>
</html>