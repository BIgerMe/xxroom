<?php

class Zhishi_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'space_zs';
    }

    /**通过ID查询知识类
     * @param int $user_id 用户ID
     * @param varchar $title 标题
     * @return boolean
    */
    function check_by_title($user_id,$title)
    {
        $rst = $this->db->where('user_id',$user_id)
            ->where('title',$title)
            ->get($this->table)->result_array();
        return $rst ? true : false;
    }

    /**
     * @param int $user_id 用户ID
     * @param varchar $content 内容
     * @return boolean
    */
    function check_by_content($user_id,$content)
    {
        $rst = $this->db->where('user_id',$user_id)
            ->where('content',$content)
            ->get($this->table)->result_array();
        return $rst ? true : false;
    }

    /**
     * @param int $id 知识点ID
     * @param int $user_id 用户ID
    */
    function get_list($id,$user_id)
    {
        $rst = $this->db->where('id',$id)->or_where('user_id',$user_id)->get($this->table)->result_array();
        return $rst ?? false;
    }
}