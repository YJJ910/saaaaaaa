<?php
session_start();

// 檢查是否已登入
if (!isset($_SESSION['user'])) {
    die("請先登入才能發表文章");
}

$user_email = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>發表文章</title>
</head>
<body style="background:#f0ede5; font-family:sans-serif; padding:20px;">
    <div style="max-width:650px; margin:auto; background:white; padding:30px; border-radius:20px;">
        <h2>📝 發表文章</h2>
        <form action="post_submit.php" method="POST">
            <input type="text" name="title" placeholder="標題" required style="width:95%;padding:10px;"><br><br>

            <!-- 顯示 email 並自動填入 -->
            <input type="text" name="author_display" value="<?php echo htmlspecialchars($user_email); ?>" readonly style="width:95%;padding:10px; background:#eee;"><br><br>
            <input type="hidden" name="author" value="<?php echo htmlspecialchars($user_email); ?>">

            <input type="text" name="department" placeholder="科系（如：資訊工程系）" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="grade" placeholder="年級（如：大二）" required style="width:95%;padding:10px;"><br><br>

            <input type="text" name="goal" placeholder="學習目標（如：完成一個網頁專案）" style="width:95%;padding:10px;"><br><br>

            <textarea name="content" placeholder="內容（分享經驗、問題或資源）" rows="6" required style="width:95%;padding:10px;"></textarea><br><br>

            <input type="number" id="needed_partners" name="needed_partners" placeholder="需要學伴數量：" min="0" style="width:95%;padding:10px;"><br><br>

            <button type="submit" style="padding:10px 20px;">發表</button>
        </form>
    </div>
</body>
</html>
