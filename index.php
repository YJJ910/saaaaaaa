<?php
session_start();
if (!isset($_SESSION['user'])) {
    die("請先登入才能查看文章或留言");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 取得排序參數
$sort = $_GET['sort'] ?? 'newest';

// 根據排序條件組合 SQL
switch ($sort) {
    case 'oldest':
        $sql = "SELECT post.*, 
                (SELECT COUNT(*) FROM likes WHERE likes.post_id = post.id) AS like_count 
                FROM post ORDER BY created_at ASC";
        break;
    case 'likes':
        $sql = "SELECT post.*, 
                (SELECT COUNT(*) FROM likes WHERE likes.post_id = post.id) AS like_count 
                FROM post ORDER BY like_count DESC, created_at DESC";
        break;
    case 'newest':
    default:
        $sql = "SELECT post.*, 
                (SELECT COUNT(*) FROM likes WHERE likes.post_id = post.id) AS like_count 
                FROM post ORDER BY created_at DESC";
        break;
}

function display_comments($conn, $post_id, $parent_id = null, $level = 0) {
  $sql = "SELECT * FROM comment WHERE post_id = $post_id AND " . 
         ($parent_id === null ? "parent_id IS NULL" : "parent_id = $parent_id") . " ORDER BY created_at ASC";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $email = htmlspecialchars($row['email']);
          $content = nl2br(htmlspecialchars($row['content']));
          $created_at = $row['created_at'];
          $comment_id = $row['id'];

          echo "<div style='margin-left: " . ($level * 2) . "em; border-left: 2px solid #ccc; padding-left: 10px; margin-top: 10px;'>";
          echo "<p><strong>{$email}</strong><br>{$content}<br><small>{$created_at}</small></p>";

          if ($email === $_SESSION['user']) {
              echo "<form action='comment_delete.php' method='POST' style='display:inline;'>
                      <input type='hidden' name='comment_id' value='{$comment_id}'>
                      <button type='submit' onclick=\"return confirm('確定要刪除嗎？')\">🗑️刪除</button>
                    </form>";
          }

          echo "<button onclick=\"toggleReplyBox('reply-box-{$comment_id}')\">↩️ 回覆</button>";

          echo "<form id='reply-box-{$comment_id}' action='comment_add.php' method='POST' style='display:none; margin-top:5px;'>
                  <input type='hidden' name='post_id' value='{$post_id}'>
                  <input type='hidden' name='parent_id' value='{$comment_id}'>
                  <input type='text' name='comment' placeholder='輸入回覆內容' required style='width: 70%;'>
                  <button>送出回覆</button>
                </form>";

          echo "</div>";

          display_comments($conn, $post_id, $comment_id, $level + 1);
      }
  } else if ($level === 0) {
      echo "<p>你的留言區空無一人QQ。</p>";
  }
}

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

    a.author-link {
      color: #1e88e5;
      text-decoration: none;
    }
    a.author-link:hover {
      text-decoration: underline;
    }
  </style>
  <script>
    function toggleReplyBox(id) {
      const box = document.getElementById(id);
      box.style.display = box.style.display === 'none' ? 'block' : 'none';
    }
  </script>
</head>
<body>

<header>
  <h1>📚 轉學生交流平台</h1>
  <div class="dropdown">
    <button>功能選單 ⌄</button>
    <div class="dropdown-content">
      <a href="post_create.php">✏️ 撰寫文章</a>
      <a href="search.php">🔍 搜尋</a>
      <a href="個人資料.php">👤 個人檔案</a>
      <a href="logout.php">🚪 登出</a>
    </div>
  </div>
</header>

<div class="container">
  <div class="main-content">
    <h2>📚 文章列表</h2>

    <form class="search-box" action="search.php" method="GET">
      <input type="text" name="keyword" placeholder="輸入關鍵字搜尋..." required>
      <button type="submit" class="btn btn-edit">🔍 搜尋</button>
    </form>

    <form method="GET" class="search-box">
      <label for="sort">排序方式：</label>
      <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>🕒 時間：新到舊</option>
        <option value="oldest" <?= $sort === 'oldest' ? 'selected' : '' ?>>🕒 時間：舊到新</option>
        <option value="likes" <?= $sort === 'likes' ? 'selected' : '' ?>>👍 按讚數排序</option>
      </select>
    </form>

    <a href="post_create.php" class="btn btn-edit btn-new-post">➕ 發表新文章</a>

    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='article'>";
            echo "<h1>" . htmlspecialchars($row['title']) . "</h1>";
            echo "<p><strong>" . nl2br(htmlspecialchars($row['content'])) . "</strong></p>";
            echo "<p>需要學伴數量：" . htmlspecialchars($row['needed_partners']) . "</p>";

            $author = htmlspecialchars($row['author']);
            echo "<small>作者：<a href='個人資料.php?email={$author}' class='author-link'>{$author}</a></small><br>";

            echo "<p><small>學系：" . htmlspecialchars($row['department']) . "</small></p>";
            echo "<p><small>年級：" . htmlspecialchars($row['grade']) . "</small></p>";
            echo "<p><small>發表時間：" . $row['created_at'] . "</small></p>";

            if ($row['author'] === $_SESSION['user']) {
                echo "<a href='post_edit.php?id=" . $row['id'] . "' class='btn btn-edit'>✏️ 修改</a>";
                echo "<a href='post_delete.php?id=" . $row['id'] . "' class='btn btn-delete' onclick=\"return confirm('確定要刪除這篇文章嗎？');\">🗑️ 刪除</a>";
            }

            $post_id = $row['id'];
            $like_count = $row['like_count'];

            $liked_sql = "SELECT 1 FROM likes WHERE post_id = $post_id AND user_email = '" . $_SESSION['user'] . "'";
            $liked_result = $conn->query($liked_sql);
            $liked = ($liked_result && $liked_result->num_rows > 0);
            $btn_text = $liked ? "💔 取消讚" : "👍 按讚";

            echo "<a href='like_toggle.php?id=$post_id' class='btn btn-like'>{$btn_text} ({$like_count})</a>";
            echo "<hr>";

            // 留言表單
            echo "<form action='comment_add.php' method='POST'>";
            echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
            echo "<input type='text' name='comment' placeholder='留言...' required style='width: 70%;'>";
            echo "<button>留言</button>";
            echo "</form>";

            display_comments($conn, $post_id);

            echo "</div>";
        }
    } else {
        echo "<p>目前沒有文章。</p>";
    }
    ?>
  </div>

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
