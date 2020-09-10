<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/1 0001
 * Time: 下午 1:50
 */

class Xchenxu extends REST_Controller
{
    private $appId = "wx07f4d0165bcdbd9e";
    private $appSecret = "c25d78fab0f5053a4170217f2f3e5107";
    private $sessionKey = '';
    function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model','blog_mod');
        $this->load->model('blog_comment_model','blog_comment_mod');
        $this->load->model('blog_category_model','blog_category_mod');
    }


    /**
    @author zhangxiaoming
    @return json
    */
    function blogList_get(){
        $this->load->library('pagination');

        $per_page = (int)$this->get('per_page') ? (int)$this->get('per_page') : 10;
        $page = (int)$this->get('page') != 0 ? (int)$this->get('page') : 1;
        $title = $this->get('title') ?? '';
        $category = $this->get('category') ?? '';
        $category = urldecode($category);


        $counts = $this->db->like('title', $title)->like('category',$category)->where(['status'=>1])->count_all_results('blog');

        $data = [];
        $data['count'] = $counts;

        $list = $this->blog_mod->blogShow($title,$category,$page,$per_page);
        //时间 分类
        foreach ($list as &$l){
            $category_arr = explode(',',$l['category']);
            $l['category'] = array_slice($category_arr,0,2);
            $l['created_at'] = $this->format_date($l['created_at']);
        }
        $data['list'] = $list;

        $categoryList = $this->blog_category_mod->getList();
        //颜色
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        $data['categoryList'] = array_column($categoryList,NULL,'title');
        $this->send_response(REST_Controller::HTTP_OK,'success',$data);
    }

    //详情页
    function blogview_get(){
        $id = (int)$this->get('id') ? (int)$this->get('id') : '';
        if(!$id)
            $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED);

        $blog = $this->blog_mod->blogDetail($id);

        $this->blog_mod->updateView($id);

        $this->send_response(REST_Controller::HTTP_OK,'success',$blog);
    }



    function checkLogin_get()
    {
        $code = $this->get('code') ? $this->get('code') : '';

        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$this->appId."&secret=".$this->appSecret."&js_code=".$code."&grant_type=authorization_code";
        $rst = $this->curl_request($url);
        $rst = json_decode($rst);
        $this->send_response(REST_Controller::HTTP_OK,'测试',$rst);
    }

    function checkMember_post()
    {
        $encryptedData = $this->post('encryptedData');
        $iv = $this->post('iv');
        $this->sessionKey = $this->post('sessionKey');


        $aesKey = base64_decode($this->sessionKey);

        if (strlen($iv) != 24 || strlen($this->sessionKey) != 24) {
            $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED, '匹配错误');
        }
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED, '匹配错误');
        }
        if ($dataObj->watermark->appid != $this->appId) {
            $this->send_response(REST_Controller::HTTP_NOT_IMPLEMENTED, '匹配错误');
        }
        $this->send_response(REST_Controller::HTTP_OK, '获取成功');
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
}
