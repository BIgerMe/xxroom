<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/15 0015
 * Time: 下午 7:05
 */
class Personal extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model','user_mod');
        $this->load->model('avatar_model','avatar_mod');
    }

    /*头像列表*/
    function avatar_get(){
        $avatar = $this->db->select("*")->where('status',1)->get('avatar')->result_array();
        $this->send_response(REST_Controller::HTTP_OK,'头像列表',$avatar);
    }

    function userInfo_get()
    {
        $user_id = $this->get('user_id');
        $user_info = $this->user_mod->UserInfo($user_id);
        $this->send_response(REST_Controller::HTTP_OK,'用户信息',$user_info);
    }

    function userInfo_post()
    {
        $user_id = $this->post('user_id');
        $avatar = $this->post('avatar');
        $truename = $this->post('truename');

        $this->user_mod->commit([
            'id'=>$user_id,
            'avatar'=>$avatar,
            'truename'=>$truename
        ]);
        $this->send_response(REST_Controller::HTTP_OK,'提交成功');
    }
}