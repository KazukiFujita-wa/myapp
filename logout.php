<?php
session_start();

//セッション変数を全て解除
$_SESSION = array();
//セッションの破棄
session_destroy();
//ログインページへリダイレクト
header('Location: login.php');
exit;
?>