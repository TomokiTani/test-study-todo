<?php
//セッションの開始
session_start();
$_SESSION['subject_id'] = $_POST['subject_id'];
$_SESSION['subject_name'] = $_POST['subject_name'];
$_SESSION['test_date'] = $_POST['test_date'];


//リダイレクト
header('Location: ./todo_items.php');
exit();
