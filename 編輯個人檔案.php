<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>編輯個人檔案</title>
  <style>
    body {
      background: #f0ede5;
      font-family: sans-serif;
      padding: 20px;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 5px;
    }
    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
      margin-top: 20px;
    }
    .post-list {
      margin-top: 40px;
    }
    .post {
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 8px;
    }
    .post h3 {
      margin: 0;
    }
    .post small {
      color: #888;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>👤 編輯個人檔案</h2>

  <form action="update_profile.php" method="POST">
    <label for="nickname">暱稱</label>
    <input type="text" id="nickname" name="nickname" value="小明" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="xiaoming@example.com" required>

    <label for="bio">自我介紹</label>
    <textarea id="bio" name="bio" rows="4">大家好，我是小明，一位熱愛學習與分享的資工系學生，喜歡開發網頁應用和學習新技術。</textarea>

    <button type="submit" class="btn">💾 儲存變更</button>
  </form>

  <div class="post-list">
    <h2>📝 我發過的貼文</h2>

    <div class="post">
      <h3>尋找一起練習 Leetcode 的夥伴</h3>
      <p>內容：希望每週能一起討論 2~3 題，有興趣的請留言～</p>
      <small>發表時間：2025-04-01</small>
    </div>

    <div class="post">
      <h3>需要統計學學伴</h3>
      <p>內容：這學期統計學進度好快，有沒有人想一起複習的？</p>
      <small>發表時間：2025-03-25</small>
    </div>

  </div>

</div>
</body>
</html>
