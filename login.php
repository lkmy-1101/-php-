<?php
// 引用数据库连接文件
include('db.php');

session_start();

$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

if (empty($username) || empty($password)) {
    echo "<script>alert('用户名或密码不能为空！'); window.history.back();</script>";
     exit;
}
// 查询数据库中是否存在该用户名和密码
$sql = "SELECT id, username, password, email FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // 用户名和密码匹配，登录成功
    $user = mysqli_fetch_assoc($result); // 获取用户信息
    $_SESSION['username'] = $user['username']; // 将用户名存储到Session中

    echo "<script>
        alert('登录成功！'); window.location.href = 'forum.php';
     </script>";
    exit;
} else {
    // 用户名或密码错误
    echo "<script>alert('用户名或密码错误！'); window.history.back();</script>";
}



// 关闭连接
mysqli_close($conn);
?>
    