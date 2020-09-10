<?php $this->load->view("public/blog/header.php");?>
<style type="text/css">
    .mainBody{
        margin-top:100px;
        min-height:79vh;
    }
    table .nb{
        width:10%;
    }
    table .tt{
        width:40%;
    }
    table .tg{
        width:8%
    }
    table .cr{
        width:15%;
    }
    table .ct{
        width:15%;
    }
    table .op{
        width:15%;
    }
    @media (max-width: 991px){
        .mainBody{
            min-height: 72.5vh;
        }
        table .nb{
            width:0%;
        }
        table .tt{
            width:40%;
        }
        table .tg{
            width:15%
        }
        table .cr{
            width:20%;
        }
        table .ct{
            width:0%;
        }
        table .op{
            width:35%;
        }
    }
</style>

<body>
<div class="container mainBody">
    <form METHOD="get" action="<?php echo site_url('/blog/index'); ?>">
        <div>
            <section class="search clearfix">
                <div id="search" class="input-append"/>
                <input class="input-sm" size="20" type="text" value="" placeholder="blog title" name="title"/>
                <button class="btn btn-default hidden-phone" style="padding:4px 8px; !important;">搜索</button>
            </section>
        </div>
    </form>
    <table class="table table-striped">
        <tr>
            <th class="text-center nb hidden-xs">序号</th>
            <th class="text-center tt">标题</th>
            <th class="text-center tg">分类</th>
            <th class="text-center cr hidden-xs">创建人</th>
            <th class="text-center ct hidden-xs">发表时间</th>
            <th class="text-center op">操作</th>
        </tr>
        <?php $i=1;if($list): foreach ($list as $v):?>
        <tr data-id="<?=$v['id']?>">
            <td class="text-center hidden-xs"><?=$i++?></td>
            <td class="text-center"><?=$v['title']?></td>
            <td class="text-center"><?php echo $v['tag']== 0 ? "博客" :($v['tag']=='1' ? '问答' : '其他'); ?></td>
            <td class="text-center hidden-xs"><?=$v['truename']?></td>
            <td class="text-center hidden-xs"><?=$v['created_at']?></td>
            <td class="text-center">
                <button class="btn btn-sm"><a href="<?php echo $v['tag'] == 1 ?  '/blogshow/qaview?id='.$v['id'] : ( $v['tag']==2 ? '/blogshow/gameview?id='.$v['id'] : '/blogshow/view?id='.$v['id']); ?>">详情</a></button>
            &nbsp;  <button class="btn btn-sm" type="button" onclick="del(<?=$v['id']?>)">删除</button>
            </td>
        </tr>
        <?php endforeach;endif; ?>
    </table>
    <div class="page text-right">
        <?=$page?>
    </div>
</div>
</body>
<?php $this->load->view("public/blog/footer.php");?>
<script>
    function del(id) {
        var del = confirm("确认删除?");
        if(del == false){
            return false;
        }
        $.ajax({
            url:'/blog/delete',
            type:'POST',
            data:{id:id},
            async:true,
            dataType:'json',
            success:function(res){
                showTips('删除成功',1,1000);
                setTimeout(function () {
                    window.location.reload();
                },1000)
            }
        });
    }
</script>