<?php

class TidyRoom_lists_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'tidyroom_lists';
    }

    /*list项*/
    function listInfo($center_id)
    {
        $rst = $this->db
            ->select('id,title,score')
            ->from($this->table)
            ->where('center_id',$center_id)
            ->get()
            ->result_array();
        return $rst;
    }
}