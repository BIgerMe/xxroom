<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title><?php echo @$blog ? @$blog['title'] : 'xRoom' ;?></title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/blog/css/style.css">
    <link rel="stylesheet" href="/assets/css/content.css">
<!--    <link rel="stylesheet" href="/assets/layer/css/layui.css">-->
    <link href="/assets/css/prism_okaidia.css" rel="stylesheet">
    <script src="/assets/js/jquery-1.9.1.min.js"></script>

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/assets/layer/layui.js"></script>
    <script src="/assets/markdown/lib/marked.js"></script>
    <script src="/assets/js/prism_okaidia.js"></script>
    <script src="/assets/js/local.js"></script>

    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
</head>
<style type="text/css">
    .nav>li{
        position:relative;
    }
    .navbar{
        border:0
    }
    @media (min-width: 1200px){
        .container {
            width: 1440px;
        }
    }
</style>
<nav class="navbar navbar-default navbar-fixed-top" id="navbar" style="background: #ffffff">
    <div class="container">
        <div class="navbar-header">
            <a href="/personal/publichome" style="padding: 5px;" class="navbar-brand logo"><img style="width:150px;height: 40px" src="/assets/images/xlogo-blue.png"></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right" >
                <li><a href="/personal/publichome"><span class="glyphicon glyphicon-home"></span>首页</a></li>
                <li><a href="/navigation/index"><span class="glyphicon glyphicon-plane"></span>导航</a></li>
                <li><a href="/blogshow/index"><span class="glyphicon glyphicon-list"></span>博客集</a></li>
                <li><a href="/blogshow/qa"><span class="glyphicon glyphicon-font"></span>问答</a></li>
                <li><a href="/upload/pic"><span class="glyphicon glyphicon-picture"></span>图库</a></li>
                <?php if(@$user_info):?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>
                            <?=$user_info['truename']?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
<!--                            <li><a href="/personal">设置</a></li>-->
                            <li><a href="/entrance/editpsw">修改密码</a></li>
                            <li><a href="/upload/pic">图库</a></li>
                            <li><a href="/navigation/addpage">导航新增</a></li>
                            <li><a href="/blog/index">个人后台</a></li>
                            <li><a href="/logout">退出登录</a></li>
                            <li><a onclick="hiddenNav()"><span class="glyphicon glyphicon-eye-close"></span>隐藏</a></li>
                        </ul>

                    </li>
                <?php else:?>
                    <li><a href="/entrance"><span class="glyphicon glyphicon-user"></span>请登录</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</nav>

<script>

    function hiddenNav(){
        console.log(123);
        $("#navbar").addClass('hidden');
    }
</script>
