<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/10/12
 * Time: 10:58
 */
//推入队列
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
for($i=0;$i<50;$i++){
    try{
        $redis->LPUSH('click',rand(1000,5000));
    }catch(Exception $e){
        echo $e->getMessage();
    }
}

//消费队列
$redis = new Redis();
$redis->pconnect('127.0.0.1',6379);
while(true){
    try{
        $value = $redis->LPOP('click');
        if(!$value){
            break;
        }
        var_dump($value)."\n";
        /*
        * 利用$value进行逻辑和数据处理
        */
    }catch(Exception $e){
        echo $e->getMessage();
    }
}