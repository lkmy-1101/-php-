<?php
// 引用数据库连接文件
include('db.php');

// 获取并清理用户输入
$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$creat_time=date("Y-m-d H:i:s");

// 插入数据到数据库
$sql = "INSERT INTO users (username, password, email, update_time) VALUES ('$username', '$password', '$email','$creat_time')";
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('注册成功！'); window.location.href = 'login.html';
    </script>";
} else {
    echo "<script>alert('注册失败，用户或密码已存在。'); window.history.back();</script>";
}

// 关闭数据库连接
mysqli_close($conn);
?>
