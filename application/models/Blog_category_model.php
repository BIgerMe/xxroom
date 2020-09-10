<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class blog_category_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'blog_category';
    }

    /*
     * @param $tag 分类  0博客 1问答 2生活
     * */
    function getList($tag = 0){
        $rst = $this->db->select("*")->where('tag',$tag)->get($this->table)->result_array();
        return $rst ?? [];
    }

    function getAllList(){
        $rst = $this->db->select("*")->get($this->table)->result_array();
        return $rst ?? [];
    }
}