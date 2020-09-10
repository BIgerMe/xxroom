<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class chat_detail_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'chat_detail';
    }

    function getList(){
        $rst = $this->db
            ->select('cd.*')
            ->from("chat_detail cd")
            ->join('users u','cd.user_id=u.id','left')
            ->where(['cd.status'=>0,'cd.is_delete'=>0])
            ->order_by('cd.created_at','desc')
            ->get()
            ->result_array();
        return $rst ? $rst : false;
    }
}