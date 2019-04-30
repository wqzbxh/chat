<?php
$access = $_POST['access'];
$pass = $_POST['password'];
//存数据库之前先判断一下数据库中是否存在该账号,存在就提示已存在,反之下一步存入数据库
include('database.php');//
$sql = "select * from  user where acces ='".$access."'";//查询数据中是否有此账号,
$result = mysqli_query($con,$sql);//执行sql 语句，查出来是一个对象
$arr = $result->fetch_all(MYSQLI_ASSOC);//取出关联数组
if(empty($arr)){//注册
	$insertSql = "INSERT INTO user (acces,pass,sex,age) VALUES ('".$access."','".$pass."', '2','21')";
	$insertResult = mysqli_query($con, $insertSql);
	if($insertResult){//已经成功了
		echo "<script>alert('添加成功！');window.location.href='http://local.chat.top/login.html'</script>";
	}else{//添加失败
		exit('添加失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
		}
}else{//
	 exit('账号已存在！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
}

