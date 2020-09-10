<?php
/**
 * Created by PhpStorm.
 * User: 22608
 * Date: 2018/5/21
 * Time: 11:41
 */

$config['login_rule'] = [
    [
        'field' => 'login_username',
        'label' => 'USERNAME OR EMAIL ADDRESS',
        'rules' => 'trim|required|max_length[255]' /* Replace max_length w/ valid_email is site not using usernames */
    ],
    [
        'field' => 'login_psw',
        'label' => 'PASSWORD',
        'rules' => 'trim|required|min_length[6]'
    ]
];

$config['login_session'] = 'login_session';