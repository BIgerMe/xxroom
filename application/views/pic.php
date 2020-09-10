<?php $this->load->view("public/blogshow/header.php");?>
<script src="/assets/js/clipboard.min.js"></script> <!--粘贴-->
<link rel="stylesheet" href="/assets/css/cube3.css">
<style type="text/css">
    h2{
        font-family: "Microsoft YaHei";
        /*font-family: "Microsoft YaHei",arial;*/
        font-weight: 600;
    }
    .img{
        width:100%;
        height:100%;
    }
    .xm-img:hover{
        cursor: zoom-in;
    }
    .mainBody{
        min-height:90vh;
        padding: 100px 20px;
    }
    .xm-gallery{
        padding: 20px 0 0 0 ;!important;
    }
    .xm-gallery-row{
        text-align: center;
        margin-top:20px;
        background: #eeeeee59;
    }
    .xm-square{
        position: relative;
        width:80px;
        height:80px;
    }
    .xm-rectangle{
        position: relative;
        width:267px;
        height:150px;
    }
    .xm-vertical{
        position: relative;
        height: 360px;
        width: 267px;
    }
    .xm-square-card,.xm-rectangle-card,.xm-vertical-card{
        padding: 1px;
    }
    .xm-img-bg{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        opacity: 0;
        filter: alpha(opacity=0);
        z-index: 2;
        cursor: pointer;
    }

    .xm-img-handle{
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 3;
    }
    .img-down{
        background-image: linear-gradient(to right,#17e66c,#10c55b);
        position: absolute;
        bottom: 5px;
        width: 80%;
        left: 10%;
        text-align: center;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        vertical-align: middle;
        color: white;
        height: 20px;
        line-height: 20px;
    }
    .xm-view-box{
        position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 10000;
    }
    .xm-view-box .xm-img-box{
        position: absolute;top: 0; left: 0; right: 0; bottom: 0; line-height: 0; background-color: rgba(0,0,0,.8); overflow: auto;
    }
    .xm-view-box .xm-img-box .image{
        position: absolute; transition: all .2s; cursor: zoom-out;
    }
    @media (max-width: 992px){
        .xm-square{
            width:80px;
            height:80px;
        }
        .xm-rectangle{
            width:200px;
            height:112.5px;
        }
        .xm-vertical{
            height: 270px;
            width: 200px;
        }
    }
    @media (max-width: 768px){
        .xm-square{
            width:70px;
            height:70px;
        }
        .xm-rectangle{
            width:160px;
            height:90px;
        }
        .xm-vertical{
            height: 216px;
            width: 160px;
        }
    }
</style>
<div class="cube hidden-xs">
    <!--最外层图片 -->
    <?php $plane = ['front','back','left','right','top','bottom']; foreach($plane as $item):?>
        <div class="<?='out_'.$item?>">
            <img src="<?php echo  $rectangle[mt_rand(0,count($rectangle)-1)]['url'] ?>"  class="pic">
        </div>
    <?php endforeach; ?>

    <!--中间层图片 -->
    <?php $plane = ['front','back','left','right','top','bottom']; foreach($plane as $item):?>
        <span class="<?='in_'.$item?>">
            <img src="<?php echo  $rectangle[mt_rand(0,count($rectangle)-1)]['url'] ?>"  class="in_pic">
        </span>
    <?php endforeach; ?>

    <?php $plane = ['front','back','left','right','top','bottom']; foreach($plane as $item):?>
        <span class="<?='basic_'.$item?> basic">
            <img src="<?php echo  $square[mt_rand(0,count($square)-1)]['url'] ?>"  class="basic_pic">
        </span>
    <?php endforeach; ?>
</div>
<div class="mainBody">
    <div class="container xm-gallery">
        <div class="col-md-2">
            <form class="form-horizontal">
                <div class="form-group">
<!--                    <label for="logo" class="col-md-3 control-label">上传图片</label>-->
                    <div class="col-md-9">
                        <img border="0" style="width: 80px;height: 80px" src="http://head.xxroom.xyz/photo_icon.png" onclick="$('#logo').click()">
                        <input type="file" onchange="qn_upload(this)" class="hidden" id="logo" multiple accept="image/gif,image/jpeg,image/png,image/jpg" placeholder="logo">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-10">
            <!--正方形-->
            <h2>图标头像</h2>
            <div class="row xm-gallery-row">
                <?php if($square): foreach ($square as $i => $v):?>
                <div class="col-md-1 col-sm-2 col-xs-3">
                    <div class="xm-img xm-square xm-square-card">
                        <img class="img" src="<?=$v['url']?>">
                        <div class="xm-img-bg"></div>
                        <div class="xm-img-handle">
                            <div class="img-down js-copy" data-clipboard-text="<?=$v['url']?>" data-url="<?=$v['url']?>"><span>复制链接</span></div>

                            <!--                            <div class="img-down" data-url="--><?//=$v['url']?><!--"><span>立即下载</span></div>-->
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; ?>
            </div>
            <!--横矩-->
            <h2>横屏</h2>
            <div class="row xm-gallery-row">
                <?php if($rectangle):foreach ($rectangle as $i => $v):?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="xm-img xm-rectangle xm-rectangle-card">
                        <img class="img" src="<?=$v['url']?>">
                        <div class="xm-img-bg"></div>
                        <div class="xm-img-handle">
                            <div class="img-down js-copy" data-clipboard-text="<?=$v['url']?>" data-url="<?=$v['url']?>"><span>复制链接</span></div>

                            <!--                            <div class="img-down" data-url="--><?//=$v['url']?><!--"><span>立即下载</span></div>-->
                        </div>
                    </div>
                </div>
                <?php endforeach;endif; ?>
            </div>
            <!--竖矩-->
            <h2>竖屏</h2>
            <div class="row xm-gallery-row">
                <?php if($vertical):foreach ($vertical as $i => $v):?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="xm-img xm-vertical xm-vertical-card">
                        <img class="img" src="<?=$v['url']?>">
                        <div class="xm-img-bg"></div>
                        <div class="xm-img-handle">
                            <div class="img-down js-copy" data-clipboard-text="<?=$v['url']?>" data-url="<?=$v['url']?>"><span>复制链接</span></div>
<!--                            <div class="img-down "  data-url="--><?//=$v['url']?><!--"><span>立即下载</span></div>-->
                        </div>
                    </div>
                </div>
                <?php endforeach;endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    //七牛上传-图片预览
    function qn_upload(e){
        var _this = $(e);

        var token = "<?=$qiniu_token?>";

        var file = $("#logo")[0].files;
        //多图片上传
        //网络协议
        var protocolStr = document.location.protocol;
        var url = (protocolStr == 'http:') ? 'http://up.qiniup.com' : 'https://up.qbox.me';

        for (i=0;i<file.length;i++){
            var form = new FormData();
            form.append('file',file[i]);
            form.append('token',token);
            $.ajax({
                url: url,
                type: 'POST',
                dataType:'json',
                contentType: false,
                processData: false,
                data: form,
                success: function (rst) {
                    console.log(rst);return false;
                    let img = "http://head.xxroom.xyz/" + rst.key;
                    _this.prev().attr('src',img);
                    let state = add_attachment(img);
                    if( state == false){
                        showTips('上传失败',0);
                        return false;
                    }
                },
                error: function (rst) {
                    showTips('上传失败',0);
                    return false;
                }
            });
        }
        showTips('上传成功',1);
        setTimeout(function () {
            // window.location.reload()
        },1000)
    }

    var center = {
        init:function(){
            let clipboard = new ClipboardJS('.js-copy');//实例化
            /*鼠标停留图片上*/
            $(".xm-img").mouseover(function(){
                let handle = $(this).children('.xm-img-handle');
                let bg = $(this).children('.xm-img-bg');
                bg.css('opacity',0.4);
                handle.css("display","inline");
            });
            /*鼠标离开图片*/
            $(".xm-img").mouseleave(function(){
                let handle = $(this).children('.xm-img-handle');
                let bg = $(this).children('.xm-img-bg');
                bg.css('opacity',0);
                handle.css("display","none");
            });
            $(".xm-img").on('click',function (e) {
                if(e.originalEvent.target.parentNode.className == 'img-down js-copy'){return;}
                var url = $(this).children('img').attr('src');
                var img = new Image();
                img.src = url;
                //图片宽-高-比列
                let w = img.width,h = img.height;
                let p = w/h;
                //屏幕宽-高-比例
                let sw = document.body.clientWidth,sh = document.body.clientHeight;
                let sp = sw/sh;

                let lw = 0,lh = 0;
                //宽大于高，则以宽为基准（暂时）0.8只是个基数，可以取值0-1以内数
                if(w>=h){
                    if(p/sp <= 0.8 && w>=sw*0.8){
                        lh = sh*0.8;
                        lw = lh*p;
                    }else{
                        lw = Math.min(sw*0.8,w);
                        lh = lw/p;
                    }
                }else{
                    if(sp/p <= 0.8 && h>=sh*0.8){
                        lw = sw*0.8;
                        lh = lw/p;
                    }else{
                        lh = Math.min(sh*0.8,h);
                        lw = lh*p;
                    }
                }

                let left = right = (sw - lw)/2;
                let top = (sh - lh)/2;
                var imgStyle = 'width:'+lw+'px;height:'+lh+'px;left:'+left+'px;right:'+right+'px;top:'+top+'px;';
                console.log(imgStyle);
                let html = "<div class='xm-view-box'><div class='xm-img-box'><img class='image' style='"+imgStyle+"' src='"+url+"'></div></div>";
                $("body").append(html);
                $(".xm-view-box").on('click',function(){
                    $(this).remove();
                })
            });
            /*下载图片*/
            /*$(".img-down").on('click',function(e){
                e.stopPropagation();
                var img_url = $(this).data('url');
                window.location.href = "/upload/download_pic?url="+img_url;
            })*/
            $(".img-down").on('click',function(e){
                showTips('复制成功',1)
                // e.stopPropagation();
                // var img_url = $(this).data('url');
                // window.location.href = "/upload/download_pic?url="+img_url;
            });

        }
    };
    center.init();
</script>


