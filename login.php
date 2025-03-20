<?php
include 'db.php';
session_start();

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $errorMessage = "❌ 登入失敗，請檢查帳號或密碼。";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入 - 轉學生交流平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
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
        .btn-login {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn-login:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="login-container">
        <h2 class="text-center mb-4">🔐 會員登入</h2>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger text-center">
                <?= $errorMessage ?>
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

            <button type="submit" class="btn btn-login w-100">登入</button>
        </form>

        <p class="text-center mt-3">
            還沒有帳號？ <a href="register.php">註冊</a>
        </p>
    </div>
</div>

</body>
</html>
