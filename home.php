<?php
session_start();

if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ホーム</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>こんにちは、<?= htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?>さん！</h1>
    <a href="logout.php">ログアウト</a>
    <a href="post.php">投稿画面へ進む</a>
  </body>
</html>