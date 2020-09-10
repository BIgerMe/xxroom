<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title>Xroom</title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/blog/css/style.css">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/prism.css" rel="stylesheet">
    <script src="/assets/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/markdown/lib/marked.js"></script>
    <script src="/assets/js/prism.js"></script>
    <script src="/assets/js/local.js"></script>
    <!--jqueryUi-->
    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
</head>
<style type="text/css">
    @media (min-width: 1200px){
        .container {
            width: 1440px;
        }
    }
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/personal" style="padding: 5px;" class="navbar-brand logo"><img style="width:150px;height: 40px" src="/assets/images/xlogo-blue.png"></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li><a href="/blog/index"><span class="glyphicon glyphicon-list"></span>博客列表</a></li>
                <li <?php if(preg_match('/addPage/',$_SERVER['REDIRECT_URL']) != false) echo "class='active'"; ?>><a href="/blog/addPage"><span class="glyphicon glyphicon glyphicon-plus"></span>新增</a></li>
                <li><a href="/personal/publichome"><span class="glyphicon glyphicon glyphicon-home"></span>首页</a></li>
            </ul>
        </div>

    </div>
</nav>