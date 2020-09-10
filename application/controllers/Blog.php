<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/8/20
 * Time: 13:43
 */
class Blog extends Person_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model','blog_mod');
        $this->load->model('blog_category_model','blog_category_mod');

    }
    public function index(){

        $this->load->library('pagination');

        $per_page = $this->input->get('per_page') ?? 10;
        $page = $this->input->get('page') ?? 1;
        $title = $this->input->get('title') ?? '';
        $title = urldecode($title);

        $counts = $this->db->like('title', $title)->where(["user_id"=>$this->user_id,'status'=>1])->count_all_results('blog');

        $config['base_url'] = site_url("blog").'?title='.$title;
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

        $list = $this->blog_mod->allList($this->user_id,$title,$page,$per_page);
        $this->_vd['list'] = $list;
        $this->_view("blog/list");
    }

    public function addPage(){
            $this->_view("blog/add_page");
    }

    public function add(){
        $title = $this->_post["title"] ? htmlspecialchars($this->_post['title'])  : '';
        $content = $this->_post["content"] ?? '';
        $user_id = $this->user_id;
        $category = $this->_post["category"] ?  trim($this->_post["category"]) : "";
        $category = trim($category,',');
        $tag = $this->_post['tag'] ? $this->_post['tag'] : 0;

        $data = [
            'title'=>$title,
            'content'=>$content,
            'user_id'=>$user_id,
            'category'=>strtolower($category),
            'tag'=>$tag,
            'created_at'=>date("Y-m-d H:i:s",time()),
            'status'=>1
        ];
        if(!$title || !$content || !$user_id)
            $this->json_out(0,'信息不全');

        $categoryList = explode(',',$category);
        $categoryList = array_diff($categoryList,['']);
        if(count($categoryList) > 2 || count($categoryList) <=0)
            $this->json_out(0,'标签数不能大于2或小于等于0');

        $commit_c = [];
        foreach ($categoryList as $c){
            $c = strtolower($c);
            $strlen_max = strlen($c);
            $strlen_min = mb_strlen($c,"UTF8");
            $strlen = ($strlen_max + $strlen_min)/2;
            if($strlen > 12)
                $this->json_out(0,'标签过长');
            $dbC = $this->db->where("title",$c)->where('tag',$tag)->get('blog_category')->result_array();
            if(!$dbC && $c)
                $commit_c[] = ['title'=>$c,'tag'=>$tag];
        }
        if($commit_c)
            $this->blog_category_mod->commit_batch($commit_c);
        $this->blog_mod->commit($data);
        $this->json_out(1,'新增成功');
    }

    function delete(){
        $id = (int)$this->_post['id'] ? (int)$this->_post['id'] : 0;
        $this->blog_mod->delete(['id'=>$id],false);
        $this->json_out(1,'删除成功');
    }
}