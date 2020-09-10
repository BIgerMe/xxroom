<?php

/**
 * 百度09转gc2坐标
 */
function Convert_BD09_To_GCJ02($lat, $lng)
{
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $lng - 0.0065;
    $y = $lat - 0.006;
    $z = sqrt($x * $x + $y * $y) - 0.00002  * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $lng = $z * cos($theta);
    $lat = $z * sin($theta);
    return array('lng' => $lng, 'lat' => $lat);
}
//通过经纬度计算出距离
function getDistance($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = 6367000; //地球半径

    /**
     *将这些度数转换为弧度，代入公式
     * pi()返回圆周率近似值
     */
    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;
    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;
    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;
    return round($calculatedDistance);
}


$a = Convert_BD09_To_GCJ02('31.477912','120.280951');
$d = getDistance($a['lat'],$a['lng'],31.47199029446935,120.27440994300183);
echo $d;