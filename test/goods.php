<?php
$access_token = '6X5RFZWCSUOLM655RXAFWI7LZW25BTX3C7OZVGNF67OYOU2A2P3Q1128378';

$url = 'https://mobile.yangkeduo.com/goods.html?goods_id=56069640894';

$html = goods_detial(54452245384);

echo $html;

function goods_detial($goods_id)
{
    global $access_token;
    $headers = [
        'Cookie:PDDAccessToken='.$access_token,
    ];
    $html = get(goods_detial_url($goods_id), $headers);
    return $html;
}
function goods_detial_url($goods_id)
{
    return sprintf('https://mobile.yangkeduo.com/goods.html?goods_id=%d', $goods_id);
}

function get($url, $headers = [], $cookieJar = '')
{
    $ch = curl_init();
    $ip_long = array(
        array('607649792', '608174079'), //36.56.0.0-36.63.255.255
        array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
        array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
        array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
        array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
        array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
        array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
        array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
        array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
        array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
    );
    $rand_key = mt_rand(0, 9);
    $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
    $headers['CLIENT-IP'] = $ip;
    $headers['X-FORWARDED-FOR'] = $ip;

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    if ($cookieJar) curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
