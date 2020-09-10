<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/20 0020
 * Time: 下午 12:59
 */
class Auth_Controller extends CI_Controller
{
    public $user_id;
    public $username;

    public function __construct()
    {
        parent::__construct();
        $this->config->load('form_validation');
        $this->is_login();
    }
    /*检查是否登录*/
    public function is_login(){
        if($data = $this->session->userdata(config_item('login_session'))){
            $this->user_id = unserialize($data);
        }
    }

    /*登出*/
    public function logout(){
        $this->session->unset_userdata(config_item('login_session'));
    }
}