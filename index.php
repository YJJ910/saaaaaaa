<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <style>
        body {
            background: #e9f7f1; /* 柔和藍灰色 */
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
            text-decoration: none; /* 去掉底線 */
            display: inline-block;
        }
        .btn-edit { background: #28a745; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-like { background: #ffc107; color: black; }
        .btn-share { background: #17a2b8; color: white; }
        .btn-new-post {
            margin-bottom: 20px; /* 增加與文章間距 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📚 文章列表</h2>
        <a href="post_create.php" class="btn btn-edit btn-new-post">➕ 發表新文章</a>

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
    </div>
</body>
</html>
