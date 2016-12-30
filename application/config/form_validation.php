<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config = array(
    'settings' => array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|xss_clean|min_length[1]'
        ),
        array(
            'field' => 'repeat_password',
            'label' => 'Repeat Password',
            'rules' => 'trim|required|xss_clean|min_length[1]'
        )
    ), 
    
    'login' => array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),

        array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        )
    ),

    'new-user' => array(
        array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'required|trim|xss_clean|min_length[2]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'repeat_password',
            'label' => 'Повторите пароль',
            'rules' => 'required|trim|xss_clean|trim|min_length[1]'
        )
    ), 
 
    'send-mail' => array(
        array(
            'field' => 'to',
            'label' => 'Кому',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'from',
            'label' => 'Cc / Bcc',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'theme',
            'label' => 'Тема',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'message',
            'label' => 'Текст сообщения',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        )
    ),

    'add-review' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'company',
            'label' => 'Company',
            'rules' => 'xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'xss_clean|trim|min_length[1]'
        ),
        array(
            'field' => 'review',
            'label' => 'Review',
            'rules' => 'xss_clean|trim|min_length[1]'
        )
    ) 

     
);
 