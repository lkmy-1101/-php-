<?php
session_start();
include('db.php'); // 引入数据库连接文件

// 查询最新的 5 条帖子
$sql = "SELECT id, title, username, created_at FROM posts ORDER BY created_at DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

// 将帖子存储到数组
$posts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}

// 关闭数据库连接
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>校园论坛 - 论坛</title>
    <!-- 引入外部 CSS 文件 -->
    <link rel="stylesheet" href="navbar.css">     
        <style>
        body {
            background-image: url('./images/02.jpg'); /* 背景图片 */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* 页面内容区域 */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            text-align: center;
            color: #333;
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .forum-section {
            width: 80%;
            max-width: 800px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.8); /* 半透明背景 */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .forum-section h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .forum-section p {
            font-size: 16px;
            color: #555;
        }

        .forum-list {
            list-style-type: none;
            padding: 0;
        }

        .forum-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .forum-list a {
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
        }

        .forum-list a:hover {
            text-decoration: underline;
        }

        /* 页脚 */
        footer {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <nav>
        <div>
            <a href="user-center.php">个人中心</a>
            <a href="forum.php">论坛</a>
            <a href="message-board.html">留言板</a>
        </div>
        <button class="logout-btn" onclick="logout()">退出登录</button>
    </nav>

    <!-- 页面内容 -->
    <div class="container">
        <h1>欢迎来到论坛</h1>

        <div class="forum-section">
            <h2>最新帖子</h2>
            <p>查看最近发表的帖子！</p>

            <!-- 最新帖子列表 -->
            <ul class="forum-list">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <li>
                            <a href="post-detail.php?id=<?php echo $post['id']; ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                            <br>
                            <small>作者: <?php echo htmlspecialchars($post['username']); ?> | 发布于: <?php echo $post['created_at']; ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>目前还没有帖子。</li>
                <?php endif; ?>
            </ul>
        </div>


        <!-- 发帖入口 -->
        <div class="forum-section">
            <h2>发帖</h2>
            <p>你也可以发布自己的帖子，与大家分享你的想法和见解。</p>
            <a href="create-post.php">发布新帖子</a>
        </div>

    </div>

    <!-- 页脚 -->
    <footer>
        <p>校园论坛系统</p>
    </footer>

    <script>
        // 退出登录的函数
        function logout() {
            const confirmation = confirm("确认退出登录？"); // 提示用户确认退出
            if (confirmation) {
                window.location.href = 'login.html'; // 跳转到登录页面
            }
        }
    </script>
</body>
</html>
