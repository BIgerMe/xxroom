<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login</title>
    <link rel="icon" href="/assets/images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/img/icon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="Flat Dark Web Login Form Responsive Templates, Iphone Widget Template, Smartphone login forms,Login form, Widget Template, Responsive Templates, a Ipad 404 Templates, Flat Responsive Templates"/>
    <link href="/assets/css/login.css" rel='stylesheet' type='text/css'/>
    <script type="application/javascript" src="/assets/js/jquery-1.9.1.min.js"></script>
    <script type="application/javascript" src="/assets/js/local.js"></script>
</head>
<body>
<!--<h1>小小空间</h1>-->
<div class="login-form">
    <div class="login-form" id="1">
        <!--登陆-->
        <nav>
            <ul>
                <li><a href="#1">登陆</a></li>
                <li><a href="#2">注册</a></li>
                <li><a href="#3">修改密码</a></li>
            </ul>
        </nav>
        <!--<div class="avtar">
            <img src="/assets/personal/img/xiaoming.png"/>
        </div>-->
        <form id="form01" class="login-info">
			<div class="login-center">
            	<input type="text" class="text" name="login_username" onkeydown="KeyDown()" placeholder="邮箱/手机号"/>
				<input name="login_psw" type="password" onkeydown="KeyDown()" placeholder="密码"/>
			</div>
        </form>
        <div class="signin">
            <input type="submit" id="submit01" value="登陆">
        </div>
    </div>
    <div class="login-form" id="2">
        <!--注册-->
		<nav>
			<ul>
				<li><a href="#1">登陆</a></li>
				<li><a href="#2">注册</a></li>
				<li><a href="#3">修改密码</a></li>
			</ul>
		</nav>
        <!--<div class="avtar">
            <img src="/assets/personal/img/xiaoming.png"/>
        </div>-->
        <form id="form02" class="login-info">
			<div class="login-center">
				<input type="text" class="text" name="sign_username" onkeydown="KeyDown()" placeholder="登陆账号(邮箱/手机号)"/>
                <input name="truename" class="text" type="text" onkeydown="KeyDown()" placeholder="昵称"/>
                <input name="sign_psw" type="password" onkeydown="KeyDown()" placeholder="输入密码"/>
				<input name="sign_psw_cfm" type="password" onkeydown="KeyDown()" placeholder="确认密码"/>
            </div>
        </form>
        <div class="signin">
            <input type="submit" id="submit02" value="点击注册">
        </div>
    </div>
    <div class="login-form" id="3">
        <!--修改密码-->
		<nav>
			<ul>
				<li><a href="#1">登陆</a></li>
				<li><a href="#2">注册</a></li>
				<li><a href="#3">修改密码</a></li>
			</ul>
		</nav>
        <!--<div class="avtar">
            <img src="/assets/personal/img/xiaoming.png"/>
        </div>-->
        <form id="form03" class="login-info">
			<div class="login-center">
				<input type="text" class="text" name="edit_username" onkeydown="KeyDown()" placeholder="邮箱/手机号"/>
				<input name="edit_old_psw" type="password" onkeydown="KeyDown()" placeholder="输入旧密码"/>
				<input name="edit_new_psw" type="password" onkeydown="KeyDown()" placeholder="输入新密码"/>
				<input name="edit_new_psw_cfm" type="password" onkeydown="KeyDown()" placeholder="确认新密码"/>
			</div>
        </form>
        <div class="signin">
            <input type="submit" id="submit03" value="确认修改">
        </div>
    </div>
</div>

<div class="copy-rights">
    <p>Modified by <a href="/personal" target="_blank">ZhangXiaoMing</a> Designed @ 2018 </p>
</div>

</body>
</html>

<script>
    var httpRefer = "<?php echo $httpRefer ?>";
    $(document).ready(function () {
        //登陆
        $("#submit01").click(function () {
            $login_username = $("*[name='login_username']").val();
            $login_psw = $("*[name='login_psw']").val();
            if(username_check($login_username) == false){
                showTips('用户名格式不正确',0);
                return;
            }
            if($login_psw.length <6){
                showTips('密码不正确',0);
                return;
            }
            $form01 = $("#form01").serialize();
            $.ajax({
                type: "post",
                dataType: "json",
                data: $form01,
                url: "/entrance/login",
                async: true,
                success: function (result) {
                    showTips(result.msg,result.status,2000);
                    if(result.status == 1){
                        if(httpRefer)
                            window.location.href = httpRefer;
                        else
                            window.location.href = "/blogshow";
                    }
                }
            });
        })
        //注册
        $("#submit02").click(function () {
            $sign_username = $("*[name='sign_username']").val();
            $truename = $("*[name='truename']").val();
            $sign_psw = $("*[name='sign_psw']").val();
            $sign_psw_cfm = $("*[name='sign_psw_cfm']").val();

            $username_check = username_check($sign_username);
            if($username_check == false){
                showTips('账号格式不正确',0);
                return;
            }
            if($truename.length < 1){
                showTips('昵称不能为空',0);
                return;
            }
            if($sign_psw.length < 6){
                showTips('密码不能小于6位',0);
                return;
            }
            if($sign_psw_cfm != $sign_psw){
                showTips('密码不一致',0,1500);
                return;
            }
            $form02 = $("#form02").serialize();
            $.ajax({
                type: "post",
                dataType: "json",
                data: $form02,
                url: "/entrance/sign_up",
                async: true,
                success: function (result) {
                    showTips(result.msg,result.status,2000);
                    if(result.status == 1){
                        window.location.href = "/blogshow";
                        return;
                    }
                }
            });
        })

        //修改密码
        $("#submit03").click(function () {
            $edit_username = $("*[name='edit_username']").val();
            $edit_old_psw = $("*[name='edit_old_psw']").val();
            $edit_new_psw = $("*[name='edit_new_psw']").val();
            $edit_new_psw_cfm = $("*[name='edit_new_psw_cfm']").val();

            if(!$edit_username || !$edit_old_psw || !$edit_new_psw || !$edit_new_psw_cfm){
                showTips('存在为空项',0);
                return;
            }
            if(username_check($edit_username) == false){
                showTips('用户名不正确',0);
                return;
            }
            if($edit_new_psw.length < 6 || $edit_old_psw < 6){
                showTips('密码不能小于6位');
                return;
            }
            if($edit_new_psw == $edit_old_psw){
                showTips('新密码不能与旧密码相同',0);
                return;
            }
            if($edit_new_psw_cfm != $edit_new_psw){
                showTips('新密码输入不一致',0);
                return;
            }
            $form03 = $("#form03").serialize();
            $.ajax({
                type: "post",
                dataType: "json",
                data: $form03,
                url: "/entrance/change_psw",
                async: true,
                success: function (result) {
                    showTips(result.msg,result.status,2000);
                    if(result.status == 1){
                        window.location.hash = "#1";
                    }
                }
            });
        });

        //定位到当前锚点
        var page_id = window.location.hash;
        if(page_id){
            var t = $(page_id).offset().top;
            $(".login-form").scrollTop(t);
        }
    });

    function KeyDown()
    {
        var e = event || window.event;
        var page_id = window.location.hash;
        if (e.keyCode == 13)
        {
//            e.returnValue=false;
//            e.cancel = true;
            if( page_id == '#2'){
               var id = $("#submit02");
            }else if(page_id == '#3'){
               var id = $("#submit03");
            }else{
               var id = $("#submit01");
            }
            console.log(id);
            id.click();
        }
    }
</script>