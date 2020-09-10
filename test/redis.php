<?php

//spl_autoload_register(function ($class_name) {
//    require_once str_replace('\\','/',$class_name.'.php');
//});
//use app\first as Fc;
//$o = new Fc();
//echo $o->init();
$redis = new redis();
$con = $redis->connect('127.0.0.1', 6379);
$watchKey = $redis->get("watchKey");
$total = 20;   //抢购数量
if ($watchKey <= $total) {
    $redis->watch("watchKey");   //监听key值，如果在事务执行前被改动则执行失败
    $redis->multi(); //在当前连接上启动一个新的事务。
    //插入抢购数据
    $redis->set("watchKey", $watchKey + 1);
    $result = $redis->exec();
    if ($result) {
        $redis->hSet("watchList", "user_" . mt_rand(1, 9999), $watchKey);
        $watchList = $redis->hGetAll("watchList");
        echo "抢购成功！<br/>";
        echo "剩余数量：" . ($total - $watchKey - 1) . "<br/>";
        echo "用户列表：<pre>";
        var_dump($watchList);
    } else {
        $redis->hSet("watchList", "user_" . mt_rand(1, 9999), 'meiqiangdao');
        echo "手气不好，再抢购！";
        exit;
    }
}
 ?>