ws = new WebSocket("ws://127.0.0.1:2000");
ws.onopen = function() {
    console.log("Success!")
};
ws.onmessage = function(e) {
    console.log(JSON.parse(e.data));
    var html = document.getElementById("chat-left-above").innerHTML;
    document.getElementById("chat-left-above").innerHTML=html + "<div>"+e.data+"</div>";
};