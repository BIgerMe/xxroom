<?php

//获取允许码
function getcode(){

    $monthday = date('m').date('d'); //0107
    $week = date("w"); //6  周六

    $time1 = substr($monthday, 0,1) + $week;
    $time2 = substr($monthday, 1,1) + $week;
    $time3 = substr($monthday, 2,1) + $week;
    $time4 = substr($monthday, 3,1) + $week;

    $tmp1 = (strlen($time1) > 1) ? substr($time1, 1,1) : $time1;
    $tmp2 = (strlen($time2) > 1) ? substr($time2, 1,1) : $time2;
    $tmp3 = (strlen($time3) > 1) ? substr($time3, 1,1) : $time3;
    $tmp4 = (strlen($time4) > 1) ? substr($time4, 1,1) : $time4;

    return $tmp1.$tmp2.$tmp3.$tmp4;
}
//echo getcode();
/**
 * 解密加密函数
 * @param string $string
 * @param string $operation
 * @param string $key
 * @param int $expiry
 * @return string
 */
function authcode($string, $operation = 'DECODE', $key = 'pdd', $expiry = 0)
{

    $ckey_length = 4;    // 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

$a = authcode("xxxxxx", 'ENCODE');
//$a = base64_encode($a);

echo $a ;