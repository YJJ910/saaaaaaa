<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    die("請先登入才能查看文章或留言");
}

// 資料庫連線設定
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 取得所有文章
$sql = "SELECT * FROM post ORDER BY created_at DESC";
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
    </style>
</head>
<body>
<div class="container">
    <div style="text-align: right;">
        <form action="logout.php" method="post" style="display: inline;">
            <button type="submit" class="btn btn-delete">🚪 登出</button>
        </form>
    </div>
<div class="container">
    <h2>📚 文章列表</h2>

    <!-- 搜尋欄 -->
    <form class="search-box" action="search.php" method="GET">
        <input type="text" name="keyword" placeholder="輸入關鍵字搜尋..." required>
        <button type="submit" class="btn btn-edit">🔍 搜尋</button>
    </form>

    <!-- 發表文章 -->
    <a href="post_create.php" class="btn btn-edit btn-new-post">➕ 發表新文章</a>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
            echo "<p><strong>" . nl2br(htmlspecialchars($row['content'])) . "</strong></p>";
            echo "<p>需要學伴數量：" . htmlspecialchars($row['needed_partners']) . "</p>";
            echo "<small>作者：" . htmlspecialchars($row['author']) . "</small><br>";
            echo "<p><small>學系：" . htmlspecialchars($row['department']) . "</small></p>";
            echo "<p><small>年級：" . htmlspecialchars($row['grade']) . "</small></p>";
            echo "<p><small>發表時間：" . $row['created_at'] . "</small></p>";

            // 只有作者可以看到修改與刪除按鈕
            if ($row['author'] === $_SESSION['user']) {
                echo "<a href='post_edit.php?id=" . $row['id'] . "' class='btn btn-edit'>✏️ 修改</a>";
                echo "<a href='post_delete.php?id=" . $row['id'] . "' class='btn btn-delete' onclick=\"return confirm('確定要刪除這篇文章嗎？');\">🗑️ 刪除</a>";
            }

            echo "<a href='like.php?id=" . $row['id'] . "' class='btn btn-like'>👍 按讚</a>";
            echo "<a href='share.php?id=" . $row['id'] . "' class='btn btn-share'>🔗 分享</a>";
            echo "<hr>";

            // 留言表單
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
                    $comment_id = $comment_row['id'];
                    $comment_email = $comment_row['email'];
                    $comment_content = htmlspecialchars($comment_row['content']);

                    echo "<p><strong>" . htmlspecialchars($comment_email) . "</strong><br>";
                    echo $comment_content . "<br>";
                    echo "<small>留言時間：" . $comment_row['created_at'] . "</small></p>";

                    // 留言本人可以刪除
                    if ($comment_email === $_SESSION['user']) {
                        echo "<form action='comment_delete.php' method='POST' style='display:inline;'>";
                        echo "<input type='hidden' name='comment_id' value='" . $comment_id . "'>";
                        echo "<button type='submit' class='btn btn-delete' onclick=\"return confirm('確定要刪除這則留言嗎？');\">🗑️刪除留言</button>";
                        echo "</form>";
                    }
                }
            } else {
                echo "<p>你的留言區空無一人QQ。</p>";
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
