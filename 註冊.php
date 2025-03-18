<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 加密密碼

    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    try {
        $stmt->execute(['email' => $email, 'password' => $password]);
        echo "註冊成功！<a href='login.php'>點此登入</a>";
    } catch (PDOException $e) {
        echo "錯誤：" . $e->getMessage();
    }
}
?>
<form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="密碼">
    <button type="submit">註冊</button>
</form>
