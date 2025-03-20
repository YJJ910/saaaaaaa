<?php
include 'db.php';

$errorMessage = '';
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // 檢查 Email 是否已存在
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $checkStmt->execute(['email' => $email]);
    
    if ($checkStmt->fetch()) {
        $errorMessage = "❌ 此 Email 已經被註冊，請使用其他 Email。";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // 加密密碼
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");

        try {
            $stmt->execute(['email' => $email, 'password' => $hashedPassword]);
            $successMessage = "✅ 註冊成功！<a href='login.php'>點此登入</a>";
        } catch (PDOException $e) {
            $errorMessage = "❌ 註冊失敗：" . $e->getMessage();
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
            background: #f8f9fa;
        }
        .register-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
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
        <h2 class="text-center mb-4">📝 註冊帳號</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger text-center">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success text-center">
                <?= $successMessage ?>
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
