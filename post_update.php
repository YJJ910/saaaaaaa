<?php
session_start();
if (!isset($_SESSION['user'])) {
    die("請先登入");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$id = $_POST['id'];
$title = $_POST['title'];
$department = $_POST['department'];
$grade = $_POST['grade'];
$goal = $_POST['goal'];
$content = $_POST['content'];
$needed_partners = $_POST['needed_partners'];

$check = $conn->prepare("SELECT author FROM post WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$check_result = $check->get_result();
$row = $check_result->fetch_assoc();

if (!$row || $row['author'] !== $_SESSION['user']) {
    die("你沒有權限修改這篇貼文");
}

$sql = "UPDATE post 
        SET title=?, department=?, grade=?, goal=?, content=?, needed_partners=?, created_at=NOW() 
        WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $title, $department, $grade, $goal, $content, $needed_partners, $id);

if ($stmt->execute()) {
    echo "修改成功！將於 2 秒後返回首頁。";
    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
} else {
    echo "更新失敗: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
