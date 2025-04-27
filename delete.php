<?php

//GETでidが渡ってこなければ終了
if(!isset($_GET['id'])){
  exit('IDが指定されていません');
}

$id = (int)$_GET['id'];

//DB接続
$dsn = 'mysql:host=localhost;dbname=test_db;port=8889;charset=utf8';
$user = 'root';
$password = 'root';
try{
  $pdo = new PDO($dsn, $user, $password);
}catch(PDOException $e){
  echo 'DB接続エラー：' . $e->getMessage();
}

//データ削除
$sql = 'DELETE FROM test WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//処理後一蘭画面に戻る
if($status){
  header('Location: select.php');
  exit;
}else{
  echo '削除に失敗しました';
  exit;
}