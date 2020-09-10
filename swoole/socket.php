<?php

class socket{
    public $server;
    public $redis;
    public $tablename = 'chat_detail';

    public function __construct(){
        $this->redis = new Redis();
        $_this = $this;
        $server = new swoole_websocket_server("0.0.0.0", 9502,SWOOL_BASE);

        $a = [];

        //Start事件在Master进程的主线程中被调用
        $server->on('start',function(){

        });

        /**onWorkStart
         * @attention 可以通过$server->taskworker属性来判断当前是Worker进程还是Task进程
         * @attention 设置了worker_num和task_worker_num超过1时，每个进程都会触发一次onWorkerStart事件，可通过判断$worker_id区分不同的工作进程
        */
        $server->on('WorkStart',function($server,$id){

        });

        /**
         * @param $server
         * @param $fd 0-1600万的自增唯一int
         * @param $reactor_id reactor线程标识
        */
        $server->on('Connect',function($server,$fd,$reactor_id){

        });

        /**
         * @param $server
         * @param $fd 0-1600万的自增唯一int
         * @param $reactor_id reactor线程标识
        */
        $server->on('Close',function($server,$fd,$reactor_id){

        });

        /**
         * @param $server
         * @param $task_id
         * @param $worker_id
         * @param $data
        */
        $server->on('Task',function($server,$task_id,$worker_id,$data){

        });

        /**
         * @param $server
         * @param $fd 0-1600万的自增唯一int
         * @param $reactor_id reactor线程标识
         * @param string $data  最大64K数据 有可能是二进制
        */
        $server->on('Receive',function($server,$fd,$reactor_id,$data){

        });


        //已关闭Reactor\HeartbeatCheck\UdpRecv线程 和 Worker\Task\User进程
        $server->on('shutdown',function(){

        });
    }
}








//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new swoole_websocket_server("0.0.0.0", 9502);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    $fd[] = $request->fd;
    $GLOBALS['fd'][] = $fd;
    $data = jsonOut(['status'=>1,'type'=>'first','fd'=>$request->fd]);                    //标准输出-xxroom
    $ws->push($request->fd, $data);
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    $member = '游客'.$frame->fd;
    $msg = $frame->data;

    foreach($GLOBALS['fd'] as $aa){
        foreach($aa as $i){
            $ws->push($i,$msg);
        }
    }
    // $ws->push($frame->fd, "server: {$frame->data}");
    // $ws->push($frame->fd, "server: {$frame->data}");
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});
$ws->start();




//标准输出
function jsonOut($data){
    if(is_string($data)){
        $data = [$data];
    }
    if(is_array($data)){
        return json_encode($data);
    }else{
        return [];
    }
}