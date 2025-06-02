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

$id = $_GET['id'];
$sql = "SELECT * FROM post WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("找不到貼文");
}


if ($_SESSION['user'] !== $post['author']) {
    die("你沒有權限編輯這篇貼文");
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<style>
            .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 5px 12px;
            background-color: #ccc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #bbb;
        }
</style>
<head>
    <meta charset="UTF-8">
    <title>修改貼文</title>
</head>
<body style="background:#f0ede5; font-family:sans-serif; padding:20px;">
<button class="back-button" onclick="history.back()">← 返回</button>
    <div style="max-width:650px; margin:auto; background:white; padding:30px; border-radius:20px;">
        <h2>✏️ 修改貼文</h2>
        <form action="post_update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

            
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required style="width:95%;padding:10px;"><br><br>
            <input type="text" name="author_display" value="<?php echo htmlspecialchars($post['author']); ?>" readonly style="width:95%;padding:10px; background:#eee;"><br><br>
            <input type="hidden" name="author" value="<?php echo htmlspecialchars($post['author']); ?>">

            <input type="text" name="department" value="<?php echo htmlspecialchars($post['department']); ?>" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="grade" value="<?php echo htmlspecialchars($post['grade']); ?>" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="goal" value="<?php echo htmlspecialchars($post['goal']); ?>" style="width:95%;padding:10px;"><br><br>

            <textarea name="content" rows="6" required style="width:95%;padding:10px;"><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

            <input type="number" name="needed_partners" value="<?php echo $post['needed_partners']; ?>" min="0" style="width:95%;padding:10px;"><br><br>

            <button type="submit" style="padding:10px 20px;">更新貼文</button>
        </form>
    </div>
</body>
</html>
