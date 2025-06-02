<?php
session_start();


if (!isset($_SESSION['user'])) {
    die("請先登入才能刪除文章");
}

if (!isset($_GET['id'])) {
    die("未指定要刪除的文章 ID");
}

$post_id = intval($_GET['id']);
$user_email = $_SESSION['user']; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$check_sql = "SELECT author FROM post WHERE id = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("找不到這篇文章");
}

$row = $result->fetch_assoc();
$article_author = $row['author'];

if ($user_email !== $article_author) {
    die("你只能刪除自己發表的文章");
}

$delete_sql = "DELETE FROM post WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $post_id);

if ($delete_stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "刪除失敗：" . $conn->error;
}

$conn->close();
?>

