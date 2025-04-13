<?php
session_start();

// 取得 POST 的帳號密碼
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';

// 連接資料庫（sa_account）
$link = mysqli_connect('localhost', 'root', '', 'sa_account');

if (!$link) {
    die("資料庫連線失敗：" . mysqli_connect_error());
}

// 查詢是否有符合的帳號密碼
$sql = "SELECT * FROM account WHERE email='$email' AND password='$password'";
$result = mysqli_query($link, $sql);

// 如果找到帳號，就登入成功
if ($record = mysqli_fetch_assoc($result)) {
    $_SESSION['user'] = $record['email'];
    $_SESSION['user_id'] = $record['id'];

    echo "<script>
        alert('登入成功');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('登入失敗');
        window.location.href = 'login.php';
    </script>";
}

mysqli_close($link);
?>
