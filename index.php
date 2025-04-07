<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁 - 轉學生交流平台</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .logout {
            float: right;
            text-decoration: none;
            background: red;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
        form {
            margin-top: 20px;
            text-align: left;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .article {
            border: 1px solid #ddd;
            padding: 15px;
            background: white;
            margin-top: 10px;
            border-radius: 8px;
            text-align: left;
        }
        .article h4 {
            margin: 0;
            color: #007BFF;
        }
        .article small {
            color: #666;
        }
    </style>
</head>
<body>

    <div class="container">
        <a href="logout.php" class="logout">登出</a>
        <h2>🎉 歡迎，<?= htmlspecialchars($user['email']) ?>！</h2>
        
        <h3>📝 撰寫文章</h3>
        <form method="POST">
            <input type="text" name="title" required placeholder="輸入文章標題">
            <textarea name="content" rows="5" required placeholder="輸入文章內容"></textarea>
            <button type="submit">發表文章</button>
        </form>

        <h3>📚 文章列表</h3>
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h4><?= htmlspecialchars($article['title']) ?></h4>
                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                <small>✍️ 作者：<?= htmlspecialchars($article['email']) ?> | 🕒 時間：<?= $article['created_at'] ?></small>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>
