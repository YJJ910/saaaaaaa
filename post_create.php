<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>發表文章</title>
    <style>
        body {
            background: #f0ede5;
            font-family: sans-serif;
            padding: 20px;
        }
        .post-container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            position: relative; /* 設定相對定位 */
        }
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
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
    <div class="post-container">
        <button class="back-button" onclick="history.back()">← 返回</button>

        <h2>📝 發表文章</h2>
        <form action="post_submit.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="標題" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="author" placeholder="發文者（姓名或Email）" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="department" placeholder="科系（如：資訊工程系）" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="grade" placeholder="年級（如：大二）" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="goal" placeholder="學習目標（如：完成一個網頁專案）" style="width:95%;padding:10px;"><br><br>

            <textarea name="content" placeholder="內容（分享經驗、問題或資源）" rows="6" required style="width:95%;padding:10px;"></textarea><br><br>

            <label>上傳圖片或檔案：</label><br>
            <input type="file" name="attachment" accept="image/*,.pdf,.doc,.docx" style="margin-top:5px;"><br><br>

            <label>
                <input type="checkbox" name="looking_for_partner" value="1">
                是否尋找學伴
            </label><br><br>

            <button type="submit" style="padding:10px 20px;">發表</button>
        </form>
    </div>
</body>
</html>
