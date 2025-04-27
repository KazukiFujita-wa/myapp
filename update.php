<?php
// DB接続
$pdo = new PDO('mysql:dbname=test_db;host=localhost;charset=utf8','root','root');

// POST送信があったかどうかを判定
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // フォームから送信された値を取得
    $id = $_POST["id"];
    $title = $_POST["title"];
    $memo = $_POST["memo"];

    //バリデーション
    $errors = [];

    if(!$id){
      $errors[] = 'IDが取得できませんでした。';
    }

    if(mb_strlen(trim($title)) === 0){
      $errors[] = 'タイトルを入力してください。';
    }elseif(mb_strlen($title) > 50){
      $errors[] = 'タイトルは50文字以内で入力してください。';
    }
    if(mb_strlen($memo) > 200){
      $errors[] = 'メモは200文字以内で入力してください。';
    }

    if(!empty($errors)){
      foreach($errors as $e){
        echo '<p style="color:red;">'. htmlspecialchars($e, ENT_QUOTES, 'UTF-8'). '</p>';
      }
      exit;
    }

    // UPDATE文を準備して実行
    $sql = 'UPDATE test SET title = :title, memo = :memo WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    // 更新後に一覧ページに戻すなど
    if ($status !== false) {
        header("Location: select.php?message=success");
        exit();
    } else {
        echo "更新に失敗しました。";
    }

} else {
    // GETリクエスト：編集画面の表示処理
    if (!isset($_GET["id"])) {
        exit("IDが指定されていません。");
    }

    $id = $_GET["id"];

    // 対象のデータを取得
    $sql = 'SELECT * FROM test WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- HTMLフォーム（編集画面） -->
<!DOCTYPE html>
<html lang="ja"></html>
<head>
    <meta charset="UTF-8">
    <title>予定編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<form action="update.php" method="POST">
  <input type="hidden" name="id" value="<?= $record["id"] ?>">
  <input type="text" name="title" value="<?= $record["title"] ?>">
  <input type="text" name="memo" value="<?= $record["memo"] ?>">
  <button type="submit">更新</button>
</form>