<?php

class TidyRoom_records_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'tidyroom_records';
    }

    /*个人记录*/
    function RecordList($center_id = '',$user_id = '',$start_date = '',$end_date = '')
    {
        $where_add = '';
        if($start_date)
            $where_add .= " and tr.date >= '{$start_date}' ";
        if($end_date)
            $where_add .= " and tr.date <= '{$end_date}' ";
        $sql = "SELECT
	                tr.*
                FROM
                    tidyroom_records tr
                LEFT JOIN tidyroom_lists tl ON tl.id = tr.list_id
                WHERE
                    tl.center_id = ? AND tr.user_id = ? ".$where_add;

        $rst = $this->lists($sql,[$center_id,$user_id]);
        return $rst;
    }
}