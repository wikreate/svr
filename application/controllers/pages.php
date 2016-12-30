<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller { 

    private $chapter_num = 0;
   
    public function __construct() {
        parent::__construct();
        $this->load->model('pages_model'); 

        // if (empty($_GET['key_access'])) { 
        //     header('Location:'._current_url_lang(uri_string()).'?key_access='.$_SESSION['key_access']);
        // }   
    } 
    
    public function top_menu() { 
        $url2    = (!uri(2) ? '/' : clear(uri(2))); 
        $method  = ($url2 == '/' ? 'index' : $url2);
        $uri1    = uri(1);
  
        if ($uri1 == 'display_404') 
        {
            $this->display_404();
        }
        elseif (method_exists($this, $method)) 
        {
            $this->$method();
        } 
        else 
        {   
            $sql = $this->db->where('url', $url2)->get('menu')->row_array();   
            if (!empty($sql)) 
            { 
                $this->home('public/default', '', '');
            }
            else
            { 
                display_404();
            }
        }
    } 

    public function index(){    
        $this->home('public/home', '', '');
    }   

    public function faq(){

        $lang = $this->lang->lang();
        $id_cat = uri(4); 
 
        $per_page   = 10;
        $p          = clear(uri(5)); 
        $page = (isset($p)) ? intval(abs($p)) : 0;  
        if ($page == 0) {
            $page = 0;
        } else {
            $page = ($page - 1) * $per_page;
        }

        $numPage = !empty($p) ? intval(abs($p)) : 1;     
        $uri     = "/$lang/faq/cat/$id_cat/";  

        $count              = $this->pages_model->getFaq(false, false, $id_cat);
        $navigation         = get_navigation($numPage, count($count), $per_page);
        $data['navigation'] = $navigation; 

        $data = array(
            'data'           => $this->pages_model->getFaq($per_page, $page, $id_cat),
            'uri'            => $uri,
            'per_page'       => $per_page,
            'navigation'     => $navigation,
            'categories' => $this->pages_model->getFaqCats()
        ); 
 

        $this->home('public/faq', $data, '');
    }

    public function survey(){ 
        $chapterNum = !uri(3) ? '1' : uri(3); 

        $getChapters    = $this->pages_model->getSurveyChapters($this->id_interview); 
        $currentChapter = $this->pages_model->getOneChapter($chapterNum, $getChapters);  
 
        if (empty($currentChapter)) 
        {
            display_404();
        }

        $this->chapter_num = count($getChapters);
 
        $data = array(
            'data'            => $this->pages_model->getSurvey($this->id_interview),
            'totalQuestion'   => $this->pages_model->getTotalQuestions($getChapters), 
            'answer'          =>  $this->pages_model->getChapterAnswers($currentChapter['id'], $this->id_interview), 
            'chapters'        => $getChapters,
            'chapter'         => $currentChapter,
            'chapterNum'      => $chapterNum,
            'questions'       => $this->pages_model->getChapterQuestions($currentChapter['id']),
            //'countQuestions'  => $this->pages_model->countChaptersQuestions($currentChapter['id']),
            'faq_categories'  => $this->pages_model->getFaqCats()
        );      

        $this->home('public/survey', $data, '');
    }    

    public function saveSurvey(){ 
        if (isPost()) {  

            if (empty($_POST['id_chapter']) or empty($_POST['chapter'])) {
                alertRed();
            }

            $chapterNum = $_POST['chapter'];

            $id_chapter     = intval($_POST['id_chapter']);
            $questions      = key_to_id($this->pages_model->getChapterQuestions($id_chapter)); 
            $id_user        = getUserdata('id');

            $primaryData = array(
                'id_interview' => $this->id_interview,
                'id_user'      => $id_user,
                'id_chapter'   => $id_chapter
            ); 

            if (empty($questions)) {
                alertRed();
            }

            $error = false;
            foreach ($questions as $key => $item) { 
                 
                $PostQuestion = $_POST['response'];

                if ($item['type'] == '1') 
                {
                    if (!empty($item['required']) && empty($PostQuestion[$key])) 
                    {
                        $error = true;
                        break;
                    } 

                }
                elseif ($item['type'] == '2') 
                {
                    if (!empty($item['required']) && empty($PostQuestion[$key])) 
                    {
                        $error = true;
                        break;
                    }

                    if (count($PostQuestion[$key]) > $item['max_choices']) 
                    {
                        $error = true;
                        break;
                    }
                }
                elseif ($item['type'] == '3') {
                    if (!empty($item['required']) && empty($PostQuestion[$key])) 
                    {
                        $error = true;
                        break;
                    }
                }   
            } 

            $this->db->where('id_chapter', $id_chapter) 
                     ->where('id_user', $id_user)
                     ->where('id_interview', $this->id_interview)
                     ->delete('periodic_answer_question');

            $answer         = json_encode($_POST['response']);
            $data['answer'] = $answer;
            $data           = array_merge($primaryData, $data);
            $this->db->insert('periodic_answer_question', $data);

            /**
            * Сохраняем статус заполнености главы
            */
            $this->db->where('id_chapter', $id_chapter)
                     ->where('id_user', $id_user)
                     ->where('id_interview', $this->id_interview)
                     ->delete('chapter_status');

            $data           = array();
            $data['date']   = time();      
            $data['status'] = !empty($error) ? '0' : '1'; 
            $data           = array_merge($primaryData, $data);
            $this->db->insert('chapter_status', $data);


            /**
            * Записываем дату начала опроса
            */
            $start_date = getUserdata('start_date');
            if (empty($start_date)) {
                $this->db->where('hash', getUserdata('key_access'))->update('survey_access', array('start_date' => time()));
            }

            !empty($error) ? alertRed() : alertGreen(); 
        }
    }  

    public function contacts(){ 
        $data = array(
            'office' => $this->pages_model->getItems('office_contact')
            );
        
        $this->home('public/contact', $data, ''); 
    }  
   
    public function callback(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             
            if (empty($_POST['phone']) or empty($_POST['name'])) {
                alertError(REQUIRED_FIELDS);
            }

            $phone = $_POST['phone'];
            $name = $_POST['name'];

            $theme = 'Вам пришло новое сообщение с сайта http://'.$_SERVER['SERVER_NAME'].'';
            $message = '<p>Пользователь по имени '.ucfirst($name).' оставил свой номер телефона для обратного звонка. <br>  
                <b>Телефон:</b> '.$phone.'
            </p>';

            $html = 
            '<html>'.
                '<head>'. 
                    '<title>'.$theme.'</title>'.
                '</head>'.
                '<body>'.
                    '<style>a { color:#777; }</style>'.
                    '<div style="margin:0; padding:10px; background-color:#F2F2F2;">'. 
                        '<div style="width:500px; margin:0 auto; margin-top:10px; padding:15px; margin-bottom:10px; background-color:#fff; border-bottom:2px solid #D8D6D1;">'.
                            
                            '<p style="height:10px;"></p>'.
                            $message.
                            '<p style="min-height:10px"></p>'.
                        '</div>'.
                        '<p style="font-family:\'Helvetica\',\'Arial\',sans-serif;color:#9ca1ae;font-size:12px;font-weight:300;text-align:center;margin-bottom:10px;"> © '.date("Y").' <a href="http://'.$_SERVER['SERVER_NAME'].'" style="color:#777" target="_blank">'.$_SERVER['SERVER_NAME'].'</a></p>'.
                    '</div>'.
                '</body>'.
            '</html>';

            $config = Array(         
                'mailtype'  => 'html', 
                'charset'   => 'utf-8',
                'protocol' => 'sendmail' 
            );
            
            $this->email->initialize($config); 
            $this->email->from('info@'.$_SERVER['SERVER_NAME'], $_SERVER['SERVER_NAME']);
            $this->email->to(EMAIL);  

            $this->email->subject($theme);
            $this->email->message($html);  
            $this->email->send(); 
            alertSuccess(ALERT_CALLBACK_SUCCESS, true);
        }
    }
  
    public function display_404() { 
        $this->load->view('public/error', '', '');  
    } 
}


