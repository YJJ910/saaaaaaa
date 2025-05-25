<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>設定學習目標</title>
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
        .section {
            margin-top: 20px;
        }
        .section input[type="text"], .section textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 6px 12px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>設定學習目標</h2>
        <form method="POST" action="save_goal.php">
            <div class="section">
                <input type="text" name="goal" placeholder="設定你的學習目標" required>
            </div>
            <div class="section">
                <button type="submit" class="btn btn-edit">設定目標</button>
            </div>
        </form>
    </div>
</body>
</html>