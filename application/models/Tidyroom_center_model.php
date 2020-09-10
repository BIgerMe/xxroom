<?php

class TidyRoom_center_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'tidyroom_center';
    }

    /*主页列表*/
    function centerList($user_id)
    {
        $rst = $this->db
            ->select("tc.*")
            ->from("$this->table tc")
            ->join('tidyroom_users tu','tc.id = tu.center_id','left')
            ->where('tu.user_id', $user_id)
            ->get()
            ->result_array();
        return $rst;
    }

    function centerInfo($center_id)
    {
        $rst_1 = $this->db
            ->select("tc.*,GROUP_CONCAT(distinct tl.title) as list_title,GROUP_CONCAT(tl.score) as list_score")
            ->from("$this->table tc")
            ->join('tidyroom_lists tl', 'tc.id = tl.center_id', 'left')
            ->where('tc.id', $center_id)
            ->group_by('tc.id')
            ->get()
            ->result_array()[0];
        $rst_2 = $this->db
            ->select('tc.*,GROUP_CONCAT(u.username) as username,GROUP_CONCAT(u.truename) as truename')
            ->from("$this->table tc")
            ->join('tidyroom_users tu', 'tc.id = tu.center_id', 'left')
            ->join('users u ', 'tu.user_id = u.id', 'left')
            ->group_by('tc.id')
            ->get()
            ->result_array()[0];
        return array_merge($rst_1,$rst_2);
    }

    function getLatestCenter($user_id)
    {
        $rst =  $this->db
                    ->select("tc.*")
                    ->from("$this->table  tc")
                    ->join('tidyroom_users tu','tc.id = tu.center_id','left')
                    ->where('tu.user_id', $user_id)
                    ->order_by('tc.modified_at','desc')
                    ->get()
                    ->result_array();

        return $rst ? $rst[0] : array();
    }

    function getTitle($center_id)
    {
        $rst = $this->db->select("title")->from($this->table)->where('id',$center_id)->get()->result_array();
        return $rst;
    }
}