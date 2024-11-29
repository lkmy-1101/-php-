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

// 获取用户信息
$sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// 获取用户留言
$messageSql = "SELECT * FROM messages WHERE username = '$username' ORDER BY created_at DESC";
$messageResult = mysqli_query($conn, $messageSql);

// 处理用户信息更新
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // 更新用户信息
    $updateSql = "UPDATE users SET email = '$email' WHERE username = '$username'";
    if (mysqli_query($conn, $updateSql)) {
        $user['email'] = $email;  // 更新用户信息到页面
        $message = "信息更新成功！";
    } else {
        $message = "信息更新失败，请重试！";
    }
}

// 关闭数据库连接
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <link rel="stylesheet" href="navbar.css">
    <style>
        /* 页面样式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: rgba(0, 123, 255, 0.8);
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 18px;
        }

        nav a:hover {
            background-color: #0056b3;
            border-radius: 4px;
        }

        .container {
            background-color: white;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            color: #007BFF;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 10px;
        }

        .message-list {
            margin-top: 30px;
        }

        .message-item {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>
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
        <h2>个人中心</h2>
        
        <!-- 显示更新信息的反馈消息 -->
        <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

        <form method="POST" action="user-center.php">
            <div class="form-group">
                <label for="username">用户名</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            </div>

            <div class="form-group">
                <label for="email">电子邮件</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <button type="submit" class="btn">更新信息</button>
        </form>

        <div class="message-list">
            <h3>我的留言</h3>
            <?php if (mysqli_num_rows($messageResult) > 0) { 
                while ($message = mysqli_fetch_assoc($messageResult)) {
                    echo "<div class='message-item'>
                            <p><strong>留言时间：</strong>" . $message['created_at'] . "</p>
                            <p><strong>留言内容：</strong>" . nl2br(htmlspecialchars($message['message'])) . "</p>
                          </div>";
                }
            } else {
                echo "<p>没有留言记录</p>";
            } ?>
        </div>
    </div>

    <footer>
        校园论坛系统 | 个人中心
    </footer>

    <script>
        // 退出登录的函数
        function logout() {
            const confirmation = confirm("确认退出登录？");
            if (confirmation) {
                window.location.href = 'login.html';
            }
        }
    </script>

</body>
</html>
