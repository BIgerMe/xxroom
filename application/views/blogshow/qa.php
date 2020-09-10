<link rel="stylesheet" href="/assets/css/blogshow.css">

<?php $this->load->view("public/blogshow/header.php");?>

<style type="text/css">
    .ui-state-default,.ui-widget-content{

        border: 0;
    }
    .ui-accordion .ui-accordion-header{
        padding: 0px;
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default{
        background: white;
    }
    .ui-accordion .ui-accordion-header .ui-accordion-header-icon{
        display: none;
    }
    .ui-widget-content a{
        color: #337ab7;
    }

    html{
        /*background:#eee;*/
    }

    .mainBody{
        /*margin-top:50px;*/
        /*padding-top:100px*/
        min-height:87vh;
    }

    .nickName{
        font-weight: 300;
        color: #963434;
        /*color: #959595;*/
    }
    .otherIgnore{
        color: #959595;
    }

    .categoryIcon span{
        padding: 0 2px;
    }
    .qaIcon,.truenameIcon, .createdIcon, .commentIcon{
        color: #8f969c;
        border: none;
        float: left;
        display: inline;
    }
    .row{
        margin-bottom: 0px;
        display: block !important;
        /*margin-left: 0;
        margin-right: 0;*/
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
    .replyComment input{
        width: 500px;
        margin-right:7px;
    }
    .replyComment button{
    }
    .replies{
        margin-left:5px;
    }
    .panel-body{
        padding: 3px;
    }
    .media img{
        height: 40px;
        width: 40px;
    }
    .title{
        font-family: "Consolas", "Monaco", "Bitstream Vera Sans Mono", "Courier New", Courier, monospace;
        font-size: 20px;
    }
    code[class*="language-"], pre[class*="language-"] {
        white-space: pre-wrap;
        word-break: break-all;
        /*font-family: Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;*/
    }
    .navbar-form{
        box-shadow: inset 0 0px 0 rgba(255, 255, 255, 0), 0 0px 0 rgba(255,255,255,0)
    }
    @media (max-width: 768px){
        .ui-accordion .ui-accordion-content{
            padding: 10px 5px;
        }
        body{
            font-size: 13px;
        }
        .mainBody {
            min-height: 85vh
        }
        .media,pre code{
            font-size: 13px;
        }
        .media img{
            height:36px;
            width:36px;
        }
        .replyComment input {
            width:60vw;
            margin-right:5px;
        }
        .categoryList,.friendLink{
            margin-top: 0;
        }
        .blog-avatar {
            padding-left: 10px;
            padding-right: 10px;
            width:15%;
        }
        .blog-content{
            width:85%;
            padding-left: 0;
        }

        h3{
            font-size: 16px;
        }
    }

</style>
<script>
    //折叠
    $(function() {
        $( "#accordion" ).accordion({
            collapsible: true,
            active:false,
            heightStyle: "content",
            animate: 0
        });
    });

</script>
<body>

<img class="hidden" src="http://www.wailian.work/images/2018/09/21/fqa.jpg" alt="fqa.jpg" border="0" />
<div style="position: absolute;z-index:-2" class="hidden-xs">
    <canvas id="canvas"></canvas>
</div>
<div id="information" class="mainBody">
    <div class="container">
        <form class="navbar-form navbar-left" action="<?php echo site_url('/blogshow/qa');?>" role="search">
            <div class="input-group">
                <span class="input-group-btn ">
                    <button class="btn btn-default" type="button">标题</button>
                </span>
                <div class="form-group">
                    <input type="text" name="title" class="form-control" value="<?php echo $title ?? '';?>" placeholder="问答标题">
                </div>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container" >
        <div class="row">
            <div class="col-md-8">
                <div class="page text-left">
                    <?=$page?>
                </div>
            </div>
            <div class="col-md-8" style="margin-bottom: 20px;padding: 0">
                <div class="container-fluid" id="accordion" style="padding: 0">
                    <?php if($list): foreach ($list as $k=>$v): ?>
                    <div class="row info-content jump"  data-id="<?=$v['id']?>">
                        <div class="col-md-2 col-sm-2 col-xs-2 blog-avatar">
                            <img src="<?=$v['avatar']?>" class="img-responsive img-circle" alt="">
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-10 blog-content">
                            <h4></h4>
                            <span class="title"><?=$v['title']?></span>
                            <div style="display:inline;float: right">
                                <span class="badge" ><?=$v['category'][0]?></span>
                                <span class="badge" ><?=$v['comment']?></span>
                            </div>
                            <!--<ul style="padding:0 2px;float:left;width:100%;list-style: none">
                                <li class="qaIcon"><span><?/*=$v['title']*/?></span></li>
                                <li><span class="badge" style="float: right"><?/*=$v['comment']*/?></span></li>
                            </ul>-->
                        </div>
                    </div>
                    <div class="row info-content">
                        <?php $i=1; if(isset($answer[$v['id']])): foreach ($answer[$v['id']] as $a): ?>
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-body" style="width:100%" qa-id="<?=$v['id']?>" data-id="<?=$a['id']?>">
                                    <span class="badge" ><?php echo $i++."f";?></span>
                                    <span class="nickName"><?=$a['truename']?></span>&nbsp;
                                    <?php if($a['r_truename']): ?>
                                        <span class="otherIgnore">回复</span>
                                        <span class="nickName"><?=$a['r_truename']?></span>
                                    <?php endif;?>
                                    <span class="otherIgnore"><?=$a['created_at']?></span><br>
                                    <div style="width: 100%;display: inline"><?=$a['content']?></div>
                                </div>
                                <div class="media-right">
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                        <!--<div class="panel-body">
                            <div class="col-md-12 text-center" style="background: rgba(120,120,120,0.99);margin-top:8px"">
                                <button class="btn btn-default" onclick='window.location.href = ("/blogshow/qaview?id=<?/*=$v['id']*/?>")'>我要回答</button>
                            </div>
                        </div>-->
                        <?php else: ?>
                        <!--<div class="panel-body">
                            暂无回答
                            <div class="col-md-12 text-center" style="background: rgba(120,120,120,0.99);margin-top:8px">
                                <button class="btn btn-default" onclick='window.location.href = ("/blogshow/qaview?id=<?/*=$v['id']*/?>")'>我要回答</button>
                            </div>
                        </div>-->
                        <?php endif;?>
                    </div>
                    <?php endforeach;endif; ?>
                 </div>
                <div class="page text-right">
                    <?=$page?>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 col-md-offset-1"  style=";padding: 0">
            <div class="col-md-12 col-xs-12 col-md-offset-1 info-right  categoryList">
                <h3 style="margin-bottom:0;color:#00aaff">标签云</h3>
                <hr style="margin: 10px 0"/>
                <?php foreach ($categoryList as $c):?>
                    <a href="<?php echo site_url("/blogshow/qa?title=&category=").$c['title']?>" style="size:<?=$c['fontSize']?>;color:<?=$c['color']?>"><?=$c['title']?></a>
                <?php endforeach;?>
                <a href="<?php echo site_url("/blogshow/qa?title=&category=")?>" style="size:16px;color:red">All</a>
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
    $(".jump").on('click',function(e){
        let id = $(this).data('id');
        window.location.href = '/blogshow/qaview?id='+id;
    })
</script>


