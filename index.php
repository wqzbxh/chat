<?php
	 session_start();
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
						<div>王艺颖</div>
						<div>普秋真</div>
						<div>王海洋</div>
					</div>
				</div>	
			</div>
		</div> <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
		<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
		<script> var username="<?php echo $_SESSION['userinfo']; ?>";var userid="<?php echo $_SESSION['userid']; ?>"</script>
		<script src="js/chat.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/index.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
<script type="text/javascript">

</script>
