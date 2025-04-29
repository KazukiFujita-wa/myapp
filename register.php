<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>ユーザー登録</h1>
  <form action="register.php" method="POST">
    <div>
      <label>ユーザー名：</label>
      <input typw="text" name="username" required>
    </div>
    <div>
      <label>パスワード：</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit">登録する</button>
  </form>

<?php
  //登録処理
  if($_SERVER["REQUEST_METHOD"] === "POST"){
    //DB接続
    $pdo = new PDO('mysql:dbname=test_db;host=localhost;charset=utf8','root','root');

    //入力取得
    $username = $_POST['username'];
    $password = $_POST['password'];

    //バリデーション
    if(empty($username) || empty($password)){
      echo "<p>ユーザー名とパスワードは必須です。</p>";
      exit;
    }

    //パスワードのハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //データ登録
    $stmt = $pdo->prepare('INSERT INTO users (username,password) VALUES(:username, :password)');
    $stmt->bindValue(':username',$username, PDO::PARAM_STR);
    $stmt->bindValue(':password',$hashedPassword, PDO::PARAM_STR);
    $stmt->execute();

    echo "<p>登録が完了しました！</p>";
    echo '<p><a href="login.php>ログイン画面へ</a></p>';
  }
?>
</body>
</html>