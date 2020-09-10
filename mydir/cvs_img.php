<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2018/2/28
 * Time: 9:17
 */
if(@$img = $_POST['img']) {
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
        $type = $result[2];
    }
    $file = "save_img/zxm".time().'.'.$type;
    $base_code =  base64_decode(str_replace(' ','+',str_replace($result[1],'',$img)));
    file_put_contents($file,$base_code);
    exit;
}else{}
?>
<!--利用canvas来制作并上传图片-->
<html>
<body>

<canvas id="myCanvas" width="500" height="500" style="border:0px solid #d3d3d3;">
    您的浏览器不支持 HTML5 canvas 标签。
</canvas>
<script>
    var c=document.getElementById("myCanvas");
    var ctx=c.getContext("2d");

    var grd=ctx.createRadialGradient(250,250,155,250,250,660);
    // grd.addColorStop(0,"#001fff");
    grd.addColorStop(1,"#FFFFFF");
    ctx.fillStyle = grd;
//    ctx.fillStyle="#006fcf";
    ctx.fillRect(0,0,500,500);
//    ctx.fillStyle="#006fcf";
//    ctx.fillRect(125,125,250,250);

    ctx.lineWidth = "10"
    ctx.beginPath();
    ctx.moveTo(125,125);
    ctx.lineTo(375,125);
    ctx.moveTo(125,375);
    ctx.lineTo(375,375);
    ctx.strokeStyle= "#00FFFF";
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(125,125);
    ctx.lineTo(125,375);
    ctx.moveTo(375,125);
    ctx.lineTo(375,375);
    ctx.strokeStyle= "#FFFF00";
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(125,125);
    ctx.lineTo(250,250);
    ctx.strokeStyle= "#FF0000";
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(250,250);
    ctx.lineTo(375,125);
    ctx.strokeStyle= "#000000";
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(125,375);
    ctx.lineTo(250,250);
    ctx.strokeStyle= "#0000FF";
    ctx.stroke();

    ctx.beginPath();
    ctx.moveTo(250,250);
    ctx.lineTo(375,375);
    ctx.strokeStyle= "#FF00FF";
    ctx.stroke();


    var strDataURI = c.toDataURL("image/png");
    post(strDataURI);

    function post(d) {
        var ajax = null;

        if (window.XMLHttpRequest) {
            ajax = new XMLHttpRequest();
        } else {
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        }
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
//                alert(ajax.responseText);
            }
        }
        ajax.open("POST", "cvs_img.php", true);
        ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        ajax.send("img=" + d);
    }
</script>
</body>
</html>