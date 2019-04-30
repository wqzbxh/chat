ws = new WebSocket("ws://127.0.0.1:2000");
var d =  document;
ws.onopen = function() {
		var msg_obj = {"action_type":"login","username":username,"userid":userid};
		var msg = JSON.stringify(msg_obj);
		ws.send(msg);
};
ws.onmessage = function(e) {
    var resultObj = JSON.parse(e.data);
	if(resultObj.action_type == 'login'){//f服务端返回状态是登录
		var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>'
		console.log(resultObj);
		 $(".chat-left-above").append(html);
		 showUserList(resultObj.iser_list);
		 message_scrollTop();
	}
	if(resultObj.action_type == 'senAllMsg'){//f服务端返回状态是发消息
		if(resultObj.my_msg == 0){
			var html = '<div class="chat-content-list"><div class="usernametime"><span class="username"><a href="">'+resultObj.username+'：</a></span><i class="usertime">2019-04-28 17：29：45</i></div><div class="usercontent"><span class="usertext">'+resultObj.content+'</span></div></div>'
		}else{
			var html = '<div class="chat-content-list-minne"><div class="usernametime"><span class="username"><a href="">'+resultObj.username+'：</a></span><i class="usertime">2019-04-28 17：29：45</i></div><div class="usercontent"><span class="usertextmine">'+resultObj.content+'</span></div></div>'
		}
		
		 $(".chat-left-above").append(html);
		 message_scrollTop();
	}  
	    // 当前在线人数
    if (resultObj.action_type == 'online_user_count') {
        var html = resultObj.online_user_count + '人在线';
        $("#online_user_count").html(html);
    } 
	    // 用户断开链接
    if (resultObj.action_type == 'user_on_close') {
		var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>'
        $(".chat-left-above").append(html);
		showUserList(user_list)
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

function showUserList(user_list)
{
	$('.chat-list').html('');
	$.each(user_list,function(i,n){
		var htmllist = "<div><a href=chat_two.php?userid="+n.userid+">"+n.username+"</a></div>";
	    $('.chat-list').append(htmllist);
	});
}