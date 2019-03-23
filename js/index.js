var userid = 1;
var username = "普秋真";
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
