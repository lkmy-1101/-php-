<?php
include('db.php');
session_start(); // 启动会话

// 获取用户名和留言内容
$user = isset($_SESSION['username']) ? $_SESSION['username'] : ''; // 从会话中获取用户名
$message = isset($_POST['message']) ? trim($_POST['message']) : ''; // 获取并清理留言内容

// 验证留言内容是否为空
if (empty($message)) {
    echo "<script>alert('留言内容不能为空！'); window.history.back();</script>";
    exit;
}

// 插入留言到数据库
$sql = ("INSERT INTO messages (username, message) VALUES ('$user', '$message')");


// 执行插入操作
if (mysqli_query($conn, $sql)) {
    // 插入成功，跳转回留言板页面
    echo  "<script>alert('留言成功！');window.location.href = 'message-board.html';</script>";
    exit();
} else {
    // 插入失败，显示错误信息
    echo "<script>alert('留言失败，请稍后再试！'); window.history.back();</script>";
}

// 关闭数据库连接
$conn->close();
?>
