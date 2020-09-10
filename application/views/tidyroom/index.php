<?php $this->load->view("public/tidyroom/header"); ?>
<head>
<!--    <link rel="stylesheet" type="text/css" href="tidyRoom.css">-->
    <style type="text/css">
        body{
            font-family: -apple-system, "handingwringPingFang SC", PingFang SC, Hiragino Sans GB, Microsoft YaHei, Helvetica Neue, Arial, sans-serif;
            font-weight: 500;
            font-size: 14px;
        }
        .main-body{
            margin-top: 50px;
            padding: 0;
        }

        .headList{
            margin: 15px 0;
            padding: 10px 0 ;
            /*background: #b2dba1;*/
        }
        button {
            /*margin: 0;*/
            /*border: 0;*/
            color: #0B2E68;
            background-color: #abd88a;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
        button:active{
            position: relative;
            top:1px;
            background-color: #18a077;
        }
        input{
            background-color: #8fd3d4;
        }
        select{
            background-color: #8fd3d4;
        }
        .headList div {
            display: inline-block;
        }

        .main .list h2,h5{
            text-align: center;
        }
        .main .list ul{
            padding-left:0;
            margin: 0;
            position: absolute;
            background: rgb(137, 220, 187);
            width: 95%;
            height: auto;
        }
        .main .list ul li{
            list-style-type: none;
            line-height: 5vh;
            height: 5vh;
            width: 100%;
            border: 0;
            text-align: center;
            border-bottom: solid 0.1px darkgrey;
            /*display: block;*/
        }

        .main ul li p{
            margin :0;
            display: inline-block;
        }

        #add-model{
            background: rgb(222, 211, 211);
            z-index: 1;
        }
        #add-model table{
            width: 90%;
            text-align: center;
        }
        #add-model table input{
            text-align: center;
            width: 75%;
        }
        #add-model i{
            color: red;
        }

        .row{
            margin-left: 0;
            margin-right: 0;
        }
        @media (max-width:768px) {
            .headList{
                margin: 15px 0;
            }
            #mainBody{
                padding: 0 2px;
            }
            .add-item{
                width:30px;
            }
            .add-date{
                width:80px;
            }
            .select-date{
                width:80px;
            }
            body{
                font-size:12px;
                font-weight:600;
            }
            table{
                font-size: 12px;
            }
            .list-select{
                width:100px;
            }

        }
    </style>
</head>
<div class="container main-body">
    <!--新增按钮 跳转新增模块-->
    <div class="row headList">
            <button class="hidden-xs btn btn-primary btn-xs" type="button" id="add">新增&编辑项目</button>
    </div>

    <div class="row" style="background:rgba(252,255,204,0.5);padding: 0 2px">
        <div class="" style="padding: 0px">
            <span>起始日期:&nbsp;</span><input class="datepicker select-date">&nbsp;
            <span>结束日期:&nbsp;</span><input class="datepicker select-date">&nbsp;
            <button class="search btn btn-primary btn-xs" type="button">搜索</button>
        </div>
    </div>
    <!--页面初始化主要部分-->
    <div class="row">
        <div class="" id="mainBody">

        </div>
    </div>

    <!--新增模块-->
    <div id="add-model">
        <br><div>&nbsp;&nbsp;编辑项目:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select onchange="changeCenter()"><option value="">选择存在项目</option></select><i>(选择后视为编辑,若想新增请跳过选择)</i></div>
        <br><div>&nbsp;&nbsp;家务标题:<i>*</i>&nbsp;&nbsp;&nbsp;<input type="text" id="title"></div><br>
        <div id="user-add">&nbsp;&nbsp;选择好友:<i>*</i>&nbsp;&nbsp;&nbsp;
        </div>
        <br>
        <table title="测试">
            <thead>
                <tr>
                    <th style="width: 60%" >新增项</th>
                    <th style="width: 20%">分数/项</th>
                    <th style="width: 10%">操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input class="item_name" type="text"></td>
                    <td><input class="item_score" type="text"></td>
                    <td>
                        <button class="list-add" type="button">+</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    var user_id = "<?=$user_id?>";
    window.onload = function(){
        centerList();
        userList();
        mainBodyList(user_id);
        datepickerSet();
    };
    $().ready(function (){
        $("#add").click(function (){
            $("#add-model").dialog("open");
        });
        $("#add-model").dialog({
            autoOpen : false,   // 是否自动弹出窗口
            modal : true,    // 设置为模态对话框
            width : 800,   //弹出框宽度
            height : 800,   //弹出框高度
            title : "新增家务",  //弹出框标题
            position : "",  //窗口显示的位置
            buttons:{
                '确定':function(){
                    var _this = $("#add-model");
                    var id = _this.find("select").val();
                    var listTitle = $("#title").val();
                    var user = new Array();
                    var list = new Array();
                    //用户
                    $.each($("input[name='userList']"),function (){
                        if(this.checked){
                            user.push({user_id:$(this).val()});
                        }
                    });
                    //模块
                    $("#add-model").find("tbody").find("tr").each(function (){
                        var tdArr = $(this).children();
                        var title = tdArr.eq(0).find('input').val();
                        var score = tdArr.eq(1).find('input').val();
                        if(title){
                            list.push({ title:title,score:score})
                        }
                    });
                    if(id == ""){
                        $.ajax({
                            type:"post",
                            url:"/Api/tidyRoom/center",
                            data:{"title":listTitle,"list":list,"user":user},
                            async:true,
                            dataType:"json",
                            success:function (res) {
                                if(res.status = 200){
                                    showTips('新增成功',1);
                                    window.location.reload();
                                }else{
                                    showTips('新增失败',0);
                                }
                            }
                        });
                    }else{
                        $.ajax({
                            type:"post",
                            url:"/Api/tidyRoom/editCenter",
                            data:{"id":id,"title":listTitle,"list":list,"user":user},
                            async:true,
                            dataType:"json",
                            success:function(res){
                                if(res.status = 200){
                                    showTips(res.msg,1);
                                    window.location.reload();
                                }else{
                                    showTips('res.msg',0)
                                }
                            }
                        });
                    }
                },
                '取消':function(){
                   $(this).dialog("close");
                }
            }
        });
    });
    /*列出选择的项目*/
    $(document).on("click",".centerList",function(){
        var id = $(this).attr('center-id');
        mainBodyList(user_id,id);
    });
    /*按日期查询主体*/
    $(document).on("click",".search",function(){
       var center_id = $(".list").attr('body-id');
       var start_date = $(this).parent().find("input:eq(0)").val();
       var end_date = $(this).parent().find("input:eq(1)").val();
       mainBodyList(user_id,center_id,start_date,end_date);
    });
    /*新增家务项*/
    $(document).on('click',".list-add",function (){
        var _this = $("#add-model").find("tbody");
        _this.append("<tr><td><input class='item_name'  type='text'></td><td><input class='item_score' type='text'></td><td><button class='list-add' type='button'>+</button><button class='del' type='button'>-</button></td></tr>");
    });
    /*删除家务项*/
    $(document).on("click", ".del", function () {
        $(this).parent().parent().remove();
    });
    /*新增记录*/
    $(document).on("click",".record-add",function(){
        var list_id = $(this).parent().find(".list-select").val();
        var count = $(this).parent().find(".list-add-count").val();
        var date = $(this).parent().find(".datepicker").val();
        if(list_id && count && date){
            var add_data = { 'record': [{'user_id':user_id,'list_id':list_id,'count':count,'date':date}]};
            console.log(add_data);
            $.ajax({
                type:"post",
                url:"/Api/tidyRoom/record",
                data: add_data,
                async:true,
                dataType:"json",
                success:function (res) {
                    if(res.status = 200){
                        showTips(res.msg,1);
                        var center_id = $(".list").attr('body-id');
                        mainBodyList(user_id,center_id);
                    }else{
                        showTips('未知错误',0)
                    }
                }
            });
        }
    });

    /*获取个人考勤列表*/
    function centerList()
    {
        $.ajax({
            type:"get",
            url:"/Api/tidyRoom/centerList",
            data:{"user_id": user_id},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.data){
                    var list = res.data;
                    var list_html = "";
                    var option_html = "";
                    $.each(list,function($k,$v){
                        /*项目栏*/
                        list_html += "<button class='centerList btn btn-info btn-xs' center-id='"+$v['id']+"'>"+$v['title']+"</button>";
                        option_html += "<option value='"+$v['id']+"'>"+$v['title']+"</option>";
                    });
                    $("#add-model").find("select").append(option_html);
                    $(".headList").prepend(list_html);
                }else{
                    showTips('暂无数据',0)
                }
            }
        });
    }

    /*获取所有用户*/
    function userList()
    {
        $.ajax({
            type:"get",
            url:"/Api/user/userList",
            data:{},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.data){
                    var userList = res.data;
                    $.each(userList,function($k,$v){
                        var user_html = "<input type='checkbox' name='userList' value="+$v['id']+">"+$v['truename'];
                        $("#user-add").append(user_html);
                    });
                }else{
                    showTips('暂无数据',0)
                }
            }
        });
    }
    /*主BODY主入口*/
    function mainBodyList(user_id,center_id,start_date,end_date){
        $("#mainBody").children().remove();
        $.ajax({
            type:"get",
            url:"/Api/tidyRoom/index",
            data:{"user_id": user_id,"center_id": center_id,"start_date":start_date,"end_date":end_date},
            async:true,
            dataType:"json",
            success:function (res) {
                if(res.data){
                    var list = res.data.data;
                    var title = res.data.title;
                    var finalScore = res.data.finalScore;
                    var center_id = res.data.center_id;
                    mainBodySet(list,center_id,title,finalScore);
                }else{
                    showTips('暂无数据',0)
                }
            }
        });
    }
    /*主BODY从方法*/
    /*function mainBodySet_f(data,center_id,center_title,finalScore){

        var list = data;
        var select_html = "<select class = 'list-select'>";
        var list_html = "<ul><li><p class='list_name'>项目</p><p class='list_score'>分数</p><p class='list_count'>数量</p><p class='list_total'>总分</p><p class ='list_date'>更新时间</p></li>";
        $.each(list,function($k,$v){
            select_html += "<option value='"+$v['id']+"'>"+$v['title']+"</option>";
            list_html += "<li><p class='list_name'>"+$v['title']+"</p><p class='list_score'>"+$v['score']+"</p><p class='list_count'>"+$v['count']+"</p><p class='list_total'>"+$v['totalScore']+"</p><p class ='list_date'>"+$v['lastDate']+"</p></li>";
        });
        select_html += "</select>";
        list_html += "</ul>";
        var list_add = "<br><div>家务:"+select_html+"<br class='hidden-sm hidden-md hidden-lg'>数量:<input class='list-add-count'><br class='hidden-sm hidden-md hidden-lg'>日期:<input type='text' class='datepicker'>&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='record-add btn btn-sm btn-default'>新增</button></div>";
        $("#mainBody").append("<div class='list' body-id ="+center_id+"><h2>"+center_title+"</h2><h5>总计:&nbsp;"+finalScore+"分</h5>"+list_add+list_html+"</div>");
        datepickerSet();
    }*/

    /*主BODY从方法*/
    function mainBodySet(data,center_id,center_title,finalScore){

        var list = data;
        var select_html = "<select class = 'list-select'>";
        var list_html = "<table class='table table-striped'><thead><tr><th>项目</th><th>分数</th><th>数量</th><th class='hidden-xs'>总分</th><th>更新时间</th></tr></thead><tbody>";
        $.each(list,function($k,$v){
            select_html += "<option value='"+$v['id']+"'>"+$v['title']+"</option>";
            list_html += "<tr><td>"+$v['title']+"</td><td>"+$v['score']+"</td><td>"+$v['count']+"</td><td class='hidden-xs'>"+$v['totalScore']+"</td><td>"+$v['lastDate']+"</td></tr>";
        });
        select_html += "</select>";
        list_html += "</tbody></table>";
        var list_add = "<br><div style='background:rgba(252,255,204,0.5)'>家务:"+select_html+"&nbsp;数量:<input class='list-add-count add-item'>&nbsp;日期:<input type='text' class='datepicker add-date'>&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='record-add btn btn-xs btn-primary'>新增</button></div>";
        $("#mainBody").append("<div class='list' body-id ="+center_id+">"+list_add+"<h3 style='text-align: center'>"+center_title+"</h3><h5>总计:&nbsp;"+finalScore+"分</h5>"+list_html+"</div>");
        datepickerSet();
    }


    function datepickerSet()
    {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear:true,
            prevText: '<上月',
            nextText: '下月>',
            currentText: '今天',
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                '七月', '八月', '九月', '十月', '十一月', '十二月'],
            monthNamesShort: ['一', '二', '三', '四', '五', '六',
                '七', '八', '九', '十', '十一', '十二'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        });
    }

    /*编辑项目,同步项目名称到家务标题*/
    function changeCenter()
    {
        var _this = $("#add-model");
        if( _this.find("select").val() != ""){
            $("#title").val(_this.find("option:selected").text());
        }
    }
</script>

