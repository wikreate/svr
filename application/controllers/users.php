<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
   
    public function __construct() {
        parent::__construct();
        $this->load->model('users_model'); 
    }  

    public function facebookOuth(){ 

        require_once(realpath('public').'/lib/login/facebook/inc/facebook.php' );

        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {       

            //initialize facebook sdk
            $facebook = new Facebook(array(
                'appId' => FB_CLIENT_ID,
                'secret' => FB_CLIENT_SECRET,
            ));
            
            $fbuser = $facebook->getUser();
            
            if ($fbuser) { 
                $me = $facebook->api('/me');  
                $oauth_id = $facebook->getUser(); 
            }else{
                $fbuser = null;
            }
            
            // redirect user to facebook login page if empty data or fresh login requires
            if (!$fbuser){
                $loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>'http://nitro.loc/', false));
                header('Location: '.$loginUrl);
            }
            
            //user details
            $username = $me['name'];
            $email = $me['email'];
 
            //Check user id in our database 
            $getuserdata=$this->db->where('oauth_id', $oauth_id)->where('login_type', 'fb')->get('users')->row_array();
            if (!empty($getuserdata)) {
                $_SESSION['user']=$getuserdata;
            }else{
                $data=array(
                        'username'     =>$username,
                        'oauth_id'     =>$oauth_id,
                        'email'        =>$email,
                        'login_type'   =>'fb',
                        'register_date'=>time()
                    );

                $this->db->insert('users', $data);
                $id = $this->db->insert_id();

                $_SESSION['user']=getUserdata($id);
            }

            echo "Success";
            exit();
        } 
    } 

    public function fbChanelUrl(){
        $cache_expire = 60*60*24*365;
        header("Pragma: public");
        header("Cache-Control: max-age=".$cache_expire);
        header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
        echo '<script src="//connect.facebook.net/en_US/all.js"></script>';
    }

    public function vkOuth(){ 
        if (isAjax() && !empty($_POST['response'][0])) {
            $data=$_POST['response'][0];
           
            $username = $data['first_name'].' '.$data['last_name'];
            $oauth_id = $data['uid']; 
            $phone = @$data['home_phone']; 
            
            $getuserdata=$this->db->where('oauth_id', $oauth_id)->where('login_type', 'vk')->get('users')->row_array();
            if (!empty($getuserdata)) {
                $_SESSION['user']=$getuserdata;
            }else{
                $data=array(
                        'username'     =>$username,
                        'oauth_id'     =>$oauth_id, 
                        'phone'        => $phone,
                        'login_type'   =>'vk',
                        'register_date'=>time()
                    );

                $this->db->insert('users', $data);
                $id = $this->db->insert_id();

                $_SESSION['user']=getUserdata($id);
            }

            alertSuccess('Вы успешно вошли в систему', true);
        } 
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            if (empty($_POST['email']) or empty($_POST['password'])) alertError(REQUIRED_FIELDS);

            $email=clear($_POST['email']);
            $password=clear($_POST['password']);

            $getuserdata=$this->db->where('email', $email)->get('users')->row_array();
            if (!empty($getuserdata)) {
                $_SESSION['user']=$getuserdata;
            }

            alertError('Пользователя не существует');
        }
    }

    public function registration(){
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            exit(print_arr($_POST));
        }else{
            $this->home('public/users/registration', array(), '');
        } 
    } 

    public function logout(){
        unset($_SESSION['user']);
        header('Location:/');
    }
    
    public function display_404() { 
        $this->load->view('public/error', '', '');  
    } 
}


