<?php
$host = 'localhost';
$dbname = 'sa_post';     // 資料庫名稱
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("資料庫（sa_post）連線失敗：" . $e->getMessage());
}
?>
