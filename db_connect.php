<?php
// DB接続用ファイル（共通化）

$dsn = 'mysql:host=localhost;port=8889;dbname=test_db;charset=utf8';
$user = 'root';
$password = 'root';

try {
  $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  exit('DB接続エラー: ' . $e->getMessage());
}
?>
