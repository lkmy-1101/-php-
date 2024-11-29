<?php
include('db.php');

$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
$new_password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$create_time=date("Y-m-d H:i:s");

// 使用查询检查是否存在相同的用户名和邮箱
$sql = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // 用户名和邮箱匹配，更新密码
    $sql_update = "UPDATE users SET password = '$new_password', update_time = '$create_time' WHERE username = '$username' AND email = '$email'";
    
    if (mysqli_query($conn, $sql_update) ) {
        echo "<script>alert('密码更新成功！'); window.location.href = 'login.html';</script>";
    } else {
        echo "<script>alert('密码更新失败，请稍后再试！'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('用户名或邮箱不匹配，更新失败'); window.history.back();</script>";
}
?>