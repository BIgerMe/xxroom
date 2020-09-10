<?php
$access_token = 'NGCIJZS2C5I37QPXOHTBUGRSIPI4XL3L64Y3ZU5SX23BRGH7DGUQ1128378';
$html = goods_detial2(70620145726);
echo $html;
function goods_detial2($goods_id)
{
    global $access_token;
    $headers = [
        'accesstoken:' . $access_token,
        "Content-Type:"."application/json"
    ];
    $url = 'https://api.pinduoduo.com/goods/'.$goods_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
