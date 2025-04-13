<?php
require_once 'db_account.php'; // 引入 sa_account 資料庫連線

$errorMessage = '';
$successMessage = '';

// 如果使用者送出表單
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 簡單驗證
    if (empty($email) || empty($password)) {
        $errorMessage = '請填寫所有欄位。';
    } else {
        try {
            // 準備 SQL 插入語法（不使用密碼加密）
            $stmt = $pdo->prepare("INSERT INTO account (email, password) VALUES (:email, :password)");
            $stmt->execute([
                ':email' => $email,
                ':password' => $password // 沒有加密直接存明文密碼
            ]);

            $successMessage = '註冊成功！';
        } catch (PDOException $e) {
            $errorMessage = '註冊失敗：' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊 - 轉學生交流平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://img.ltn.com.tw/Upload/news/600/2021/12/09/3762840_1_1.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .register-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-register {
            background: #28a745;
            color: white;
            font-weight: bold;
        }
        .btn-register:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="register-container">
        <h2 class="text-center mb-4">📝 轉學生交流平台</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success text-center">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">電子郵件</label>
                <input type="email" class="form-control" name="email" id="email" required placeholder="請輸入 Email">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">密碼</label>
                <input type="password" class="form-control" name="password" id="password" required placeholder="請輸入密碼">
            </div>

            <button type="submit" class="btn btn-register w-100">註冊</button>
        </form>

        <p class="text-center mt-3">
            已經有帳號？ <a href="login.php">登入</a>
        </p>
    </div>
</div>

</body>
</html>
