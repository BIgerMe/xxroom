<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Attachment_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'attachment';
    }

    /**获取所有1:1图片*/
    function getAllSquare(){
        $rst = $this->db->where('proportion','0')->get($this->table)->result_array();
        return $rst;
    }
    /**获取所有0.5625:1图片*/
    function getAllRectangle(){
        $rst = $this->db->where('proportion','1')->get($this->table)->result_array();
        return $rst;
    }
    /**获取所有1:1.35图片*/
    function getAllVertical(){
        $rst = $this->db->where('proportion','2')->get($this->table)->result_array();
        return $rst;
    }

}