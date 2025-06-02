<?php
session_start();

if (!isset($_SESSION['user'])) {
    die("未登入");
}

$logged_in_user = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);


    $conn = new mysqli("localhost", "root", "", "sa_account");
    if ($conn->connect_error) {
        die("連線失敗：" . $conn->connect_error);
    }


    $check_sql = "SELECT * FROM comment WHERE id = $comment_id";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $comment = $check_result->fetch_assoc();
        if ($comment['email'] === $logged_in_user) {

            $delete_sql = "DELETE FROM comment WHERE id = $comment_id";
            if ($conn->query($delete_sql) === TRUE) {
                header("Location: index.php");
                exit();
            } else {
                echo "刪除失敗：" . $conn->error;
            }
        } else {
            echo "你只能刪除自己的留言。";
        }
    } else {
        echo "找不到留言。";
    }

    $conn->close();
} else {
    echo "非法請求。";
}
?>
