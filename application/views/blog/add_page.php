<?php $this->load->view("public/blog/header.php");?>
<style type="text/css">
    .mainBody{
        margin-top:100px
    }

    .input{
        padding-bottom:20px;
    }
    .input input{
        width:300px;
    }
    .body{
        padding: 0 0 50px 0;
    }
    #md,#html{
        height:1200px;
        min-height: 1200px;
        overflow:hidden;
    }
    #md{
        resize: none;
    }
    #html{
        border: solid 1px darkgrey;
        border-radius: 5px;
    }

    @media (max-width: 768px){
        #md,#html{
            height:300px;
            min-height:300px;
        }
    }
</style>

<body>
<div class="container-fluid mainBody">
    <div class="row">
        <div class="col-md-12 input">
            <span><b>标题:</b></span>&nbsp;&nbsp;&nbsp;
            <input class="input-sm" id="title" type="text" placeholder="title" autocomplete="off" />
        </div>
        <div class="col-md-12 input">
            <span><b>标签:</b></span>&nbsp;&nbsp;&nbsp;
            <input class="input-sm" id="category" type="text" placeholder="category" />
            <span style="color: #ff420f">&emsp;多个分类以半角'逗号'隔开,如: php,java(最多两个标签,每个标签不超过12个字母或不超过6个汉字)</span>
        </div>
        <div class="col-md-12 input">
            <span><b>分类:</b></span>&nbsp;&nbsp;&nbsp;
            <select id="tag" class="form-control input-sm" style="width: 160px;display: inline">
                <option value="0">博客</option>
                <option value="1">问答</option>
                <option value="2">游戏</option>
            </select>
        </div>
        <div class="col-md-12">
            <span><b>内容</b>(Markdown):</span>
        </div>
        <div class="col-md-12 body">
            <div class="col-sm-6 col-lg-6 col-md-6">
                <textarea id="md" class="form-control"  placeholder="请输入Markdown代码"></textarea>
            </div>
            <div id="html" class="col-lg-6 col-sm-6 col-md-6 hidden-xs"></div>
        </div>

        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-primary" onclick="submit()">提交</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-default" onclick="window.location.href = '/blog/index';
">取消</button>
        </div>
	</div>
</body>

<script>

    $(function() {
        //自动显示
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }

        $( "#category" )
        // 当选择一个条目时不离开文本域
            .bind( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).data( "ui-autocomplete" ).menu.active ) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                    // 回到 autocomplete，但是提取最后的条目
                    response( $.ui.autocomplete.filter(
                        availableTags, extractLast( request.term ) ) );
                },
                focus: function() {
                    // 防止在获得焦点时插入值
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // 移除当前输入
                    terms.pop();
                    // 添加被选项
                    terms.push( ui.item.value );
                    // 添加占位符，在结尾添加逗号+空格
                    terms.push( "" );
                    this.value = terms.join( "," );
                    return false;
                }
            });
    });

    $("#md").on("keyup blur",function () {
        var mdH = $("#md")[0].scrollHeight;
        var htmlH = $("#html")[0].scrollHeight;
        var h = mdH > htmlH ? mdH : htmlH ;
        $("#md").css('height',h + "px");
        $("#html").css('height', h + "px");

        $('#html').html(marked($("#md").val()));
    });


    function submit(){
        var title = $("#title").val();
        var category = $("#category").val();
        var content = $("#html").html();
        var tag = $("#tag").val();
        $.ajax({
            type: "post",
            dataType: "json",
            data: {title:title,category:category,content:content,tag:tag},
            url: "/blog/add",
            async: true,
            success: function (res) {
                if(res.status == 1){
                    showTips('新增成功',1,2000);
                    setTimeout(function(){
                        window.location.href = '/blog/';
                    },2000);
                }else{
                    showTips(res.msg,0,2000)
                }
            }
        });
    }
</script>
