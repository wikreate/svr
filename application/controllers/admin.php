<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller { 

    /**
    * @var $user_id
    */
    private $user_id;

    /**
    * @var $user_role
    */
    private $user_role;

    /**
    * @var $user_login
    */
    private $user_login;

    /**
    * @var $session_id
    */
    private $session_id; 

    public function __construct() 
    {
        parent::__construct();

        $this->initAdmin();   

        $this->config->load('config');  
        $this->config->set_item('language', 'en'); 
        $this->load->model('admin_model');   
    }  
 
    private function initAdmin()
    { 
        if (empty($_SESSION['admin_user']['session']) or getAdminUser('session_hash') != $_SESSION['admin_user']['session'])
        {
            redirect(base_url('login'), 'refresh');
            exit();
        }    

        $userdata = getAdminUser();

        if (empty($userdata)) 
        {
            redirect(base_url('login'), 'refresh');
        }

        $this->user_id    = $userdata['id'];
        $this->user_role  = $userdata['id_role'];
        $this->user_login = $userdata['login'];
        $this->session_id = $userdata['session_hash']; 
    }
  
    public function controller($url)
    {    
        $url = str_replace('-', '_', $url);
        if (!method_exists($this, $url)) 
        {
            exit('404, page no found');
        } 
        else
        {

            $interviewAcess = array(
               'interview',  'edit-chapter', 'question', 'deactivatedInterview', 'activateInterview', 'sendTestLetter', 'copyInterview'
            );

            if (Can(array('WORKING_WITH_SURVEY')) === false && in_array($url, $interviewAcess)) {
               admin_404();
            }

            $this->$url();
        }
    }   

    public function menu() { 

        $id              = $this->uri->segment(3);
        $table           = 'menu';
        $table_translate = 'menu_lang'; 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            if (empty($id)) {

                /* Insert */ 

                if (empty($_POST['url'])) {
                    alertError('Fill url Field!');
                }
 
                $data['url'] = to_url_title($_POST['url']);
                $this->db->insert($table, $data);  
                $id = $this->db->insert_id();

                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name', 'text', 'seo_title', 'seo_description', 'seo_keywords'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);   

                $this->alertSuccess(true); 
            }else{

                /* Edit */
 
                $url_prioryti = $this->db->select('let_alone')->where('id', $id)->get('menu')->row();
                if ($url_prioryti->let_alone != 1) {
                    $url = to_url_title($_POST['url']);
                    $this->db->where('id', $id)->update($table, array(
                        'url' => $url
                    )); 
                } 
 
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name', 'text', 'seo_title', 'seo_description', 'seo_keywords'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);

                $this->alertSuccess(true); 
            }
             
        }else{ 

            if (!empty($id)) {
                $getMenu = $this->admin_model->getEdit($id, 'menu', true);
                $data = getTranslateArray($getMenu, array('name', 'text', 'seo_title', 'seo_description', 'seo_keywords'), $table_translate, false);
            }else{  
                $getMenu = $this->admin_model->getItems('menu');
                $data = getTranslateArray($getMenu, array('name', 'text', 'seo_title', 'seo_description', 'seo_keywords'), $table_translate);
            }

             //exit(print_arr($data));

            $data = array(
                'data'     => $data, 
                'db_table' => 'menu',
                'method'   => $table
            ); 
             
            $this->admin('private/menu', $data, '');
        } 
    } 

    public function date(){
        $uri3 = $this->uri->segment(3);
        $days = $uri3;

        echo time() - ($days*86400);

        exit();
    } 

    public function languages() 
    {

        $id = $this->uri->segment(3);
        if (isPost()) { 

            $lang      = clear($_POST['name']);
            $checkLang = $this->db->where('name', $lang)->get('languages');

            if ($checkLang->num_rows() > 0) 
            {
                $this->alertError('This language already exists');
            }

            if (empty($id)) {

                /* Insert */
                 
                $data = returnData($_POST, array('name'));  
                 
                $this->db->insert('languages', $data); 
                $this->alertSuccess(false, true); 
            }else{

                /* Edit */
   
                $data = returnData($_POST, array('name'));  

                $this->db->where('id', $id)->update('languages', $data); 
                $this->alertSuccess(false, true); 
            } 
        }else{
            $data = array(
                'data'     => !empty($id) ? $this->admin_model->getEdit($id, 'languages')  : $this->admin_model->getItems('languages'), 
                'db_table' => 'languages',
                'method'   => 'languages' 
            ); 
             
            $this->admin('private/languages', $data, '');
        } 
    } 
 
    public function projects()
    {
        $id              = $this->uri->segment(3);
        $table           = 'projects';
        $table_translate = 'projects_lang';

        if (isPost()) 
        {  

            if (empty($_POST['id_lang'])) {
                $this->alertError(alert('required_fields'));
            }
              
            if (empty($id)) 
            {

                /* Insert */   

                $data['id_lang'] = intval($_POST['id_lang']);    
                $this->db->insert($table, $data); 
                $id = $this->db->insert_id();

                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);  

                $this->db->insert('user_projects', array('id_user' => getAdminUser('id'), 'id_project' => $id));

                $this->alertSuccess(false, true); 
            }
            else
            {

                /* Edit */   

                $data['id_lang'] = intval($_POST['id_lang']);    
                $this->db->where('id', $id)->update($table, $data); 
                
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config); 
                $this->alertSuccess(false, true); 
            } 
        }
        else
        { 

            if (!empty($id) && AccessProject($id) == false) {
                admin_404();
            }

            $data = array(
                'data' => !empty($id) ? getTranslateArray($this->admin_model->getEdit($id, 'projects', true), array('name'), 'projects_lang', false) : '', 
                'tree' =>  map_tree($this->admin_model->getProjects()),   
                'db_table' => $table, 
                'method' => 'projects' 
            ); 
 
            $this->admin('private/projects', $data, '');
        } 
    }

    public function faq()
    {
        $id              = $this->uri->segment(3);
        $table           = 'faq';
        $table_translate = 'faq_lang';

        if (isPost()) 
        {  

            if (empty($_POST['id_category'])) {
                alertError('Choose category!');
            }
              
            if (empty($id)) 
            {

                /* Insert */   
 
                $data['id_category'] = intval($_POST['id_category']);    
                $this->db->insert($table, $data); 
                $id = $this->db->insert_id(); 

                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name', 'description', 'text'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);  
                $this->alertSuccess(false, true); 
            }
            else
            {

                /* Edit */   
                
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name', 'description', 'text'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);

                $data['id_category'] = intval($_POST['id_category']); 
                $this->db->where('id', $id)->update($table, $data);  

                $this->alertSuccess(false, true); 
            }
            
        }
        else
        { 

            $data = array(
                'data'       => !empty($id) ? getTranslateArray($this->admin_model->getEdit($id, $table, true), array('name', 'description', 'text'), $table_translate, false) : $this->admin_model->getFaq(),  
                'categories' => map_tree($this->admin_model->getFaqCategories()),
                'db_table'   => $table, 
                'method'     => 'faq' 
            );  
 
            $this->admin('private/faq', $data, '');
        } 
    } 

    public function faq_categories()
    {
        $id              = $this->uri->segment(3);
        $table           = 'faq_categories';
        $table_translate = 'faq_categories_lang';

        if (isPost()) 
        {  
              
            if (empty($id)) 
            {

                /* Insert */   
 
                $data['parent_id'] = '';    
                $this->db->insert($table, $data); 
                $id = $this->db->insert_id(); 

                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config); 

                $this->alertSuccess(false, true); 
            }
            else
            {

                /* Edit */   
                
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('name'),
                        'lang_arr' => false,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);

                $this->alertSuccess(false, true); 
            }
            
        }else{ 

            $data = array(
                'data'     => !empty($id) ? getTranslateArray($this->admin_model->getEdit($id, $table, true), array('name'), $table_translate, false) : map_tree($this->admin_model->getFaqCategories()),   
                'db_table' => $table, 
                'method'   => 'faq-categories' 
            ); 
 
            $this->admin('private/faq_categories', $data, '');
        } 
    } 

    public function notification_status()
    {
        $id              = $this->uri->segment(3);
        $table           = 'notification_status'; 
        if (isPost()) {  
              
            if (empty($id)) 
            {

                /* Insert */    
                $data = returnData($_POST, array('name'));  
                $this->db->insert($table, $data);

                $this->alertSuccess(false, true); 
            }
            else
            {

                /* Edit */   
                
                $data = returnData($_POST, array('name')); 
                $this->db->where('id', $id)->update($table, $data);
            
                $this->alertSuccess(false, true); 
            }
            
        }else{ 
            $data = array(
                'data' => !empty($id) ? $this->admin_model->getEdit($id, $table, false) : $this->admin_model->getItems($table),  
                'db_table' => $table, 
                'method' => 'notification-status' 
            );    
            
            $this->admin('private/notification_status', $data, '');
        } 
    }

    public function emails_list()
    {
        if (empty($_GET['pr_id']))  display_404();

        $id_project = intval($_GET['pr_id']); 
        $table      = 'emails_list';
        $id         = intval($this->uri->segment(3));

        if (AccessProject($id_project) == false) {
            admin_404(); 
        }

        if (isPost()) 
        {  
              
            if (empty($id)) 
            {

                /* Insert */  

                if (empty($_POST['id_project']) or empty($_POST['emails'])) 
                {
                    $this->alertError('Заполните поле!');
                }  

                $id_project    = intval($_POST['id_project']);
                $emails        = $_POST['emails']; 
                $explodeEmails = explode('<br />', nl2br($emails));
 

                /**
                * Массив со всеми имейлами для указанной категории
                */
                $getEmails = $this->db->where('id_project', $id_project)->where('delete', '0')->get($table)->result_array();

                /**
                * Массив с совпадающими имейлами
                */
                $compareEmails = array_filter($getEmails, function($v) use($explodeEmails)
                {
                    if (in_array(decrypt(trim($v['email'])), $explodeEmails)) 
                    {
                        return decrypt(trim($v['email']));
                    } 
                });
 
                

                if (!empty($compareEmails)) {

                    /**
                    * @var $returnSameEmail
                    *  Хранит массив первого уровня с совпадающими имейлами
                    */ 
                    $returnSameEmail = array_map(function($v){
                        return trim($v['email']);
                    }, $compareEmails);

                    $implodeEmails = implode(',<br>', $returnSameEmail);

                    /**
                    * Вывод ошибки а также список совпадающих имейлав
                    */
                    echo json_encode(array('msg'             => 'error', 
                                           'cause'           => 'Емайлы уже существуют', 
                                           'existing_emails' => $implodeEmails
                                        ));
                    exit();
                }   

                  
                foreach ($explodeEmails as $key => $value) 
                {
                    
                    $this->db->insert($table, array(
                                                        'id_project' => $id_project,
                                                        'email'      => encrypt(trim($value))
                                                    ));
                }
  
                $this->alertSuccess(false, true); 
            }
            else
            {

                /* Edit */   

                if (empty($_POST['email'])) 
                {
                    $this->alertError('The field can not be empty!'); 
                }

                if ($this->db->where('email', clear($_POST['email']))->where('id_project', $id_project)->get('emails_list')->num_rows() > 0) 
                {
                    $this->alertError('This email is already exist in this project!'); 
                }
                
                $email = clear($_POST['email']);   
                $this->db->where('id', $id)->update('emails_list', array('email' => encrypt($email))); 
                $this->alertSuccess(false, true); 
            }
            
        }
        else
        {
            $data = array(
                'project'  => getTranslateArray($this->admin_model->getEdit($id_project, 'projects', true), array('name'), 'projects_lang', false),  
                'db_table' => $table, 
                'data'     => empty($id) ? $this->admin_model->getEmailsByProject($id_project) : $this->admin_model->getEdit($id, $table),
                'method'   => 'emails-list' 
            );  

            if (empty($id)) 
            {
                $crumb = '<li>
                            <a href="javascript:;" style="text-decoration:none; cursor:pointer;">Emails List</a> 
                         </li> ';
            }
            else
            {
                $crumb = '<li>
                            <a href="/cp/emails-list/?pr_id='.$id_project.'" >Emails List</a> 
                            <i class="fa fa-angle-right"></i> 
                         </li>
                         <li>
                            <a href="javascript:;" style="text-decoration:none; cursor:pointer;">'.decrypt($data['data']['email']).'</a> 
                         </li> ';
            }

            $data['breadcrumbs'] = '<li>
                                        <i class="fa fa-home"></i>
                                        <a href="/cp/menu/">Home</a>
                                        <i class="fa fa-angle-right"></i> 
                                    </li>
                                    <li> 
                                        <a href="/cp/projects/">'.$data['project']['name_'.var_data_lang].'</a> 
                                        <i class="fa fa-angle-right"></i> 
                                    </li>
                                     '.$crumb;

            $this->admin('private/emails_list', $data, ''); 
        } 
    }

    public function loadEmailFile()
    {
        if (isPost())
        { 

            if (empty($_POST['id_project']) or AccessProject($_POST['id_project']) == false) 
            {
                $this->alertError();
            }  

            $id_project = intval($_POST['id_project']);
 

            if (isset($_FILES['file_emails']['size']) && !empty($_FILES['file_emails']['size'])) 
            { 
                $file            = $_FILES['file_emails']['name'];  
                $explodeFileName = explode('.', $file);
                $ext =            end($explodeFileName);

                $allowed_types = array('xls', 'xlsx', 'csv');
                if (!in_array($ext, $allowed_types)) 
                {
                    $this->alertError('Файл должен быть формата xls, xlsx, csv');
                }

                $config = array(
                    'upload_path' => 'public/files/emails',
                    'allowed_types' => '*',
                    'overwrite' => false,
                    'max_size' => '10000',
                    'remove_spaces' => true,
                    'encrypt_name' => true
                );

                $upload = $this->doUpload('file_emails', $config);
                if ($upload['response'] !== TRUE) 
                { 
                    $this->alertError($upload['response']);  
                } 
                else 
                {
                    $file_name = $upload['image'];
                } 
            }
            else
            {
                $this->alertError('Choose the file with properties');
            } 

            if ($ext == 'xls' or $ext == 'xlsx') 
            {
                include realpath('public').'/lib/phpExcel/Classes/PHPExcel/IOFactory.php';

                $inputFileName = realpath('public').'/files/emails/'.$file_name; 
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName); 
                
                $Data = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
  
                $emails   = ""; 
                $existing = "";
                $a        = "";
                foreach ($Data as $key => $value) 
                {
                    if (!empty($value['A'])) 
                    {
                        $email = $value['A'];

                        if ($this->db->where('email', trim(encrypt($email)))->where('id_project', $id_project)->where('delete', '0')->get('emails_list')->num_rows() > 0) 
                        {
                            $existing .= $email.'<br>';
                        }
                        else
                        {
                            $emails .= $a.$email; $a="\n";
                        }  
                    } 
                }  

                echo json_encode(array('emails' => $emails, 'existing' => $existing, 'msg' => true));
                exit();

            }
            else if($ext == 'csv')
            {
                $file_path = realpath('public').'/files/emails/'.$file_name;
                $file_name = $file_name;
  
                $csv = array_map('str_getcsv', file($file_path));   
                $emails   ="";
                $existing = "";
                $a        = "";   
                foreach ($csv as $key => $value) 
                { 
                    $email_arr = explode(",",$value[0]);  

                    if (!empty($email_arr[0])) 
                    { 
                        $email = trim($email_arr[0]);  
                        if ($this->db->where('email', encrypt($email))->where('id_project', $id_project)->where('delete', '0')->get('emails_list')->num_rows() > 0) 
                        {
                            $existing .= $email.'<br>';
                        }
                        else
                        {
                            $emails .= $a.$email; $a="\n";
                        }  
                    } 
                }
                echo json_encode(array('emails' => $emails, 'existing' => $existing, 'msg' => true));
                exit();
            }
        }
    }

    public function interview()
    { 
        $uri3 = $this->uri->segment('3');

        $actions = array('add', 'edit');
        if (in_array($uri3, $actions)) 
        {
            $this->addInterview();
            return;
        }
 
        $data = array(
                'data'     => $this->admin_model->getInterviews(@$_GET),
                'method'   => 'interview',
                'db_table' => 'interview',
                'status'   => $this->admin_model->getItems('interview_status')
            );   

        $this->admin('private/interview', $data, ''); 
    }

    public function deactivatedInterview()
    {
        if (isPost()) 
        { 
            if (empty($_POST['id']) ) 
            {
                $this->alertError(alert('required_fields'));
            }

            $id_interview = intval($_POST['id']);

            $this->db->where('id', $id_interview)
                     ->update('interview', array(
                                                'activated' => '0' 
                                            ));

            $config = array(
                        'post'     => $_POST,
                        'fields'   => array('deactivated_message'),
                        'lang_arr' => getInterviewLangArr($id_interview),
                        'db_table' => 'interview_lang',
                        'post_id'  => $id_interview
                    ); 

            insertDataLang($config); 

            $this->alertSuccess('The survey was successfully deactivated!', true);
        }
    }

    public function activateInterview()
    {
         if (isPost()) 
         { 
            if (empty($_POST['id']) ) 
            {
                $this->alertError(alert('required_fields'));
            }

            $id_interview = intval($_POST['id']);

            $this->db->where('id', $id_interview)
                     ->update('interview', array(
                                                'activated' => '1' 
                                            )
                                );    

            $this->alertSuccess('The survey was successfully activated!', true);
        }
    }

    public function getInterviewProjects($id_interview, $array = array())
    {
        $getProjects  = $this->admin_model->getProjects();
        $getInterview = $this->admin_model->getInterview($id_interview); 
        $idsProject   = getChildProjectsId(map_tree($getProjects), $getInterview['id_project'], &$array); 
        return $this->admin_model->getProjects($idsProject);  
    }
 
    public function emailsProject($project, $array = array())
    { 
        $getProjects  = $this->admin_model->getProjects(); 
        $idsProject   = getChildProjectsId(map_tree($getProjects), $project, &$array); 
 
        if (empty($idsProject)) 
        {
            return array();
        }

        return $this->admin_model->getEmailsByProject($idsProject, true); 
    }

    /**
    * Система уведомления
    */
    public function sendSystemNotification()
    {   
        $array = $this->admin_model->getSendNotifications(); 
   
        if (empty($array)) {
            return;
        } 

        $logArr = array();
        foreach ($array as $item) 
        {
            $getEmails = $this->emailsProject($item['id_project']); 

            if (!empty($getEmails)) 
            {
                foreach ($getEmails as $value) 
                {
                    $lang      = array();
                    $lang_name = '';
                    if (!empty($this->lang->languages[$value['lang']])) 
                    {
                        $lang_name = $this->lang->languages[$value['lang']];
                        $lang      = array($value['lang'] => $lang_name); 
                    }
                    
                    $email  = $value['email'];
                    $result = getTranslateArray(array($item), array('text'), 'notification_system_lang', false, $lang);

                    if (!empty($result) && !empty($lang) && !empty($lang_name)) 
                    { 
                        send_mail($email, 'Theme', $result["text_$lang_name"]);

                        $logArr[$email] = $result["text_$lang_name"];

                        $log_data = array(
                                'email'        => encrypt($email),
                                'id_interview' => $item['id_interview'],
                                'type'         => $item['status'],
                                'date'         => time()
                            );

                        $this->db->insert('notification_system_log', $log_data);
                    } 
                }
            } 
        }

        if (!empty($logArr)) {
            foreach ($logArr as $key => $message) { 
                echo "Email: $key; <br> Message: ".htmlspecialchars_decode($message);;
                echo "<br clear='all'> <hr>";
            }
        } 
        exit();
    }

    public function sendWelcomeLetter()
    { 
        $getInterview = $this->admin_model->getSendWelcomeMessage();

        if (empty($getInterview)) {
            return;
        } 

        $logArr = array();
        foreach ($getInterview as $item) 
        {
            $getEmails = $this->emailsProject($item['id_project']); 

            if (!empty($getEmails)) 
            {
                foreach ($getEmails as $value) 
                {
                    $lang      = array();
                    $lang_name = '';
                    if (!empty($this->lang->languages[$value['lang']])) 
                    {
                        $lang_name = $this->lang->languages[$value['lang']];
                        $lang      = array($value['lang'] => $lang_name); 
                    }
                     
                    $email  = $value['email'];
                    $result = getTranslateArray(array($item), array('welcome_text'), 'interview_lang', false, $lang);
 
                    if (!empty($result) && !empty($lang) && !empty($lang_name)) 
                    {  
                        send_mail($email, 'Theme', $result["welcome_text_$lang_name"]); 

                        $logArr[$email] = $result["welcome_text_$lang_name"];
                    } 
                }
            } 
        }  

        if (!empty($logArr)) {
            foreach ($logArr as $key => $message) { 
                echo "Email: $key; <br> Message: ".htmlspecialchars_decode($message);;
                echo "<br clear='all'> <hr>";
            }
        } 
        exit();
    }
 
    public function sendTestWelcomeLetter()
    {
        if (isPost()) 
        {
            if (empty($_POST['email']) or empty($_POST['id']) or empty($_POST['lang'])) 
            {
                $this->alertError('Fill in all fields!');
            }

            $id_interview = intval($_POST['id']);
            $email        = $_POST['email'];
            $lang         = $_POST['lang'];
            $acceptLangs  = getInterviewLangArr($id_interview);

            $getInterview = $this->admin_model->getInterview($id_interview, $acceptLangs);
            if (empty($getInterview)) $this->alertError(); 

            $theme = 'Theme';
            $message = $getInterview["welcome_text_$lang"];
            send_mail($email, $theme, $message);
            
            $this->alertSuccess('The message was successfully send!', true);
        }
    } 

    public function copyInterview()
    {
        if (isPost()) 
        { 
            if (empty($_POST['id']) ) 
            {
                $this->alertError(alert('required_fields'));
            }

            $id_interview = intval($_POST['id']);

            /**
            * Дублирование: 
            * Опрос + Перевод
            * Система уведомления + Перевод
            * Главы опроса + Перевод
            * Вопросы глав + Перевод
            * Множественный выбор ответа на Вопрос + Перевод
            */ 
 
            /**
            * Дублирование Опроса
            */
            $getInterview = $this->db->where('id', $id_interview)->where('delete', '0')->get('interview')->row_array(); 
            if (empty($getInterview)) 
            {
                $this->alertError('Server error!');
            }

            foreach ($getInterview as $key => $value){   
                if($key != 'id' and $key != 'activated'){  
                    $this->db->set($key, $value);               
                } 
                elseif ($key == 'activated') 
                {
                    $this->db->set('activated', null);    
                }
            }  
            $this->db->insert('interview');
            $id = $this->db->insert_id();

            /**
            * Дублирование перевода Опроса
            */
            $getInterviewTranslate = $this->db->where('post_id', $id_interview)->where('delete', '0')->get('interview_lang')->result_array();  
            foreach ($getInterviewTranslate as $item)
            {   
                foreach ($item as $key => $value)
                { 
                    if($key != 'id' and $key != 'post_id' and $key != 'name')
                    {  
                        $this->db->set($key, $value);               
                    } 
                    elseif ($key == 'post_id') 
                    {
                        $this->db->set('post_id', $id);    
                    } 
                    elseif ($key == 'name') 
                    {
                        $this->db->set('name', $value.' - copy');    
                    }
                } 

                $this->db->insert('interview_lang');
            }  
               
            /**
            * Дублирование Глав Опроса
            */
            $getInterviewChapter = $this->db->where('id_interview', $id_interview)->where('delete', '0')->get('chapter')->result_array();  
            if (!empty($getInterviewChapter)) {
                foreach ($getInterviewChapter as $item)
                {   
                    foreach ($item as $key => $value)
                    { 
                        if($key != 'id' and $key != 'id_interview')
                        {  
                            $this->db->set($key, $value);               
                        } 
                        elseif ($key == 'id_interview') 
                        {
                            $this->db->set('id_interview', $id);    
                        }
                    } 

                    $this->db->insert('chapter'); 
                    $id_chapter = $this->db->insert_id();

                    /**
                    * Дублирование Перевода Глав Опроса
                    */
                    $getChapterTranslate = $this->db->where('post_id', $item['id'])->where('delete', '0')->get('chapter_lang')->result_array();   
                    if (!empty($getChapterTranslate)) 
                    {
                        foreach ($getChapterTranslate as $item1)
                        {   
                            foreach ($item1 as $key => $value)
                            { 
                                if($key != 'id' and $key != 'post_id')
                                {  
                                    $this->db->set($key, $value);               
                                } 
                                elseif ($key == 'post_id') {
                                    $this->db->set('post_id', $id_chapter);    
                                } 
                            } 

                            $this->db->insert('chapter_lang'); 
                        }   
                    } 
 
                    /**
                    * Дублирование Вопросов главы
                    */ 
                    $getQuestion = $this->db->where('id_chapter', $item['id'])->where('delete', '0')->get('chapter_question')->result_array();  
                    if (!empty($getQuestion)) 
                    {
                        foreach ($getQuestion as $item1)
                        {   
                            $answer_id = 0;
                            foreach ($item1 as $key => $value)
                            { 
                                if($key != 'id' and $key != 'id_chapter')
                                {  
                                    $this->db->set($key, $value);               
                                } 
                                elseif ($key == 'id_chapter') 
                                {
                                    $this->db->set('id_chapter', $id_chapter);    
                                } 
                            } 

                            $this->db->insert('chapter_question'); 
                            $id_question = $this->db->insert_id();

                            /**
                            * Дублирование Перевода Вопросов главы
                            */
                            $getQuestionTranslate = $this->db->where('post_id', $item1['id'])->where('delete', '0')->get('chapter_question_lang')->result_array();   
                            if (!empty($getQuestionTranslate)) 
                            {
                                foreach ($getQuestionTranslate as $item2)
                                {   
                                    foreach ($item2 as $key => $value)
                                    { 
                                        if($key != 'id' and $key != 'post_id')
                                        {  
                                            $this->db->set($key, $value);               
                                        } 
                                        elseif ($key == 'post_id') 
                                        {
                                            $this->db->set('post_id', $id_question);    
                                        } 
                                    }  

                                    $this->db->insert('chapter_question_lang'); 
                                }   
                            } 


                            /**
                            * Дублирование множественного варианта ответа
                            */
                            $getChoice = $this->db->where('id_question', $item1['id'])->where('delete', '0')->get('choice')->result_array();  
                            if (!empty($getChoice)) 
                            {
                                foreach ($getChoice as $item3)
                                {   
                                    foreach ($item3 as $key => $value){ 
                                        if($key != 'id' and $key != 'id_question')
                                        {  
                                            $this->db->set($key, $value);               
                                        } 
                                        elseif ($key == 'id_question') 
                                        {
                                            $this->db->set('id_question', $id_question);    
                                        }
                                    } 

                                    $this->db->insert('choice'); 
                                    $id_choice = $this->db->insert_id();

                                    /**
                                    * Дублирование Перевода Системы уведомления 
                                    */
                                    $getChoiceTranslate = $this->db->where('post_id', $item3['id'])->where('delete', '0')->get('choice_lang')->result_array();   
                                    if (!empty($getChoiceTranslate)) 
                                    {
                                        foreach ($getChoiceTranslate as $item4)
                                        {   
                                            foreach ($item4 as $key => $value)
                                            { 
                                                if($key != 'id' and $key != 'post_id')
                                                {  
                                                    $this->db->set($key, $value);               
                                                } 
                                                elseif ($key == 'post_id') 
                                                {
                                                    $this->db->set('post_id', $id_choice);    
                                                }
                                            } 

                                            $this->db->insert('choice_lang'); 
                                        }  
                                    } 
                                } 
                            } 
                        } 
                    } 
                }  
            }

            /**
            * Дублирование Системы уведомления
            */ 
            $getNotificationSystem = $this->db->where('parent_id', $id_interview)->where('delete', '0')->get('notification_system')->result_array();  
            if (!empty($getNotificationSystem)) 
            {
                foreach ($getNotificationSystem as $item)
                {   
                    foreach ($item as $key => $value){ 
                        if($key != 'id' and $key != 'parent_id')
                        {  
                            $this->db->set($key, $value);               
                        } 
                        elseif ($key == 'parent_id') 
                        {
                            $this->db->set('parent_id', $id);    
                        }
                    } 

                    $this->db->insert('notification_system'); 
                    $id_notif = $this->db->insert_id();

                    /**
                    * Дублирование Перевода Системы уведомления 
                    */
                    $getNotificationSystemTranslate = $this->db->where('post_id', $item['id'])->where('delete', '0')->get('notification_system_lang')->result_array();   
                    if (!empty($getNotificationSystemTranslate)) 
                    {
                        foreach ($getNotificationSystemTranslate as $item)
                        {   
                            foreach ($item as $key => $value)
                            { 
                                if($key != 'id' and $key != 'post_id')
                                {  
                                    $this->db->set($key, $value);               
                                } 
                                elseif ($key == 'post_id') 
                                {
                                    $this->db->set('post_id', $id_notif);    
                                }
                            } 

                            $this->db->insert('notification_system_lang'); 
                        }   
                    } 
                } 
            } 

            $this->alertSuccess('The survey successfully copied!', true);
        }
    }
 
    public function addInterview()
    {   

        $table_translate = 'interview_lang';
        $table           = 'interview';

        /**
        * Хрянят данные только после сохранения на первом этапе. 
        * В случае если гет параметр будет отсутствовать на след. этапах
        * Пользователь возвращается на первый шаг и все начинается с начало.
        * @var $id_interview
        * @var $iwIdParam
        */
        $id_interview   = !empty($_GET['iw_id']) ? $_GET['iw_id'] : '';
        $iwIdParam      = !empty($id_interview) ? '&iw_id='.$id_interview : '';
        $beginInterview = !empty($id_interview) ? checkBeginInterview($id_interview) : false;

        /**
        * Массив с выбранными языками для опроса
        */
        $acceptLangs = getInterviewLangArr($id_interview);
         
        /**
        * Этапы добавления опроса
        */
        $data['steps'] = $this->getSteps($id_interview); 
            
        if (isPost()) 
        {  

            if (empty($_POST['current_step']) or !array_key_exists($_POST['current_step'], $data['steps'])) 
            {
                $this->alertError('Server error'); 
            }

            $current_step = intval($_POST['current_step']);
            $id_interview = !empty($_POST['iw_id']) ? intval($_POST['iw_id']) : ''; 

            if ($current_step != '3' && $beginInterview == true) 
            {
                $this->alertError(); 
            }

            if ($current_step == '1') 
            {

                /**
                * Сохранение языков опроса
                */ 
                if (empty($_POST['langs'])) 
                {
                    $this->alertError('Select the language (\'s) for interview'); 
                }
  
                if (!empty($id_interview)) 
                {
                    $this->db->where('id_interview', $id_interview)->delete('interview_select_lang');  
                }
                else
                {
                    $this->db->insert('interview', array('delete' => '0'));
                    $id_interview = $this->db->insert_id();
                }  

                foreach ($_POST['langs'] as $key => $value) {
                    $this->db->insert('interview_select_lang', array('id_interview' => $id_interview, 'id_lang' => $value));  
                }

                $this->nextStep(2, $id_interview);

            } 
            elseif ($current_step == '2' && !empty($id_interview)) 
            {

                /**
                * Сохранение основных данных опроса
                */ 

                if (empty($_POST['iw_id'])) {
                    $this->alertError();   
                }
 

                /**
                * Массив с обязательными полями 
                */ 
                $reqFields     = array('name');
                $checkReqLang = checkReqLang(getInterviewLangArr($id_interview), $reqFields, $_POST); 
 
                if (empty($checkReqLang) or empty($_POST['id_project']) or empty($_POST['status']) or empty($_POST['date_send_welcome']) or empty($_POST['date_start']) or empty($_POST['date_end'])) {
                    $this->alertError(alert('required_fields'));   
                } 

                if (AccessProject($_POST['id_project']) == false) {
                    $this->alertError(); 
                }

                if (isset($_FILES['image']['size']) && !empty($_FILES['image']['size'])) 
                { 
                    $config = array(
                        'upload_path' => 'public/image/interview',
                        'allowed_types' => 'gif|jpg|jpeg|png',
                        'overwrite' => false,
                        'max_size' => '2048',
                        'remove_spaces' => true,
                        'encrypt_name' => true
                    );

                    $upload = $this->doUpload('image', $config);
                    if ($upload['response'] !== TRUE)
                    {
                        $this->alertError($upload['response']);  
                    } 
                    else 
                    {
                        $image = $upload['image'];
                    }
                }
  
                $config = array(
                        'post'     => $_POST,
                        'fields'   =>array('name', 'description', 'welcome_text', 'info_text'),
                        'lang_arr' => getInterviewLangArr($id_interview),
                        'db_table' => $table_translate,
                        'post_id'  => $id_interview
                    ); 

                insertDataLang($config);

                if (!empty($image)) 
                {
                    $post['image']         = $image; 
                } 

                $post['id_project']        = intval($_POST['id_project']); 
                $post['status']            = $_POST['status'];
                $post['date_send_welcome'] = !empty($_POST['date_send_welcome']) ? datetotime($_POST['date_send_welcome'], 'DD.MM.YYYY') : '';
                $post['date_start']        = !empty($_POST['date_start']) ? datetotime($_POST['date_start'], 'DD.MM.YYYY') : '';
                $post['date_end']          = !empty($_POST['date_end']) ? datetotime($_POST['date_end'], 'DD.MM.YYYY') : '';

                $this->db->where('id', $id_interview)->update($table, $post);  
                $this->nextStep(3, $id_interview); 
            } 
            elseif ($current_step == '3' && !empty($id_interview)) 
            {

                /**
                * Сохранение системы уведомления опроса
                */  
 
                //Удаление предыдущих уведомлений
                $langIdIds = $this->db->where('parent_id', $id_interview)->get('notification_system')->result_array();
                foreach ($langIdIds as $item) 
                {
                    $this->db->where('post_id', $item['id'])->where('delete', '0')->delete('notification_system_lang');
                }
                $this->db->where('parent_id', $id_interview)->where('delete', '0')->delete('notification_system');

                if (isset($_POST['notify_status'])) 
                {  
                    $dataArray = sortValue($_POST['notify_text']);
                   
                    foreach ($dataArray as $key => $value) 
                    {

                        // Распечатай массив что бы было понятней как я сохраняю данные 
   
                        $this->db->insert('notification_system', array(
                                                                 'parent_id' => $id_interview,
                                                                 'date'      => !empty($_POST['notify_date'][$key]) ? datetotime($_POST['notify_date'][$key], 'DD.MM.YYYY') : '',
                                                                 'status'    => $_POST['notify_status'][$key] 
                                                                )
                                         );

                        $post_id = $this->db->insert_id();

                        /**
                        * Сохранения перевода на языках выбранных на пером этапе
                        */
                        foreach ($value as $l_key => $val) {
                            $id_lang = array_search($l_key, getInterviewLangArr($id_interview));
                            $this->db->insert('notification_system_lang', array(
                                                                            'post_id'  => $post_id,
                                                                            'text' => $val,
                                                                            'id_lang'  => $id_lang 
                                                                          )
                                             ); 
                        }  
                    }
                }

                $this->nextStep(4, $id_interview); 
            }
            elseif ($current_step == '4' && !empty($id_interview)) 
            {

                /**
                * Массив с обязательными полями 
                */ 
                $reqFields     = array('name');
                $checkReqLang = checkReqLang(getInterviewLangArr($id_interview), $reqFields, $_POST);
                if (empty($checkReqLang)) 
                {
                    $this->alertError(alert('required_fields')); 
                }
 
                /**
                * Сохранение Главы
                */
                $post['id_interview'] = $id_interview;    
                $this->db->insert('chapter', $post);
                $id_chapter = $this->db->insert_id(); 

                $config = array(
                        'post'     => $_POST,
                        'fields'   =>array('name', 'description', 'welcome_text', 'info_text'),
                        'lang_arr' => getInterviewLangArr($id_interview),
                        'db_table' => 'chapter_lang',
                        'post_id'  => $id_chapter
                    ); 

                insertDataLang($config); 

                $this->nextStep(4, $id_interview); 
            }
        }
        else
        { 

            if (empty($_GET['step']) or !array_key_exists($_GET['step'], $data['steps'])) 
            {
                header('Location: /cp/interview/');
            }
            else if (!empty($_GET['step']) && $_GET['step'] > 1 && empty($id_interview) ) 
            {
                header('Location: /cp/interview/add/?step=1');
            }
  
            $current_step                = intval($_GET['step']);   
              
            /**
            * Данные передоваемые в вид
            */ 
            $data['crumb2']              = 'Add';
            $data['current_step']        = $_GET['step'];  
            $data['interview']           = !empty($id_interview) ? $this->admin_model->getInterview($id_interview) : array(); 
            $data['projects']            = map_tree($this->admin_model->getProjects());
            $data['langs']               = $acceptLangs;
            $data['interview_status']    = $this->admin_model->getItems('interview_status'); 
            $data['notifications']       = !empty($id_interview) ? $this->admin_model->getInterviewNotifications($id_interview, $acceptLangs) : '';
            $data['notification_status'] = $this->admin_model->getItems('notification_status');
            $data['db_table']            = $table;
            $data['chapter']             = $this->admin_model->getChapter($id_interview, $acceptLangs);
            $data['def_lang']            = getDefLang($acceptLangs);
  
            $this->admin('private/interview/add', $data, '');
        } 
    }

    function getSteps($id_interview){

        $id_interview = !empty($_GET['iw_id']) ? $_GET['iw_id'] : '';
        $iwIdParam    = !empty($id_interview) ? '&iw_id='.$id_interview : ''; 
          
        $steps = array(
                    '1' => array(
                            'name'     => 'Select Language',
                            'url'      => '?step=1'.$iwIdParam,
                            'access'   => true 
                        ),

                    '2' => array(
                            'name'     => 'General Info',
                            'url'      => '?step=2'.$iwIdParam,
                            'access'   => false  
                        ),

                    '3' => array(
                            'name'     => 'Notification System',
                            'url'      => '?step=3'.$iwIdParam ,
                            'access'   => false 
                        ),

                    '4' => array(
                            'name'     => 'Chapter Survey',
                            'url'      => '?step=4'.$iwIdParam,
                            'access'   => false  
                        ) 
                );

        if (empty($id_interview)) 
        {
            return $steps;
        }

        $beginInterview = checkBeginInterview($id_interview);

        $getInterview = $this->admin_model->getInterview($id_interview);  
        foreach ($steps as $key => $value) 
        {

            if ($beginInterview == true && $key == '1') 
            {
                $steps[$key]['access'] = false;
            }

            if ($key == '2') {
                $acceptLangs = getInterviewLangArr($id_interview);
                if (!empty($acceptLangs)) 
                {
                    $steps[$key]['access'] = true;
                }
                else
                {
                    break;
                }

                if ($beginInterview == true) 
                {
                    $steps[$key]['access'] = false;
                }
            }elseif ($key == '3') {
                $break = false;
                $req = array( 
                        'date_send_welcome', 
                        'date_start',
                        'date_end',
                        'status',
                        'id_project'
                    );

                foreach ($req as $req_value) 
                { 
                    if (!empty($getInterview[$req_value])) 
                    {
                        $steps[$key]['access'] = true;
                    } 
                    else
                    {
                        $steps[$key]['access'] = false;
                        $break = true;
                        break;
                    } 
                }

                if (!empty($break)) 
                { 
                    break;
                } 

            }elseif ($key == '4') 
            {

                if ($this->db->where('parent_id', $id_interview)->where('delete', '0')->get('notification_system')->num_rows() > 0) 
                {
                    $steps[$key]['access'] = true;
                }
                else
                {
                    break;
                }

                if ($beginInterview == true) 
                {
                    $steps[$key]['access'] = false;
                }
            }
        }

        $current_step = $_GET['step'];
        if (empty($steps[$current_step]['access']) && $beginInterview == false) 
        {
            header("Location: /cp/interview/add/?step=".($current_step-1)."&iw_id={$id_interview}");
            exit();
        } 
        elseif(empty($steps[$current_step]['access']) && $beginInterview == true)
        {
            header("Location: /cp/interview/add/?step=3&iw_id={$id_interview}");
            exit();
        }

        return $steps;
    }

    public function question()
    {
        $id_chapter      = $this->uri->segment('3');
        $id              = $this->uri->segment('4');
        $id_interview    = intval(@$_GET['iw_id']);
        $table           = 'chapter_question';
        $table_translate = 'chapter_question_lang';
        $acceptLangs     = getInterviewLangArr($id_interview);
 
        /**
        * Суфикс языка. Пример: ru
        * Выбирается один язык из массива с выбранными языками для опроса
        *
        * @var $def_lang 
        */
        $def_lang        = getDefLang($acceptLangs);

        if (isPost()) 
        {  

            if (empty($id_chapter)) 
            {
                $this->alertError(0);
            }

            if (empty($_POST['question_type']) or empty($_POST['id_interview'])) 
            {
                $this->alertError(alert('required_fields'));
            }

            if ($_POST['question_type'] == '2' && empty($_POST['max_choices'])) {
                $this->alertError('Fill `Max choices` field!');
            } 

            if (empty($id)) 
            {

                /* Insert */  
 
                if ($_POST['question_type'] == '2' && 
                    $_POST['max_choices'] > (!empty($_POST['choice']) ? count($_POST['choice']) : 0) ) {
                    $this->alertError('Max choices value can not be greater than the number of options');
                }

                $question_type = $_POST['question_type'];
                $id_interview  = $_POST['id_interview'];
                $required      = !empty($_POST['required']) ? '1' : '0'; 
                $max_choices   = intval($_POST['max_choices']);

                $post['id_chapter']  = $id_chapter;
                $post['type']        = $question_type;
                $post['required']    = $required;
                $post['max_choices'] = $max_choices;

                $this->db->insert('chapter_question', $post);
                $id = $this->db->insert_id();
   
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('question'),
                        'lang_arr' => getInterviewLangArr($id_interview),
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config); 

                if ($question_type === '3') 
                {
                    $this->db->where('id_question', $id)->update('choice', array('delete' => '1'));
                }
              
                /**
                * Добавления списка множественного выбора
                */
                if (isset($_POST['choice']) && $question_type != '3') 
                { 
                    /**
                    * Сортирует полученные даные для более удобного сохранения перевода
                    * helpers/mine_helper.php
                    *
                    * @var $dataArray : array()
                    */  
                    $dataArray = sortValue($_POST['choice']);
                    foreach ($dataArray as $id_key => $value) 
                    { 
                        $this->db->insert('choice', array( 
                                                        'id_question' => $id 
                                                    )
                                         );

                        $post_id = $this->db->insert_id();

                        /**
                        * Сохранения перевод множественного выбора
                        */
                        foreach ($value as $l_key => $val) 
                        {  
                            $id_lang = array_search($l_key, getInterviewLangArr($id_interview)); 
                            $this->db->insert('choice_lang', array(
                                                            'post_id'  => $post_id, 
                                                            'id_lang'  => $id_lang,
                                                            'name'    => $val
                                                            )
                                            ); 
                        }
 
                    }
                } 
                  
                $this->alertSuccess(false, true);

            }else{

                /* Edit */
 
                $question_type = $_POST['question_type'];
                $id_interview  = $_POST['id_interview'];
                $required      = !empty($_POST['required']) ? '1' : '0';
                $max_choices   = intval($_POST['max_choices']);
 
                /**
                * Обнавляем Вопроса
                */
                $config = array(
                        'post'     => $_POST,
                        'fields'   => array('question'),
                        'lang_arr' => getInterviewLangArr($id_interview),
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config); 

                if ($question_type === '3') 
                { 
                    $this->db->where('id_question', $id)->update('choice', array('delete' => '1'));
                } 

                $post['type']        = $question_type;
                $post['required']    = $required;
                $post['max_choices'] = $max_choices;
                $this->db->where('id', $id)->update($table, $post);

                /**
                * Обновлния списка множественного выбора
                */
                if (isset($_POST['update_choice']) && $question_type != '3') 
                { 
                    /**
                    * В случае если выбрали множественный выбор
                    */ 
                    $dataArray = sortValue($_POST['update_choice']);  
                    foreach ($dataArray as $id_key => $value) 
                    {
                          
                        /**
                        * Сохранения перевод множественного выбора
                        */ 
                        foreach ($value as $l_key => $row) 
                        {
                            $id_lang = array_search($l_key, getInterviewLangArr($id_interview));   
                            $this->db->where('id_lang', $id_lang)
                                     ->where('post_id', $id_key)->update('choice_lang', array( 
                                                                         'name'    => $row
                                                                        )
                                            );
                        }
                    }
                }
                  
                /**
                * Добавления списка множественного выбора
                */
                if (isset($_POST['choice']) && $question_type != '3') 
                {
   
                    /**
                    * В случае если выбрали множественный выбор
                    */  
                    $dataArray = sortValue($_POST['choice']);
                    foreach ($dataArray as $id_key => $value) 
                    { 
                        $this->db->insert('choice', array( 
                                                        'id_question' => $id 
                                                    )
                                         );

                        $post_id = $this->db->insert_id();

                        /**
                        * Сохранения перевода множественного выбора
                        */
                        foreach ($value as $l_key => $val) 
                        {  
                            $id_lang = array_search($l_key, getInterviewLangArr($id_interview)); 
                            $this->db->insert('choice_lang', array(
                                                            'post_id'  => $post_id, 
                                                            'id_lang'  => $id_lang,
                                                            'name'    => $val
                                                            )
                                            ); 
                        } 
                    }
                } 

                $this->alertSuccess(false, true);
            }

        }
        else
        {
 
            if (empty($id_chapter) or empty($id_interview) or checkBeginInterview($id_interview) == true) 
            {
                admin_404(); 
            }
     
            if (!empty($id)) 
            { 
                $getQuestions = $this->admin_model->getEdit($id, $table, true);  
                $data         = getTranslateArray($getQuestions, array('question'), $table_translate, false, $acceptLangs); 
            }
            else{$data = '';}

            $getChapter = $this->admin_model->getEdit($id_chapter, 'chapter', true); 
            $data = array(
                'data'            => $data,  
                'db_table'        => $table,
                'table_translate' => $table_translate,
                'method'          => 'question',
                'interview'       => $this->admin_model->getInterview($id_interview),
                'chapter'         => getTranslateArray($getChapter, array('name'), 'chapter_lang', false),
                'langs'           => $acceptLangs,
                'def_lang'        => $def_lang,
                'id_chapter'      => $id,
                'id_interview'    => $id_interview
            ); 

            /**
            * Хлебные крошки
            */ 
            if (!empty($id)) 
            {
                $crumb = '<li> 
                            <a href="javascript:;" style="text-decoration:none; cursor:pointer;">'.$data['data']["question_{$def_lang}"].'</a>  
                          </li>';
                $arrow = '<i class="fa fa-angle-right"></i>';
            }
            else{ $crumb = ''; $arrow = '';}
     
            $data['breadcrumbs'] = '<li>
                                        <i class="fa fa-home"></i>
                                        <a href="/cp/menu/">Home</a>
                                        <i class="fa fa-angle-right"></i> 
                                    </li>

                                    <li>
                                        <a href="/cp/interview/add/?step=4&iw_id='.$data['interview']['id'].'" style="text-decoration:none; cursor:pointer;">'.$data['interview']["name_$def_lang"].'</a>
                                        <i class="fa fa-angle-right"></i>  
                                    </li>  
                                    <li> 
                                        <a href="/cp/edit-chapter/'.$data['chapter']['id'].'/'.$id_interview.'">'.$data['chapter']["name_{$def_lang}"].'</a>  
                                        '.$arrow.'
                                    </li>
                                     '.$crumb;  

            $this->admin('private/interview/question', $data, '');
        }
 
    } 

    public function edit_chapter()
    {
        $id              = intval($this->uri->segment('3'));
        $id_interview    = intval($this->uri->segment('4'));
        $table           = 'chapter';
        $table_translate = 'chapter_lang';
        $acceptLangs     = getInterviewLangArr($id_interview);
 
        /**
        * Язык в окончании. Пример: ru
        * Выбирается один из массива с доступными языками для опроса
        *
        * @var $def_lang 
        */
        $def_lang        = getDefLang($acceptLangs);

        if (isPost()) {   
              
            if (!empty($id)) 
            {   
 
                /* Edit */  

                if (empty($id_interview) or empty($_POST["name_{$def_lang}"])) 
                {
                    $this->alertError(alert('required_fields'));
                }  

                $config = array(
                        'post'     => $_POST,
                        'fields'   =>array('name'),
                        'lang_arr' => $acceptLangs,
                        'db_table' => $table_translate,
                        'post_id'  => $id
                    ); 

                insertDataLang($config);  

                $this->alertSuccess(false, true); 
            }
            
        }
        else
        {  

            if (empty($id) or empty($id_interview) or checkBeginInterview($id_interview) == true)
            { 
                admin_404(); 
            }
 
            $getInterview = $this->admin_model->getInterview($id_interview);

            $data = array( 
                'db_table'        => $table,
                'table_translate' => $table_translate,
                'method'          => 'edit-chapter', 
                'chapter'         => getTranslateArray($this->admin_model->getEdit($id, 'chapter', true), array('name'), 'chapter_lang', false),
                'langs'           => $acceptLangs,
                'def_lang'        => $def_lang,
                'id_chapter'      => $id,
                'id_interview'    => $id_interview
            ); 
              
            $data['breadcrumbs'] = '<li>
                                        <i class="fa fa-home"></i>
                                        <a href="/cp/menu/">Home</a>
                                        <i class="fa fa-angle-right"></i> 
                                    </li>

                                    <li>
                                        <a href="/cp/interview/add/?step=4&iw_id='.$getInterview['id'].'" style="text-decoration:none; cursor:pointer;">'.$getInterview["name_$def_lang"].'</a>
                                        <i class="fa fa-angle-right"></i>  
                                    </li>  

                                    <li> 
                                        <a href="javascript:;" style="text-decoration:none; cursor:pointer;">'.$data['chapter']["name_$def_lang"].'</a>  
                                    </li>
                                     '; 
            
            $this->admin('private/interview/edit_chapter', $data, '');
        } 
    } 

    private function nextStep($step, $id)
    {
        $url = "/cp/interview/add/?step={$step}&iw_id=".$id;  
        echo json_encode(array('msg' => '', 'redirect' => $url));
        exit();
    }
 

    public function constants() 
    { 
        if (isPost()) 
        {
            $data = array();
            while (list($key, $val) = each($_POST['text'])) 
            {
                $val = htmlspecialchars(trim($val));
                $data[] = array(
                    'id'=>$key,
                    'value'=>$val,
                ); 
                
            }

            $this->db->update_batch('constants_value', $data, 'id'); 
            $this->alertSuccess(false, true); 
        }

        $data = array(
            'text' => $this->admin_model->getConstants()
        );
        
        $this->admin('private/constants', $data, '');
    }

    public function edit_user()
    {
        $id = intval($this->uri->segment('3'));

        if (empty($id)) admin_404();

        if (isPost()) 
        {
            $login   = $this->input->post('login'); 
            $id_role = intval($_POST['id_role']);

            if (empty($login) || empty($id_role)) {
                $this->alertError('Заполните все поля');  
            } 
 
            if (empty($_POST['privilege'])) {
                $this->alertError('Set the user privileges!');  
            }
  
            /**
            * Если тип пользователя == администратор
            */
            if ($id_role == '2') 
            {
                if (empty($_POST['projects'])) {
                    $this->alertError('Select projects to which the user has access!');  
                }
            }else{
                $this->db->where('id_user', $id)->update('user_projects', array('delete' => '1'));
            }  
  
            $check_unique = $this->db->where('delete', '0')->where('id <>', $id)->where('login', $login)->get('admin_users');
            if ($check_unique->num_rows() > 1) 
            {
                $this->alertError('User with this login already exists');  
            }
  
            $sql = $this->db->where('id', $id)->update('admin_users', array(
                'login'                => $login, 
                'id_role'              => $id_role 
            )); 

            if ($id_role == '2' && !empty($_POST['projects'])){
                $this->db->where('id_user', $id)->where('delete', '0')->delete('user_projects');
                foreach ($_POST['projects'] as $key => $value) 
                {
                    $this->db->insert('user_projects', array('id_user' => $id, 'id_project' => $key));
                } 
            }
            
            if (!empty($_POST['privilege'])) {
                $this->db->where('id_user', $id)->delete('user_privileges');
                foreach ($_POST['privilege'] as $key => $value) {
                    $this->db->insert('user_privileges', 
                                                        array('id_user' => $id, 
                                                             'id_role' => $id_role, 
                                                             'id_privilege' => $key
                                                        ));
                }
            } 
 
            $this->alertSuccess(false, true);
        } 

        $breadcrumbs = '<li>
                            <i class="fa fa-home"></i>
                            <a href="/cp/menu/">Home</a>
                            <i class="fa fa-angle-right"></i> 
                        </li>
                        <li> 
                            <a href="/cp/settings?p=users">Users</a> 
                            <i class="fa fa-angle-right"></i> 
                        </li>
                         <li>
                            <a href="javascript:;" style="text-decoration:none; cursor:pointer;">Edit</a> 
                         </li>
                         ';

        $data = array(
            'data'        => $this->admin_model->getEdit($id, 'admin_users'), 
            'privilege'   => $this->admin_model->getPrivilege(),
            'role'        => $this->admin_model->getItems('role'),
            'projects'    => map_tree($this->admin_model->getProjects()),
            'breadcrumbs' => $breadcrumbs,
            'method'      =>'edit-user'
        ); 

        if (!empty($data['data']) && $data['data']['id_role'] == '2' && Can(array('EDIT_ADMIN')) === false) {
            header('Location:/cp/settings/?p=users');
        }

        if ($id == getAdminUser('id')) {
            admin_404();
        }
        
        $this->admin('private/settings/edit_user', $data, '');
    }
 
    public function settings()
    { 
        $data = array(
                'users'     => $this->admin_model->getUsers(),
                'userdata'  => getUserdata($this->user_id),
                'role'      => $this->admin_model->getItems('role'),
                'projects'  => map_tree($this->admin_model->getProjects()),
                'settings'  => $this->admin_model->getItems('settings', true, false, false, false),
                'privilege' => $this->admin_model->getPrivilege()
            );   

        $get = !empty($_GET['p']) ? clear($_GET['p']) : '';
  
        switch ($get) 
        {
            case 'users':
                $view = 'users';
                break;

            case 'privilege':
                $view = 'privilege';
                break;

            case 'settings':
                $view = 'settings';
                break;
            
            default:
                $view = 'account';
                break;
        } 

        $data['view'] = $view;

        $this->admin('private/settings', $data, '');
    }

    public function saveSettings()
    {
        if (isPost()) 
        {
            if (!empty($_POST['settings'])) 
            {
                foreach ($_POST['settings'] as $key => $value) 
                {
                    $this->db->where('id', $key)->update('settings', array('value' => $value));
                }
                $this->alertSuccess(false, true); 
            }
        }
    }

    public function editRole()
    {
        if (isPost()) {
            foreach ($_POST['role'] as $key => $value) 
            {
                $this->db->where('id', $key)->update('role', array('name'=>$value));
            }  
            $this->alertSuccess(false, true); 
        }
    } 

    public function editPersonalInfo() 
    { 
        if (isPost()) { 

            $password         = clear($_POST['password']);
            $repeat_password  = clear($_POST['repeat_password']);
            $current_password = clear($_POST['current_password']);

            if (empty($password) || empty($repeat_password) || empty($current_password)) {
                $this->alertError(alert('required_fields'));  
            }

            /**
            * Проверка текущего пароля
            */ 
            $checkCurentPassword = $this->db->where('delete', '0')->where('password', md5($current_password))->get('admin_users')->row_array();

            if (empty($checkCurentPassword)) {
                $this->alertError('Current password is wrong!');
            }   

            if ($password != $repeat_password){
                $this->alertError('Passwords do not match'); 
            } 

            $checkPassword = checkPassword($password);
            if ($checkPassword !== true) 
            {
                $this->alertError($checkPassword);
            } 
  
            $sql = $this->db->where('id', $this->user_id)->update('admin_users', array(
                'password' => md5($password)
            ));
 
            $this->alertSuccess(false, true); 
        }
    }

    public function addNewUser() {
        if (isPost()) { 
 
            if (empty($_POST['password']) || empty($_POST['repeat_password']) || empty($_POST['login']) || empty($_POST['id_role'])) {
                $this->alertError(alert('required_fields'));  
            } 

            $login           = $_POST['login'];
            $password        = $_POST['password'];
            $id_role         = intval($_POST['id_role']);
            $repeat_password = $_POST['repeat_password'];
            $parent_user     = getAdminUser('id');

            if ($password != $repeat_password){
                $this->alertError('Passwords do not match'); 
            } 

            if (empty($_POST['privilege'])) {
                $this->alertError('Set the user privileges!');  
            }

            $checkPassword = checkPassword($password);
            if ($checkPassword !== true) 
            {
                $this->alertError($checkPassword);
            } 
   
            /**
            * Если тип пользователя == администратор
            */
            if ($id_role == '2') 
            {
                if (empty($_POST['projects'])) {
                    $this->alertError('Select projects to which the user has access!');  
                }
            }  
  
            $check_unique    = $this->db->where('delete', '0')->where('login', $login)->get('admin_users');
            if ($check_unique->num_rows() > 0) 
            {
                $this->alertError('User with this login already exists');  
            }
  
            $sql = $this->db->insert('admin_users', array(
                'login'                => $login,
                'password'             => md5($password),
                'id_role'              => $id_role, 
                'parent_id'            => $parent_user
            ));

            $id = $this->db->insert_id(); 

            if ($id_role == '2' && !empty($_POST['projects'])){
                foreach ($_POST['projects'] as $key => $value) 
                {
                    $this->db->insert('user_projects', array('id_user' => $id, 'id_project' => $key));
                } 
            }

            if (!empty($_POST['privilege'])) {
                foreach ($_POST['privilege'] as $key => $value) {
                    $this->db->insert('user_privileges', 
                                                        array('id_user' => $id, 
                                                             'id_role' => $id_role, 
                                                             'id_privilege' => $key
                                                        ));
                }
            }

            $this->alertSuccess(false, true); 
        }
    }  

    public function addRole(){
        if (isPost()) {
            $role = $_POST['role'];
            $this->db->insert('role', array('name' => $role));
            $this->alertSuccess(false, true); 
        } 
    }

    public function editPriveleges(){
        if (isPost()) { 
            $this->db->where('id >', '0')->delete('user_privileges'); 
            foreach ($_POST as $key => $value) { 
                foreach ($value as $item) {  
                    $this->db->insert('user_privileges', array('id_role' => $key, 'id_privilege' => $item));
                } 
            } 
            $this->alertSuccess(false, true); 
        }
    }

    public function changeUsrType(){
        if (isPost()) {  
            $this->db->where('id', intval($_POST['id']))->update('admin_users', array('id_role' => intval($_POST['type'])));
            $this->alertSuccess(false, true);   
        }
    }

    private function checkRuleUrl(){
        if (!isset($_POST['url'])) {
            return;
        }

        if (empty($_POST['url'])) {
            $this->alertError('Заполните поле URL');
        }

        if (stripos($_POST['url'], ' ')) {
            $this->alertError('URL должен быть без пробелов');    
        }  
    }

    public function sendBackRequest(){
        if (isPost()) {
            $message = nl2br($_POST['message']);
            $theme = $_POST['theme'];
            $email = $_POST['email'];
            send_mail($email, $theme, $message);
            $this->alertSuccess(false, true); 
        }
    }

    public function doUpload($input, $config, $_resize = FALSE) {
        if ($_FILES[$input]['error'] == 0) {
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($input)) {
                return array(
                    'response' => $this->upload->display_errors()
                );
            } else {
                $data = $this->upload->data('file_name');
                return array(
                    'response' => TRUE,
                    'image' => $data['raw_name'] . $data['file_ext']
                );
            }
        } else {
            return false;
        }
    } 

    private function uploadBase64($base64, $path){
        $data = $base64;
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));   
        $file = uniqid() . '.png'; 
        $path = $path.'/'.$file;
        $success = file_put_contents($path, $data);
        return $file;
    }

    public function uploadMultiFile($files, $array_name, $more_config = FALSE, $config_thumbs = FALSE, $return_type, $delimiter = '', $array = array()) {
        if (is_array($more_config))
            extract($more_config);
        if (is_array($config_thumbs))
            extract($config_thumbs);

        $config['upload_path']   = $path ? $path : $path = 'public/global_public_img/default';
        $config['allowed_types'] = 'jpg|png|gif';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $count = count($files[$array_name]['name']); 

        $temp_files = $_FILES;
        for ($i = 0; $i <= $count - 1; $i++) {
            if (isset($temp_files[$array_name]['name'][$i])) {
                $_FILES[$array_name] = array(
                    'name' => $temp_files[$array_name]['name'][$i],
                    'type' => $temp_files[$array_name]['type'][$i],
                    'tmp_name' => $temp_files[$array_name]['tmp_name'][$i],
                    'error' => $temp_files[$array_name]['error'][$i],
                    'size' => $temp_files[$array_name]['size'][$i]
                );

                if (!$this->upload->do_upload($array_name)) {
                    return array(
                        'error' => true,
                        'msg' => $this->upload->display_errors()
                    );
                }
                 
                $tmp_data = $this->upload->data();

                switch ($return_type) {
                    case 'array':
                        $array[] = $tmp_data['file_name'];
                        break;

                    case 'delimiter':
                        $delimiter .= $tmp_data['file_name'] . "|";
                        break;    
                    
                    default:
                        exit();
                        break;
                }
  
                if (is_array($config_thumbs))
                    newthumbs($tmp_data['file_name'], $path, $width, $height, $version, $zc);
            }
        }

        return array(
            'error' => false,
            'msg' => empty($array) ? $delimiter : $array
        );
    } 
 
    public function viewElement()
    { 
        $id    = $this->input->post('id');
        $table = $this->input->post('table'); 
        $row = !empty($_POST['row']) ? $_POST['row'] : 'view';
         
        $query = $this->db->select("{$row}")->where('id', $id)->get($table)->row();

        if ($query->$row == 1) { 
            $data = array(
                "{$row}" => '0'
            ); 
            $this->db->where('id', $id)->update($table, $data);
            $this->alertSuccess();
        } else {
            $data = array(
                "{$row}" => '1'
            );
            $this->db->where('id', $id)->update($table, $data); 
            $this->alertSuccess();
        }
    }

    public function sortMultiLevel(){   
        $arr = $_POST['arr']; 
        $table =  $_POST['table'];  
        foreach ($arr as $key => $value) { 
           $data[] = $value; 
           $this->sort($data, 0, $table);  
        }    
        $this->alertSuccess();
    } 

    public function sort($arr, $parent = 0, $table){
        $i     = 1;
        foreach ($arr as $item) { 
            $this->db->where('id', $item['id'])->update($table, array(
                                                            'parent_id' => $parent,
                                                            'page_up'   => $i 
                                                ));  

            if (!empty($item['children'])) { 
                $this->sort($item['children'], $item['id'], $table);
            }  

            $i++;
        }   
    }

    public function sortElement() { 
        $i     = 1;
        $table = $_POST['table']; 
        foreach ($_POST['arr'] as $value) { 
            $this->db->where('id', $value)->update($table, array(
                'page_up' => $i
            ));
            $i++;
        }
        $this->alertSuccess();
    }
  
    public function viewMenuFooter() {
        $id    = (int) $this->input->post('id');
        $table = $this->input->post('table');
        $this->db->select('view_footer');
        $this->db->where('id', $id);
        $query = $this->db->get($table)->row();
        if ($query->view_footer == 1) {
            $data = array(
                'view_footer' => '0'
            );
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            $this->alertSuccess();
        } else {
            $data = array(
                'view_footer' => '1'
            );
            $this->db->where('id', $id);
            $this->db->update($table, $data);
            $this->alertSuccess();
        }
    }
 
    public function nestableElement() {  
        $i     = 1;
        $table = $this->input->post('table');
        foreach ($this->input->post('arr') as $value) { 
            $this->db->where('id', $value['id'])->update($table, array(
                'page_up' => $i
            ));
            $i++;
        }
        $this->alertSuccess();
    }

    public function changeStatus(){
        $this->db->where('id', intval($_POST['id']))->update($_POST['table'], array('status'=>$_POST['status']));
        $this->alertSuccess();
    }

    public function deleteElement() { 
        $id    = (int) $this->input->post('id');
        $table = $this->input->post('table');

        if ($table == 'admin_users' ) 
        {
            $getuserRole = $this->db->where('id', $id)->get('admin_users')->row_array();
            if ($getuserRole == '2' && Can(array('TRASH_ADMIN')) === false) 
            {
                $this->alertError();
            } 
        } 
        
        $sql = $this->db->where('id', $id)->update($table, array('delete' => '1'));  
        $this->alertSuccess();
    }

    public function deleteImageElement() {
        $id    = (int) $this->input->post('id');
        $table = $this->input->post('table');
        $name = $this->input->post('name'); 
        $del_img = !empty($name) ? $name : 'image';
        $sql   = $this->db->where('id', $id)->update($table, array(
            $del_img => ''
        ));  
        $this->alertSuccess();
    } 
 
 
    private function pageUp($db) {
        $sql    = $this->db->select_max('page_up')->get($db)->row_array();
        $result = $sql['page_up'];
        $return = empty($result) ? '0' : $result + '1';
        return $return;
    }

    function changePosition(){
        $table = $_POST['table']; 
        $id = $_POST['id'];
        $page_up = $_POST['page_up'];
        $this->db->where('id', $id)->update($table, array('page_up' => $page_up));
        return $this->alertSuccess();
    }

    private function alertSuccess($msg = false, $session=false){ 

        if (empty($msg)) {
            $msg = alert('saved_data');
        }
          
        if ($session == true) {
            $_SESSION['msg'] = '<div class="alert alert-success">'.$msg.'</div>';
        }
 
        echo json_encode(array('msg' => $msg));   
        exit();
    } 

    public function alertError($msg = 0, $session=false){ 
        if ($session == true) {
            $_SESSION['msg'] = '<div class="alert alert-danger">'.$msg.'</div>';
        }

        echo json_encode(array('msg' => "error", 'cause' => $msg));  
        exit();  
    } 

    public function display_404() { 
        $this->load->view('public/error', '', '');  
    }
  
}


