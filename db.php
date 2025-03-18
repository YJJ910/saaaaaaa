<?php
$host = 'localhost';  // 資料庫主機
$dbname = 'exchange_platform'; // 資料庫名稱
$username = 'root'; // MySQL 帳號
$password = ''; // MySQL 密碼 (XAMPP 預設為空)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("連線失敗：" . $e->getMessage());
}
?>
