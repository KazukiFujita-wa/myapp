<?php
echo $_SERVER['REQUEST_METHOD'];
// 入力値チェック（未入力対策）
if (
  !isset($_POST['title']) || $_POST['title'] === '' ||
  !isset($_POST['date']) || $_POST['date'] === ''
) {
  exit('パラメータが不正です');
}

// 値の受け取り
$title = $_POST['title'];
$date = $_POST['date'];
$memo = $_POST['memo'] ?? ''; 

//バリデーション
$errors = [];

if (mb_strlen(trim($title)) === 0) {
  $errors[] = 'タイトルを入力してください。';
} elseif (mb_strlen($title) > 50) {
  $errors[] = 'タイトルは50文字以内で入力してください。';
}

if (mb_strlen($memo) > 200) {
  $errors[] = 'メモは200文字以内で入力してください。';
}

// エラーがある場合は表示して終了
if (!empty($errors)) {
  foreach ($errors as $e) {
    echo '<p style="color:red;">' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</p>';
  }
  exit;
}

// DB接続（別ファイルを読み込み）
require_once('db_connect.php');

// SQL作成・実行（prepareで安全に）
$sql = 'INSERT INTO test (title, date, memo) VALUES (:title, :date, :memo)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':memo', $memo);
$status = $stmt->execute();

// 処理結果確認
if ($status === false) {
  $error = $stmt->errorInfo();
  exit('SQLエラー：' . $error[2]);
} else {
  echo '登録成功！';
  header("Location: select.php?message=insert_success");
  exit;
}
?>
