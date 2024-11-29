<?php
session_start();
include('db.php');

// 确保用户已登录
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// 获取当前登录用户的用户名
$username = $_SESSION['username'];

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $message = "标题和内容不能为空！";
    } else {
        $sql = "INSERT INTO posts (title, content, username) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $content, $username);

        if ($stmt->execute()) {
            $message = "帖子发布成功！";
        } else {
            $message = "发布失败，请重试！";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>发布新帖子</title>
    <link rel="stylesheet" href="navbar.css"> 
</head>
<style>
    /* 背景样式与 message-board 页面一致 */
    body {
        background-image: url('./images/02.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    /* 页脚样式统一 */
    footer {
        width: 100%;
        text-align: center;
        padding: 10px;
        background-color: rgba(0, 123, 255, 0.8);
        color: white;
        position: fixed;
        bottom: 0;
        left: 0;
    }

    /* 按钮与输入框样式优化 */
    .form-group input, .form-group textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        width: 98%;
        margin-bottom: 10px;
    }
    /* 容器标题的样式 */
    .container h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

    
    

    button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<body>

<nav>
    <div>
        <a href="user-center.php">个人中心</a>
        <a href="forum.php">论坛</a>
        <a href="message-board.html">留言板</a>
    </div>
    <button class="logout-btn" onclick="logout()">退出登录</button>
</nav>

<div class="container">
    <h2>发布新帖子</h2>

    <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

    <form method="POST" action="create-post.php">
        <div class="form-group">
            <label for="title">标题</label>
            <input type="text" id="title" name="title" placeholder="请输入帖子标题" required>
        </div>

        <div class="form-group">
            <label for="content">内容</label>
            <textarea id="content" name="content" rows="10" placeholder="请输入帖子内容" required></textarea>
        </div>

        <button type="submit" class="btn">发布</button>
    </form>
</div>

<footer>
    校园论坛系统 | 发布新帖子
</footer>

<script>
    function logout() {
        const confirmation = confirm("确认退出登录？");
        if (confirmation) {
            window.location.href = 'login.html';
        }
    }
</script>

</body>
</html>
