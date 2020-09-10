<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/1 0001
 * Time: 下午 1:50
 */

class User extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model','user_mod');
    }
    function userList_get()
    {
        $userList = $this->user_mod->userList();
        $this->send_response(REST_Controller::HTTP_OK,'用户列表',$userList);
    }
}