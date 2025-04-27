<?php
//DB接続
$pdo = new PDO('mysql:dbname=test_db;host=localhost;charset=utf8','root','root');

//POSTデータ取得
if ($_SERVER["REDIRECT_METHOD"] === "POST"){
$id = $_POST["id"];
$title = $POST["title"];
$memo = $POST["memo"];

//SQL実行（update文）
$sql = 'UPDATE test SET title - :title, memo = :memo WHEERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();
}else{
  //初回アクセス（編集画面を開くとき）
  if(!isset($_FET["id"])){
    exit("IDが指定されていません。");
  }
  $id =$_GET["id"];
}
if($status){
  header("Location: select.php");
  exit();
}else{
  echo "更新失敗";
}