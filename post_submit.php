<?php
// 設定資料庫連線
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sa_account";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 取得表單資料
$title = $_POST['title'];
$author = $_POST['author'];
$department = $_POST['department'];
$grade = $_POST['grade'];
$goal = $_POST['goal'];
$content = $_POST['content'];
$needed_partners = $_POST['needed_partners'];

// 準備 SQL 查詢，將資料插入資料表
$sql = "INSERT INTO post (title, author, department, grade, goal, content, needed_partners)
        VALUES ('$title', '$author', '$department', '$grade', '$goal', '$content', '$needed_partners')";

// 執行 SQL 查詢
if ($conn->query($sql) === TRUE) {
    // 插入成功後，顯示成功訊息並跳轉
    echo "文章發表成功！將於 3 秒後轉到首頁。";
    echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>";
} else {
    echo "發表失敗: " . $conn->error;
}

// 關閉資料庫連接
$conn->close();
?>
