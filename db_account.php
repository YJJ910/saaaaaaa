<?php
$host = 'localhost';
$dbname = 'sa_account';
$username = 'root'; // 預設是 root
$password = '';     // 如果有密碼請填入

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("資料庫連線失敗：" . $e->getMessage());
}
?>