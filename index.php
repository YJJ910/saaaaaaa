<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <style>
        body {
            background:#f0ede5;
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
        .section form {
            display: flex;
            flex-direction: column;
        }
        .section input[type="text"], .section textarea {
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
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

        <!-- 📝 單篇文章範例 -->
        <div class="article">
            <h3>轉學經驗分享</h3>
            <p>剛轉學的那一年真的有點孤單，但我找到很多資源來幫助自己。</p>
            <small>作者：example@email.com</small>
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
            <a href="search_partner.php" class="btn btn-edit">搜尋學伴</a>

        </div>

        <!-- 🎯 設定學習目標 -->
        <div class="section">
            <h3>🎯 設定學習目標</h3>
            <a href="set_goal.php" class="btn btn-edit">設定學習目標</a>
        </div>

    </div>
</body>
</html>
