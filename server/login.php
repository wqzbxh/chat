<?php
session_start();
$access = $_POST['access'];
$pass = $_POST['password'];
$url ="http://local.chat.top/login.html";
if(!empty($access) && !empty($pass)){//验证账号和密码是否为空
	include('database.php');
	$sql = "select * from  user where acces ='".$access."' and pass = '".$pass."'";
	$result = mysqli_query($con,$sql);//查出来是一个对象
	$arr = $result->fetch_all(MYSQLI_ASSOC);
	if(!empty($arr)){//账号密码正确
		$_SESSION['userinfo'] = $access;//把用户名存起来session
		$_SESSION['userid'] = $arr[0]['id'];//把用户名存起来session
		echo "<script>window.location.href='http://local.chat.top/zhuye.php'</script>";
	}else{
		 exit('账号密码不正确！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
	}
}else{
	  exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}
w:windows ;
a:apache ;
m:mysql ;
p: php ;


//连接数据库查询账号密码是不是存在这个数据库里面
	//如果存在数据库则调到登录页面并把用户写进session
	
	
//反之跳回登录页面
