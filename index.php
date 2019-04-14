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
		<script> var username="<?php echo $_SESSION['userinfo']; ?>"</script>
		<script src="js/chat.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>
<script type="text/javascript">
	var userid = 1;
	var username =" <?php echo $_SESSION['userinfo']; ?>";
	document.onkeydown=function(e){
	    var content =  document.getElementById("chatContent").value;
	    if(e.keyCode == 13 && e.ctrlKey){ // 这里实现换行
	        document.getElementById("chatContent").value += "\n";
	    }else if(e.keyCode == 13){// 避免回车键换行
	        e.preventDefault();
	        // 下面写你的发送消息的代码
			var msg_obj = {"action_type":"senAllMsg","username":username,"userid":userid,"content":content};
	 		var msg = JSON.stringify(msg_obj);
	        if(content!= ""){
	            ws.send(msg);
				var text="";
				document.getElementById("chatContent").value = text;
	        }
	    }
	}
</script>
