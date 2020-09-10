<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/8/20
 * Time: 13:43
 */
class Blogshow extends Yl_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model','blog_mod');
        $this->load->model('blog_comment_model','blog_comment_mod');
        $this->load->model('avatar_model','avatar_mod');
        $this->load->model('blog_category_model','blog_category_mod');
    }
    public function index(){

        $this->load->library('pagination');

        $per_page = $this->input->get('per_page') ?? 10;
        $page = $this->input->get('page') ?? 1;
        $title = $this->input->get('title') ?? '';
        $category = $this->input->get('category') ?? '';
        $title = urldecode($title);
        $category = urldecode($category);

        $counts = $this->db->where(['status'=>1,'tag'=>0])->like(['title'=>$title,'category'=>$category])->count_all_results('blog');

        $this->_vd['title'] =$title;
        $this->_vd['category'] = $category;

        $config['base_url'] = site_url("blogshow").'?title='.$title.'&category='.$category;
        $config['total_rows'] = $counts;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '上页';
        $config['next_link'] = '下页';
        $config['last_link'] = '尾页';
        $config['first_link']= '首页';
        $config['first_tag_open'] = '<li>';
        $config['first_tage_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tage_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);

        $this->_vd['counts'] = $counts;
        $this->_vd['page'] = $this->pagination->create_links();
        $list = $this->blog_mod->blogShow($title,$category,$page,$per_page);
        //时间 分类
        foreach ($list as &$l){
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
        $this->_vd['list'] = $list;

        $categoryList = $this->blog_category_mod->getList(0);
        //颜色
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        $this->_vd['categoryList'] = array_column($categoryList,NULL,'title');
        $this->_view("blogshow/list");
    }

    //留言
    function msg_leave(){
        $msg_name = $this->_post['msg_name'] ? htmlspecialchars($this->_post['msg_name']) : '';
        $msg_content = $this->_post['msg_content'] ? htmlspecialchars($this->_post['msg_content']) : '';
        if(!$msg_name)
            $this->json_out(0,'昵称必填');
        if(!$msg_content)
            $this->json_out(0,'留言内容必填');

        $msgInfo = [
            'nickname'=>$msg_name,
            'content'=>$msg_content
        ];
        $this->db->insert("msg_leave",$msgInfo);
        $this->json_out(1,'留言成功');
    }

    function view(){

        $id = $this->_get['id'] ?? '';
        if(!$id)
            $this->json_out(0,'信息不全');

        $reply = [];
        //分享
        $blogC = $this->blog_mod->blogComment($id);
        
        $this->_vd['comment'] = $blogC;
        $this->_vd['comment_num'] = $blogC ? count($blogC) : 0;

        $blog = $this->blog_mod->blogDetail($id);

        //博客不存在
        if(empty($blog) || $blog['status'] == 0) {
            $this->_view('errors/html/error_404');
            return;
        }
        $blog['category'] = explode(',',$blog['category']);
        $this->_vd['blog'] =$blog;
        $this->blog_mod->updateView($id);
        $this->_view('blogshow/view');
    }

    /*新增回复*/
    function replyAdd(){
        $blog_id = $this->_post['blog_id'] ?? '';
        $content = $this->_post['content'] ?? '';
        $reply_id = $this->_post['id'] ?? 0;
        if(!$this->user_id)
            $this->json_out(0,'请先登录再回复');
        if($blog_id && $content){
            $data = [
                'blog_id'=>$blog_id,
                'content'=>$content,
                'user_id'=>$this->user_id,
                'reply_id'=>$reply_id,
                'base_id'=>0,
                'created_at'=>date('Y-m-d H:i:s',time())
            ];
            $this->blog_comment_mod->commit($data);
            $this->json_out(1,'回复成功');
        }else{
            $this->json_out(0,'信息不全');
        }
    }

    /**
    @author zhangxiaoming
    @return json
    */
    function qa(){
        $this->load->library('pagination');

        $per_page = $this->input->get('per_page') ?? 10;
        $page = $this->input->get('page') ?? 1;
        $title = $this->input->get('title') ?? '';
        $category = $this->input->get('category') ?? '';
        $title = urldecode($title);
        $category = urldecode($category);

        $counts = $this->db->like('title', $title)->like('category',$category)->where(['status'=>1,'tag'=>1])->count_all_results('blog');

        $this->_vd['title'] =$title;
        $this->_vd['category'] = $category;

        $config['base_url'] = site_url("blogshow/qa").'?title='.$title.'&category='.$category;
        $config['total_rows'] = $counts;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '上页';
        $config['next_link'] = '下页';
        $config['last_link'] = '尾页';
        $config['first_link']= '首页';
        $config['first_tag_open'] = '<li>';
        $config['first_tage_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tage_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);

        $this->_vd['counts'] = $counts;
        $this->_vd['page'] = $this->pagination->create_links();
        $list = $this->blog_mod->qaShow($title,$category,$page,$per_page);
        //时间 分类
        foreach ($list as &$l){
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
        $this->_vd['list'] = $list;

        $ids = array_column($list,'id');
        $qaC = $this->blog_mod->qaComment($ids);
        $as = [];
        if($qaC){
            foreach ($qaC as $item){
                $as[$item['blog_id']][] = $item;
            }
        }
        $this->_vd['answer']  = $as;

        $categoryList = $this->blog_category_mod->getList(1);
        //颜色
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        $this->_vd['categoryList'] = array_column($categoryList,NULL,'title');
        $this->_view('blogshow/qa');
    }

    function qaview(){

        $id = $this->_get['id'] ?? '';
        if(!$id)
            $this->json_out(0,'信息不全');

        $reply = [];
        //分享
        $blogC = $this->blog_mod->blogComment($id);

        $this->_vd['comment'] = $blogC;
        $this->_vd['comment_num'] = $blogC ? count($blogC) : 0;

        $blog = $this->blog_mod->qaDetail($id);
        //博客不存在
        if(empty($blog) || $blog['status'] == 0) {
            $this->_view('errors/html/error_404');
            return;
        }
        $blog['category'] = explode(',',$blog['category']);
        $this->_vd['blog'] =$blog;
        $this->blog_mod->updateView($id);
        $this->_view('blogshow/qaview');
    }


    public function game(){
        $this->load->library('pagination');

        $per_page = $this->input->get('per_page') ?? 10;
        $page = $this->input->get('page') ?? 1;
        $title = $this->input->get('title') ?? '';
        $category = $this->input->get('category') ?? '';
        $title = urldecode($title);
        $category = urldecode($category);

        $counts = $this->db->like('title', $title)->like('category',$category)->where(['status'=>1,'tag'=>2])->count_all_results('blog');
//        print_r("<pre>");
//        print_r($counts);exit('point');
        $this->_vd['title'] =$title;
        $this->_vd['category'] = $category;

        $config['base_url'] = site_url("blogshow/game").'?title='.$title.'&category='.$category;
        $config['total_rows'] = $counts;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '上页';
        $config['next_link'] = '下页';
        $config['last_link'] = '尾页';
        $config['first_link']= '首页';
        $config['first_tag_open'] = '<li>';
        $config['first_tage_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tage_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);

        $this->_vd['counts'] = $counts;
        $this->_vd['page'] = $this->pagination->create_links();
        $list = $this->blog_mod->gameShow($title,$category,$page,$per_page);
        //时间 分类
        foreach ($list as &$l){
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
        $this->_vd['list'] = $list;
        $categoryList = $this->blog_category_mod->getList(2);

        //颜色
        $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
        foreach ($categoryList as &$c){
            $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
            $c['color'] = $color;
            $c['fontSize'] = rand(12,18).'px';
        }
        $this->_vd['categoryList'] = array_column($categoryList,NULL,'title');
        $this->_view("blogshow/game");
    }

    function gameview(){

        $id = $this->_get['id'] ?? '';
        if(!$id)
            $this->json_out(0,'信息不全');

        $reply = [];
        //分享
        $blogC = $this->blog_mod->blogComment($id);

        $this->_vd['comment'] = $blogC;
        $this->_vd['comment_num'] = $blogC ? count($blogC) : 0;

        $blog = $this->blog_mod->gameDetail($id);

        //博客不存在
        if(empty($blog) || $blog['status'] == 0) {
            $this->_view('errors/html/error_404');
            return;
        }
        $blog['category'] = explode(',',$blog['category']);
        $this->_vd['blog'] =$blog;
        $this->blog_mod->updateView($id);
        $this->_view('blogshow/gameview');
    }
}
