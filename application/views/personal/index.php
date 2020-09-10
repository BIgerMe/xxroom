<?php $URL_PATH = '/assets/personal'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Tidy House</title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/img/icon.ico" type="image/x-icon">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="<?=$URL_PATH?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$URL_PATH?>/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?=$URL_PATH?>/css/fontAwesome.css">
    <link rel="stylesheet" href="<?=$URL_PATH?>/css/light-box.css">
    <link rel="stylesheet" href="<?=$URL_PATH?>/css/templatemo-main.css">

    <script src="<?=$URL_PATH?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script src="/assets/js/local.js"></script>
    <style type="text/css">
        .isCheck{
            border: 2px solid red;
        }
        .linkList{
            width: 200px;
            margin:10px 20px;
            border: none;
            float: left;
            display: inline;
        }
        .linkList a{
            text-decoration:none;
            size: 22px;
        }
        #selfAvatar:hover{
            content: '更换头像';
        }
    </style>
</head>

<body>

<div class="sequence">

    <div class="seq-preloader">
        <svg width="39" height="16" viewBox="0 0 39 16" xmlns="http://www.w3.org/2000/svg" class="seq-preload-indicator"><g fill="#F96D38"><path class="seq-preload-circle seq-preload-circle-1" d="M3.999 12.012c2.209 0 3.999-1.791 3.999-3.999s-1.79-3.999-3.999-3.999-3.999 1.791-3.999 3.999 1.79 3.999 3.999 3.999z"/><path class="seq-preload-circle seq-preload-circle-2" d="M15.996 13.468c3.018 0 5.465-2.447 5.465-5.466 0-3.018-2.447-5.465-5.465-5.465-3.019 0-5.466 2.447-5.466 5.465 0 3.019 2.447 5.466 5.466 5.466z"/><path class="seq-preload-circle seq-preload-circle-3" d="M31.322 15.334c4.049 0 7.332-3.282 7.332-7.332 0-4.049-3.282-7.332-7.332-7.332s-7.332 3.283-7.332 7.332c0 4.05 3.283 7.332 7.332 7.332z"/></g></svg>
    </div>

</div>


<nav>
    <div class="logo">
        <img src="<?=$URL_PATH?>/img/logo.png" alt="">
    </div>
    <div class="mini-logo">
        <img src="<?=$URL_PATH?>/img/mini_logo.png" alt="">
    </div>
    <ul>
        <li><a href="#1"><i class="fa fa-user"></i> <em>个人设置</em></a></li>
        <li><a href="#2"><i class="fa fa-home"></i> <em>网站功能</em></a></li>
    </ul>
</nav>

<div class="slides">
    <div class="slide" id="1">
        <div class="content first-content">
            <div class="container-fluid">
                <div class="col-md-3">
                    <div class="author-image"><img id="selfAvatar"  src="<?=$user_info['avatar']?>" alt=""></div>
                </div>
                <div class="col-md-9">
                    <h2>个人信息</h2>
                    <p class="truename"></p>
                    <div class="main-btn"><a onclick="configure()">更换头像</a></div>
                    <div class="fb-btn"><a href="/logout" target="_self">登出</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="slide" id="2">
        <div class="content second-content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <ul style="margin-top: 30px;padding:10px 2px;float:left;width:100%;list-style: none">
                        <li class="linkList"><h4><a href="/tidyroom">家庭考勤</a></h4></li>
                        <li class="linkList"><h4><a href="/blogshow">博客系统</a></h4></li>
                        <li class="linkList"><h4><a href="/personal/publicHome">bootstrap实例网站</a></h4></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--头像选择-->
<div id="configure">
</div>


<script src="/assets/js/jquery-1.9.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=$URL_PATH?>/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<!--<script src="--><?//=$URL_PATH?><!--/js/vendor/bootstrap.min.js"></script>-->

<script src="<?=$URL_PATH?>/js/datepicker.js"></script>
<!--<script src="--><?//=$URL_PATH?><!--/js/plugins.js"></script>-->
<script src="<?=$URL_PATH?>/js/main.js"></script>

<script src="/assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<!--dialog-->
<link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
<script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var user_id = "<?=$user_id?>";

        $("#configure").dialog({
            autoOpen : false,   // 是否自动弹出窗口
            modal : true,    // 设置为模态对话框
            width : 400,   //弹出框宽度
            height : 500,   //弹出框高度
            title : "头像更换",  //弹出框标题
            position : "",  //窗口显示的位置
            buttons:{
                '确定':function(){
                    var avatar = $(".isCheck").attr('src');
                    if(avatar){
                        $.ajax({
                            type: "post",
                            url: "/personal/changeAvatar",
                            data: {'avatar':avatar},
                            async: true,
                            dataType: "json",
                            success: function (res) {
                                if (res.status = 1) {
                                    showTips('更换成功',1,1000);
                                    $("#selfAvatar").attr('src',avatar);
                                    $("#configure").dialog("close");
                                }else{
                                    showTips('更换失败',0,1000);
                                }
                            }
                        });
                    }else{
                        showTips('请选择头像',0,1500);
                    }
                },
                '取消':function(){
                    $(this).dialog("close");
                }
            }
        });
        // navigation click actions
        $('.scroll-link').on('click', function(event){
            event.preventDefault();
            var sectionID = $(this).attr("data-id");
            scrollToID('#' + sectionID, 750);
        });
        // scroll to top action
        $('.scroll-top').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');
        });
        // mobile nav toggle
        $('#nav-toggle').on('click', function (event) {
            event.preventDefault();
            $('#main-nav').toggleClass("open");
        });
        userInit(user_id);
    });
    function configure() {
        $.ajax({
            type:"get",
            url:"/Api/personal/avatar",
            data:{},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.status = 200){
                   var avatarList = res.data;
                   var html = "";
                   $.each(avatarList,function ($i,$v) {
                       html += "<img onclick='choose(this)' style='width: 48px;height:48px;padding:2px' src='"+$v['path']+"'>";
                   });
                   $("#configure img").remove();
                   $("#configure").append(html);
                   $("#configure").dialog("open");
                }else{
                    showTips('获取头像失败',0,1000);
                }
            }
        });
    }
    //选择头像
    function choose(obj){
        var _this = $(obj);
        $("#configure img").removeClass('isCheck');
        _this.addClass('isCheck');
    }
    // scroll function
    function scrollToID(id, speed){
        var offSet = 0;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if (typeof console === "undefined") {
        console = {
            log: function() { }
        };
    }

    /*初始化*/
    function userInit(user_id)
    {
        $.ajax({
            type:"get",
            url:"/Api/personal/userInfo",
            data:{"user_id":user_id},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.status = 200){
                    username = res.data.username;
                    truename = res.data.truename;
                    avatar = res.data.avatar;

                    $("input.truename").attr("value",truename);
                    $("p.truename").html('昵称:'+truename);
                    if(avatar)
                        $("*.avatar").attr("src",'/assets/images/avatar/'+avatar);
                }
            }
        });
    }


</script>
</body>
</html>