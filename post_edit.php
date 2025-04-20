<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>修改文章</title>
    <style>
        body {
            background: #f0ede5;
            font-family: sans-serif;
            padding: 20px;
        }
        .edit-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            position: relative; 
        }
        .back-button {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            background-color: #ccc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>

    <div class="edit-container">
        <button class="back-button" onclick="history.back()">← 返回</button>

        <h2>✏️ 修改文章</h2>
        <form action="#" method="POST">
            <input type="text" name="title" value="原標題" style="width:92%;padding:10px;" required><br><br>
            <textarea name="content" rows="6" style="width:92%;padding:10px;" required>原內容</textarea><br>
            <button type="submit" style="padding:10px 20px;">儲存修改</button>
        </form>
    </div>

</body>
</html>
