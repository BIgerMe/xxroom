<?php

class Auth_model extends Public_model
{
    public $pk_name;
    public $table;
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'auth_sessions';
    }

    function get_one($user_id){
        $rst = $this->db->select('id')
            ->where('user_id',$user_id)
            ->get($this->table)
            ->result_array();
        return $rst ? $rst[0]['id'] : null;
    }

}