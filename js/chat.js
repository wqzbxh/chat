ws = new WebSocket("ws://127.0.0.1:2000");
var d =  document;
ws.onopen = function() {
    console.log("Success!")
	var msg_obj = {"action_type":"login","username":"普秋真","userid":1};
	var msg = JSON.stringify(msg_obj);
	ws.send(msg);
};
ws.onmessage = function(e) {
    var resultObj = JSON.parse(e.data);
	if(resultObj.action_type == 'login'){//f服务端返回状态是登录
		var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>'
		 $(".chat-left-above").append(html);
		 message_scrollTop();
	}
	if(resultObj.action_type == 'senAllMsg'){//f服务端返回状态是发消息
		if(resultObj.my_msg == 0){
			var html = '<div class="chat-content-list"><span class="username"><a href="">'+resultObj.username+'</a>：</span><span class="usertext">'+resultObj.content+'</span></div>';
		}else{
			var html = '<div class="chat-content-list"><span class="usernamemine"><a href="">'+resultObj.username+'</a>：</span><span class="usertextmine">'+resultObj.content+'</span></div>';
		}
		
		 $(".chat-left-above").append(html);
		 message_scrollTop();
	}  
	    // 当前在线人数
    if (resultObj.action_type == 'online_user_count') {
        var html = resultObj.online_user_count + '人在线';
		console.log(online_user_count);
        $("#online_user_count").html(html);
    } 
	    // 用户断开链接
    if (resultObj.action_type == 'user_on_close') {
		var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>'
        $(".chat-left-above").append(html);
        message_scrollTop();
    }
};

//滚动到底部
function scrollToEnd() {
    document.body.scrollTop = document.body.scrollHeight;
}

function message_scrollTop(){
  $(".chat-left-above").scrollTop($(".chat-left-above")[0].scrollHeight);
}