<?php
session_start();
if (!isset($_SESSION['user'])) {
    die("未登入");
}

$user_email = $_SESSION['user'];
$post_id = intval($_GET['id']);

// 資料庫連線
$conn = new mysqli("localhost", "root", "", "sa_account");
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 檢查是否已按讚
$check_sql = "SELECT * FROM likes WHERE post_id = $post_id AND user_email = '$user_email'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    // 已按讚 → 收回
    $conn->query("DELETE FROM likes WHERE post_id = $post_id AND user_email = '$user_email'");
} else {
    // 未按讚 → 新增
    $conn->query("INSERT INTO likes (post_id, user_email) VALUES ($post_id, '$user_email')");
}

$conn->close();
header("Location: index.php");
exit;
?>
