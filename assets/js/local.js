/**
 * Created by Administrator on 2018/5/15 0015.
 */

/* 封装提示框*/
if (typeof showTips !== "function") {
    function showTips(txt,status,time) {
        var htmlCon = '';
        if (txt != '') {
            if (status != 0 && status != undefined) {
                htmlCon = '<div class="tipsBox" style="width:220px;padding:10px;background-color:#4AAF33;border-radius:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;color:#fff;box-shadow:0 0 3px #ddd inset;-webkit-box-shadow: 0 0 3px #ddd inset;text-align:center;position:fixed;top:25%;left:50%;z-index:999999;margin-left:-120px;"><img src="/assets/images/ok.png" style="vertical-align: middle;margin-right:5px;" alt="OK，"/>' + txt + '</div>';
            } else {
                htmlCon = '<div class="tipsBox" style="width:220px;padding:10px;background-color:#D84C31;border-radius:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;color:#fff;box-shadow:0 0 3px #ddd inset;-webkit-box-shadow: 0 0 3px #ddd inset;text-align:center;position:fixed;top:25%;left:50%;z-index:999999;margin-left:-120px;"><img src="/assets/images/err.png" style="vertical-align: middle;margin-right:5px;" alt="Error，"/>' + txt + '</div>';
            }
            $('body').prepend(htmlCon);
            if (time == '' || time == undefined) {
                time = 1500;
            }
            setTimeout(function () {
                $('.tipsBox').remove();
            }, time);
        }
    }
}

/*用户名校验*/
function username_check($username)
{
    //手机号
    var mobile = /^1[34578]\d{9}$/;
    //邮箱  xx@xx.xx xx@xx.xx.xx
    var email = /^\w+(\.\w+)*@\w+(\.\w+){1,2}$/
    if(mobile.exec($username) || email.exec($username)){
        return true;
    }else{
        return false;
    }
}

//增加附件
function add_attachment(path){
    let url = '/upload/add';
    $.ajax({
        url: url,
        type: 'POST',
        dataType:'json',
        async:false,
        data: {path:path},
        success: function (rst) {
            console.log(rst);
            if(rst.status == 0){
                console.log('失败');
                return 0;
            }
            return 1;
        },
        error: function () {
            return 0;
        }
    });
}