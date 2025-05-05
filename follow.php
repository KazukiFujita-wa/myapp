<?php
session_start();
require 'db_connect.php';

//未ログインの場合はリダイレクト
if(!isset($_SESSION['user_id'])){
  header('Location: login.php');
  exit;
}

$follower_id = $_SESSION['user_id'];
$followed_id = (int)$_POST['followed_id'];

//自分自身をフォローしようとした場合はリダイレクト
if($follower_id === $followed_id){
  header('Location: follow_users.php');
  exit;
}

//フォロー済みかどうかのチェック
$stmt = $pdo->prepare("
  SELECT COUNT(*) FROM follows
  WHERE follower_id = :follower_id AND followed_id = :followed_id");
  $stmt->bindValue(':follower_id', $follower_id, PDO::PARAM_INT);
  $stmt->bindValue(':followed_id', $followed_id, PDO::PARAM_INT);
  $stmt->execute();
  $alleady_followed = $stmt->fetchColumn();

  if ($follower_id !== $followed_id){
  $stmt = $pdo->prepare("
    INSERT INTO follows (follower_id, followed_id)
    VALUES (:follower_id, :followed_id)");
  $stmt->bindValue(':follower_id', $follower_id, PDO::PARAM_INT);
  $stmt->bindValue(':followed_id', $followed_id, PDO::PARAM_INT);
  $stmt->execute();
  }

  //一覧画面に戻る
  header('Location: follow_user.php');
  exit;