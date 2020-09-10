<?php $this->load->view("public/blogshow/header.php");?>

<style type="text/css">
    html,body,h4{
        font-family: Microsoft YaHei,Helvetica Neue,Arial,sans-serif;
    }
    .mainBody{
        min-height:79vh;
        padding: 50px 0 0 0;
        /*background: #e6fffb;*/
    }
    .panel{
        animation: sky 120s linear 0s infinite alternate;
        margin-bottom: 10px;
    }
    .panel .panel-title{
        font-size: 12px;
        font-weight: 500;
        color: #8f2727;
        width:50px;
        text-align: center;
        background: -webkit-linear-gradient(left, #ffd591, #ffe7ba); /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(right, #ffd591, #ffe7ba); /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(right, #ffd591, #ffe7ba); /* For Firefox 3.6 to 15 */
        background: linear-gradient(to right, #ffd591, #ffe7ba); /* Standard syntax */
        box-shadow: 1.5px 2px 0px rgba(6, 6, 6, 0.41);
    }
    .card-all{
        padding-top:10px;
        padding-bottom: 10px;
        animation: sky 120s linear 0s infinite alternate;
        margin-bottom: 10px;
    }
    .card {
        background: #ffd591;
        margin-bottom: 10px;
        border-radius: 3px;
        box-shadow: 2px 2px 0px rgba(6, 6, 6, 0.41);
    }
    .card .card-head {
        overflow: hidden;
        margin-bottom: 7px;
        display: block;
        cursor: pointer;
        padding: 10px 18px 0;
        color: #333;
        text-decoration : none;
    }
    .card .card-head:hover{
        color: #4aa1a8;
    }
    .card .card-head .card-icon {
        width: 50px;
        height: 50px;
        float: left;
        display: block;
        background: rgba(196,228,230,0.1);
    }
    .card .card-head .card-icon img {
        display: block;
        width: 100%;
        height: 100%;
    }

    .card .card-head .card-title {
        display: block;
        padding-left: 50px;
        margin-top: 18px;
        font-weight: 700;
        font-size: 15px;
        color: inherit;
    }

    .card .card-body {
        color: #666666;
        font-size: 12px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        margin-bottom: 2px;
        padding: 0 18px;
    }
    .card .card-foot {
        padding: 0 18px 8px;
    }
    .sidenav {
        -webkit-overflow-scrolling: touch;
        width: 230px;
        position: fixed;
        z-index: 200;
        top: 0;
        left: 0;
        background-color: #ffd591;
        padding: 31px 0;
        color: #ccc;
    }

    ul.ani{
        height: 227px;
        /*background-color: skyblue;*/
        /*margin-top: 150px;*/
        animation: sky 120s linear 0s infinite alternate;
        position: relative;
        margin-bottom: 0;
    }
    @keyframes sky {
        from{
            background-color: skyblue;
        }
        to{
            background-color: skyblue;
        }
    }
    ul.ani li{
        list-style: none;
        width:400%;
        height: 227px;
        position: absolute;
        left: 0;
        top: 0;
    }


   /* ul.ani li:nth-child(1){
        background: url("https://www.wailian.work/images/2018/10/10/o_cloud_two.png");
        animation: oneSport 180s linear 0s infinite ;
    }*/
    ul.ani li:nth-child(1){
        background: url("https://www.wailian.work/images/2018/10/10/o_cloud_two.png");
        animation: twoSport 180s linear 0s infinite ;
    }
    ul.ani li:nth-child(2){
        background: url("https://www.wailian.work/images/2018/10/10/o_cloud_three.png");
        animation: threeSport 180s linear 0s infinite ;
    }
    ul.ani li:nth-child(3){
        background: url("https://www.wailian.work/images/2018/10/10/plane.png");
        animation: fourSport 80s linear 0s infinite ;
    }
    ul.ani li:nth-child(4){
        background: url("https://www.wailian.work/images/2018/10/10/plane2.png");
        animation: fiveSport 60s linear 0s infinite ;
    }
    div.float{
        animation: sky 120s linear 0s infinite alternate;
        position: fixed;
        /*border-radius: ;*/
        left: 80px;
        top: 100px;
        box-shadow: 7px 7px 0px rgba(6, 6, 6, 0.41);
    }
    li.left-nav{
        width: 80px;
        margin: 10px;
        background: #ffd591;
        text-align: center;
        /*transform: skew(30deg);*/
        /*-webkit-transform: skew(15deg);*/
        /*-moz-transform: skew(15deg);*/
        /*-o-transform: skew(15deg);*/
        /*-ms-transform: skew(15deg);*/
        border-radius: 8px;
    }
    li.left-nav :hover{
        color: #4aa1a8;
    }
    li.left-nav a{
        display:inline-block;
        /*字体不倾斜 必须是块级元素*/
        /*-webkit-transform: skew(-15deg);*/
        /*-moz-transform: skew(-15deg);*/
        /*-o-transform: skew(-15deg);*/
        /*-ms-transform: skew(-15deg);*/
        color: #8f2727;
        font-size:19px;
        text-decoration : none;
    }
    /*@keyframes oneSport {
        from{
            left: 0;
        }
        to{
            left:-100%;
        }
    }*/
    @keyframes twoSport {
        from{
            left: 0;
        }
        to{
            left: -250%;
        }
    }
    @keyframes threeSport {
        from{
            left: 0;
        }
        to{
            left: -300%;
        }
    }
    @keyframes fourSport {
        from{
            left: 0;
        }
        to{
            left:-250%;
        }
    }
    @keyframes fiveSport {
        from{
            left: 0;
        }
        to{
            left:-350%;
        }
    }
    @media (min-width: 1200px){
        .container {
            /*width: 1200px;*/
        }
    }
    @media (max-width: 768px){
        .card .card-head .card-icon {
            width:32px;
            height:32px;
        }
        .card .card-head .card-title {
            padding-left: 32px;
            margin-top:5px;
        }
        .row div{
            padding: 0;
        }
    }
</style>
<body>
    <div id="information" class="mainBody">
        <div class="container hidden-xs" style="padding: 0">
            <ul class="ani">
<!--                <li></li>-->
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <div class="container card-all">
            <?php foreach ($category as $c): ?>
            <div class="panel">
                <div class="panel-title" id="id_<?=$c['id']?>">
                    <i class="<?=$c['logo']?>"></i><span><?=$c['title']?></span>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if(!empty($navigation[$c['id']])): foreach ($navigation[$c['id']] as $n): ?>
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="card">
                                <a class="card-head" href="<?=$n['href']?>" onclick="updateview(<?=$n['id']?>)" target="_blank">
                                    <span class="card-icon"><img class="img-circle" src="<?=$n['logo']?>"></span>
                                    <span class="card-title">&#160;<?=$n['title']?> <span style="float: right;color: #9a9494"><i class="glyphicon glyphicon-link"></i>&#160;<?=$n['view']?></span></span>

                                </a>
                                <div class="card-body"><?=$n['content']?></div>
                                <div class="card-foot" style="text-align: right">
<!--                                    <i class="glyphicon glyphicon-link"></i>&#160;<span>--><?//=$n['view']?><!--</span>&nbsp;&nbsp;&nbsp;-->
        <!--                            <i class="glyphicon glyphicon-thumbs-up"></i>&#160;<span>--><?//=$n['praise']?><!--</span>-->
                                </div>
                            </div>
                        </div>
                        <?php endforeach; endif;?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="float hidden-xs hidden-phone">
        <ul>
            <?php foreach ($category as $i=>$v): ?>
                <?php if($i == 0):?>
                <li class="left-nav"><a href="#"><i class="<?=$v['logo']?>"></i>&nbsp;<?=$v['title']?></a></li>
                <?php elseif($i): ?>
                <li class="left-nav"><a href="#id_<?=$category[$i-1]['id'] ?>"><i class="<?=$v['logo']?>"></i>&nbsp;<?=$v['title']?></a></li>
            <?php endif; endforeach;?>
        </ul>
    </div>
</body>

<?php $this->load->view("public/blogshow/footer.php");?>
<script>
    function updateview(id){
        $.ajax({
            url:'/navigation/updateview',
            type:"post",
            dataType:"json",
            data:{'id':id},
            async:true,
            success:function () {
                console.log(id);
            }
        })
    }
</script>
