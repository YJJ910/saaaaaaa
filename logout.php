<?php
session_start();
session_destroy(); // 清除所有 session
header("Location: login.php"); // 導回登入頁
exit();
?>
