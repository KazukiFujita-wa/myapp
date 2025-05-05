<?php
session_start();
require_once 'db_connect.php';

//投稿一覧取得
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare(
  'SELECT posts.*, users.username, users.icon
  FROM posts
  JOIN users ON posts.user_id = users.id
  WHERE (posts.user_id = :user_id
          OR posts.user_id IN (
            SELECT followed_id FROM follows WHERE follower_id = :user_id
          ))
  ORDER BY posts.created_at DESC'
);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();
if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}
//ログイン判別
if (!isset($_SESSION['user_id'])) {
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
      <div class="card">
        <p><strong><?= htmlspecialchars($post['username']) ?></strong></p>
        <p><strong><?= htmlspecialchars($post['goal_title'])?></strong></p>
        <p><?= htmlspecialchars($post['content'])?></p>
        <p><em><?= $post['created_at']?></em></p>
      </div>
    <?php endforeach ?>
    <a href="logout.php">ログアウト</a>
    <a href="post.php">投稿画面へ進む</a>
    <a href="mypage.php">マイページを表示する</a>
  </body>
</html>