<?php
// 创建连接
$con = mysqli_connect('localhost','root','root','chat','3306');
//判断是否连接成功
if(!$con){
    echo "数据库失败！";
}
?>