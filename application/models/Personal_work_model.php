<?php
/**
 * Created by PhpStorm.
 * User: 22608
 * Date: 2018/5/10
 * Time: 9:58
 */
class Personal_work_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->table = 'personal_work';
        log_message('debug', 'Com_Model class loaded');
    }

    /*new function by zxm*/
    public function get_lists()
    {
        return $this->db->select('*')->get($this->table)->result_array();
    }

}