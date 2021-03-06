<link rel="stylesheet" href="/assets/css/blogshow.css">
<?php $this->load->view("public/blogshow/header.php");?>

<style type="text/css">
    html,body,h4{
        font-family: -apple-system,"handingwringPingFang SC",PingFang SC,Hiragino Sans GB,Microsoft YaHei,Helvetica Neue,Arial,sans-serif;
    }
    html{
    }
    .mainBody{
        min-height:79vh;
    }
    .categoryIcon{
        float: left;
        display: inline;
        color:#fff;
        margin-right: 14px;
    }
    .categoryIcon span{
        padding: 0 2px;
    }
    .truenameIcon, .createdIcon, .commentIcon{
        color: #8f969c;
        border: none;
        float: left;
        display: inline;
    }
    .truenameIcon:after,.createdIcon:after{
        content: "\B7";
        margin: 0 .4em;
        color: #8f969c;
    }

    .row{
        margin-bottom: 0px;
    }
    .blog-avatar{
        width:10%;
    }
    .blog-content{
        width:90%;
    }
    .otherLink{
        width:90px;
        margin:5px 10px;
        border: none;
        float: left;
        display: inline;
        font-weight: 600;
    }
    .categoryList{
        float: right;
        padding-bottom: 20px
    }
    .categoryList a{
        float: left;
        padding: 2px 3px;
        text-decoration:none;
        font-weight: 500;
    }
    .friendLink{
        float: right;
        margin-top: 20px;
    }
    a{
        text-decoration:none;
        color:#2e3135;
    }
    .info-content h4{
        font-weight: 600;
    }
    .navbar-form{
        box-shadow: inset 0 0px 0 rgba(255, 255, 255, 0), 0 0px 0 rgba(255,255,255,0)
    }
    .title{
        font-family: "Consolas", "Monaco", "Bitstream Vera Sans Mono", "Courier New", Courier, monospace;
        font-size: 20px;
    }
    @media (max-width: 768px){
        .mainBody {
            min-height: 80.8vh
        }
        .categoryIcon{
            margin-right: 6px;
            font-size: x-small;
        }
        .truenameIcon, .createdIcon, .commentIcon{
            /*width:100px;*/
            /*margin:5px 10px;*/
            border: none;
            font-size: x-small;
        }
        .categoryList,.friendLink{
            margin-top: 0;
        }
        .blog-avatar{
            width:16.66666667%;
        }
        .blog-content{
            width:83.33333333%;
        }

        h3{
            font-size: 16px;
        }
    }

</style>

<body>
<img class="hidden" src="http://www.wailian.work/images/2018/09/21/earth.jpg" alt="earth.jpg" border="0" />
<div style="position: absolute;z-index:-2">
    <canvas id="cas"></canvas>
</div>
<div id="information" class="mainBody">
    <div class="container ">

        <form class="navbar-form navbar-left" action="<?php echo site_url('/blogshow/index');?>" role="search">
            <div class="input-group">
                <span class="input-group-btn ">
                    <button class="btn btn-default" type="button">标题</button>
                </span>
                <div class="form-group">
                    <input type="text" name="title" class="form-control" value="<?php echo $title ?? '';?>" placeholder="博客标题">
                </div>
                <!-- <span class="input-group-btn hidden-xs" for="title">
                        <button class="btn btn-default" type="button">分类</button>
                </span>-->
               <!-- <div class="form-group hidden">
                    <input type="text" name="category" class="form-control" value="<?php /*echo $category ?? ''; */?>" placeholder="博客分类">
                </div>-->
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="page text-left">
                    <?=$page?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="container-fluid" style="padding: 0">
                    <?php if($list): foreach ($list as $k=>$v): ?>
                    <div class="row info-content" data-id="<?=$v['id']?>">
                        <div class="col-md-2 col-sm-2 col-xs-2 blog-avatar">
                            <img style="width:64px;float: right" src="<?=$v['avatar']?>" class="img-responsive img-circle" alt="">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-10 blog-content" style="padding-left:0">
                            <h4 class="title"><a href="/blogshow/view?id=<?=$v['id']?>"><?=$v['title']?></a></h4>
                            <ul style="padding:0 2px;float:left;width:100%;list-style: none">
                                <li class="categoryIcon">
                                <?php foreach ($v['category'] as $c):?>
                                <span style="background: <?=$categoryList[$c]['color']?>"><?=$c?></span>
                                <?php endforeach;?>
                                </li>
                                <li class="truenameIcon"><?php echo $v['truename'];?></li>
                                <li class="createdIcon"><?=$v['created_at']?></li>
                                <li class="commentIcon"><?=$v['view']?>次偷窥</li>
                                <li><span class="badge" style="float: right"><?=$v['comment']?></span></li>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach;endif; ?>
                </div>
                <div class="page text-right">
                    <?=$page?>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-md-offset-1" style="padding: 0">
                <div class="col-md-12 col-xs-12 col-md-offset-1 info-right  categoryList">
                    <h3 style="margin-bottom:0;color:#00aaff">标签云</h3>
                    <hr style="margin: 10px 0"/>
                    <?php foreach ($categoryList as $c):?>
                    <a href="<?php echo site_url("/blogshow/index?title=&category=").$c['title']?>" style="size:<?=$c['fontSize']?>;color:<?=$c['color']?>"><?=$c['title']?></a>
                    <?php endforeach;?>
                    <a href="<?php echo site_url("/blogshow/index?title=&category=")?>" style="size:16px;color:red">All</a>
                </div>
                <div class="col-md-12 col-xs-12 col-md-offset-1 info-right hidden-sm  friendLink">
                    <h3 style="margin-bottom:0;color:#00aaff">友情链接</h3>
                    <hr style="margin: 10px 0"/>
                    <ul style="padding:0 2px;float:left;width:100%;list-style: none">
                        <li class="otherLink"><a target="_blank" href="https://crowall.com/">CroWall</a></li>
                        <li class="otherLink"><a target="_blank" href="http://rango.swoole.com/">韩天峰</a></li>
                        <li class="otherLink""><a target="_blank" href="http://www.laruence.com/">风雪之隅</a></li>
                        <li class="otherLink""><a target="_blank" href="https://juejin.im/">掘金网</a></li>
                        <li class="otherLink""><a target="_blank" href="https://www.v2ex.com/">VE2X</a></li>
                        <li class="otherLink""><a target="_blank" href="http://chuangzaoshi.com/">创造狮导航</a></li>
                    </ul>
                </div>
                <div class="col-md-12 col-xs-12 col-md-offset-1 info-right hidden-sm  friendLink">
                    <h3 style="margin-bottom:0;color:#00aaff">置顶文章  </h3>
                    <hr style="margin: 10px 0"/>
                    <ul style="padding:0 2px;float:left;width:100%;list-style: none">
                        <li class="otherLink" style="width:auto"><a target="_blank" href="https://xxroom.xyz/blogshow/view?id=22">常用链接-个人工作</a></li>
                        <li class="otherLink" style="width:auto"><a target="_blank" href="https://sorry.xuty.tk/wangjingze/">套路Gif在线生成</a></li>
                    </ul>
                </div>
                <div class="col-md-12 col-xs-12 col-md-offset-1 info-right hidden-sm  friendLink">
                    <h3 style="margin-bottom:0;color:#00aaff">留言</h3>
                    <hr style="margin: 10px 0"/>
                    <div class='panel panel-default'>
                    <div class="panel-body">
                        <span></span><input type="text"  class="input-sm msg_name" style="width:100%" placeholder="您的昵称"><br>
                    </div>
                        <div class="panel-body">
                            <span></span><textarea rows="4" class="input-sm msg_content" style="width:100%;resize:none" placeholder="留言内容"></textarea>
                    </div>
                    <div class="panel-footer" style="text-align: center">
                        <input type="button" onclick="send_msg()" class="btn btn-default btn-sm" value="提交">
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>

<?php $this->load->view("public/blogshow/footer.php");?>
<?php include_once("baidu_js_push.php");?>

<script>
    //发送留言
    function send_msg(){
        var msg_name = $(".msg_name").val();
        var msg_content = $(".msg_content").val();
        $.ajax({
            url:'/blogshow/msg_leave',
            data:{msg_name:msg_name,msg_content:msg_content},
            type:'post',
            async:true,
            dataType:'json',
            success:function (res) {
                showTips(res.msg,res.status,1000);
                if(res.status == 1){
                    setTimeout(function () {
                        window.location.reload();
                    },1000)
                }
            }
        });
    }
</script>

