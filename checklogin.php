<?php
session_start();


$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';


$link = mysqli_connect('localhost', 'root', '', 'sa_account');

if (!$link) {
    die("資料庫連線失敗：" . mysqli_connect_error());
}


$sql = "SELECT * FROM account WHERE email='$email' AND password='$password'";
$result = mysqli_query($link, $sql);


if ($record = mysqli_fetch_assoc($result)) {
    $_SESSION['user'] = $record['email'];
    $_SESSION['user_id'] = $record['id'];

    echo "<script>
        alert('登入成功');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('登入失敗');
        window.location.href = 'login.php';
    </script>";
}

mysqli_close($link);
?>
