<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>個人檔案</title>
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
    .profile-header {
      text-align: center;
      margin-bottom: 30px;
    }
    .profile-header h1 {
      margin: 10px 0;
    }
    .profile-header p {
      color: #666;
    }
    .btn {
      padding: 6px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
    }
    .btn-edit {
      background: #28a745;
      color: white;
    }
    .post-list {
      margin-top: 30px;
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

  <div class="profile-header">
    <h1>小明</h1>
    <p>📧 Email：xiaoming@example.com</p>
    <p>👋 自我介紹：大家好，我是小明，一位熱愛學習與分享的資工系學生，喜歡開發網頁應用和學習新技術。</p>
    <a href="編輯個人檔案.php" class="btn btn-edit">✏️ 編輯個人檔案</a>
  </div>

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

    <div class="post">
      <h3>想學 Vue.js，有人要組讀書會嗎？</h3>
      <p>內容：初學者想從 Vue 3 開始學習，可以一起看文件、做小專案～</p>
      <small>發表時間：2025-03-20</small>
    </div>

  </div>

</div>
</body>
</html>
