<?php
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '123456';          // mysql用户名密码
$dbname = 'luntan';     // 数据库名称
// 创建数据库连接
$conn = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname);

// if(! $conn )
// {
//     die('Could not connect: ' . mysqli_error());
// }
// echo '数据库连接成功！';
// mysqli_close($conn);
?>