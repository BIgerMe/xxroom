<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Test_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        log_message('debug', 'Com_Model class loaded');
    }

    function get_one(){
        $sql = "select * from test";
        $res =  $this->db->query($sql)->result_array();
        return $res;
    }

}