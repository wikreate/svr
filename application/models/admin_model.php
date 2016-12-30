<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    private $result = array();
    
    function __construct() {
        parent::__construct();
    } 
 
    public function getEdit($id, $table, $multiple = false){
        $sql = $this->db->where('id', $id)->get($table);
        if ($multiple) {
            $this->result = $sql->result_array();
        }else{
            $this->result = $sql->row_array();
        } 
        $this->_empty_data();
        return $this->result;
    }

    public function getInterview($id, $lang_arr = false){ 
        $sql = $this->db->where('delete', '0')->where('id', $id)->get('interview');
        $this->result = $sql->result_array();
        $this->_empty_data();
        return getTranslateArray($this->result, array('name', 'description', 'welcome_text', 'info_text'), 'interview_lang', false, $lang_arr);
    }

    public function getInterviews($get = false){
        $status = 0;
        if (!empty($get['date_from']) ) {  
            $this->db->where('date_start <='.datetotime($get['date_from'], 'DD.MM.YYYY'));
            $status = 1;
        } 
 
        if (!empty($get['date_to'])) {  
            $this->db->where('date_end >= '.datetotime($get['date_to'], 'DD.MM.YYYY'));
            $status = 1;
        } 

        if (!empty($get['status'])) {
            $status = 1;
            $this->db->where('status', intval($get['status']));
        }

        if (!empty($get) && $status == 0) {
            $this->db->where('id <', '0');
        } 

        $sql = $this->db->where('delete', '0')->get('interview');
        $this->result = $sql->result_array();  
        return getTranslateArray($this->result, array('name', 'description', 'welcome_text', 'info_text'), 'interview_lang', true);
    } 

    public function getItems($table, $page_up = true, $view = false, $where = false, $delete = true){
        if ($page_up) {
            $this->db->order_by('page_up', 'asc');
        }else{
            $this->db->order_by('date', 'desc');
        }

        if ($view) {
            $this->db->where('view', '1');
        }

        if (!empty($where)) {
            $this->db->where($where);
        }

        if ($delete) {
            $this->db->where('delete', '0');
        }

        $sql = $this->db->order_by('id', 'desc')->get($table);
        return $sql->result_array();
    }    

    public function getProjects($where_in = false){ 
        $userData        = getAdminUser();  

        if ($userData['parent_id'] != '0') {
            $getUserProjects = $this->db->where('id_user', $userData['id'])->get('user_projects')->result_array(); 
            if (empty($getUserProjects)) {
                return array(); 
            }

            $ids = array_map(function($v){
                return $v['id_project'];
            }, $getUserProjects);

            $this->db->where_in('id', $ids);
        }

        if (!empty($where_in)) {
            $this->db->where_in('id', $where_in);
        }

        $sql = $this->db->select('projects.*')
                        ->where('delete', '0')
                        ->order_by('page_up', 'asc')
                        ->order_by('id', 'desc')
                        ->get('projects');
 
        $result = key_to_id($sql->result_array()); 

        foreach ($result as $item) {
            if (empty($result[$item['parent_id']])) {
                $result[$item['id']]['parent_id'] = 0;
            }
        }
 
        $translate = getTranslateArray($result, array('name'), 'projects_lang'); 
  
        return $translate; 
    }

    public function getFaq(){
        $lang_arr = $this->lang->languages;
        $id_lang  = array_search(var_data_lang, $lang_arr);
         
        $sql = $this->db->select('faq.*, faq_categories_lang.name as cat_name')
                        ->join('faq_categories_lang', "faq_categories_lang.post_id = faq.id_category AND id_lang = '{$id_lang}'", 'left')
                        ->join('faq_categories', "faq_categories.id = faq.id_category", 'left')
                        ->where('faq.delete', '0')
                        ->where('faq_categories_lang.delete', '0')
                        ->order_by('faq_categories.page_up', 'asc')
                        ->order_by('faq_categories.id', 'desc') 
                        ->order_by('faq.page_up', 'asc')
                        ->order_by('faq.id', 'desc') 
                        ->get('faq');

        $result = $sql->result_array(); 
        return getTranslateArray($result, array('name'), 'faq_lang'); 
    }

    public function getFaqCategories(){
        $sql = $this->db->where('delete', '0')
                        ->order_by('faq_categories.page_up', 'asc')
                        ->order_by('faq_categories.id', 'desc')
                        ->get('faq_categories');
        $result = $sql->result_array();
        return getTranslateArray($result, array('name'), 'faq_categories_lang'); 
    }
 

    public function getEmailsByProject($id_project, $where_in = false){
        if (!empty($where_in)) { 
            $this->db->where_in('id_project', $id_project);
        }else{
            $this->db->where('id_project', $id_project);
        }

        $sql = $this->db->select('emails_list.*, projects.id_lang as lang')
                        ->from('emails_list')
                        ->join('projects', 'projects.id = emails_list.id_project', 'left')
                        ->where('emails_list.delete', '0')
                        ->where('emails_list.view', '1')
                        ->group_by('emails_list.email')
                        ->order_by('id', 'desc')
                        ->get()
                        ->result_array(); 

        $array = array();
        if (!empty($sql)) { 
            foreach ($sql as $item) {
                $item['email'] = decrypt($item['email']);
                $array[] = $item;
            }
        }

        return $array;
    }

    public function getPrivilege(){ 
        $id = getAdminUser('id'); 
        $getPrivilege = $this->db->query("SELECT privilege.define,
                                               privilege.name,
                                               privilege.id, 
                                               user_privileges.id_user
                                     FROM privilege
                                     LEFT JOIN user_privileges ON (user_privileges.id_privilege = privilege.id)
                                     LEFT JOIN admin_users ON (admin_users.id = user_privileges.id_user)
                                     WHERE admin_users.delete = '0'
                                     AND admin_users.active = '1'
                                     AND user_privileges.id_user = '$id'
                                  ")->result_array(); 

        $privilege = array();
        if (!empty($getPrivilege)) { 
            foreach ($getPrivilege as $item) {
                $privilege[$item['name']]['id_privilege'] = $item['id'];
                $privilege[$item['name']]['id_user'] = $item['id_user']; 
            }
        }   

        return $privilege;
    }     

    public function getInterviewNotifications($parent_id, $lang_arr){ 
        $sql = $this->db->where('parent_id', $parent_id)
                        ->where('delete', '0')
                        ->order_by('date', 'desc')
                        ->get('notification_system');

        $result = $sql->result_array();
        return getTranslateArray($result, array('text'), 'notification_system_lang', true, $lang_arr);
    }    

    public function getSendNotifications(){
        $today = date('d.m.Y', time()); 
        $get = $this->db->select('notification_system.*, interview.id_project, 
                                  notification_system.parent_id as id_interview')
                        ->select("FROM_UNIXTIME(notification_system.date, '%d.%m.%Y') as notification_date", FALSE)
                        ->from('notification_system')
                        ->join('interview', 'interview.id = notification_system.parent_id')
                        ->join('projects', 'projects.id = interview.id_project')
                        ->join('interview_select_lang', 'interview_select_lang.id_interview = interview.id')
                        ->where('interview.delete', '0')
                        ->where('interview.activated', '1')
                        ->where('interview.status', '2')
                        ->where('projects.view', '1')
                        ->where('projects.delete', '0')
                        ->where('notification_system.delete', '0') 
                        ->where("FROM_UNIXTIME(notification_system.date, '%d.%m.%Y') = '$today'")
                        ->group_by('interview.id')
                        ->get()
                        ->result_array(); 
  
        return $get;
    }

    public function getSendWelcomeMessage(){
        $today = date('d.m.Y', time()); 
        $get = $this->db->select('interview.*')
                        ->select("FROM_UNIXTIME(interview.date_send_welcome, '%d.%m.%Y') as welcome_date", FALSE)
                        ->from('interview') 
                        ->where('interview.delete', '0')
                        ->where('interview.activated', '1')
                        ->where('interview.status', '2') 
                        ->where("FROM_UNIXTIME(interview.date_send_welcome, '%d.%m.%Y') = '$today'")
                        ->group_by('interview.id')
                        ->get()
                        ->result_array();  
        return $get;
    }

    public function getChapter($parent_id, $lang_arr){
        $sql = $this->db->where('id_interview', $parent_id)
                        ->where('delete', '0')
                        ->order_by('page_up', 'asc')
                        ->get('chapter');

        $result = $sql->result_array();
        return getTranslateArray($result, array('name'), 'chapter_lang', true, $lang_arr);
    }      

    public function getConstants() {
        $sql = $this->db->where('view', '1')->order_by('page_up', 'asc')->get('constants');
        return $sql->result_array();
    }

    public function getUsers() { 
        $sql = $this->db->select('admin_users.*, role.name as role_name')
                        ->from('admin_users')
                        ->join('role', 'role.id = admin_users.id_role')
                        ->where('admin_users.delete', '0')
                        ->where('admin_users.parent_id >', '0')
                        ->order_by('role.page_up', 'asc')
                        ->order_by('admin_users.id', 'desc')
                        ->get(); 
        return $sql->result_array(); 
    }  
    
    private function _empty_data() {
        if (empty($this->result))
            admin_404();
    }
 
}