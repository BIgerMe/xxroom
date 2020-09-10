<?php

class Zhishi_category_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'space_zs_category';
    }

    /**通过ID查询知识类
     * @param int $id
     * @return array
    */
    function get_by_id($id)
    {
        $rst = $this->db->where('id',$id)->get($this->table)->result_array();
        return $rst ?? false;
    }

    /**
     * @param int $parent_id
     * @return array
    */
    function get_by_parent_id($parent_id)
    {
        $rst = $this->db->where('parent_id',$parent_id)->get($this->table)->result_array();
        return $rst ?? false;
    }
}