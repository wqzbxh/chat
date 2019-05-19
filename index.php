<?php
	 session_start();
	@var_dump($_GET['room_id']);
	if($_GET['room_id'] == NULL) {
			echo "<script>alert('房间号不存在！');window.location.href='http://local.chat.top/roomlist.php'</script>";
	}
	if($_SESSION['userinfo'] == NULL) {
			echo "<script>alert('没有用户信息！');window.location.href='http://local.chat.top/roomlist.php'</script>";
	}
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
			<div class="chat-title">聊天室：<span style="color: #555;font-size: 12px;" id="online_user_count">0人在线</span></div>
			<div id="nac">
				<div class="chat-left">
					<div class="chat-left-above" id="chat-left-above">
					</div>						
					<div class="chat-left-below">
						<textarea class="chat-left-text" id="chatContent"></textarea>
					</div>
				</div>
				<div class="chat-right">
					<div class="chat-list-title">在线列表</div>
					<div class="chat-list">
					</div>
				</div>	
			</div>
		</div> 
		<a href="server/quit.php">退出</a>
		<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
		<script> 
			var username="<?php echo $_SESSION['userinfo']; ?>";//定义用户姓名
			var userid="<?php echo $_SESSION['userid'];?>";//定义用户ID
			var room_id="<?php echo $_GET['room_id']; ?>";
			var type= 1;
			var touserid = 0;
		</script>
		<script src="js/chat.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/index.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
<script type="text/javascript">

</script>
