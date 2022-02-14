<?php
//セッションの開始
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
        <form action="subject_register.php" method="POST">
            <div class="mb-3">
                <label for="subject" class="form-label">教科名</label>
                <input type="text" name="subject" id="subject" class="form-control  form-control-lg">
            </div>
            <div class="mb-3">
                <label for="test_date" class="form-label">日付</label>
                <input type="date" name="test_date" id="test_date" class="form-control  form-control-lg">
            </div>
            <div class="mt-5 mb-3"><button class="btn btn-primary" type="submit">登録</button></div>
        </form>
        <?php if (!empty($_SESSION['subject_error'])) echo  "<p>".$_SESSION['subject_error']."</p>"; ?>
        <?php if (!empty($_SESSION['test_date_error'])) echo  "<p>".$_SESSION['test_date_error']."</p>"; ?>
    </div>

</body>

</html>