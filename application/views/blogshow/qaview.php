<?php $this->load->view("public/blogshow/header.php");?>
<!--kindEditor-->
<link rel="stylesheet" href="/assets/kindedit/themes/default/default.css">
<script src="/assets/kindedit/kindeditor-all-min.js"></script>
<script charset="utf-8" src="/assets/kindedit/lang/zh-CN.js"></script>

<style type="text/css">
    .mainBody{
        margin-top:100px
    }
    .nickName{
        font-weight: 300;
        color: #963434;
        /*color: #959595;*/
    }
    .otherIgnore{
        color: #959595;
    }
    .body-content{
        min-height: 20vh;
        margin-bottom: 20px;
    }
    .bg-img{position: fixed;background-color:rgba(190,190,190,0.5);z-index:9999;}
    .tra-img{text-align:center;position:relative;top:50%;
        -webkit-transform:translateY(-50%);
        -moz-transform:translateY(-50%);
        -o-transform:translateY(-50%);
        -ms-transform:translateY(-50%);
        transform:translateY(-50%);
    }

    .zoom-out{
        cursor: -moz-zoom-out;
        cursor: -webkit-zoom-out;
        cursor: zoom-out;
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
    code[class*="language-"], pre[class*="language-"] {
        white-space: pre-wrap;
        word-break: break-all;
    }
    @media (max-width: 768px){
        .body-content{
            min-height: 0;
        }
        .replyComment input {
            width:45vw;
            margin-right:5px;
        }
        h2{
            font-size: 20px;
        }
        h3{
            font-size: 19px;
        }

    }
</style>

<div class="container mainBody">
    <div class="row body-content">
        <!--标题-->
        <div class="col-md-12 text-center">
            <h2><b><?=$blog['title']?></b></h2>
        </div>
        <!--文章信息标签-->
        <div class="col-md-10 col-md-offset-1 text-center" style="text-align: right">
            <span class="badge"><?=$blog['truename']?></span>&nbsp;&nbsp;<span class="badge"><?php echo date("Y/m/d",strtotime($blog['created_at']))?></span>
            <?php foreach ($blog['category'] as $c): ?>
               <a class="badge" href="/blogshow/qa?category=<?=$c?>"><?=$c?></a>
            <?php endforeach; ?>
        </div>
        <br/><br/>
        <div class="col-md-10 col-md-offset-1">
            <?=$blog['content']?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div style="height:10px;border:none;border-top:10px groove skyblue;">
                <hr/>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    添加评论
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form action="" method="post">
                            <textarea id="firstComment" class="form-control" rows="4"></textarea>
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-default" onclick="addComment()" style="margin-top:10px">评论</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    全部回复
                </div>
                <div class="panel-body">
                    <?php $i=1; if($comment): foreach ($comment as $c):?>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="media">
                                <div class="media-left">
                                    <img class="" style="height: 48px" src="<?php if($c['avatar']){echo $c['avatar'];}else{ echo $c['sex']== 0 ? site_url('assets/images/noman.png') : ($c['sex']==1 ? site_url('assets/images/man.png') : site_url('assets/images/woman.png')); }?>" alt="">
                                </div>
                                <div class="media-body" style="width:100%"  data-id="<?=$c['id']?>">
                                    <span class="badge" ><?php echo $i++."f";?></span>
                                    <span class="nickName"><?=$c['truename']?></span>&nbsp;
                                    <?php if($c['r_truename']): ?>
                                        <span class="otherIgnore">回复</span>
                                        <span class="nickName"><?=$c['r_truename']?></span>
                                    <?php endif;?>
                                    <span class="otherIgnore"><?=$c['created_at']?></span>
                                    <div style="width: 100%;display: inline"><?=$c['content']?></div>
                                    <span style="margin:5px 0;word-break: break-all" class="media-content">
                                        <a class="replies" onclick="replyComment(this)">回复</a>
                                    </span>
                                    <!--<p style="margin:5px 0;word-break: break-all" class="media-content">
                                        <?/*=$c['content']*/?><a class="replies" onclick="replyComment(this)">回复</a>
                                    </p>-->
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <?php endforeach;else:?>
                    <?php echo "暂无回复"; endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("public/blogshow/footer.php");?>

<script>
    $(document).ready(function () {

    });

    KindEditor.ready(function (K) {
        console.log(window.editor)
        window.editor = K.create(("#firstComment"),{
            items: [
                'source','link','code'
            ],
            filterMode : false,
            width: "100%",
            afterBlur: function () {
                this.sync();
            }
        })
    });

    function addComment(){
        var blog_id = <?=$blog['id']?>;
        var content = $("#firstComment").val();
        if(content == '' || content==undefined){
            showTips('评论不能为空',0,1000);
            return false;
        }
        $.ajax({
            type:"post",
            url:'/blogshow/replyAdd',
            data:{"blog_id":blog_id,"content":content},
            async:true,
            dataType:"json",
            success:function(res){//成功后的函数,可以当做是php页面来处理,不能思维定式
                if(res.status == 1){
                    showTips('评论成功',1,1500);
                    //调整到哪个页面
                    setTimeout(function(){
                        window.location.reload();
                    },1500);
                }else{
                    showTips(res.msg,0,1500);
                }
            }
        })
    }

    /*点击回复*/
    function replyComment(obj){
        var _this = $(obj);
        var html = _this.html();
        if( html == '回复'){
            $(".replyComment").remove();
            $(".replies").html("回复");
            var reply_html = '<div class="replyComment"><input class="input-sm" ><button class="btn btn-default" onclick="replySubmit(this)">回复</button></div>';
            _this.parent().parent().append(reply_html);
            _this.html('收起');
            $(".replyComment input").focus();

        } else{
            $(".replyComment").remove();
            $(".replies").html("回复");
            _this.html('回复');
        }
    }

    function replySubmit(obj){
        var _this = $(obj);
        var content = $(".replyComment input").val();
        var id = _this.parent().parent().attr('data-id');
        var blog_id = "<?=$blog['id']?>";
        $.ajax({
            type:"post",
            url:"/blogshow/replyAdd",
            data:{"id":id,"content":content,"blog_id":blog_id},
            async:true,
            dataType:"json",
            success:function(res){//成功后的函数,可以当做是php页面来处理,不能思维定式
                if(res.status == 1){
                    showTips('回复成功',1,1500);
                    //调整到哪个页面
                    setTimeout(function(){
                        window.location.reload();
                    },1500);
                }else{
                    showTips(res.msg,0,1500);
                }
            }
        })
    }

</script>
