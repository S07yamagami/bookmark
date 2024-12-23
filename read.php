<?php
try {
    // さくらサーバー用のデータベース接続設定
    $pdo = new PDO('mysql:dbname=tealtapir84_gs_db;charset=utf8;host=mysql3104.db.sakura.ne.jp', 'tealtapir84_gs_db', 'R6FYP-vag-9gCbp');
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// データ取得用SQLの準備
$stmt = $pdo->prepare("SELECT * FROM bookmark ORDER BY date DESC");
$status = $stmt->execute();

// 結果の取得
$view = '';
if ($status === false) {
    // SQLエラーの場合
    $error = $stmt->errorInfo();
    $view = 'データ取得エラー: ' . htmlspecialchars($error[2], ENT_QUOTES, 'UTF-8');
} else {
    // データがある場合
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $view .= '<div class="record">';
        $view .= '<h3>' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</h3>';
        $view .= '<p><strong>URL:</strong> <a href="' . htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8') . '</a></p>';
        $view .= '<p><strong>コメント:</strong> ' . nl2br(htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8')) . '</p>';
        $view .= '<p><small>登録日時: ' . htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8') . '</small></p>';
        $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<body>
    <div class="jumbotron">
        <fieldset>
            <legend>ブックマーク一覧</legend>
            <?php echo $view; ?>
        </fieldset>
    </div>
</body>

</html>
