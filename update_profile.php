<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['user']; 
$nickname = $_POST['nickname'] ?? '';
$bio = $_POST['bio'] ?? '';
$skills = $_POST['skills'] ?? '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=sa_account;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("UPDATE account SET nickname = :nickname, bio = :bio, skills = :skills WHERE email = :email");
    $stmt->execute([
        ':nickname' => $nickname,
        ':bio' => $bio,
        ':skills' => $skills,
        ':email' => $email
    ]);

    header("Location: 個人資料.php");
    exit;

} catch (PDOException $e) {
    die("更新失敗：" . $e->getMessage());
}
