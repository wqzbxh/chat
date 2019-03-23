document.onkeydown=function(e){
    var content =  document.getElementById("chatContent").value;
    if(e.keyCode == 13 && e.ctrlKey){ // 这里实现换行
        document.getElementById("chatContent").value += "\n";

    }else if(e.keyCode == 13){// 避免回车键换行
        e.preventDefault();
        // 下面写你的发送消息的代码
// 		var msg_obj = '{"username":"普秋真","userid":1,"action_type":"send_msg","msg":"'+content+'"}';
// 		var msg = JSON.parse(msg_obj)
        if(content!= ""){
            ws.send(content);
			var text="";
			document.getElementById("chatContent").value = text;
        }
    }
}

