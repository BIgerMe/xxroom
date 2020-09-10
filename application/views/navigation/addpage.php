<?php $this->load->view("public/blogshow/header.php");?>

<style type="text/css">
    html,body,h4{
        font-family: Microsoft YaHei,Helvetica Neue,Arial,sans-serif;
    }
    .mainBody{
        min-height:86vh;
        padding: 50px 0 0 0;
        /*background: #e6fffb;*/
    }
</style>
<body>
    <div id="information" class="mainBody">
        <div class="container" style="padding-top:10vh">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            添加导航
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="title" class="col-md-3 control-label">标题</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm" id="title" placeholder="标题">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="logo" class="col-md-3 control-label">图标</label>
                                            <div class="col-md-9">
                                                <img border="0" style="width: 80px;height: 80px" src="http://head.xxroom.xyz/photo_icon.png" onclick="$('#logo').click()">
                                                <input type="file" onchange="qn_upload(this)" class="hidden" id="logo" placeholder="logo">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="category" class="col-md-3 control-label">分类</label>
                                            <div class="col-md-9">
                                                <select id="category" style="margin-top:5px">
                                                    <?php foreach ($category as $c): ?>
                                                        <option value="<?=$c['id']?>"><?=$c['title']?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="content" class="col-md-3 control-label">简介</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm" id="content" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="href" class="col-md-3 control-label">链接</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control input-sm" id="href" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12" style="text-align: center">
                                                <button type="button" id="submit" class="btn btn-default">提交</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3>"></div>
            </div>
        </div>
    </div>
</body>

<?php $this->load->view("public/blogshow/footer.php");?>
<?php include_once("baidu_js_push.php");?>

<script>
    //七牛上传-图片预览
    function qn_upload(e){
        var _this = $(e);
        var form = new FormData();
        var token = "<?=$qiniu_token?>";
        var file = $("#logo")[0].files[0];
        form.append('file',file);
        form.append('token',token);
        //网络协议
        var protocolStr = document.location.protocol;
        if(protocolStr == 'http:'){
            var url = 'http://up.qiniup.com';
        }else{
            var url = 'https://up.qbox.me';
        }
        $.ajax({
            url: url,
            type: 'POST',
            dataType:'json',
            contentType: false,
            processData: false,
            data: form,
            success: function (rst) {
                let img = "http://head.xxroom.xyz/" + rst.key;
                _this.prev().attr('src',img);
                add_attachment(img);
            },
            error: function (rst) {
                showTips('上传失败',0);
            }
        });
    }
    //提交
    $("#submit").click(function () {
        let title = $("#title").val();
        let content = $("#content").val();
        let logo = $("#logo").prev().attr('src');
        //检查用户是否上传
        if(logo == 'http://head.xxroom.xyz/photo_icon.png'){
            showTips('请上传图标!',0);
            return false;
        }
        let href = $("#href").val();
        let category_id = $("#category").val();

        if(!title || !content || !logo || !href || !category_id){
            showTips('存在为空项',0);
            return;
        }

        $.ajax({
            type: "post",
            dataType: "json",
            data: {title:title,content:content,logo:logo,href:href,category_id:category_id},
            url: "/navigation/add",
            async: true,
            success: function (result) {
                showTips(result.msg,result.status,2000);
                if(result.status == 1){
                    setTimeout(function () {
                        // window.location.href = "";
                    },1000);
                }
            }
        });
    });
</script>
