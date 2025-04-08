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
        body {
            background: url('https://img.ltn.com.tw/Upload/news/600/2021/12/09/3762840_1_1.jpg') no-repeat center center fixed;
            background-size: cover;
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
