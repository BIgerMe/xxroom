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
    <title>首页</title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/personal/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/personal/css/style.css">
</head>
<style type="text/css">
    .mainBody {
        min-height: 80vh;
        padding: 0 0 0 0;
        margin-bottom: 30px;
        /*background: #e6fffb;*/
    }

    .head {
        margin-top:50px;
        width: 100%;
        height: 40vh;
        background: #26796e
    }

    .form-style {
        margin-left: 5%;
        width: 90%
    }

    /*导航*/
    .card {
        margin-bottom: 10px;
    }

    .card .card-head {
        overflow: hidden;
        margin-bottom: 7px;
        display: block;
        cursor: pointer;
        padding: 0;
        color: #333;
        text-decoration: none;
    }

    .card .card-head:hover {
        color: #4aa1a8;
    }

    .card .card-head .card-icon {
        width: 40px;
        height: 40px;
        float: left;
        display: block;
        background: rgba(196, 228, 230, 0.1);
    }

    .card .card-head .card-icon img {
        display: block;
        width: 100%;
        height: 100%;
    }

    .card .card-head .card-title {
        display: block;
        padding-left: 5px;
        margin-top: 10px;
        font-weight: 700;
        font-size: 15px;
        color: inherit;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    /*博客*/
    .categoryIcon {
        float: left;
        display: inline;
        color: #fff;
        margin-right: 14px;
    }

    .categoryIcon span {
        padding: 0 2px;
    }

    .truenameIcon, .createdIcon, .commentIcon {
        color: #8f969c;
        border: none;
        float: left;
        display: inline;
    }

    .truenameIcon:after, .createdIcon:after {
        content: "\B7";
        margin: 0 .4em;
        color: #8f969c;
    }

    h4 > a:hover {
        color: yellowgreen;
    }

    .info-content {
        margin: 0;
        box-shadow: 0 0 0 0;
    }

    @media (min-width: 1200px) {
        .container {
            width: 1440px;
        }
    }

    @media (min-width: 992px) {
        .form-style {
            margin-left: 30%;
            width: 40%
        }
    }

    @media (max-width: 768px) {
        h4.blog {
            margin: 3px;
        }

        .categoryIcon {
            margin-right: 6px;
            font-size: x-small;
        }
    }

</style>
<body>
<div id="" class="mainBody">
    <nav id="navbar" class="navbar navbar-default navbar-fixed-top" style="background: #ffffff;border: 0px">
        <div class="container">
            <div class="navbar-header">
                <a href="/personal/publichome" style="padding: 5px;" class="navbar-brand logo"><img
                            style="width:150px;height: 40px" src="/assets/images/xlogo-blue.png"></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/personal/publichome"><span class="glyphicon glyphicon-home"></span>首页</a></li>
                    <li><a href="/navigation/index"><span class="glyphicon glyphicon-plane"></span>导航</a></li>
                    <li><a href="/blogshow/index"><span class="glyphicon glyphicon-list"></span>博客集</a></li>
                    <li><a href="/blogshow/qa"><span class="glyphicon glyphicon-font"></span>问答</a></li>
                    <li><a href="/upload/pic"><span class="glyphicon glyphicon-picture"></span>图库</a></li>
                    <?php if (@$user_info): ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user"></span>
                                <?= $user_info['truename'] ?>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
<!--                                <li><a href="/personal">设置</a></li>-->
                                <li><a href="/entrance/editpsw">修改密码</a></li>
                                <li><a href="/upload/pic">图库</a></li>
                                <li><a href="/navigation/addpage">导航新增</a></li>
                                <li><a href="/blog/index">个人后台</a></li>
                                <li><a href="/logout">退出登录</a></li>
                                <li><a onclick="hiddenNav()"><span class="glyphicon glyphicon-eye-close"></span>隐藏</a>
                                </li>
                            </ul>

                        </li>
                    <?php else: ?>
                        <li><a href="/entrance"><span class="glyphicon glyphicon-user"></span>请登录</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container head" style="width:100%">
        <h2 class="tab-h2" style="margin-top:9vh"><b>「分享、问答、学习交流」</b></h2>
        <p class="tab-p">talk is cheap, show me the code</p>
        <p class="tab-p">公告：本网站即将作废，迁移至新站点 <a href="http://war3.xxroom.xyz/view/homepage.html" style="color: #56cc7af0">http://war3.xxroom.xyz/view/homepage.html</a></p>
        <form action="/personal/search" method="get" enctype="application/x-www-form-urlencoded" class="form-style">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="key" autocomplete="off" placeholder="php">
                <span class="input-group-btn"><button class="btn btn-sm btn-default" type="submit">搜索</button></span>
            </div>
        </form></div>
    <div class="tab1">
        <div class="container">
            <!-- <h2 class="tab-h2">「本站功能」</h2>
             <p class="tab-p">导航常用链接、博客分享、快速问答、伙伴交流...</p>-->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6 col">
                    <div class="media">
                        <div class="media-left">
                            <a href="/navigation/index">
                                <img src="https://www.wailian.work/images/2018/12/26/link-circle.png"
                                     class="media-object" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">导航页</h4>
                            <p class="hidden-xs">收录墙内外优质网站</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 col">
                    <div class="media">
                        <div class="media-left">
                            <a href="/blogshow/index">
                                <img src="https://www.wailian.work/images/2018/12/26/blog-circle.png"
                                     class="media-object" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">博客集</h4>
                            <p class="hidden-xs">markdown写作分享</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 col">
                    <div class="media">
                        <div class="media-left">
                            <a href="/blogshow/qa">
                                <img src="https://www.wailian.work/images/2018/12/26/fqa-circle.png"
                                     class="media-object" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">问答</h4>
                            <p class="hidden-xs">快速QA，寻找答案</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 col">
                    <div class="media">
                        <div class="media-left">
                            <a>
                                <img src="https://www.wailian.work/images/2018/12/27/more-circle1.png"
                                     class="media-object" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">功能开发中...</h4>
                            <p class="hidden-xs">商城、聊天室等各项功能开发中...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--导航-->
    <div class="tab1" style="margin-bottom: 0">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px;text-align: center;margin-left: -15px">
                    <img style="width:150px;" src="https://www.wailian.work/images/2018/12/26/link-red.png"
                         class="media-object" alt="">
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: white;">
                    <?php foreach ($navigation as $n): ?>
                        <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                            <div class="card">
                                <a class="card-head" href="<?= $n['href'] ?>" onclick="updateview(<?= $n['id'] ?>)"
                                   target="_blank">
                                    <span class="card-icon"><img class="img-circle" src="<?= $n['logo'] ?>"></span>
                                    <span class="card-title">&#160;<?= $n['title'] ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!--博客-->
    <div class="hidden" style="padding-bottom: 10px">
        <div class="container" style="">
            <div class="row">
                <div class="col-md-12" style="padding:3px 0;">
                    <img style="height:45px;width:120px" src="https://www.wailian.work/images/2018/12/26/blog.png"
                         class="media-object" alt="">
                </div>
                <div class="col-md-8">
                    <div class="container-fluid" style="padding: 0">
                        <?php if ($blog): foreach ($blog as $b): ?>
                            <div class="row info-content" data-id="<?= $b['id'] ?>">
                                <div class="col-md-2 col-sm-2 col-xs-2 blog-avatar">
                                    <img style="width:64px;float: right" src="<?= $b['avatar'] ?>"
                                         class="img-responsive img-circle" alt="">
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 blog-content" style="padding-left:0">
                                    <h4><a href="/blogshow/view?id=<?= $b['id'] ?>"><?= $b['title'] ?></a></h4>
                                    <ul style="padding:0 2px;float:left;width:100%;list-style: none">
                                        <li class="categoryIcon">
                                            <?php foreach ($b['category'] as $c): ?>
                                                <span style="background: <?= $categoryList[$c]['color'] ?>"><?= $c ?></span>
                                            <?php endforeach; ?>
                                        </li>
                                        <li class="truenameIcon"><?php echo $b['truename']; ?></li>
                                        <li class="createdIcon"><?= $b['created_at'] ?></li>
                                        <li class="commentIcon"><?= $b['view'] ?>次偷窥</li>
                                        <!--                                        <li><span class="badge" style="float: right">-->
                                        <? //=$b['comment']?><!--</span></li>-->
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--问答-->
    <div class="tab1 hidden">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="padding:3px 0 ;background: white">
                    <img style="width:100px" src="https://www.wailian.work/images/2018/12/26/FQA.png"
                         class="media-object" alt="">
                </div>
                <div class="col-md-8">
                    <div class="container-fluid" style="padding: 0">
                        <?php if ($blog): foreach ($blog as $b): ?>
                            <div class="row info-content" data-id="<?= $b['id'] ?>">
                                <div class="col-md-2 col-sm-2 col-xs-2 blog-avatar">
                                    <img style="width:64px;float: right" src="<?= $b['avatar'] ?>"
                                         class="img-responsive img-circle" alt="">
                                </div>
                                <div class="col-md-10 col-sm-10 col-xs-10 blog-content" style="padding-left:0">
                                    <h4><a href="/blogshow/view?id=<?= $b['id'] ?>"><?= $b['title'] ?></a></h4>
                                    <ul style="padding:0 2px;float:left;width:100%;list-style: none">
                                        <li class="categoryIcon">
                                            <?php foreach ($b['category'] as $c): ?>
                                                <span style="background: <?= $categoryList[$c]['color'] ?>"><?= $c ?></span>
                                            <?php endforeach; ?>
                                        </li>
                                        <li class="truenameIcon"><?php echo $b['truename']; ?></li>
                                        <li class="createdIcon"><?= $b['created_at'] ?></li>
                                        <li class="commentIcon"><?= $b['view'] ?>次偷窥</li>
                                        <!--                                        <li><span class="badge" style="float: right">-->
                                        <? //=$b['comment']?><!--</span></li>-->
                                    </ul>
                                </div>
                            </div>
                        <?php endforeach;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("public/blogshow/footer.php"); ?>
<!--<footer id="footer">
    <div class="container">
        <p>业务规划 | 合作事宜 | 版权投诉</p>
        <p>Email：zxmzyl9189@gmail.com</p>
    </div>
</footer>-->


<script src="/assets/personal/js/vendor/jquery-1.11.2.min.js"></script>
<script src="/assets/personal/js/vendor/bootstrap.min.js"></script>
<script>
    $(function () {
        //自动轮播
        $("#myCarousel").carousel({
            interval: 5000
        });
        /*//设置垂直居中
         $(".carousel-control").css('line-height',$(".carousel-inner img").height() + 'px');
         $(window).resize(function (){
         var $height = $(".carousel-inner img").eq(0).height() ||
         $(".carousel-inner img").eq(1).height() ||
         $(".carousel-inner img").eq(2).height();
         $(".carousel-control").css('line-height',$height + 'px')
         });*/
    });
    $(window).load(function () {
        $(".text").eq(0).css('margin-top', ($(".auto").eq(0).height() - $(".text").eq(0).height()) / 2 + 'px');
        $(".text").eq(1).css('margin-top', ($(".auto").eq(1).height() - $(".text").eq(1).height()) / 2 + 'px');
    });
    //设置tab2 tab3文字垂直居中
    $(window).resize(function () {
        $(".text").eq(0).css('margin-top', ($(".auto").eq(0).height() - $(".text").eq(0).height()) / 2 + 'px');
    });

    $(window).resize(function () {
        $(".text").eq(1).css('margin-top', ($(".auto").eq(1).height() - $(".text").eq(1).height()) / 2 + 'px');
    });

    function hiddenNav() {
        console.log(123);
        $("#navbar").addClass('hidden');
    }

    function updateview(id) {
        $.ajax({
            url: '/navigation/updateview',
            type: "post",
            dataType: "json",
            data: {'id': id},
            async: true,
            success: function () {
                console.log(id);
            }
        })
    }
</script>
</body>
</html>
