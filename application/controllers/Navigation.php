<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/8/20
 * Time: 13:43
 */
class Navigation extends Yl_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->qiniu();
        $this->load->model('navigation_model','navigation_mod');
        $this->load->model('navigation_category_model','navigation_category_mod');

    }
    public function index(){

        $category = $this->navigation_category_mod->getList();

        $navigation = $this->navigation_mod->getList();
        $nav = [];
        foreach($navigation as $n){
            $nav[$n['category_id']][] = $n;
        }
        $this->_vd['category'] = $category;
        $this->_vd['navigation'] = $nav;
        $this->_vd['blog'] = ['title'=>'Xroom导航页'];
        $this->_view("navigation/index");
    }

    public function addPage(){
        $category = $this->navigation_category_mod->getList();
        $this->_vd['category'] = $category;
        $this->_view('navigation/addpage');
    }

    public function add(){
        $title = $this->_post['title'];
        $content = $this->_post['content'];
        $href = $this->_post['href'];
        $logo= $this->_post['logo'];
        $category_id = $this->_post['category_id'];
        $exist = $this->db->where(['title'=>$title])->get('navigation')->result_array();
        if($exist)
            $this->json_out(0,'标题已存在');
        $data =  [
            'title'=>$title,
            'content'=>$content,
            'href'=>$href,
            'logo'=>$logo,
            'category_id'=>$category_id
        ];
        $this->navigation_mod->commit($data);
        $this->json_out(1,'新增成功');
    }

    public function updateview(){
        $id = $this->_post['id'] ?? '';
        if($id){
            $this->navigation_mod->update($id);
        }
    }
}