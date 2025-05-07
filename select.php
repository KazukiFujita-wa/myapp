<?php
//DB接続
$dsn = 'mysql:host=localhost;dbname=test_db;port=9990;charset=utf8';
$user = 'root';
$password = 'root';
try{
  $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
  echo 'DB接続エラー: ' . $e->getMessage();
  exit;
}

//検索キーワード取得
$search = '';
if(isset($_GET['search'])){
  $search = $_GET['search'];
}


//データ取得
if(!empty($search)){
  $sql = 'SELECT * FROM test WHERE title LIKE :search ORDER BY date DESC';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}else{
  $sql = 'SELECT * FROM test ORDER BY date DESC';
  $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//メッセージ取得
$message = '';
if(isset($_GET['message'])){
  if($_GET['message'] === 'insert_success'){
    $message = '登録が完了しました！';
  }elseif($_GET['message'] === 'update_success'){
    $message= '更新が完了しました！';
  }elseif($_GET['message'] === 'delete_success'){
    $message = '削除が完了しました！';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>予定一覧</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>登録された予定一覧</h1>
  <form method="GET" action="select.php" style="margin-bottom: 20px">
    <input type="text" name="search" placeholder="タイトルで検索" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES) : ''; ?>">
    <button type="submit">検索</button>
  </form>


  <div class="card-container">
    <?php
    // 表示
    foreach ($results as $record) {
      echo '<div class="card">';
      echo '<p><strong>タイトル：</strong>' . htmlspecialchars($record["title"], ENT_QUOTES) . '</p>';
      echo '<p><strong>日付：</strong>' . htmlspecialchars($record["date"], ENT_QUOTES) . '</p>';
      echo '<p><strong>メモ：</strong>' . nl2br(htmlspecialchars($record["memo"], ENT_QUOTES)) . '</p>';
      echo '<div class="btn-area">';
      echo '<a href="update.php?id=' . $record["id"] . '" class="btn">更新</a> ';
      echo '<a href="delete.php?id=' . $record["id"] . '" class="btn btn-delete">削除</a>';
      echo '<form action="complete_goal.php" method="POST" style="display:inline;">';
      echo '<input type="hidden" name="goal_id" value="' . $record["id"] . '">';
      echo '<button type="submit" class="btn">達成</button>';
      echo '</form>';
      echo '</div>';
      echo '</div>';
    }

    ?>
  </div>

</body>
</html>
