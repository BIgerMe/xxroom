<?php
/**
 * Created by PhpStorm.
 * User: 晓明
 * Date: 2017/10/12
 * Time: 14:18
 */
class Email_model extends Public_model
{
    function __construct() {
        parent::__construct();
        $this->pk_name = 'email';
        $this->table = 'user_email_code';
    }

}