<?php
	 session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>个人中心</title>
	<link rel="stylesheet" type="text/css" href="css/ui.css">
	<link href="favicon.ico" type="image/x-icon" rel="icon">
	<link href="iTunesArtwork_402x.png" sizes="114x114" rel="apple-touch-icon-precomposed">
</head>
<body style="text-align: center;margin-left:45% ;width: 100%;">
	<div class="aui-container" style="width:360px;text-align: center;">
		<div class="aui-page">
			<div class="aui-page-my">
				<div class="aui-my-info">
					<div class="aui-my-info-back"></div>
					<a href="javascript:;" class="">
						<img src="images/icon-png/my-aw.jpg" class="aui-my-avatar">
					</a>
					<div class="aui-mt-location aui-l-red"></div>
				</div>
				<div class="aui-l-content">
					<div class="aui-menu-list aui-menu-list-clear">
						<ul>
							<li class="b-line">
								<a href="my-put.html">
									<div class="aui-icon"><img src="images/icon-home/my-in1.png"></div>
									<h3>姓名：<?php echo  $_SESSION['userinfo'] ;?></h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
							<li class="b-line">
								<a href="roomlist.php">
									<div class="aui-icon"><img src="images/icon-home/my-in2.png"></div>
									<h3>加入群聊</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
							<li class="b-line">
								<a href="my-secure.html">
									<div class="aui-icon"><img src="images/icon-home/my-in3.png"></div>
									<h3>创建房间</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
<!-- 							<li class="b-line">
								<a href="my-up.html">
									<div class="aui-icon"><img src="images/icon-home/my-in4.png"></div>
									<h3>好友列表</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
							<li class="b-line">
								<a href="my-up.html">
									<div class="aui-icon"><img src="images/icon-home/my-in5.png"></div>
									<h3>阅读</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
							<li class="b-line">
								<a href="my-up.html">
									<div class="aui-icon"><img src="images/icon-home/my-in6.png"></div>
									<h3>服务区域</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li>
							<li class="b-line">
								<a href="my-up.html">
									<div class="aui-icon"><img src="images/icon-home/my-in8.png"></div>
									<h3>推荐给好友</h3>
									<div class="aui-time"><i class="aui-jump"></i></div>
								</a>
							</li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>