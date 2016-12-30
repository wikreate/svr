<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{ 
    /**
    * @var $lang
    */
    public $lang = 'en';

    /**
    * @var $lang
    */
    static $lang_arr = array();

    private $key_access;

    public $id_interview;

    function __construct()
    {
        parent::__construct();
        $this->load->library('parser');
 
        //run session
        @session_start();   

        //init lang
        $this->initLang();
  
        //constants
        $this->initDefines(); 

        //settings
        $this->initSettings();  
 

        if ($this->checkAccess() == false) 
        {  
            display_404();
        }
    }

    private function checkAccess()
    { 
        $uri1      = (!uri(1)) ? '/' : uri(1);
        $permitUri = array('cp', 'login', 'updatePassword', 'display_404', '/'); 

        if (in_array($uri1, $permitUri)) {
            return true;
        }

        $key       = ''; 
        if (!empty($_GET['key_access'])) 
        {
            $key = clear($_GET['key_access']);   
        }
        else if (!empty($_SESSION['key_access'])) 
        {
            $key = clear($_SESSION['key_access']); 
        } 
        
        /**
        * Проверка на существование опроса
        */
        $this->load->model('pages_model');

        $get = $this->pages_model->getSurveyAccess($key);
        
        if (empty($get)) 
        { 
            return false;
        }

        $this->key_access   = $key;
        $this->id_interview = $get['id_interview'];  

        $getInterviewLangs  = getInterviewLangArr($this->id_interview);
        if (empty($getInterviewLangs)) 
        {
            return false;
        } 

        $this->lang_arr     = $getInterviewLangs; 

        $this->CheckLang();

         
        $getSurvey = $this->pages_model->getSurvey($this->id_interview);
 
        if (empty($getSurvey)) 
        {
            return false;
        }

          
        if (in_array($uri1, array_merge($permitUri, $this->lang_arr))) {

            /**
            * Сохраняем пользователя
            */

            $_SESSION['key_access'] = $key; 

            return true;
        }

        return false; 
    }

    public function home($view, $data, $to_parse) {
        $this->load->model('pages_model');
        $url = (!uri(2) ? '/' : uri(2));
  
        /**
        * Хранит данные страницы
        */
        $data['pages']  = $this->pages_model->getPage($url);  

        $data['survey'] = $this->pages_model->getSurvey($this->id_interview);

        /**
        * Хранит мета тэги страницы
        */
        //$data['meta'] = $this->pages_model->getMeta();
  
        /**
        * Массив со всеми страницами на сайте
        */
        //$data['menu']  = $this->pages_model->getNavMenu(); 

        /**
        * Многоуровневый Массив Категорий
        */
        //$data['categories']  = map_tree(getCategories(true));  
        
        /**
        * Массив с языками на сайте
        */
        $data['lang_arr'] = $this->lang_arr;  
 
        /**
        * Установленный язык на сайте
        */
        $data['lang'] = $this->lang->lang();
 
        $parse = array( 
            'content' => $this->load->view($view, $data, TRUE) 
        ); 
        
        if (!empty($to_parse)) {
            foreach ($to_parse as $item => $value) {
                $parse[$item] = $value;
            }
        } 

        $this->parser->parse('template/home_template', $parse);
    }

    public function pageData(){
        $this->load->model('pages_model');
        $url = (!$this->uri->segment(2) ? '/' : $this->uri->segment(2));
        return $this->pages_model->getPage($url);
    }

    public function admin($view, $data, $to_parse)
    {

        if (empty($_SESSION['admin_user']['session']))
            redirect(base_url('login'), 'refresh');

        $data['lang_arr'] = $this->lang->lang_arr(); 

        $data['lang'] = $this->lang->lang();
 
        $parse = array(
            'content' => $this->load->view($view, $data, TRUE)
        );
        
        //foreach to_parser if not empty 
        if (!empty($to_parse)) {
            foreach ($to_parse as $item => $value) {
                $parse[$item] = $value;
            }
        }
        $this->parser->parse('template/admin_template', $parse);
    }

    public function initDefines() {
        $result = $this->db->get('constants')->result_array();
  
        switch ($this->lang) {
            case 'ru':
                $lang = '1';
                break;
 
            case 'ro':
                $lang = '2';
                break;  
 
            default:
                $lang = '1';
                break;
        } 
         
        if(count($result)>0) {
            foreach($result AS $row) {
                
                $result2 = $this->db
                    ->select('constants_value.value')
                    ->from('constants_value')
                    ->where("constants_value.id_const",$row['id'])
                    ->where("constants_value.id_lang",$lang)
                    ->get()
                    ->row();
                    
                if (count($result2) > 0) {
                    define(trim($row['name']), trim($result2->value));
                } else {
                        define(trim($row['name']), "");
                } 
            }
        } 
    }

    public function initSettings(){
        $result = $this->db->get('settings')->result_array();
        foreach($result AS $row) { 
            if (!empty($row['var'])) {
                define('var_'.trim($row['var']), trim($row['value']));
            }  
        }
    }

    function initLang(){ 
        $getLangArr = $this->db->where('delete', '0')->where('view', '1')->order_by('page_up', 'asc')->order_by('id', 'desc')->get('languages')->result_array();

        if (!empty($getLangArr)) {
            $languages = array(); 
            foreach ($getLangArr as $item) {
                $languages[$item['id']] = $item['name'];
            }
        }else{
            $languages = array('en' => 'en');
        } 
 
        $this->lang->languages = $languages;   
    }

    private function CheckLang(){    

        $keysLang = key_to_asc($this->lang_arr); 

        $uri1 = uri(1);

        $this->config->load('config'); 
        if (in_array($uri1, $this->lang_arr)) {
            $lang = clear($uri1);

            $date = time() + 30*24*60*60; 

            $_SESSION['lang'] = $lang;

            set_cookie('lang', $lang, $date); 

        }else if(isset($_COOKIE['lang'])){ 
            $_SESSION['lang'] = $_COOKIE['lang'];  
        } else{  
            $_SESSION['lang'] = $keysLang[0];  
        }  

        //$this->lang = $_SESSION['lang'];
        $this->config->set_item('language', 'en'); 
    }  
}