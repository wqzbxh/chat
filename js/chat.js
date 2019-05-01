ws = new WebSocket("ws://127.0.0.1:2000");
var d =  document;

ws.onopen = function() {
		var msg_obj = {"action_type":"login","username":username,"userid":userid,"room_id":room_id};
		var msg = JSON.stringify(msg_obj);
		ws.send(msg);
};

ws.onmessage = function(e) {
    var resultObj = JSON.parse(e.data);
	if(resultObj.action_type == 'login'){//f服务端返回状态是登录
	if(type == 1){
		var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>';
		$(".chat-left-above").append(html);
	}
		
		 // 当前在线人数
		var htmllist = resultObj.online_user_count + '人在线';
		$("#online_user_count").html(htmllist);
		
		 showUserList(resultObj.iser_list);
		 message_scrollTop();
	}
	if(resultObj.action_type == 'senAllMsg'){//f服务端返回状态是发消息
		if(resultObj.my_msg == 0){
			var html = '<div class="chat-content-list"><div class="usernametime"><span class="username"><a href="">'+resultObj.username+'：</a></span><i class="usertime">'+resultObj.time+'</i></div><div class="usercontent"><span class="usertext">'+resultObj.content+'</span></div></div>'
		}else{
			var html = '<div class="chat-content-list-minne"><div class="usernametime"><span class="username"><a href="">'+resultObj.username+'：</a></span><i class="usertime">'+resultObj.time+'</i></div><div class="usercontent"><span class="usertextmine">'+resultObj.content+'</span></div></div>'
		}
		
		 $(".chat-left-above").append(html);
		 message_scrollTop();
	}  
	    // 当前在线人数
    if (resultObj.action_type == 'online_user_count') {
       
    } 
	    // 用户断开链接
    if (resultObj.action_type == 'user_on_close') {
		if(type == 1){
			var html = '<div class="new-user"><a href="#">'+resultObj.username+'</a>'+resultObj.text+'</div>'
			$(".chat-left-above").append(html);
		}
				 // 当前在线人数
		var htmllist = resultObj.online_user_count + '人在线';
		$("#online_user_count").html(htmllist);
		showUserList(resultObj.iser_list)
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
		var htmllist = "<div class='userli' onclick='skip("+n.userid+")'>"+n.username+"</div>";
	    $('.chat-list').append(htmllist);
	});
}
// 私聊跳转
function skip(id)
{
	if(userid == id ){
		alert('不能与自己聊天');
		return;
	}
	window.open("chat_two.php?id="+id);
}