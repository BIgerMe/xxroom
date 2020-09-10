<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/11/14
 * Time: 10:54
 */
?>


<!DOCTYPE html>
<?php $this->load->view("public/blogshow/header.php");?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="msg">开始<br></div>
<input type="text" id="text">
<input type="submit" value="发送数据" onclick="song()">
</body>
<script>
    var msg = document.getElementById("msg");
    var wsServer = 'ws://122.152.218.203:9502';
    //调用websocket对象建立连接：
    //参数：ws/wss(加密)：//ip:port （字符串）
    var websocket = new WebSocket(wsServer);
    //onopen监听连接打开
    websocket.onopen = function (evt) {
        console.log('连接成功');
        msg.innerHTML = "连接成功,开始聊天";
    };

    function song(){
        var text = document.getElementById('text').value;
        document.getElementById('text').value = '';
        //向服务器发送数据
        websocket.send(text);
    }
    //onmessage 监听服务器数据推送
    websocket.onmessage = function (evt) {
        msg.innerHTML += '<br>'+evt.data ;
//        console.log('Retrieved data from server: ' + evt.data);
    };
</script>
</html>
