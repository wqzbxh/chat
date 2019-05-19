<?php
	 session_start();
	if($_SESSION['userinfo'] == NULL) {
			echo "<script>alert('没有用户信息！');window.location.href='http://local.chat.top/roomlist.php'</script>";
	}
	 //获取这个私聊的ID以及用户信息保存起来
	 $touserid = $_GET['id'];
	 $myuserid = $_SESSION['userid'];
	 $userid_arrA = $touserid.'000000'.$myuserid;
	 $userid_arrB = $myuserid.'000000'.$touserid;
	include('server/database.php');
	
	//获取对方信息
	
	$sql = "select * from  user where id ='".$touserid."'";
	$result = mysqli_query($con,$sql);//查出来是一个对象
	$userInfo = $result->fetch_all(MYSQLI_ASSOC);
	if(empty($userInfo)){//说明数据库中不存在个用户
		echo "<script>alert('房间号不存在！');window.location.href='http://local.chat.top/roomlist.php'</script>";
		return;
	};
	$tousername = $userInfo[0]['acces'];
	$sql = "select * from  flock where userid_arr ='".$userid_arrA."'";
	$resultA = mysqli_query($con,$sql);//查出来是一个对象
	$arrA = $resultA->fetch_all(MYSQLI_ASSOC);
	
	$sql = "select * from  flock where userid_arr ='".$userid_arrB."'";
	$resultB= mysqli_query($con,$sql);//查出来是一个对象
	$arrB = $resultB->fetch_all(MYSQLI_ASSOC);
	
	if($arrA || $arrB){//存在一个是说明之前聊过天,
			if($arrA){
				$room_id = $arrA[0]['id'];
				$type = $arrA[0]['type'];
			}
			if($arrB){
				$room_id = $arrB[0]['id'];
				$type = $arrB[0]['type'];
			}
	}else{//找不到说明是没聊过,
		//重新创建一个房间号,然后进行通讯,	
			$insertSql = "INSERT INTO flock (belongs_id,type,userid_arr) VALUES ('".$myuserid."', '2','".$userid_arrA."')";
			$insertResult = mysqli_query($con, $insertSql);
			if($insertResult){//已经成功了
				$sql = "select * from  flock where userid_arr ='".$userid_arrA."'";
				$result= mysqli_query($con,$sql);//查出来是一个对象
				$arr= $result->fetch_all(MYSQLI_ASSOC);
				$room_id = $arr[0]['id'];
				$type = $arrB[0]['type'];
			}else{//添加失败
					echo "<script>alert('房间号不存在！');window.location.href='http://local.chat.top/roomlist.php'</script>";
					return;
			}
	}
	if($type == 2){//获取用户聊天信息
			$chatsql = "select *,FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s') as datetime from  content left join user on content.user_id = user.id  where content.to_purpose = ".$room_id;
			$chatsqlResult = mysqli_query($con, $chatsql);
			$chatarr= $chatsqlResult->fetch_all(MYSQLI_ASSOC);
			if($chatarr){
			}
			
			
	}
	 //给这这个设置房间号(唯一的房间号),下次聊也是这个房间号,保存两个的用户的聊天记录
	 
 ?>
 
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="index.css"/>
		<title>自制聊天室</title>
	</head>
	<body>
		<div class="chat-big-box">
			<div class="chat-title">对方:<?php echo $tousername;?></div>
			<div id="nac">
				<div class="chat-left">
					<div class="chat-left-above" id="chat-left-above">
						<?php
							foreach($chatarr as $value){
								if($value['user_id'] == $myuserid){ ?>
									<div class="chat-content-list"><div class="usernametime"><span class="username"><a href=""><?php echo $value['acces'] ?>：</a></span><i class="usertime"><?php echo $value['datetime'] ?></i></div><div class="usercontent"><span class="usertext"><?php echo $value['content'] ?></span></div></div>
							<?php 	}else{  ?>
									<div class="chat-content-list-minne"><div class="usernametime"><span class="username"><a href=""><?php echo $value['acces'] ?> ：</a></span><i class="usertime"><?php echo $value['datetime'] ?></i></div><div class="usercontent"><span class="usertextmine"><?php echo $value['content'] ?></span></div></div>
								<?php	}
							}
						 ?>
						
					</div>
					<div class="chat-left-below">
						<textarea class="chat-left-text" id="chatContent"></textarea>
					</div>
				</div>
				<div class="chat-right">
					
				</div>	
			</div>
		</div> 
		<a href="server/quit.php">退出</a>
		<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
		<script> 
			var username="<?php echo $_SESSION['userinfo']; ?>";
			var userid="<?php echo $_SESSION['userid']; ?>";
			var room_id="<?php echo $room_id; ?>";
			console.log(room_id);
			var type="<?php echo $type; ?>";
			var touserid="<?php echo $touserid; ?>";
		</script>
		<script src="js/chat.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/index.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
<script type="text/javascript">

</script>
