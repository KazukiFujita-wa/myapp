<?php
session_start();

//DB接続
$dsn = 'mysql:host=localhost;dbname=test_db;port=8888;charset=utf8mb4';
$user = 'root';
$password = 'root';
try {
  $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e){
  echo 'DB接続エラー：' . $e->getMessage();
  exit;
}

//フォームから送られてきたデータ
$username = $_POST['username'] ?? '';
$password_input = $_POST['password'] ?? '';

//入力チェック
if(empty($username) || empty($password_input)){
  echo 'ユーザー名またはパスワードが未入力です';
  exit;
}

//ユーザー検索（SQL実行）
$sql = 'SELECT * FROM users WHERE username = :username';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
  echo 'ユーザー名が間違っています';
  exit;
}

//パスワードチェック
if(password_verify($password_input, $user['password'])){
  //ログイン成功
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];

  header('Location: home.php');
  exit;
}else{
  var_dump($password_input);
  var_dump($user['password']);
  echo 'パスワードが間違っています';
  exit;
}
?>