<?php
	unset($_SESSION['userinfo']);
	unset($_SESSION['userid']);
	echo "<script>alert('已退出！');window.location.href='http://local.chat.top/login.html'</script>";