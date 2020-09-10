<?php
/**
 * Created by PhpStorm.
 * User: Weshine
 * Date: 2018/9/11
 * Time: 9:15
 */
class Shop extends Yl_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model', 'blog_mod');
        $this->load->model('blog_category_model', 'blog_category_mod');
        $this->load->model('shop_above_model', 'shop_above_mod');

    }

    /**
    @author zhangxiaoming
    @return
    */
    function index(){
         
    }
    
    /**
    @author zhangxiaoming
    @return
    */
    function above(){
        $above_id = $this->_get['id'] ?? "";
        $above_info = $this->shop_above_mod->getInfo($above_id);
        //排除用户url乱写ID
        if($above_id && !$above_info){
            $this->_view("errors/html/error_404");
            return;
        }
        $this->_vd['above_info'] = $above_info;
        $this->_vd['above_id'] = $above_id;
        $this->_view('shop/above');
    }

    /**
    @author zhangxiaoming
    @return
    */
    function lists(){
        $this->_view('shop/lists');
    }

    /**保存*/
    function save(){
        $id = $this->_post['id'] ?? "";
        $title = $this->_post['title'] ?? "";
        $html = $this->_post['html'] ?? "";
        if(!$title || !$html)
            $this->json_out(0,'标题或内容不能为空');
        $id = $this->shop_above_mod->commit(['id'=>$id,'title'=>$title,'html'=>$html]);
        $this->json_out(1,'保存成功',$id);
    }
    
}