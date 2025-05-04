<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user'];
$nickname = $_POST['nickname'] ?? '';
$bio = $_POST['bio'] ?? '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sa_account;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE account SET nickname = :nickname, bio = :bio WHERE email = :email");
    $stmt->execute([
        ':nickname' => $nickname,
        ':bio' => $bio,
        ':email' => $email
    ]);

    // 更新成功後導回個人檔案頁面
    header("Location: 個人資料.php");
    exit;

} catch (PDOException $e) {
    die("更新失敗：" . $e->getMessage());
}
?>
