<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Navigation_category_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'navigation_category';
    }

    function getList(){
        $rst = $this->db->get($this->table)->result_array();
        return $rst;
    }
}