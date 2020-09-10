<?php
define('ZFB',6);
define('WX',38);

$access_token = 'NGCIJZS2C5I37QPXOHTBUGRSIPI4XL3L64Y3ZU5SX23BRGH7DGUQ1128378';
$uid = 1394575321731;
$user = ['address_id'=>15309940234];
$goods = ['normal_price'=>6,'goods_id'=>77905536526,'sku_id'=>445788006640,'group_id'=>26779495766];
$total =  6;
$charge_mobile = 15716197390;
$order = order($user,$goods,$total,WX,$charge_mobile);  //订单详情
print_r("<pre>");
print_r($order);
exit('point');
$payUrl = pay(WX,$order); //支付连接

function order($user, $goods, $total, $pay_type,$charge_mobile)
{
    global  $uid;
    $sku_number = $total / $goods['normal_price'];

    $params = [
        'address_id' => $user['address_id'],
        //'anti_content' => '0alAfxnUmctyg9EVWicck2J9d6BMw_ZpTiX_vv_FEh_knQP40lnCqj5IecT_8v_bFte7n0X4L5ogux3mAupi29iCA2BW9Gp8mLAypMymkIlqyr09g9qAP1Z9Xsh2GuVB8ki7d7o4rBuODilJ4A4hdhRbbGWTQ2N4oERySADr2zFxxNfYbpyPy8Qv_9qS7vigkmZkKdz1Fa7v_T1GYag-t1jYeP-qbLdkAhfkXaXUyGlt67XEvxKOFa2YL9uojBzeTy5Kkf3aTx0Xml-q47Rzn6-Ck5Bus53HW4zFmI6esZfeuiYfZPpc_Zkm_jGl2nAY6E9yy4zD9638gRR6cJVtAb_LV0B0mOyiHmOUqxUMsHcLLHmTC5HSZw99J0LtXrogJssDzKTnoambhKXjnTjwA9BF-cg8Pguu2JlcFJcRs3cS9RMjL0LJ2erTS8JlsX7XHOrMzHg5iwfSCIaBgNQqh0BJauqptF6m4epCzuic9tGWpoKxYxrsHBwD6_GXPy1KSn6wrNQerm6-iqVk18LifzSk1UtMutiEGDi2K8xZzUDAlJhRdKcIHX23cIwSSx3CKiKSFxrtm5Z7761pTiLerLdH-7qnFvfl6MfbruiMj3DRYLR2AuxK7H',
        'attribute_fields' => [
            //'PTRACER-TRACE-UUID' => "3009158000000000000000#1556955506660#st2-glb-308",
            //'create_order_token' => "dc7e192d-2e77-4ccf-b799-aedc55ffab7e",
            'order_amount' => $total,
            //'original_front_env' => 0,
        ],
        //'biz_type' => 0,
        //'duoduo_type' => 0,
        'goods' => [
            [
                'goods_id' => $goods['goods_id'],
                'sku_id' => $goods['sku_id'],
                'sku_number' => $sku_number,
            ]
        ],
        'group_id' => $goods['group_id'],
        //'is_app' => '0',
        //'page_id' => '10002_1556955394117_tmwzG2UrBi',
        'pay_app_id' => $pay_type,  //6支付宝 38微信
        //'source_channel' => '0',
        //'source_type' => 0,
        //'version' => 1,
    ];
    if($charge_mobile){
        $params['charge_mobile'] = $charge_mobile;
    }
    return post(order_url($uid), json_encode($params, JSON_UNESCAPED_UNICODE));
}
function order_url($uid)
{
    return sprintf('https://mobile.yangkeduo.com/proxy/api/order?pdduid=%d', $uid);
}
function post($url, $params=[], $headers=[])
{
    global $access_token;
    $headers = $headers + [
            'AccessToken:' . $access_token,
            'Content-Type:application/json;charset=UTF-8',
        ];
    $result = netpost($url, json_encode($params, JSON_UNESCAPED_UNICODE), $headers);
    return check_result($result);
}
function netpost($url, $params = [], $headers = [], $cookieJar = '')
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    if ($cookieJar) curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function check_result($result)
{
    $result = json_decode($result, true);

    if (isset($result['error_msg']) && $result['error_msg']) {
        exit('here is ERROR');
    }
    return $result;
}
function pay($pay_code, $order)
{
    if ($pay_code == WX) {
        return wepay($order['fp_id']);
    }
    if ($pay_code == ZFB) {
//        return alipay($order['order_sn']);
    }
}
function wepay($fp_id)
{
    return sprintf('https://mobile.yangkeduo.com/friend_pay.html?fp_id=%s', $fp_id);
}
