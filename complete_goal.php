<?php
session_start();

//BD接続
$dsn = 'mysql:host=localhost;dbname=test_db;port=8888;charset=utf8mb4';
$user = 'root';
$password = 'root';

try {
  $pdo = new PDO($dsn, $user, $password);
}catch (PDOException $e) {
  echo 'DB接続エラー：' . $e->getMessage();
  exit;
}

//POSTデータ取得
$goal_id = $_POST['goal_id'] ?? null;

if($goal_id){
  $stmt = $pdo->prepare('UPDATE test SET is_completed = 1 WHERE id = :id');
  $stmt->bindValue(':id', $goal_id, PDO::PARAM_INT);
  $stmt->execute();  
  header('Location: select.php?message=completed');
  exit;
}else{
  echo '不正なリクエストです';
}

?>