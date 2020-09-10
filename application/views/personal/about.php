<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/31 0031
 * Time: 下午 7:41
 */
?>
<!DOCTYPE html>
<html lang="zh-cn" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>项目实战</title>
    <link rel="stylesheet" href="/assets/personal/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/personal/css/style.css">
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/personal" style="padding: 5px;" class="navbar-brand logo"><img style="width:150px;height: 40px" src="/assets/images/xlogo-blue.png"></a>
<!--            <a href="/personal/" class="navbar-brand logo"><img style="width:150px;height: 40px" src="/assets/images/xlogo-blue.png"></a>-->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li><a href="/personal/publicHome"><span class="glyphicon glyphicon-home"></span>首页</a></li>
                <li><a href="/personal/information"><span class="glyphicon glyphicon-list"></span>资讯</a></li>
                <li><a href="/personal/publicCase"><span class="glyphicon glyphicon-fire"></span>案例</a></li>
                <li class="active"><a href="/personal/about"><span class="glyphicon glyphicon-question-sign"></span>关于</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron">
    <div class="container">
        <hgroup>
            <h1>关于</h1>
            <h4>本站成长介绍...</h4>
        </hgroup>
    </div>
</div>
<div id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-xs hidden-sm">
                <div class="list-group">
                    <a class="list-group-item" href="#1">1.机构介绍</a>
                    <a class="list-group-item" href="#2">2.加入我们</a>
                    <a class="list-group-item" href="#3">3.联系方式</a>
                </div>
            </div>
            <div class="col-md-9 about">
                <a name="1"></a>
                <h3>机构介绍</h3>
                <p>查看样式查看样式查看样式查看样式查看样式</p>
                <a name="2"></a>
                <h3>加入我们</h3>
                <p>查看样式查看样式查看样式查看样式查看样式</p>
                <a name="3"></a>
                <h3>联系方式</h3>
                <p>地址:江苏无锡锡山区</p>
                <p>邮编:213000</p>
                <p>电话:157****7390</p>
            </div>
        </div>
    </div>
</div>


<footer id="footer">
    <div class="container">
        <p>业务规划 | 合作事宜 | 版权投诉</p>
        <p>Email：zxmzyl9189@gmail.com</p>
    </div>
</footer>


<script src="/assets/personal/js/vendor/jquery-1.11.2.min.js"></script>
<script src="/assets/personal/js/vendor/bootstrap.min.js"></script>
<script>

</script>
</body>
</html>