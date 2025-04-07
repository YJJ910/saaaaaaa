<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>尋找學伴</title>
    <style>
        body {
            background: #e9f7f1;
            padding: 20px;
            font-family: sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-box input[type="text"] {
            flex-grow: 1;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit { background: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>尋找學伴</h2>
        <form class="search-box" action="search_partner_results.php" method="GET">
            <input type="text" name="subject" placeholder="輸入學科名稱 (如：數學、英語等)" required>
            <button type="submit" class="btn btn-edit">搜尋學伴</button>
        </form>
        <p>請輸入你希望找到的學科，例如數學、英語、程式設計等。</p>
    </div>
</body>
</html>
