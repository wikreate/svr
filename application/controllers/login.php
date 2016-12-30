<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
  
    public function __construct() {
        parent::__construct();  
    }  

    public function log_in() {  
        if (isPost()) { 

            if (empty($_POST['login']) or empty($_POST['password'])) {
                showError('Fill required fields!', 'login');
            }

            $login    = clear($_POST['login']);
            $password = md5(clear($_POST['password']));
            
            $checkUserdata = $this->db->where('delete', '0')->where('login', $login)->where('password', $password)->limit('1')->get('admin_users')->row_array();

            if (empty($checkUserdata)) {
                showError('Incorrect login or password', 'login'); 
            } 

            if (empty($checkUserdata['active'])) {
                showError('Your account are disactivated', 'login');
            }
              
            /**
            * Привязываем сессию к аккаунту пользователя
            */
            $session_id = md5(microtime()); 
            
            /**
            * Проверяем если пароль был изменен в указанный период 
            */  

            $intervalTimestamp = $checkUserdata['last_update_password']+(var_interval_update_password*86400);
              
            if (time() >= $intervalTimestamp) {
                $_SESSION['admin_user']['token'] = $session_id;
                header('Location: /login?token='.$session_id.'&p=update_password');
                exit();
            } else{
                $_SESSION['admin_user']['session'] = $session_id;

                $this->db->where('id', $checkUserdata['id'])->update('admin_users', array('last_visit'=>time(), 'session_hash' => $session_id));

               showSuccess('You are logged in', 'cp/projects'); 
            } 
             
        } else{

            $page = !empty($_GET['p']) ? $_GET['p'] : '';
 
            if (!empty($_SESSION['admin_user']['session']) && getAdminUser('session_hash') == $_SESSION['admin_user']['session']) {
                redirect(base_url('cp/projects'), 'refresh');
            }  

            switch ($page) {
                case 'update_password':
                    if (empty($_GET['token']) or empty($_SESSION['admin_user']['token']) or $_GET['token'] !== $_SESSION['admin_user']['token']) {
                        redirect(base_url('login'), 'refresh');
                    }

                    $view = 'update_password';

                    break;
                
                default:
                    $view = 'login';
                    break;
            }

            $data['view'] = $view;
                
            $this->load->view('template/login_template', $data, '');
        }
    } 

    public function updatePassword(){ 
        if (isPost() && $_GET['token'] == $_SESSION['admin_user']['token']) {

            if (empty($_POST['password']) or empty($_POST['repeat_password']) or empty($_POST['old_password'])) {
                showError('Fill all fields!', 'login?token='.$_SESSION['admin_user']['token'].'&p=update_password'); 
            }

            $password         = clear($_POST['password']);
            $repeat_password  = clear($_POST['repeat_password']);
            $old_password     = clear($_POST['old_password']);

            $checkUserdata = $this->db->where('delete', '0')->where('password', md5($old_password))->limit('1')->get('admin_users')->row_array();

            $redirect = 'login?token='.$_SESSION['admin_user']['token'].'&p=update_password';

            if (empty($checkUserdata)) {
                showError('Incorrect old password', $redirect); 
            } 

            if (empty($checkUserdata['active'])) {
               showError('Your account are disactivated', 'login');
            }

            if ($password != $repeat_password){
                showError('Passwords do not match', $redirect);  
            } 

            if ($password == $old_password) {
                showError('Passwords must not be the same', $redirect);  
            }

            $checkPassword = checkPassword($password);
            if ($checkPassword !== true) 
            {
                showError($checkPassword, $redirect);
            } 

            $session_id = md5(microtime());

            $_SESSION['admin_user']['session'] = $session_id;

            $data = array(
                'last_visit'=>time(), 
                'last_update_password' => time(), 
                'password' => md5($password), 
                'session_hash' => $session_id
            );

            $this->db->where('id', $checkUserdata['id'])->update('admin_users', $data);

            showSuccess('You are logged in', 'cp/settings'); 

        }else{
            redirect(base_url('cp'), 'refresh');  
        }
    }
 
    public function logout() { 
        unset($_SESSION['admin_user']);  
        redirect(base_url('login'), 'refresh'); 
    }   
}


