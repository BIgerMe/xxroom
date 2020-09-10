<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>主播录制界面</title>
</head>
<body>
<video id="video" autoplay="" style='width:640px;height:480px'></video>
<canvas id="output" style="display:none"></canvas>
<script type="text/javascript" charset="utf-8">
    var ws = new WebSocket("ws://122.152.218.203:8888");
    var back = document.getElementById('output');
    var backcontext = back.getContext('2d');
    var video = document.getElementById("video");
    var success = function(stream){
        video.src = window.URL.createObjectURL(stream);
    }
    ws.onopen = function(){
        draw();
    }
    var draw = function(){
        try{
            backcontext.drawImage(video,0,0, back.width, back.height);
        }catch(e){
            if (e.name == "NS_ERROR_NOT_AVAILABLE") {
                return setTimeout(draw, 100);
            } else {
                throw e;
            }
        }
        if(video.src){
            ws.send(back.toDataURL("image/jpeg", 0.5));
        }
        setTimeout(draw, 100);
    }
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia || navigator.msGetUserMedia;
    navigator.getUserMedia({video:true, audio:false}, success, console.log);
</script>
</body>
</html>