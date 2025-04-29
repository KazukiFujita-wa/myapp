<?php
session_start();

// DB接続
$dsn = 'mysql:host=localhost;dbname=test_db;port=8888;charset=utf8mb4';
$user = 'root';
$password = 'root';

try{
  $pdo = new PDO($dsn, $user, $password);
}catch(PDOException $e){
  echo 'DB接続エラー：'. $e->getMessage();
  exit;
}

//セッションからユーザー情報を取得
$user_id = $_SESSION['user_id'];

//フォームからデータ取得
$content = $_POST['content'];
$goal = $_POST['goal'];

//バリデーション
if(empty($content) || empty($goal)){
  header('Location: post.php?error=1');
  exit;
}

//データ登録
$sql = "INSERT INTO posts (user_id, content, goal_title, created_at) VALUES (:user_id, :content, :goal_title, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':goal_title', $goal, PDO::PARAM_STR);
$stmt->execute();

//処理後ホームへリダイレクト
header('Location: home.php');
exit;
?>