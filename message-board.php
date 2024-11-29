<?php
// message-board.php - 显示留言板和留言列表

session_start();
include('db.php'); // 引入数据库连接

// 获取当前登录的用户名，如果没有登录，使用“匿名”
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '匿名';

// 获取留言数据
$sql = "SELECT id, username, message, created_at FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

// 关闭数据库连接
mysqli_close($conn);

$messages = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}


// 设置 Content-Type 为 JSON 并输出数据
header('Content-Type: application/json');
echo json_encode($messages);
?>


