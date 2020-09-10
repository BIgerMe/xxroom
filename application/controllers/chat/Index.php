<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/8/20
 * Time: 13:43
 */
class Index extends Person_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model','user_mod');
        $this->load->model('chat_room_model','chat_room_mod');
        $this->load->model('chat_detail_model','chat_detail_mod');
    }
    public function index(){
        $userInfo = $this->user_mod->UserInfo($this->user_id);
        $chatDetail = $this->chat_detail_mod->getList();

        $this->_view("chat/public/index");
    }

    public function addPage(){
        $this->_view("");
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