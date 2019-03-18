document.onkeydown=function(e){
    var content =  document.getElementById("chatContent").value;
    if(e.keyCode == 13 && e.ctrlKey){ // 这里实现换行
        document.getElementById("chatContent").value += "\n";

    }else if(e.keyCode == 13){// 避免回车键换行
        e.preventDefault();
        // 下面写你的发送消息的代码
        if(content!= ""){
            ws.send(content);
        }
    }
}

