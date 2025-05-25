<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user']; // 使用 session 中的 user

// 從資料庫取得使用者資料
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sa_account;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT nickname, email, bio, skills FROM account WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("使用者不存在");
    }

} catch (PDOException $e) {
    die("資料庫連線失敗：" . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>編輯個人檔案</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f0ede5;
      font-family: 'Arial', sans-serif;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .profile-header {
      text-align: center;
      margin-bottom: 30px;
    }
    .profile-header h2 {
      margin: 10px 0;
      color: #333;
    }
    .form-label {
      font-weight: bold;
      color: #555;
    }
    .form-control {
      border-radius: 8px;
      box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .form-control:focus {
      border-color: #28a745;
      box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
    textarea.form-control {
      resize: vertical;
      min-height: 150px;
    }
    .btn-submit {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }
    .btn-submit:hover {
      background-color: #218838;
    }
    .text-center a {
      color: #007bff;
      text-decoration: none;
    }
    .text-center a:hover {
      text-decoration: underline;
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
    <h2>👤 編輯個人檔案</h2>
  </div>

  <form action="update_profile.php" method="POST">
    <div class="mb-3">
      <label for="nickname" class="form-label">暱稱</label>
      <input type="text" id="nickname" name="nickname" class="form-control" value="<?= htmlspecialchars($user['nickname']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="bio" class="form-label">自我介紹</label>
      <textarea id="bio" name="bio" class="form-control" rows="4" placeholder="請簡單介紹自己，例如興趣、目前在學的科系或想找什麼樣的學伴"><?= htmlspecialchars($user['bio']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="skills" class="form-label">專業能力</label>
      <textarea id="skills" name="skills" class="form-control" rows="3" placeholder="請簡述你的專業能力:如多益分數、是否通過機測?、日文程度"><?= htmlspecialchars($user['skills']) ?></textarea>
    </div>

    <button type="submit" class="btn-submit">💾 儲存變更</button>
  </form>
</div>
</body>
</html>