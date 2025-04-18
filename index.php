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

    .section {
      margin-top: 30px;
      padding: 20px;
      background: #fff8e1;
      border-radius: 8px;
      border-left: 5px solid #f4a261;
    }

    .section h3 {
      margin-bottom: 15px;
    }

    .section a {
      display: inline-block;
      padding: 8px 14px;
      background-color: #e9c46a;
      color: #4e342e;
      border-radius: 6px;
      text-decoration: none;
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
      <a href="set_goal.php">🎯 學習目標</a>
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

    <!-- ➕ 發表文章 -->
    <a href="post_create.php" class="btn btn-edit btn-new-post">➕ 發表新文章</a>

    <!-- 📝 單篇文章範例 -->
    <div class="article">
      <h3>轉學經驗分享</h3>
      <p>剛轉學的那一年真的有點孤單，但我找到很多資源來幫助自己。</p>
      <small>👤 作者：example@email.com</small>
      <br><br>
      <a href="post_edit.php?id=1" class="btn btn-edit">✏️ 修改</a>
      <a href="post_delete.php?id=1" class="btn btn-delete">🗑️ 刪除</a>
      <a href="like.php?id=1" class="btn btn-like">👍 按讚 (5)</a>
      <a href="share.php?id=1" class="btn btn-share">🔗 分享</a>
      <hr>
      <form action="comment_add.php" method="POST">
        <input type="hidden" name="post_id" value="1">
        <input type="text" name="comment" placeholder="留言..." required style="width: 70%;">
        <button class="btn btn-edit">留言</button>
      </form>
      <p>💬 留言：很有共鳴！我也是剛轉來～</p>
    </div>

    <!-- 🌐 尋找學伴 -->
    <div class="section">
      <h3>🤝 尋找學伴</h3>
      <a href="search_partner.php">搜尋學伴</a>
    </div>

    <!-- 🎯 設定學習目標 -->
    <div class="section">
      <h3>🎯 設定學習目標</h3>
      <a href="set_goal.php">設定學習目標</a>
    </div>
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
