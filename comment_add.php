<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    die("請先登入才能留言");
}

// 取得留言內容與文章 ID
$comment = $_POST['comment'] ?? '';
$post_id = $_POST['post_id'] ?? '';
$email = $_SESSION['user'];  // 從登入 session 中取得 email

// 驗證基本欄位
if (empty($comment) || empty($post_id)) {
    die("留言內容或文章編號不得為空");
}

// 建立資料庫連線
$conn = new mysqli("localhost", "root", "", "sa_account");
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 預備 SQL，插入留言
$sql = "INSERT INTO comment (post_id, email, content, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL 預備失敗：" . $conn->error);
}

$stmt->bind_param("iss", $post_id, $email, $comment);
$stmt->execute();

// 關閉連線
$stmt->close();
$conn->close();

// 留言完成後回到文章列表
header("Location: index.php");
exit;
?>
