<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages_model extends CI_Model {
    private $result = array();
    
    function __construct() {
        parent::__construct();
    }  

    public function getNavMenu() {
        $sql = $this->db->where('view', '1')->order_by('page_up', 'asc')->get('menu');
        return $sql->result_array();
    }  
     
    public function getPage($url) {   
        $id_lang = getIdLang();
        $sql = $this->db->select('menu.*, menu_lang.name, menu_lang.text, menu_lang.seo_title, menu_lang.seo_description, menu_lang.seo_keywords')
                        ->from('menu')
                        ->join('menu_lang', "menu_lang.post_id = menu.id AND id_lang = $id_lang", 'left')
                        ->where('menu.url', clear($url)) 
                        ->get();

        $this->result = $sql->row_array();   
        return  $this->result;
    } 

    public function getMeta(){
        $segment = !$this->uri->segment(2) ? '/' : $this->uri->segment(2);
        $page = $this->security->xss_clean(clear($segment)); 
  
        $sql = $this->db->where('url', $this->security->xss_clean($page))->get('menu');
        $this->result = $sql->row_array();  
        //$this->_empty_data(); 
        return $this->result;
    } 

    public function getItems($table, $page_up = true, $view=true, $limit=false, $where=false){
        $lang = $this->lang->lang();
        if ($page_up) {
            $this->db->order_by('page_up', 'asc');
        }else{
            $this->db->where('name_'.$lang.' != ', '')->where('text_'.$lang.' != ', '')->order_by('date', 'asc');
        }

        if ($view) {
            $this->db->where('view', '1');
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($limit)) {
            $this->db->limit($limit);
        }

        $sql = $this->db->order_by('page_up', 'asc')->order_by('id', 'desc')->get($table);
        return $sql->result_array();
    }   

    public function getFaqCats(){
        $id_lang = getIdLang();
        $sql = $this->db->select('faq_categories.*, faq_categories_lang.name')
                        ->from('faq_categories')
                        ->join('faq_categories_lang', 
                               "faq_categories_lang.post_id = faq_categories.id AND id_lang = $id_lang", 'left')
                        ->order_by('page_up', 'asc')
                        ->order_by('id', 'desc')
                        ->get();

        return $sql->result_array(); 
    }

    public function getFaq($start = false, $limit = false, $id_cat){

        if ($limit || $start) {
            $this->db->limit($start, $limit);
        }

        $id_lang = getIdLang();
        $sql = $this->db->select('faq.id, faq.id_category, faq_lang.post_id, faq_lang.id_lang, faq_lang.name, faq_lang.description, faq_lang.text')
                        ->from('faq')
                        ->join('faq_lang', 
                               "faq_lang.post_id = faq.id AND id_lang = $id_lang", 'left')
                        ->where('faq.id_category', $id_cat)
                        ->where('faq_lang.id_lang', $id_lang)
                        ->group_by('faq_lang.post_id')
                        ->group_by('faq_lang.id_lang')  
                        ->order_by('faq.page_up', 'asc')
                        ->order_by('faq.id', 'desc') 
                        ->get(); 

        $this->result = $sql->result_array(); 
        $this->_empty_data();  
        return $this->result; 
    }

    public function getSurvey($id){ 
        if (empty($id)) {
            return array();
        }
        $today = datetotime(date('d.m.Y'), 'DD.MM.YYYY');  
        $id_lang = getIdLang();
        $sql = $this->db->select('interview.*, interview_lang.id_lang, interview_lang.name, interview_lang.description ')
                        ->from('interview')
                        ->join('interview_lang', 
                               "interview_lang.post_id = interview.id AND id_lang = $id_lang AND interview_lang.delete = '0'", 'left')
                        ->where('interview.delete', '0') 
                        ->where('date_start <= ', $today)
                        ->where('date_end >= ', $today)
                        ->where('activated', '1') 
                        ->where('interview.id', $id) 
                        ->group_by('interview_lang.post_id')
                        ->group_by('interview_lang.id_lang')  
                        ->get(); 

        return $sql->row_array(); 
    }  

    public function getSurveyAccess($key){
        if (empty($key)) {
            return array();
        }

        $today = datetotime(date('d.m.Y'), 'DD.MM.YYYY');  
        $sql = $this->db->select('interview.id_project, survey_access.id_interview, survey_access.hash as key_access, survey_access.id_user, emails_list.email')
                        ->from('survey_access')
                        ->join('interview', "interview.id = survey_access.id_interview", 'left')
                        ->join('emails_list', "emails_list.id = survey_access.id_user", 'left')
                        ->where('interview.delete', '0') 
                        ->where('interview.date_start <= ', $today)
                        ->where('interview.date_end >= ', $today)
                        ->where('interview.activated', '1') 
                        ->where('survey_access.hash', $key)
                        ->where('emails_list.delete', '0') 
                        ->where('emails_list.view', '1') 
                        ->group_by('survey_access.id')
                        ->get();
 
        $result = $sql->row_array(); 

        if (empty($result)) {
            return array();
        }

        $getProjects = $this->getProjects(); 
        $array       = array();  
        $idsProject  = getChildProjectsId(map_tree($getProjects), $result['id_project'], &$array, false); 

        if (!empty($array) && in_array($result['id_project'], $array)) {
            return $result;
        } 

        return array();
    }

    public function getProjects(){
        $sql = $this->db->select('projects.*')
                        ->where('delete', '0')
                        ->order_by('page_up', 'asc')
                        ->order_by('id', 'desc')
                        ->get('projects');

        $result = key_to_id($sql->result_array()); 

        return $result;
    }

    public function getSurveyChapters($id_interview){  
        if (empty($id_interview)) {
            return array();
        }
        $id_lang = getIdLang(); 
        $id_user = getUserdata('id');
        $sql = $this->db->select('chapter.*, chapter_lang.name, chapter_lang.id_lang, chapter_status.status as chapter_status, chapter_status.date as start_chapter_time')
                        ->select('COUNT(chapter_question.id) as total_questions', false)
                        ->from('chapter')
                        ->join('chapter_status', "chapter_status.id_chapter = chapter.id AND chapter_status.id_user = $id_user AND chapter_status.id_interview = $id_interview", 'left')
                        ->join('chapter_lang', 
                               "chapter_lang.post_id = chapter.id AND id_lang = $id_lang AND chapter_lang.delete = '0'", 'left')
                        ->join('chapter_question', 
                               "chapter_question.id_chapter = chapter.id AND chapter_question.delete = '0' AND chapter_question.view = '1'", 'left')
                        ->where('chapter.id_interview', $id_interview) 
                        ->where('chapter.delete', '0') 
                        ->where('chapter.view', '1')  
                        ->having('total_questions > 0') 
                        ->group_by('chapter_lang.post_id')
                        ->group_by('chapter_lang.id_lang')
                        ->order_by('page_up', 'asc')
                        ->get();

        $result = $sql->result_array();
        return $result; 
    }     

    public function getChapterAnswers($id_chapter, $id_interview){
        $id_user = getUserdata('id');
        $sql = $this->db->select('answer')
                        ->where('id_interview', $id_interview)
                        ->where('id_chapter', $id_chapter)
                        ->where('id_user', $id_user)
                        ->get('periodic_answer_question')
                        ->row_array(); 

        if (empty($sql)) {
            return array(); 
        }

        $data = json_decode($sql['answer'], true);
        return $data;
    }

    public function getChapterQuestions($id_chapter){ 
        if (empty($id_chapter)) {
            return array();
        } 
        $id_lang = getIdLang(); 
        $sql = $this->db->select('chapter_question.*, chapter_question_lang.question, chapter_question_lang.id_lang')
                        ->from('chapter_question')
                        ->join('chapter_question_lang', 
                               "chapter_question_lang.post_id = chapter_question.id AND id_lang = $id_lang AND chapter_question_lang.delete = '0'", 'left')
                        ->where('chapter_question.id_chapter', $id_chapter) 
                        ->where('chapter_question.delete', '0') 
                        ->where('chapter_question.view', '1') 
                        ->group_by('chapter_question_lang.post_id')
                        ->group_by('chapter_question_lang.id_lang')
                        ->order_by('page_up', 'asc')
                        ->get();

        $result = $sql->result_array();
        return $result; 
    }   

    public function getQuestionChoice($id_question){
        if (empty($id_question)) {
            return array();
        }

        $id_lang = getIdLang(); 
        $sql = $this->db->select('choice.*, choice_lang.name, choice_lang.id_lang')
                        ->from('choice')
                        ->join('choice_lang', 
                               "choice_lang.post_id = choice.id AND id_lang = $id_lang AND choice_lang.delete = '0'", 'left')
                        ->where('choice.id_question', $id_question) 
                        ->where('choice.delete', '0') 
                        ->where('choice.view', '1') 
                        ->group_by('choice_lang.post_id')
                        ->group_by('choice_lang.id_lang')
                        ->order_by('page_up', 'asc')
                        ->get();

        $result = $sql->result_array();
        return $result; 
    }  

    public function getTotalQuestions($array){
        if (empty($array)) {
            return false;
        }

        $ids = array_map(function($v){
            return $v['id'];
        }, $array);

        $sql = $this->db->where_in('id_chapter', $ids)->where('view', '1')->where('delete', '0')->count_all_results('chapter_question');
        return $sql;
    }

    public function getOneChapter($chapter_num, $array){ 
        if ($chapter_num >= '1') {
            $chapter_num = $chapter_num-1;
        }else {
            return array();
        } 
        
        if (!empty($array[$chapter_num])) {
            return $array[$chapter_num];
        } 
    }

    public function getViewItem($url, $table){
        $sql = $this->db->where('url', clear($url))->where('view', '1')->get($table);
        $this->result = $sql->row_array(); 
        $this->_empty_data();
        return $this->result;
    } 

    public function getMainItemImg($id, $db_name){ 
        $sql = $this->db->where('parent_id', $id)->where('view', '1')->order_by('page_up', 'asc')->order_by('image', 'desc')->get($db_name)->row_array();
        return !empty($sql['image']) ? $sql['image'] : '';
    }

    public function getParentItems($table, $id){
        $sql = $this->db->where('parent_id', $id)->where('view', '1')->order_by('page_up', 'asc')->get($table)->result_array(); 
        return $sql;
    } 

    public function getMainItemImgData($id, $db_name){ 
        $sql = $this->db->where('parent_id', $id)->where('view', '1')->order_by('page_up', 'asc')->get($db_name)->row_array();
        return $sql;
    }    

    public function getProducts($where=false, $limit_num=false){   
        $lang = $this->lang->lang();

        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($limit_num)) {
            $this->db->limit($limit_num);
        }

        $sql = $this->db->select("catalog.*, categories.name_$lang as cat_name, categories.percentage as percentage")
                        ->join('categories', 'categories.id = catalog.id_category', 'left')
                        ->where('catalog.view', '1') 
                        ->order_by('catalog.page_up', 'asc')
                        ->order_by('catalog.id', 'asc')
                        ->get('catalog');
        
        return $sql->result_array();
    }

    public function getViewProduct($url){   
        $lang = $this->lang->lang(); 

        $sql = $this->db->select("catalog.*, categories.name_$lang as cat_name, categories.url as cat_url, categories.percentage as percentage")
                        ->join('categories', 'categories.id = catalog.id_category', 'left')
                        ->where('catalog.view', '1') 
                        ->where('catalog.url', clear($url))
                        ->order_by('catalog.page_up', 'asc')
                        ->order_by('catalog.id', 'asc')
                        ->get('catalog');
        
        $this->result = $sql->row_array(); 
        $this->_empty_data();
        return $this->result;
    } 

    public function getCategoryByQuery($query){
        $lang = $this->lang->lang(); 
        $sql = $this->db->where("name_$lang LIKE '%".$query."%'")->where('parent_id !=', '0')->get('categories'); 
        return $sql->result_array();
    }

    public function getProductByCat($start=false, $limit=false, $url, $get=false){
        $lang = $this->lang->lang(); 

        if (!empty($limit) or !empty($start)) {
            $this->db->limit($limit, $start);
        } 

        if (!empty($get['sort']) && $get['sort']=='price_asc') {
            $this->db->order_by('price', 'asc');
        }

        if (!empty($get['sort']) && $get['sort']=='price_desc') {
            $this->db->order_by('price', 'desc');
        }

        if (!empty($get['params'])) {
            $param_arr= array_map(function($v){
                return intval($v);
            }, explode(',', $get['params']));  

            $sql=$this->db->select("catalog.*, categories.name_$lang as cat_name, filter_product.id_product as filter_pr_id, categories.percentage as percentage, filters.name_$lang as filter_name")
                        ->join('categories', 'categories.id = catalog.id_category', 'left') 
                        ->join('filter_product', 'filter_product.id_product = catalog.id', 'left')
                        ->join('filters', 'filters.id = filter_product.id_filter', 'left') 
                        ->where('categories.url', clear($url))
                        ->where('catalog.view', '1') 
                        ->where('categories.view', '1') 
                        ->where_in('filter_product.value', $param_arr)
                        ->where('filters.type', 'checkbox')
                        ->order_by('catalog.page_up', 'asc')
                        ->order_by('catalog.id', 'asc')
                        ->get('catalog');

        }else{
            $sql=$this->db->select("catalog.*, categories.name_$lang as cat_name, categories.percentage as percentage")
                        ->join('categories', 'categories.id = catalog.id_category', 'left')  
                        ->where('categories.url', clear($url))
                        ->where('catalog.view', '1') 
                        ->where('categories.view', '1') 
                        ->order_by('catalog.page_up', 'asc')
                        ->order_by('catalog.id', 'desc')
                        ->get('catalog');
        }

         
        return $sql->result_array();
    }  

    public function _empty_data(){
        if (empty($this->result)) {
            display_404();
        }
    } 
}