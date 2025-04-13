<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    die("請先登入才能查看文章或留言");
}

// 資料庫連線設定
$servername = "localhost";
$username = "root";  // 資料庫使用者名稱
$password = "";      // 密碼為空
$dbname = "sa_account";  // 資料庫名稱

// 創建資料庫連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 從資料庫讀取所有文章
$sql = "SELECT * FROM post ORDER BY created_at DESC"; // 按照發表時間排序
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <style>
        body {
            background: #f0ede5;
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
        .btn-new-post { margin-bottom: 20px; }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-box input[type="text"] {
            flex-grow: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .section {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .section h3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📚 文章列表</h2>

        <!-- 🔍 搜尋欄位 -->
        <form class="search-box" action="search.php" method="GET">
            <input type="text" name="keyword" placeholder="輸入關鍵字搜尋..." required>
            <button type="submit" class="btn btn-edit">🔍 搜尋</button>
        </form>

        <!-- ➕ 發表文章 -->
        <a href="post_create.php" class="btn btn-edit btn-new-post">➕ 發表新文章</a>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='article'>";
                echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
                echo "<p><strong>" . htmlspecialchars($row['content']) . "</strong></p>";
                echo "<p>需要學伴數量：" . htmlspecialchars($row['needed_partners']) . "</p>";

                // 顯示學系、年級
                echo "<small>作者：" . htmlspecialchars($row['author']) . "</small><br>";
                echo "<p><small>學系：" . htmlspecialchars($row['department']) . "</small></p>";
                echo "<p><small>年級：" . htmlspecialchars($row['grade']) . "</small></p>";

                // 發表時間
                echo "<p><small>發表時間：" . $row['created_at'] . "</small></p>";
                echo "<a href='post_edit.php?id=" . $row['id'] . "' class='btn btn-edit'>✏️ 修改</a>";
                echo "<a href='post_delete.php?id=" . $row['id'] . "' class='btn btn-delete'>🗑️ 刪除</a>";
                echo "<a href='like.php?id=" . $row['id'] . "' class='btn btn-like'>👍 按讚</a>";
                echo "<a href='share.php?id=" . $row['id'] . "' class='btn btn-share'>🔗 分享</a>";
                echo "<hr>";

                // 留言區
                echo "<form action='comment_add.php' method='POST'>";
                echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                echo "<input type='text' name='comment' placeholder='留言...' required style='width: 70%;'>";
                echo "<button class='btn btn-edit'>留言</button>";
                echo "</form>";

                // 顯示留言
                $post_id = $row['id'];
                $comment_sql = "SELECT * FROM comment WHERE post_id = $post_id ORDER BY created_at ASC";
                $comment_result = $conn->query($comment_sql);

                if ($comment_result->num_rows > 0) {
                    while ($comment_row = $comment_result->fetch_assoc()) {
                        echo "<p><strong>" . htmlspecialchars($comment_row['email']) . "</strong><br>";
                        echo htmlspecialchars($comment_row['content']) . "<br>";
                        echo "<small>留言時間：" . $comment_row['created_at'] . "</small></p>";
                    }
                } else {
                    echo "<p>目前沒有留言。</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>目前沒有文章。</p>";
        }
        ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>
