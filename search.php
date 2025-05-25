<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("請先登入才能搜尋文章");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$escaped_keyword = $conn->real_escape_string($keyword);

$sql = "SELECT * FROM post 
        WHERE title LIKE '%$escaped_keyword%' 
           OR content LIKE '%$escaped_keyword%' 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>搜尋結果</title>
    <style>
        body {
            background: #e9f7f1;
            padding: 20px;
            font-family: sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .article {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .btn {
            padding: 6px 12px;
            margin-right: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit { background: #28a745; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-like { background: #ffc107; color: black; }
        .btn-share { background: #17a2b8; color: white; }
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 12px;
            background-color: #ccc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔍 搜尋結果：<em><?= htmlspecialchars($keyword) ?></em></h2>
    <button class="back-button" onclick="history.back()">← 返回</button>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="article">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                <small>作者：<?= htmlspecialchars($row['author']) ?></small><br><br>

                <?php if ($row['author'] === $_SESSION['user']): ?>
                    <a href="post_edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">✏️ 修改</a>
                    <a href="post_delete.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('確定要刪除嗎？')">🗑️ 刪除</a>
                <?php endif; ?>

                <?php
                    $post_id = $row['id'];
                    $like_sql = "SELECT COUNT(*) AS cnt FROM likes WHERE post_id = $post_id";
                    $like_result = $conn->query($like_sql);
                    $like_count = $like_result->fetch_assoc()['cnt'] ?? 0;

                    $liked_sql = "SELECT 1 FROM likes WHERE post_id = $post_id AND user_email = '" . $_SESSION['user'] . "'";
                    $liked_result = $conn->query($liked_sql);
                    $liked = ($liked_result->num_rows > 0);

                    $btn_text = $liked ? "💔 取消讚" : "👍 按讚";
                ?>
                <a href="like_toggle.php?id=<?= $post_id ?>" class="btn btn-like"><?= $btn_text ?> (<?= $like_count ?>)</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>❗ 找不到與「<strong><?= htmlspecialchars($keyword) ?></strong>」相關的文章。</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-edit">⬅ 返回首頁</a>
</div>
</body>
</html>