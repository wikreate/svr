<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {
    private $result = array();
    
    function __construct() {
        parent::__construct();
    }   

    public function _empty_data(){
        if (empty($this->result)) {
            display_404();
        }
    } 
}