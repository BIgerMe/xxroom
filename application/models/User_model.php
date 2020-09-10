<?php

class User_model extends Public_model
{
    public $pk_name;
    public $table;
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'users';
    }

    function userList()
    {
        $rst = $this->db->select('id,username,truename')->get($this->table)->result_array();
        return $rst;
    }
    /**
     * @param $user_id 用户ID
     * @return array
    */
    function UserInfo($user_id){
        $rst = $this->db->select("username,truename,avatar")->where('id',$user_id)->get($this->table)->result_array();
        return  $rst ? $rst[0] : false;
    }
    /*用户名是否存在*/
    function check_user_exist($username)
    {
        $rst = $this->db->select("*")
                        ->where('username',$username)
                        ->get($this->table)
                        ->result_array();
        return $rst ? true : false;
    }

    function login_check($username,$psw){
        $rst = $this->db->select("id")
            ->where('username',$username)
            ->where('password',$psw)
            ->get($this->table)
            ->result_array();
        return $rst ? $rst[0]['id'] : false;
    }

    function insert($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

}