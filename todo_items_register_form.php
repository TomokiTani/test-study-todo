<?php
//セッションの開始
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>テスト勉強todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <form action="todo_items_register.php" method="POST">
            <div class="mb-3">
                <label for="item_name" class="form-label">やらなければならないこと</label>
                <input type="text" name="item_name" id="item_name" class="form-control  form-control-lg">
            </div>
            <div class="mb-3">
                <label for="deadline" class="form-label">締切</label>
                <input type="date" name="deadline" id="deadline" class="form-control  form-control-lg">
            </div>
            <div class="mt-5 mb-3"><button class="btn btn-primary" type="submit">登録</button></div>
        </form>
        <?php if (!empty($_SESSION['item_name_error'])) echo  "<p>" . $_SESSION['item_name_error'] . "</p>"; ?>
        <?php if (!empty($_SESSION['deadline_error'])) echo  "<p>" . $_SESSION['deadline_error'] . "</p>"; ?>
    </div>
</body>

</html>