<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/30 0030
 * Time: 下午 3:42
 */

class Tidyroom extends Person_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function  index()
    {
        $this->_view('tidyroom/index');
    }
}