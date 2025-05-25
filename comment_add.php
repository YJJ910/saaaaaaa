<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    die("請先登入才能留言");
}

$comment = $_POST['comment'] ?? '';
$post_id = $_POST['post_id'] ?? '';
$parent_id = $_POST['parent_id'] ?? null;
$email = $_SESSION['user'];

if (empty($comment) || empty($post_id)) {
    die("留言內容或文章編號不得為空");
}

$conn = new mysqli("localhost", "root", "", "sa_account");
if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}

// 如果 parent_id 是空字串，設為 NULL
$parent_id = ($parent_id === '' || $parent_id === null) ? null : (int)$parent_id;

// 插入留言或回覆
$sql = "INSERT INTO comment (post_id, email, content, parent_id, created_at) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL 預備失敗：" . $conn->error);
}
$stmt->bind_param("issi", $post_id, $email, $comment, $parent_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: index.php");
exit;
?>
