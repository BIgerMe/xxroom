<?php $this->load->view("public/shop/header"); ?>
<style>
    .mainBody{
        margin-top: 51px;
        /*width:1200px;*/
        /*height:900px;*/
        /*border: 1px solid;*/
    }
    .tools{
        height:800px;
        border:1px solid;
    }
    .editBody{
        height:800px;
        border: 1px solid;
    }
    p{margin:0;padding:0;}
    .draggable {
        width: 80px;
        height: 80px;
        float: left;
        font-size: .9em;
        text-align: center;
        line-height: 70px;
    }
    .circle {
        float: left;
        height:80px;
        width:80px;
        font-size: .9em;
        text-align: center;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
    }
    .Ellipse {
        float: left;
        height:80px;
        width:80px;
        font-size: .9em;
        text-align: center;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
    }
    .Triangle{

    }
    .draggable>input,.circle>input,.Ellipse>input,.Triangle>input{
        margin-top: 30px;
        height: 20px;
        width: 80%;
        text-align: center;
        vertical-align:middle;
    }

    .ui-widget-header p, .ui-widget-content p {
        margin: 0;
    }

</style>
<script>
    //缩放  配置1
    function initRis(){
        $(".draggable").resizable({
            resize:function (event, ui) {
                var height = ui.size.height;
                var inputH = $(event.target).children("input").height();
                var marginTop = (height - inputH ) / 2;
                $(event.target).children("input").css('margin-top',marginTop+'px')
                // $(event.target).css('line-height',height+'px')
            },
        });
        $(".circle").resizable({
            resize:function (event, ui) {
                var height = ui.size.height;
                var inputH = $(event.target).children("input").height();
                var marginTop = (height - inputH ) / 2;
                $(event.target).children("input").css('margin-top',marginTop+'px')
            },
            aspectRatio: 1 / 1
        });
        $(".Ellipse").resizable({
            resize:function (event, ui) {
                var height = ui.size.height;
                var inputH = $(event.target).children("input").height();
                var marginTop = (height - inputH ) / 2;
                $(event.target).children("input").css('margin-top',marginTop+'px')

            }
        });
        $("#Ellipse").resizable({
            resize:function (event, ui) {
                var height = ui.size.height;
                var inputH = $(event.target).children("input").height();
                var marginTop = (height - inputH ) / 2;
                $(event.target).children("input").css('margin-top',marginTop+'px');
                Ellipse();
            }
        });
    }
    //拖放 配置2
    function initDrag(){
        $( ".editBody>.draggable,.editBody>.circle,.editBody>.Ellipse" ).draggable({containment:".editBody",stack: ".editBody div"});
    }

    $(function() {
        Ellipse();

        //元素赋能
        initRis();
        initDrag();
        //配置3
        $(".tools>.draggable,.tools>.circle,.tools>.Ellipse,#Ellipse").draggable({
            helper: "clone",
            stop:function(event,ui){

                //配置4
                if($(event.target).hasClass('circle')){
                    var cTop = $('.tools>.circle').offset().top;
                    var cLeft = $('.tools>.circle').offset().left;
                    var eTop = $('.editBody').offset().top;
                    var eLeft = $('.editBody').offset().left;
                    var html = "<div class='circle ui-widget-content'><input type='text'></div>"
                }else if($(event.target).hasClass('draggable')){
                    var cTop = $('.tools>.draggable').offset().top;
                    var cLeft = $('.tools>.draggable').offset().left;
                    var eTop = $('.editBody').offset().top;
                    var eLeft = $('.editBody').offset().left;
                    var html = "<div class='draggable ui-widget-content'><input type='text'></div>"
                }else if($(event.target).hasClass('Ellipse')){
                    var cTop = $('.tools>.Ellipse').offset().top;
                    var cLeft = $('.tools>.Ellipse').offset().left;
                    var eTop = $('.editBody').offset().top;
                    var eLeft = $('.editBody').offset().left;
                    var html = "<canvas class='Ellipse ui-widget-content'><input type='text'></canvas>"
                }else{
                    html = "";
                }

                var minW = eLeft - cLeft;
                var maxW = minW + $(".editBody").width();
                var minH = 0 - $(".tools>.circle").height();
                var maxH = $(".editBody").height();

                //确保移动到指定内容里
                if(ui.position.top<minH || ui.position.top>maxH || ui.position.left<minW || ui.position.left>maxW)
                    return;

                $(".editBody").append(html);
                //赋能
                initRis();
                initDrag();
            }
        });
    });
</script>
<?php if($above_info):?>
    <?=$above_info['html']?>
<?php else:?>
<div class="mainBody container-fluid">
    <div class="row">
        <div class="tools col-md-3">
            <div class="draggable ui-widget-content">
                <input type="text" value="长方形">
            </div>
            <div class="circle ui-widget-content ">
                <input type="text" value="圆形">
            </div>
            <div class="Ellipse ui-widget-content ">
                <input type="text" value="椭圆形">
            </div>
            <canvas id="Ellipse" class="Ellipse" width="80" height="80" style="">圆形</canvas>
        </div>
        <div class="editBody col-md-8">

            <br style="clear:both">

            <div class="draggable ui-widget-content">
                <input type="text">
            </div>

            <div class="circle ui-widget-content ">
                <input type="text" >
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="container" style="margin-bottom: 20px">
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="text-align: center">
            <span>标题:</span><input type="text" id="htmlTitle" value="<?php echo $above_info ? $above_info['title'] : ''; ?>" class="input-sm">
            &emsp;&emsp;&emsp;<button type="button" class="btn btn-primary" onclick="save()">保存</button>
        </div>
    </div>
</div>

<?php $this->load->view("/public/shop/footer")?>
<script>
    //获取canvas容器
    function Ellipse() {
        var c=document.getElementById("Ellipse"),
            width = c.offsetWidth,
            height = c.offsetHeight,
            ctx=c.getContext("2d");

        c.height = height;
        c.width = width;

        if(ctx.ellipse){
            ctx.ellipse(width/2,height/2,width/2,height/2,0,0,Math.PI*2);
            ctx.fillStyle="#3587ee";
            ctx.strokeStyle="#000";
            ctx.fill();
            ctx.stroke();
        }
    }


    /*保存outerhtml*/
    function save() {
        var id = "<?=$above_id?>";
        var title = $("#htmlTitle").val();
        //这一步必须执行,否则缩放生成的div会不断增加覆盖
        $("div.ui-resizable-handle").remove();
        var html = $(".mainBody").prop("outerHTML");
        $.ajax({
            url:"/shop/save",
            type:"POST",
            data:{id:id,title:title,html:html},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.status == 1){
                    showTips(res.msg,1,1000);
                    setTimeout(function () {
                        window.location = "/shop/above?id="+res.data;
                    },1000)
                }else{
                    showTips(res.msg,0,1000);
                }
            }
        })
    }
</script>















<?php //$this->load->view("public/shop/footer"); ?>

