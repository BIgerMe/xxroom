<?php

class TidyRoom_users_model extends Public_model
{
    function __construct()
    {
        parent::__construct();
        $this->pk_name = 'id';
        $this->table = 'tidyroom_users';
    }
}