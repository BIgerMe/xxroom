<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Navigation_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'navigation';
    }

    function getList(){
        $rst = $this->db->get($this->table)->result_array();
        return $rst;
    }

    function getTop18(){
        $rst = $this->db->select("*")->from($this->table)->limit(18,0)->order_by('view','desc')->get()->result_array();
        return $rst;
    }
    function getAll(){
        $rst = $this->db->select("*")->from($this->table)->order_by('view','desc')->get()->result_array();
        return $rst;
    }

    function update($id){
        $date = date("Y-m-d H:i:s",time());
        $sql = "update {$this->table} set `view` = `view` + 1,`viewtime` = '{$date}' where id = {$id} ";
        $this->db->query($sql);
    }

    /**关键词搜索*/
    function selectByKey($key){
        $rst = $this->db->select("*")->from($this->table)->or_like(['title'=>$key,'content'=>$key])->get()->result_array();
        return $rst;
    }
}