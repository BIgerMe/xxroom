<?php $this->load->view("public/shop/header"); ?>
<style>
    .mainBody{
        margin-top: 51px;
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
<script type="text/javascript">
    $(function () {
        rect();
        Ellipse();
        Triangle();
    });
</script>
<?php if($above_info):?>
    <?=$above_info['html']?>
<?php else:?>
<div class="mainBody container-fluid">
    <div class="row">
        <div class="tools col-md-3">
            <canvas id="rect" width="80" height="80"></canvas>
            <canvas id="Ellipse" width="80" height="80"></canvas>
            <canvas id="Triangle" width="80" height="80"></canvas>
        </div>
        <div class="editBody col-md-8">

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
    function rect(){
        var canvas = document.getElementById('rect');
        if(!canvas.getContext) return;
        var ctx = canvas.getContext("2d");
        ctx.lineWidth = 2;
        //绘制矩形
        ctx.strokeRect(0,0,80,80);
        ctx.fillStyle="#3587ee";
        ctx.fillRect(0,0,80,80);
    }
    //椭圆
    function Ellipse() {
        var c=document.getElementById("Ellipse"),
            width = c.offsetWidth,
            height = c.offsetHeight,
            ctx=c.getContext("2d");

        c.height = height;
        c.width = width;

        if(ctx.ellipse){
            ctx.ellipse(width/2,height/2,width/2,height/2,0,0,Math.PI*2);
            ctx.fillStyle = "#3587ee";
            ctx.strokeStyle = "#000";
            ctx.fill();
            // ctx.stroke();
        }
    }
    //三角形
    function Triangle(){
        var canvas = document.getElementById('Triangle');
        var ctx = canvas.getContext("2d");
        //绘制三角形
        ctx.beginPath();
        ctx.moveTo(40,0);
        ctx.lineTo(0,80);
        ctx.lineTo(80,80);
        ctx.fillStyle = "#3587ee";
        ctx.fill();
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

