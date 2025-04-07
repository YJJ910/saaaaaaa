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
    </style>
</head>
<body>
    <div class="container">
        <?php
            // 取得關鍵字（從網址參數）
            $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '';
        ?>
        <h2>🔍 搜尋結果：<em><?= $keyword ?></em></h2>

        <!-- ✅ 模擬一筆符合的文章 -->
        <?php if ($keyword === '轉學'): ?>
            <div class="article">
                <h3>轉學經驗分享</h3>
                <p>剛轉學的那一年真的有點孤單，但我找到很多資源來幫助自己。</p>
                <small>作者：example@email.com</small>
                <br><br>
                <a href="post_edit.php?id=1" class="btn btn-edit">✏️ 修改</a>
                <a href="post_delete.php?id=1" class="btn btn-delete">🗑️ 刪除</a>
                <a href="like.php?id=1" class="btn btn-like">👍 按讚 (5)</a>
                <a href="share.php?id=1" class="btn btn-share">🔗 分享</a>
            </div>
        <?php else: ?>
            <!-- ❌ 找不到任何符合 -->
            <p>❗ 找不到與「<strong><?= $keyword ?></strong>」相關的文章。</p>
        <?php endif; ?>

        <a href="index.php" class="btn btn-edit">⬅ 返回首頁</a>
    </div>
</body>
</html>
