<?php
include('db.php');
session_start();

// 获取留言 ID
$messageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($messageId > 0) {
    // 删除留言
    $sql = "DELETE FROM messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $messageId);

    if ($stmt->execute()) {
        echo "<script>alert('留言已删除！'); window.location.href = 'message-board.html';</script>";
    } else {
        echo "<script>alert('删除留言失败！'); window.location.href = 'message-board.html';</script>";
    }
    $stmt->close();
}

$conn->close();
?>
