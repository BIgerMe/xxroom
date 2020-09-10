<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/27 0027
 * Time: 下午 8:35
 */
class Test
{
    public function __construct()
    {
    }

    public function getIo()
    {
        $data = [
            'requestId'=> "test-request-id-5cde6700cf8e3",
            "errorCode"=>"InvalidProject.NotFound",
            "errorMessage"=>"The project \"123\" does not exist."
        ];
        echo json_encode($data);
    }
    public function postIo(){

    }
}