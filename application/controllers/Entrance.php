<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*平台入口*/

class Entrance extends Yl_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user_mod');
        $this->load->model('auth_model','auth_mod');
        $this->load->model('email_model','email_mod');
    }

    /*登陆首页*/
    public function index()
    {
        if($this->user_id)
            parent::redirect("/blogshow/index");
        //登录后跳转上次进入的页面
        $this->_vd['httpRefer'] = '';
        if(isset($_SERVER['HTTP_REFERER'])){
            $refer = $_SERVER['HTTP_REFERER'];
            $refer = str_replace(HOME_HOST,'',$refer);
            if(preg_match('/^\//',$refer) && !preg_match('/logout|entrance/',$refer))
                $this->_vd['httpRefer'] = $refer;
        }
        $this->_view('entrance');
    }
    //注册
    public function register(){
        $this->_view('register');
    }

    //修改密码
    public function editpsw(){
        $this->_view('editpsw');
    }

    /**注册
     * @var $sign_username 用户名
     * @var $sign_psd 密码
     * return json
     */
    public function sign_up()
    {
        $username = $this->_post['sign_username'];
        $truename = $this->_post['truename'];
        $psw = $this->_post['sign_psw'];
        $code = $this->_post['code'];

        //邮箱验证码
        $codeCheck = $this->db->where(['email'=>$username,'code'=>$code])->get("user_email_code")->result_array();
        if(!$codeCheck)
            $this->json_out(0,'邮箱验证码错误');

        //用户名是否存在
        if ($rst = $this->user_mod->check_user_exist($username)) {
            $this->json_out(0, '用户名已存在');
        }

        $avatar = "/assets/images/avatar/kof/".rand(1,48).'.png';
        $commit_data = [
            'username' => $username,
            'truename'=>$truename,
            'password' => md5($psw),
            'avatar'=>$avatar
        ];
        if ($this->user_mod->commit($commit_data)) {
            //登录设置session
            $this->login_check($username,$psw);
            $this->json_out(1, '注册成功');
        }
    }

    /**登陆
     * @var $login_username 登录用户名
     * @var $login_psw 登录密码
     * @return json
     */
    public function login()
    {
        $login_username = $this->_post['login_username'];
        $login_psw = $this->_post['login_psw'];
        $login_data = array('login_username' => $login_username, 'login_psw' => $login_psw);
        $this->config->load('form_validation');
        $this->form_validation->set_data($login_data);
        $this->form_validation->set_rules(config_item('login_rule'));

        if($this->form_validation->run() !== FALSE) {
            //检查用户名密码是否匹配
            if($this->login_check($login_username,$login_psw)){
               $this->json_out(1,'success',$this->session->userdata(config_item('login_session')));
            }
        }

        $this->json_out(0,'用户名或密码错误');
    }

    /**登陆验证
     * @param $username 用户名
     * @param $psw 密码
     * @return boolean
     */
    public function login_check($username,$psw)
    {
        $psw = md5($psw);

        if($user_id = $this->user_psw_check($username,$psw)){
            $this->session->set_userdata(config_item('login_session'),serialize($user_id));

            $session_id = $_COOKIE['ci_session'];
            $id = $this->auth_mod->get_one($user_id);
            $auth_data = array(
                'id'=>$id,
                'user_id'=>$user_id,
                'session_id'=>$session_id,
                'expire'=>time() + config_item('sess_expiration'),
                'ip'=>$this->getIP()
                );
            $this->auth_mod->commit($auth_data);
            return true;
        }
        return false;
    }

    /**用户密码配对
     * @var $username 用户名
     * @var $psw 密码
     * @return str||boolean
     */
    public function user_psw_check($username,$psw){
       $user_id = $this->user_mod->login_check($username,$psw);
       return $user_id;
    }

    /**修改密码
     * @var $username 用户名
     * @var $old_psw 旧密码
     * @var $new_psw 新密码
     * @return json
     */
    public function change_psw(){
        $username = $this->_post['edit_username'];
        $old_psw = $this->_post['edit_old_psw'];
        $new_psw = $this->_post['edit_new_psw'];

        //用户名是否存在
        if (!$this->user_mod->check_user_exist($username)) {
            $this->json_out(0, '用户名不存在');
        }
        //账号密码是否匹配
        if(!$user_id = $this->user_psw_check($username,md5($old_psw))){
            $this->json_out(0,'原密码不正确');
        }

        $user_data = array('id'=>$user_id,'password'=>md5($new_psw));
        $this->user_mod->commit($user_data);
        $this->json_out(1,'修改密码成功');
    }

    /*邮箱验证*/
    function send_email_code()
    {
        $email = $this->_get['email'];
        if(!preg_match("/^\w+(\.\w+)*@\w+(\.\w+){1,2}$/",$email))
            $this->json_out(0,'邮箱格式不正确');
        $this->load->library("mailer");
        $code = rand('100000','999999');
        $rst = $this->mailer->sendMail($email,'注册邮箱验证码',"https://www.xxroom.xyz 注册邮箱验证码:".$code);
        if($rst['status'] == 1){
            $rst = $this->db->where("email",$email)->get("user_email_code")->result_array();
            if($rst){
                $this->email_mod->commit(['email'=>$email,'code'=>$code]);
            }else{
                $this->db->insert("user_email_code",['email'=>$email,'code'=>$code]);
            }
            $this->json_out(1,'已发送');
        }else{
            $this->json_out(0,$rst['msg']);
        }
    }

    /*登出*/
    function logout()
    {
        parent::logout();
        parent::redirect('/blogshow');
    }

}
