var config = {
    requestUrl : "http://localhost:8080"
    // requestUrl: "http://zzj.gaogutrade.com:888"
    // requestUrl: "http://zzj.gaogutrade.com:90"
};
function setCookie(cname,cvalue,exmins=1440){
    var d = new Date();
    d.setTime(d.getTime()+(exmins*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname+"="+cvalue+";"+expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++)
    {
        var c = ca[i].trim();
        if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
}
/*检查登录*/
function checkLogin(){
    if(!getCookie('token') || !getCookie('loginUser')){
        location.href = 'login.html';
    }
}
/*登出*/
function loginOut(){
    document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    document.cookie = "loginUser=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    location.href = 'login.html';
}
/*获取参数*/
function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable){return pair[1];}
    }
    return(false);
}