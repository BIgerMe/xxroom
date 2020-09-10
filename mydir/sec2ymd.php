<?php

$durtime  =  500000;
$d = floor($durtime / (3600*24));
$h = floor($durtime % (3600*24) / 3600);
$m = floor($durtime % (3600*24) % 3600 / 60);
$s = floor($durtime % (3600*24) % 3600 % 60);
$str = '';
if($d > 0){
    $str = $d."天".$h."时".$m."分".$s."秒";
}else if($h>0){
    $str = $h."时".$m."分".$s."秒";
}else if($m>0){
    $str = $m."分".$s."秒";
}else{
    $str = $s."秒";
}
echo $str;
//输出：5天18时53分20秒