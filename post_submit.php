<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

$title = $_POST['title'];
$author = $_POST['author'];
$department = $_POST['department'];
$grade = $_POST['grade'];
$goal = $_POST['goal'];
$content = $_POST['content'];
$needed_partners = $_POST['needed_partners'];

$sql = "INSERT INTO post (title, author, department, grade, goal, content, needed_partners)
        VALUES ('$title', '$author', '$department', '$grade', '$goal', '$content', '$needed_partners')";

if ($conn->query($sql) === TRUE) {
    echo "文章發表成功！將於 3 秒後轉到首頁。";
    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>";
} else {
    echo "發表失敗: " . $conn->error;
}

$conn->close();
?>
