<?php
// 获取帖子 ID
if (!isset($_GET['id'])) {
    die("帖子ID未指定！");
}
$post_id = $_GET['id'];

// 数据库连接
include('db.php');

// 查询帖子内容
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

// 检查帖子是否存在
if ($result->num_rows == 0) {
    die("帖子未找到！");
}

$post = $result->fetch_assoc();

// 关闭数据库连接
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>帖子详情 - <?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="navbar.css">
    <style>
        /* 页面样式 */
        body {
            background-image: url('./images/02.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .container h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 18px;
            color: #333;
        }

        .container .post-info {
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

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

    <!-- 帖子内容展示 -->
    <div class="container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>

        <!-- 帖子信息 -->
        <div class="post-info">
            <span>发布者：<?php echo htmlspecialchars($post['username']); ?></span> |
            <span>发布时间：<?php echo $post['created_at']; ?></span>
        </div>

        <!-- 帖子内容 -->
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
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
