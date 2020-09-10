<?php $this->load->view("public/blogshow/header.php");?>
<style type="text/css">
    .mainBody{
        margin-top:100px;
        min-height:79vh;
    }
</style>
<div id="login-form" class="mainBody">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          登录
                      </div>
                      <div class="panel-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <form id="form01">
                                      <div class="form-group">
                                          <label for="login_username">邮箱</label>
                                          <input type="email" class="form-control" name="login_username" onkeydown="KeyDown()" placeholder="Email">
                                      </div>
                                      <div class="form-group">
                                          <label for="password">密码</label>
                                          <input type="password" class="form-control" name="login_psw" onkeydown="KeyDown()" placeholder="Password">
                                      </div>
                                      <button type="button" id="submit01" class="btn btn-default">登陆</button>
                                      <div style="margin-top:10px">没有账号?&emsp;<a href="/entrance/register">注册</a></div>
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
    var httpRefer = "<?php echo $httpRefer ?>";
    $(document).ready(function () {
        //登陆
        $("#submit01").click(function () {
            var login_username = $("*[name='login_username']").val();
            var login_psw = $("*[name='login_psw']").val();
            if(username_check(login_username) == false){
                showTips('用户名格式不正确',0);
                return;
            }
            if(login_psw.length <6){
                showTips('密码不正确',0);
                return;
            }
            $.ajax({
                type: "post",
                dataType: "json",
                data: {'login_username':login_username,'login_psw':login_psw},
                url: "/entrance/login",
                async: true,
                success: function (result) {
                    showTips(result.msg,result.status,1000);
                    if(result.status == 1){
                        if(httpRefer)
                            setTimeout(function () {
                                window.location.href = "/";
                            },1000);
                        else
                            setTimeout(function () {
                                window.location.href = "/blogshow";
                            },1000);
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