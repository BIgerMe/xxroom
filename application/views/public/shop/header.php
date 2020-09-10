<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <title><?php echo @$blog ? @$blog['title'] : 'Xroom' ;?></title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/img/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/blog/css/style.css">
    <link rel="stylesheet" href="/assets/layer/css/layui.css">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/prism_okaidia.css" rel="stylesheet">
<!--    <link href="/assets/css/prism.css" rel="stylesheet">-->

    <script src="/assets/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/layer/layui.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/markdown/lib/marked.js"></script>
    <script src="/assets/js/prism_okaidia.js"></script>
<!--    <script src="/assets/js/prism.js"></script>-->
    <script src="/assets/js/local.js"></script>

    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

</head>
<style type="text/css">
    .nav>li{
        position:relative;
    }

    .down-menu{
        position:absolute;
        list-style: none;
        background: white;
        padding:3px 20px;
        font-size: 14px;
        text-align: left;
        border: 1px solid #c3c7c4;
        z-index: 999;
    }
    .down-menu>li>a {
        display: block;
        padding: 3px;
        clear: both;
        font-weight: 500;
        line-height: 1.42857143;
        color: #333;
        white-space: nowrap;
    }
</style>

<nav class="navbar navbar-default navbar-fixed-top" style="background: #c9ca9d">
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
                <?php if(@$user_info):?>
                    <li onclick="openMenu(this)"><a href="#"><span class="glyphicon glyphicon-user"></span><?=$user_info['truename']?><span class="caret"></span></a>
                        <ul class="down-menu hidden" aria-haspopup="true" aria-expanded="false">
                            <li><a href="/personal">设置</a></li>
                            <li><a href="/entrance/editpsw">修改密码</a></li>
                            <li><a href="/upload/pic">图库</a></li>
                            <li><a href="/navigation/addpage">导航新增</a></li>
                            <li><a href="/logout">退出登录</a></li>
                        </ul>
                    </li>
                <?php else:?>
                    <li><a href="/entrance"><span class="glyphicon glyphicon-user"></span>请登录</a></li>
                <?php endif;?>
                <li><a href="/shop/lists"><span class="glyphicon glyphicon-list"></span>商品列表</a></li>
                <li><a href="/blog/index"><span class="glyphicon glyphicon glyphicon-retweet"></span>个人后台</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    $(document).on('click',function(e){
        var _con=$('.down-menu');
        if(!_con.is(e.target) && $(e.target).parent('li').has(_con).length===0){
            $('.down-menu').removeClass('show');
            $('.down-menu').addClass('hidden');
        }
    });
    function openMenu(obj){
        var _this = $(obj);
        _this.find("ul").toggleClass('hidden');
    }
</script>