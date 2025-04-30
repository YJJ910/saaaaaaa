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
  <meta charset="UTF-8" />
  <title>轉學生交流平台</title>
  <style>
    body {
      margin: 0;
      background-color: #fdf6ec;
      font-family: 'Segoe UI', sans-serif;
      color: #4e342e;
    }

    header {
      background-color: #f4a261;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown button {
      background-color: #f4a261;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff3e0;
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      border-radius: 6px;
      z-index: 1;
    }

    .dropdown-content a {
      color: #4e342e;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #ffe0b2;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .container {
      display: flex;
      padding: 20px;
      gap: 20px;
      max-width: 1200px;
      margin: auto;
    }

    .main-content {
      flex: 3;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .sidebar {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .card {
      background-color: #fff8e1;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.05);
      border-left: 5px solid #f4a261;
    }

    .card h4 {
      margin: 0 0 10px;
      color: #6d4c41;
    }

    .card a {
      display: inline-block;
      padding: 8px 14px;
      background-color: #e9c46a;
      color: #4e342e;
      border-radius: 6px;
      text-decoration: none;
      margin-top: 10px;
    }

    h2 {
      color: #6d4c41;
    }

    .article {
      border: 1px solid #e0c6b5;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      background: #fffefc;
    }

    .article h3 {
      margin-top: 0;
      color: #8d6e63;
    }

    .btn {
      padding: 6px 12px;
      margin-right: 8px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
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

<header>
  <h1>📚 轉學生交流平台</h1>
  <div class="dropdown">
    <button>功能選單 ⌄</button>
    <div class="dropdown-content">
      <a href="post_create.php">✏️ 撰寫文章</a>
      <a href="search.php">🔍 搜尋</a>
      <a href="profile.php">👤 個人檔案</a>
      <a href="set_goal.php">🎯 學習目標</a> <!-- 如不再需要，這行也可刪除 -->
    </div>
  </div>
</header>

<div class="container">
  <div class="main-content">
    <h2>📚 文章列表</h2>

    <!-- 🔍 搜尋欄位 -->
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
  <div class="sidebar">
    <div class="card">
      <h4>📝 撰寫文章</h4>
      <a href="post_create.php">前往發表</a>
    </div>

    <div class="card">
      <h4>🤝 尋找學伴</h4>
      <a href="search_partner.php">搜尋學伴</a>
    </div>

    <div class="card">
      <h4>🎯 學習目標</h4>
      <a href="set_goal.php">設定目標</a>
    </div>
  </div>
</div>

</body>
</html>