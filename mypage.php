<?php
session_start();
if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}

require_once('db_connect.php');

//ユーザー情報の取得
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT username FROM users WHERE id = :id');
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

?>

<!DOCTYPE html>
<html>
  <head>
  <html lang="ja"></html>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1><?= htmlspecialchars($user['username']) ?>さんのマイページ</h1>

    <div><a href="home.php">投稿一覧を確認する</a></div>
    <div><a href="home.php">新規目標を設定する</a></div>

  </body>
</html>
