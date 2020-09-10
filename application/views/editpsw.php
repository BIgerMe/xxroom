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
                          修改密码
                      </div>
                      <div class="panel-body">
                          <div class="row">
                              <div class="col-md-6">
                                  <form id="form03">
                                      <div class="form-group">
                                          <label for="edit_username">邮箱</label>
                                          <input type="email" class="form-control" name="edit_username" onkeydown="KeyDown()" placeholder="Email">
                                      </div>
                                      <div class="form-group">
                                          <label for="edit_old_psw">旧密码</label>
                                          <input type="password" class="form-control" name="edit_old_psw" onkeydown="KeyDown()" placeholder="旧密码">
                                      </div>
                                      <div class="form-group">
                                          <label for="edit_new_psw">新密码</label>
                                          <input type="password" class="form-control" name="edit_new_psw" onkeydown="KeyDown()" placeholder="新密码">
                                      </div>
                                      <div class="form-group">
                                          <label for="edit_new_psw_cfm">确认新密码</label>
                                          <input type="password" class="form-control" name="edit_new_psw_cfm" onkeydown="KeyDown()" placeholder="确认新密码">
                                      </div>
                                      <button type="button" id="submit03" class="btn btn-default">提交</button>
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
                        setTimeout(function () {
                            window.location.href = "/";
                        },1000);
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