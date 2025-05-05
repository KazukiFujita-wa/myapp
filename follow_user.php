<?php
session_start();
require 'db_connect.php';

$user_id = $_SESSION['user_id'];

//既にフォローしているか確認 or 自分は除外
$stmt = $pdo->prepare("
  SELECT id, username
  FROM users
  WHERE id != :user_id
  AND id NOT IN (
    SELECT followed_id FROM follows WHERE follower_id = :user_id)");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <title>フォローできるユーザー一覧</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .card {
      border: 1px solid #ccc;
      padding: 10px;
      margin: 10px;
    }
    .card a {
      text-decoration: none;
      color: blue;
    }
  </style>
</head>
<h2>フォローできるユーザー</h2>
<?php foreach ($users as $user) : ?>
    <form action="follow.php" method="POST">
      <?= htmlspecialchars($user['username']); ?>
      <input type="hidden" name="followed_id" value="<?= htmlspecialchars($user['id']); ?>">
      <button type="submit">フォロー</button>
    </form><br>
<?php endforeach; ?>