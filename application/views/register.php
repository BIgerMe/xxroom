<?php $this->load->view("public/blogshow/header.php");?>
<style type="text/css">
    .mainBody{
        margin-top:100px;
        min-height:79vh;
    }
    .form-inline .form-control {
        display: inline-block;
        width: auto;
        vertical-align: middle;
    }
</style>
<div id="login-form" class="mainBody">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          注册
                      </div>
                      <div class="panel-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <form id="form02">
                                      <div class="form-group">
                                          <label for="login_username">邮箱</label>
                                          <input type="email" class="form-control" name="sign_username" onkeydown="KeyDown()" placeholder="Email">
                                      </div>
                                      <div class="form-group">
                                          <label for="login_username">昵称</label>
                                          <input type="text" class="form-control" name="truename" onkeydown="KeyDown()" placeholder="傻波波">
                                      </div>
                                      <div class="form-group">
                                          <label for="sign_psw">密码</label>
                                          <input type="password" class="form-control" name="sign_psw" onkeydown="KeyDown()" placeholder="输入密码">
                                      </div>
                                      <div class="form-group">
                                          <label for="sign_psw">确认密码</label>
                                          <input type="password" class="form-control" name="sign_psw_cfm" onkeydown="KeyDown()" placeholder="确认密码">
                                      </div>
                                      <div class="form-group form-inline">
                                          <label for="code">邮箱验证码</label>
                                          <input type="text" class="form-control" style="width:80px;" name="code" autocomplete="off">
                                          <button type="button" class="btn btn-default" id="sendCode">点击发送</button>
                                      </div>
                                      <button type="button" id="submit02" class="btn btn-default">注册</button>
                                      <div style="margin-top:10px">已有账号?&emsp;<a href="/entrance">登录</a></div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>
            <div class="col-md-3>">

            </div>
        </div>
    </div>
</div>
<?php $this->load->view("public/blogshow/footer.php");?>

<script>
    $(document).ready(function () {
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
                        setTimeout(function () {
                            window.location.href = "/blogshow";
                        },1000);
                    }
                }
            });
        });

        $("#sendCode").click(function () {
            var email = $("input[name='sign_username']").val();
            if(!email)
                showTips("请先填写邮箱",0,1000);
            $.ajax({
                type: "get",
                dataType: "json",
                data: {email:email},
                url: "/entrance/send_email_code",
                async: true,
                success: function (result) {
                    showTips(result.msg,result.status,1000);
                    if(result.status == 1){
                        var time = 60;
                        var timer = null;
                        timer = setInterval(function(){///开启定时器。函数内执行
                            $("#sendCode").attr('disabled','true');
                            $("#sendCode")[0].innerText = time+"秒后重新发送";    //点击发生后，按钮的文本内容变成之前定义好的时间值。
                            time--;//时间值自减
                            if(time ==0){     //判断,当时间值小于等于0的时候
                                $("#sendCode")[0].innerText = '重新发送验证码'; //其文本内容变成……点击重新发送……
                                $("#sendCode").removeAttr('disabled');
                                clearInterval(timer); //清除定时器
                            }
                        },1000)

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