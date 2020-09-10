<?php
/**
 * Created by PhpStorm.
 * User: 22608
 * Date: 2018/5/10
 * Time: 8:56
 */

class Personal extends Yl_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model','user_mod');
        $this->load->model('avatar_model','avatar_mod');
        //导航
        $this->load->model('navigation_model','navigation_mod');
        $this->load->model('navigation_category_model','navigation_category_mod');
        //博客
        $this->load->model('blog_model','blog_mod');
        $this->load->model('blog_category_model','blog_category_mod');
        //问答
    }

    /*new function by zxm*/
    public function index()
    {
        $avatar = $this->db->select("*")->where('status',1)->get('avatar')->result_array();

        $lists = [];
        $this->_vd['personal_work'] = $lists;
        $this->_vd['avatarList'] = $avatar;
        $this->_view('personal/index');
    }

    /*更换头像*/
    public function changeAvatar(){
        $avatar = $this->_post['avatar'] ?? '';
        if(!$avatar && !$this->user_id)
            $this->json_out(0,'信息不全');
        $data = [
            'id'=>$this->user_id,
            'avatar'=>$avatar
        ];
        $this->user_mod->commit($data);
        $this->json_out(1,'提交成功');

    }

    public function publicHome()
    {
        //导航
        $category = $this->navigation_category_mod->getList();
        $navigation = $this->navigation_mod->getAll();
        //博客
        $blog = $this->blog_mod->top10();
        //时间 分类
        foreach ($blog as &$l){
            $category_arr = explode(',',$l['category']);
            $l['category'] = array_slice($category_arr,0,2);
            $l['created_at'] = $this->format_date($l['created_at']);

            $strlen_max = strlen($l['truename']);
            $strlen_min = mb_strlen($l['truename'],"UTF8");
            $strlen = ($strlen_max + $strlen_min)/2;
            if($strlen > 12){
                $l['truename'] = substr($l['truename'],0,12)."..";
            }
        }
        //颜色
        $categoryList = $this->blog_category_mod->getList(0);
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        //问答


        $data = [
            'category' => $category,
            'navigation'=> $navigation,
            'blog'=>$blog,
            'categoryList'=>array_column($categoryList,NULL,'title')
        ];
        $this->_view('personal/home',$data);
    }

    /**搜索页*/
    public function search()
    {
        $key = $this->_get['key'];

        //导航
        if($key)
            $navigation = $this->navigation_mod->selectByKey($key);
        else
            $navigation = $this->navigation_mod->getAll();


        //博客 $bc总数 $bp总分页数
        $bc = $this->db->where(['status'=>1])->like('title',$key)->or_like(['category'=>$key])->count_all_results('blog');
        $bp = ceil($bc / 10);

        if($key)
            $blog = $this->blog_mod->selectByKey($key);
        else
            $blog = $this->blog_mod->getAll();
        

        //时间 分类
        foreach ($blog as &$l){
            $category_arr = explode(',',$l['category']);
            $l['category'] = array_slice($category_arr,0,2);
            $l['created_at'] = $this->format_date($l['created_at']);

            $strlen_max = strlen($l['truename']);
            $strlen_min = mb_strlen($l['truename'],"UTF8");
            $strlen = ($strlen_max + $strlen_min)/2;
            if($strlen > 12){
                $l['truename'] = substr($l['truename'],0,12)."..";
            }
        }
        //颜色
//        $categoryList = $this->blog_category_mod->getList(0);
        $categoryList = $this->blog_category_mod->getAllList();
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        //问答


        $data = [
            'key'=>$key,
            'navigation'=> $navigation,
            'blog'=>$blog,
            'categoryList'=>array_column($categoryList,NULL,'title')
        ];
        $this->_view('personal/search',$data);
    }

    /*资讯*/
    public function information()
    {
        $this->_view('personal/information');
    }

    public function publicCase()
    {
        $this->_view('personal/case');
    }

    public function about(){
        $this->_view('personal/about');
    }
}