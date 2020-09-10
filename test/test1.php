<?php
$a = checkmobile();
print_r("<pre>");
print_r($a);
if(checkmobile()){
    exit('point1');
}else{
    exit('point2');
}


/**
 *
 * 根据php的$_SERVER['HTTP_USER_AGENT'] 中各种浏览器访问时所包含各个浏览器特定的字符串来判断是属于PC还是移动端
 * @author           discuz3x
 * @lastmodify    2014-04-09
 * @return  BOOL
 */
function checkmobile() {
    global $_G;
    $mobile = array();
//各个触控浏览器中$_SERVER['HTTP_USER_AGENT']所包含的字符串数组
    static $touchbrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
        'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
        'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
        'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
        'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
        'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
        'benq', 'haier', '^lct', '320x320', '240x320', '176x220');
//window手机浏览器数组【猜的】
    static $mobilebrowser_list =array('windows phone');
//wap浏览器中$_SERVER['HTTP_USER_AGENT']所包含的字符串数组
    static $wmlbrowser_list = array('cect', 'compal', 'ctl', 'lg', 'nec', 'tcl', 'alcatel', 'ericsson', 'bird', 'daxian', 'dbtel', 'eastcom',
        'pantech', 'dopod', 'philips', 'haier', 'konka', 'kejian', 'lenovo', 'benq', 'mot', 'soutec', 'nokia', 'sagem', 'sgh',
        'sed', 'capitel', 'panasonic', 'sonyericsson', 'sharp', 'amoi', 'panda', 'zte');
    $pad_list = array('pad', 'gt-p1000');
    $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
    if(dstrpos($useragent, $pad_list)) {
        return false;
    }
    if(($v = dstrpos($useragent, $mobilebrowser_list, true))){
        $_G['mobile'] = $v;
        return '1';
    }
    if(($v = dstrpos($useragent, $touchbrowser_list, true))){
        $_G['mobile'] = $v;
        return '2';
    }
    if(($v = dstrpos($useragent, $wmlbrowser_list))) {
        $_G['mobile'] = $v;
        return '3'; //wml版
    }
    $brower = array('mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
    if(dstrpos($useragent, $brower)) return false;
    $_G['mobile'] = 'unknown';
//对于未知类型的浏览器，通过$_GET['mobile']参数来决定是否是手机浏览器
    if(isset($_G['mobiletpl'][$_GET['mobile']])) {
        return true;
    } else {
        return false;
    }
}
/**
 * 判断$arr中元素字符串是否有出现在$string中
 * @param  $string     $_SERVER['HTTP_USER_AGENT']
 * @param  $arr          各中浏览器$_SERVER['HTTP_USER_AGENT']中必定会包含的字符串
 * @param  $returnvalue 返回浏览器名称还是返回布尔值，true为返回浏览器名称，false为返回布尔值【默认】
 * @author           discuz3x
 * @lastmodify    2014-04-09
 */
function dstrpos($string, $arr, $returnvalue = false) {
    if(empty($string)) return false;
    foreach((array)$arr as $v) {
        if(strpos($string, $v) !== false) {
            $return = $returnvalue ? $v : true;
            return $return;
        }
    }
    return false;
}




echo md5("123456",true);
echo hex2bin(md5("123456"));  //十六进制转换成ascii
exit('here is point');
function sign($params = [], $secret = '')
{
    ksort($params);
    $str = '';
    foreach ($params as $k => $v) {
        $str = $str . $k . $v;
    }
    $str = $secret . $str . $secret;
    echo $str."<br>";
    return strtoupper(md5($str));
}

$params = [
    'total' => '15000',
    'api_order_sn' => 'P20190930133247564628',
    'notify_url' => "http://www.yton.biz/xypay-api/pay_callback/ppdPayService",
    'type' => 'wechat',
    'client_id' => '7abb93379ad6b4562afbb69cd6c6b99d',
    'timestamp' => '1569821573792'
];
unset($params['sign']);

$sign = sign($params, "5953551ce250aeaa91a9fe766b05e196963803758c059a32695509328f592473");

echo $sign."<br>";

echo  '7B11B1D01E4FFBBBDFE7EFF611A12AEA';
exit();






function createSign($Md5key, $list)
{
    ksort($list);
    $md5str = "";
    foreach ($list as $key => $val) {
        if (!empty($val)) {
            $md5str = $md5str . $key . "=" . $val . "&";
        }
    }
    $sign = strtoupper(md5($md5str . "key=" . $Md5key));
    return $sign;
}


$request = [
    'pay_memberid'=>"320439",
    'pay_orderid'=>"E2019092306424142604"
];
$key = "A~09DJbQncyaLMWz";

$a = createSign($key,$request);
echo $a;