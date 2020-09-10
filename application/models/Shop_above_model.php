<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Shop_above_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'shop_above';
    }

    /**
    @author zhangxiaoming
    @return json
    */
    function getInfo($id){
        $rst = $this->db->select("*")->where("id",$id)->get($this->table)->result_array();
        return $rst ? $rst[0] : false;
    }
}