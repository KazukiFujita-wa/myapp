<?php
session_start();
require_once 'db_connect.php';

//投稿一覧取得
$sql = "SELECT posts.*, users.username From posts INNER JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>投稿一覧</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>投稿一覧</h1>
    <?php foreach ($posts as $post): ?>
      <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <p><strong><?= htmlspecialchars($post['username']) ?></strong></p>
        <p><?= htmlspecialchars($post['content'])?></p>
        <p><em><?= $post['created_at']?></em></p>
      </div>
    <?php endforeach ?>
    <a href="logout.php">ログアウト</a>
    <a href="post.php">投稿画面へ進む</a>
  </body>
</html>