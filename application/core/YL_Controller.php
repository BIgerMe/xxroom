<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2018/2/27
 * Time: 16:17
 */

/*主控制器*/
require_once FCPATH . '/application/third_party/Auth_Controller.php';
require_once FCPATH . '/qiniu/autoload.php';
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Yl_Controller extends Auth_Controller
{
    public $_vd = [];
    public $_post;
    public $_get;
    public $qn_ak = 'ijSwZU-Sh5EieYloh01ElyDUop1A9aKQUcHXd4QB';
    public $qn_sk = 'suo-HidUyWS-42Hc-rICOQY0DL0FztMU1GbuAi50';
    public $qn_bk = 'xiaoming';
    function __construct()
    {
        parent::__construct();
        $this->_get = $_GET;
        $this->_post = $_POST;
        if($this->user_id){
            $this->load->model('user_model','user_mod');
            $this->_vd['user_id'] = $this->user_id;
            $this->user_info = $this->user_mod->UserInfo($this->user_id);
            $this->_vd['user_info'] = $this->user_info;
        }
        //ip
        $ip = $this->getIP();
        $this->qiniu();
        //地址
        $location = $this->get_address($ip);
        $this->db->where('ip',$ip)->delete('view_log');
        $this->db->insert('view_log',['ip'=>$ip,'location'=>$location]);
    }
    /*七牛云token*/
    function qiniu(){
        // 初始化签权对象
        $auth = new Auth($this->qn_ak, $this->qn_sk);
        $token = $auth->uploadToken($this->qn_bk);
        $this->_vd['qiniu_token'] = $token;
    }
    /*视图*/
    function _view($param,$data=[])
    {
        if(isset($data)){
            $this->_vd = array_merge($this->_vd,$data);
        }
        $this->load->view($param, $this->_vd);
    }

    /*json串输出格式化*/
    function json_out($status = 0, $msg = false, $data = false)
    {
        $output = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        );
        echo json_encode($output,JSON_UNESCAPED_UNICODE);
        die;
    }

    /**浏览器类型*/
    public function browser_type()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE 8.0")) {
            return "Internet Explorer 8.0";
        }elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE 10.0")) {
            return "Internet Explorer 10.0";
        } elseif (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE 7.0")) {
            return "Internet Explorer 7.0";
        } else if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE 6.0")) {
            return "Internet Explorer 6.0";
        } else if (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox")) {
            return "Firefox";
        } else if (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome")) {
            return "Google Chrome";
        } else if (strpos($_SERVER["HTTP_USER_AGENT"], "Safari")) {
            return "Safari";
        } else if (strpos($_SERVER["HTTP_USER_AGENT"], "Opera")) {
            return "Opera";
        } else {
            return $_SERVER["HTTP_USER_AGENT"];
        }
    }

    /**获取当前IP*/
    public function getIP()
    {
        $ip = '';
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_FROM', 'REMOTE_ADDR') as $v) {
            if (isset($_SERVER[$v])) {
                if (! preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_SERVER[$v])) {
                    continue;
                }
                $ip = $_SERVER[$v];
            }
        }
        return $ip;
    }

    /*根据IP获取地址*/
    function get_address($ip){
        $url = "http://api.map.baidu.com/location/ip?ak=2t1TNYcGWL8EITH5cz5sDMSol9rUeVYb&ip=".$ip;
        $rst = $this->curl_request($url);
        $rst = json_decode($rst,true);
        if(isset($rst['content'])){
            list($y,$x)= array_values($rst['content']['point']);
            $locate = $rst['content']['address'].',经度:'.$x.'纬度:'.$y;
        }else{
            $locate = '';
        }
        return $locate;
    }

    /*随机字符*/
    function random($length, $numeric = FALSE) {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        if ($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }

    /*是否ajax请求*/
    function is_ajax(){
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) == 'xmlhttprequest'){
            // 是ajax请求
            return true;
        } else {
            // 不是ajax请求
            return false;
        }
    }

    /*转为本地图片*/
    function tomedia($i){
        if(strpos($i,'xxroom.xyz') !== false){
            return $i;
        }else{
            $img =  HOME_HOST.$i;
            return $img;
        }
    }

    /*几天前*/
    function format_date($the_time)
    {
        $now_time = date("Y-m-d H:i:s", time());
        $now_time = strtotime($now_time);
        $show_time = strtotime($the_time);
        $t = $now_time - $show_time;

        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }

    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$cookies,参数4：是否返回$cookies
    function curl_request($url,$post='',$cookie='', $returnCookie=0){
        $curl = curl_init();
        @curl_setopt($curl, CURLOPT_URL, $url);
        @curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
        @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        @curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        @curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        @curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        @curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);


        if($post) {
            @curl_setopt($curl, CURLOPT_POST, 1);
            @curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            @curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        @curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        @curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        @curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }

    function redirect($uri)
    {
        echo "<script>window.location.href = '{$uri}';</script>";
        exit;
    }
}


class Person_Controller extends Yl_Controller{
    public $user_info;
    public $redirect_login = [
        '/blog/index',
        '/personal'
    ];
    function __construct()
    {
        parent::__construct();
        if(!$this->user_id){
           if(in_array($_SERVER['REQUEST_URI'],$this->redirect_login))
               parent::redirect('/entrance');
//           parent::redirect('/personal/publichome');
        }
        $this->load->model('user_model','user_mod');
        $this->_vd['user_id'] = $this->user_id;
        $this->user_info = $this->user_mod->UserInfo($this->user_id);
        $this->_vd['user_info'] = $this->user_info;
    }
}