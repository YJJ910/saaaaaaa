<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$login_email = $_SESSION['user']; 
$target_email = isset($_GET['email']) ? $_GET['email'] : $login_email;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sa_account;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $pdo->prepare("SELECT nickname, email, bio, skills FROM account WHERE email = :email");
    $stmt->execute([':email' => $target_email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("使用者不存在");
    }

    
    $postStmt = $pdo->prepare("SELECT id, title, content, created_at FROM post WHERE author = :email ORDER BY created_at DESC");
    $postStmt->execute([':email' => $target_email]);
    $posts = $postStmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("資料庫錯誤：" . $e->getMessage());
}
?>

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
      margin: 5px 0;
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
<button class="back-button" onclick="history.back()">← 返回</button>
<div class="container">
  <div class="profile-header">
    <h1><?= htmlspecialchars($user['nickname']) ?></h1>
    <p><?= htmlspecialchars($user['email']) ?></p>
    <p><strong>自我介紹：</strong><br><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
    <p><strong>專業能力：</strong><br><?= nl2br(htmlspecialchars($user['skills'])) ?></p>
    

    <?php if ($login_email === $user['email']): ?>
      <a href="編輯個人檔案.php" class="btn btn-edit">✏️ 編輯個人檔案</a>
    <?php endif; ?>
  </div>

  <div class="post-list">
    <h2>📚 <?= $login_email === $user['email'] ? '我的貼文' : 'TA的貼文' ?></h2>
    <?php if (count($posts) > 0): ?>
      <?php foreach ($posts as $post): ?>
        <div class="post">
          <h3><?= htmlspecialchars($post['title']) ?></h3>
          <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
          <small>發佈於：<?= htmlspecialchars($post['created_at']) ?></small>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>尚未發佈任何貼文。</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
