<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('in_multi_array')) {
    function in_multi_array($needle, $haystack)
    {
        $haystack = key_to_asc($haystack); 
        $in_multi_array = false;
        if (in_array($needle, $haystack)) {
            $in_multi_array = true;
        } else {
            for ($i = 0; $i < sizeof($haystack); $i++) {
                if (is_array($haystack[$i])) {
                    if (in_multi_array($needle, $haystack[$i])) {
                        $in_multi_array = true;
                        break;
                    }
                }
            }
        }
        return $in_multi_array;
    }
}

if (!function_exists('key_to_asc')) {
    function key_to_asc($array)
    {
        $new_arr = array();
        $i = 0;
        foreach ($array as $id => &$node) {
            $new_arr[$i] =& $node;
            $i++;
        }
        return $new_arr;
    }
}


if (!function_exists('key_to_id')) {
    function key_to_id($array) {
        if (empty($array)) {
            return array();
        }
        $new_arr = array();
        foreach ($array as $id => &$node) {
            $new_arr[$node['id']] =& $node;
        }
        return $new_arr;
    }
}

if (!function_exists('map_tree')) {
    function map_tree($dataset)
    {
        $dataset = key_to_id($dataset);
        $tree    = array();
        foreach ($dataset as $id => &$node) {
            if (empty($node['parent_id'])) {
                $tree[$id] =& $node;
            } else { 
                $dataset[$node['parent_id']]['childs'][$id] =& $node;
            }
        }
        return $tree;
    }
}

if (!function_exists('categories_to_string')) {
    function categories_to_string($data, $folder)
    {
        $string = '';
        foreach ($data as $item) {
            $string .= categories_to_template($item, $folder);
        }
        return $string;
    }
}

if (!function_exists('categories_to_template')) {
    function categories_to_template($category, $folder)
    {
        ob_start();
        include APPPATH . 'views/buffer/' . $folder . EXT;
        $buffer = ob_get_contents();
        ob_get_clean();
        return $buffer;
    }
}

function getCategories($view=false){
    $CI =& get_instance();
    if ($view) {
        $CI->db->where('view', '1');
    } 
    $getCategories=$CI->db->order_by('page_up', 'asc')->order_by('id', 'desc')->get('categories');
    return key_to_id($getCategories->result_array());
}

/* Возвращает true если категория последнего уровня. */
function isLastLevel($id_cat){
    $getResult=breadcrumbs(getCategories(), $id_cat);
    if (count($getResult)=='3') {
        return true;
    }
    return false;
}  

/* Возвращает id родительской категории первого уровня */
function getFirstParentCatId($id_cat){
    $getResult=breadcrumbs(getCategories(), $id_cat);
    if (!empty($getResult)) {
        return array_shift(array_keys($getResult));
    }

    return false;
}

/* Хлебные крошки */
function breadcrumbs($array, $id){
    if(!$id) return false;  
    
    $CI =& get_instance();  
    $lang = $CI->lang->lang(); 
    
    $breadcrumbs_array = array();
    for($i = 0; $i < count($array); $i++){
        if(isset($array[$id])){
            $name_cell = !empty($lang) ? $array[$id]["name_{$lang}"] : $array[$id]["name_ru"];
            $breadcrumbs_array[$array[$id]['id']] = $name_cell; 
            $id = $array[$id]['parent_id'];
        }else break;
    }

    return array_reverse($breadcrumbs_array, true);
}

function cats_id($array, $id){
    if(!$id) return false;
    $data = '';
    foreach($array as $item){
        if($item['parent_id'] == $id){
            $data .= $item['id'] . ",";
            $data .= cats_id($array, $item['id']);
        }
    }
    return $data;
}

function getCatIdByUrl($url){
    $CI =& get_instance();  
    $lang = $CI->lang->lang();
    $sql=$CI->db->where('url', clear($url))->get('categories')->row_array();
    return !empty($sql['id']) ? $sql['id'] : false;
}

if (!function_exists('newthumbs')) {
    function newthumbs($photo = '', $dir = '', $width = 0, $height = 0, $version = 0, $zc = 0)
    {
        //echo $dir; 
        if (empty($photo) or !file_exists($dir . '/' . $photo)) {
            $photo = "no-image-no-image-no-image.png";
            if (!file_exists($dir . "/no-image-no-image-no-image.png")) {
                copy("./public/image/default/no-image.png", $dir . "/no-image-no-image-no-image.png");
            }
        }
        if (!file_exists($dir . '/' . $photo)) {
            if (file_exists($dir . '/' . str_replace('.jpg', '.JPG', $photo))) {
                $photo = str_replace('.jpg', '.JPG', $photo);
            } elseif (file_exists($dir . '/' . str_replace(' .jpg', '.jpg', $photo))) {
                $photo = str_replace(' .jpg', '.jpg', $photo);
            } elseif (file_exists($dir . '/' . substr($photo, 1))) {
                $photo = substr($photo, 1);
            }
        }
        require_once(realpath('public/lib/phpthumb') . '/phpthumb.class.php');
        // echo $dir;exit();
        $result = is_dir(realpath($dir) . '/thumbs');
        if ($result) {
            $prevdir = $dir . '/thumbs';
        } else {
            if (mkdir(realpath($dir) . '/thumbs')) {
                $prevdir = $dir . '/thumbs';
            } else {
                return './public/image/default/no-image.png';
            }
        }
        if (!empty($version)) {
            $result = is_dir(realpath($dir) . '/thumbs/version_' . $version);
            if ($result) {
                $prevdir = $dir . '/thumbs/version_' . $version;
            } else {
                if (mkdir(realpath($dir) . '/thumbs/version_' . $version)) {
                    $prevdir = $dir . '/thumbs/version_' . $version;
                } else {
                    return './public/image/default/no-image.png';
                }
            }
        }
        //$ext=end(explode('.',$photo));
        $ext    = pathinfo($photo, PATHINFO_EXTENSION);
        $timg   = realpath($dir) . '/' . $photo;
        $catimg = realpath($prevdir) . '/' . $photo;
        if (is_file($timg) && !is_file($catimg)) {
            $opath1   = realpath($dir) . '/';
            $opath2   = realpath($prevdir) . '/';
            $dest     = $opath2 . $photo;
            $source   = $opath1 . $photo;
            $phpThumb = new phpThumb();
            $phpThumb->setSourceFilename($source);
            if (!empty($width))
                $phpThumb->setParameter('w', $width);
            if (!empty($height))
                $phpThumb->setParameter('h', $height);
            if ($ext == 'png')
                $phpThumb->setParameter('f', 'png');
            if (!empty($zc)) {
                $phpThumb->setParameter('zc', '1');
            }
            $phpThumb->setParameter('q', 100);
            if ($phpThumb->GenerateThumbnail()) {
                if ($phpThumb->RenderToFile($dest)) {
                    $img = $prevdir . '/' . $photo;
                } else {
                    return '/public/image/default/no-image.png';
                }
            }
        } elseif (is_file($catimg)) {
            $img = $prevdir . '/' . $photo;
        } else {
            return '/public/image/default/no-image.png';
        }
        return $img;
    }
} 



if (!function_exists('to_url_title')) {
    function to_url_title($str, $separator = 'dash', $lowercase = FALSE)
    {
        if ($separator == 'dash') {
            $search  = '_';
            $replace = '-';
        } else {
            $search  = '-';
            $replace = '_';
        }
        $trans    = array(
            '&\#\d+?;' => '',
            '&\S+?;' => '',
            '\s+' => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace . '+' => $replace,
            $replace . '$' => $replace,
            '^' . $replace => $replace,
            '\.+$' => ''
        );
        $translit = array(
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "c",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "",
            "ы" => "y",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
            "А" => "a",
            "Б" => "b",
            "В" => "v",
            "Г" => "g",
            "Д" => "d",
            "Е" => "e",
            "Ж" => "zh",
            "З" => "z",
            "И" => "i",
            "Й" => "y",
            "К" => "k",
            "Л" => "l",
            "М" => "m",
            "Н" => "n",
            "О" => "o",
            "П" => "p",
            "Р" => "r",
            "С" => "s",
            "Т" => "t",
            "У" => "u",
            "Ф" => "f",
            "Х" => "h",
            "Ц" => "c",
            "Ч" => "ch",
            "Ш" => "sh",
            "Щ" => "sch",
            "Ъ" => "",
            "Ы" => "y",
            "Ь" => "",
            "Э" => "e",
            "Ю" => "yu",
            "Я" => "ya",
            " " => "_",
            "," => ""
        );
        $str      = strtr($str, $translit);
        $str      = strip_tags($str);
        foreach ($trans as $key => $val) {
            $str = preg_replace("#" . $key . "#i", $val, $str);
        }
        if ($lowercase === TRUE) {
            $str = strtolower($str);
        }
        return trim(stripslashes($str));
    }
}

if (!function_exists('print_arr')) {
    function print_arr($array)
    {
        echo "<pre>" . print_r($array, true) . "</pre>";
    }
}

if (!function_exists('clear')) {
    function clear($str, $type = '0')
    {
        $str = trim($str);
        if ($type == 'email') {
            if (filter_var($str, FILTER_VALIDATE_EMAIL) === false) {
                $str = "";
            }
        } else if ($type == 1 or $type == 'int') {
            $str = intval($str);
        } else if ($type == 2 or $type == 'float') {
            $str = str_replace(",", ".", $str);
            $str = floatval($str);
        } else if ($type == 3 or $type == 'regx') {
            $str = preg_replace("/[^a-zA-ZА-Яа-я0-9.,!\s]/", "", $str);
        } else if ($type == 'alias') {
            $str = preg_replace("/[^a-zA-Z0-9_-\s]/", "", $str);
        } else if ($type == 4 or $type == 'text') {
            $str = str_replace("'", "&#8242;", $str);
            $str = str_replace("\"", "&#34;", $str);
            $str = stripslashes($str);
            $str = htmlspecialchars($str);
        } else {
            $str = strip_tags($str);
            $str = str_replace("\n", " ", $str);
            $str = str_replace("'", "&#8242;", $str);
            $str = str_replace("\"", "&#34;", $str);
            $str = preg_replace('!\s+!', ' ', $str);
            $str = stripslashes($str);
            $str = htmlspecialchars($str);
        }
        return $str;
    }
}


if (!function_exists('to_month')) {
    function to_month($date)
    {
        $_nr_month = date('m', $date);
        switch ($_nr_month) {
            case '01':
                $m = 'янв.';
                break;
            case '02':
                $m = 'фев.';
                break;
            case '03':
                $m = 'март.';
                break;
            case '04':
                $m = 'апр.';
                break;
            case '05':
                $m = 'май';
                break;
            case '06':
                $m = 'июн.';
                break;
            case '07':
                $m = 'июл.';
                break;
            case '08':
                $m = 'авг.';
                break;
            case '09':
                $m = 'сент.';
                break;
            case '10':
                $m = 'окт.';
                break;
            case '11':
                $m = 'нояб.';
                break;
            case '12':
                $m = 'дек.';
                break;
            default:
                $m = $to_date;
                break;
        }
        return date('d ' . $m . ' Y', $date);
    }
}
    if (!function_exists('_current_url_lang')) {
        function _current_url_lang($url)
        {
            $a = array_slice(explode('/', $url), 1); 
            $b = implode('/', $a);
            return $b.(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
        }
    }

    if (!function_exists('random_string')) {
        function random_string($length)
        {
            $key  = '';
            $keys = array_merge(range(0, 9), range('a', 'z'));
            for ($i = 0; $i < $length; $i++) {
                $key .= $keys[array_rand($keys)];
            }
            return $key;
        }
    }

    if (!function_exists('getRealIpAddr')) {
        function getRealIpAddr()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) // Определяем IP
                {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
    }

    if (!function_exists('explode_delimiter')) {
        function explode_delimiter($arr)
        {
            $_explode = explode('|', $arr);
            return $_arr = array_filter($_explode, function($v)
            {
                return !empty($v);
            });
        }
    }

    if (!function_exists('clear_arr')) {
        function clear_arr($arr)
        {
            return $_arr = array_filter($arr, function($v)
            {
                return !empty($v);
            });
        }
    }
 

if (!function_exists('send_mail')) {
    // SEND MESSAGES
    function send_mail($mail_to, $theme, $message) { 
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

            // echo $theme.'<br>';
            // echo $html.'<br>';
            // exit();

        $config = Array(         
            'mailtype'  => 'html', 
            'charset'   => 'utf-8',
            'protocol' => 'mail' 
        );

        $CI = &get_instance();
        
        $CI->email->initialize($config); 
        $CI->email->from('info@'.$_SERVER['SERVER_NAME'], $_SERVER['SERVER_NAME']);
        $CI->email->to($mail_to);  

        $CI->email->subject($theme);
        $CI->email->message($html);  
        $CI->email->send();
        return true;
    }
}

    if (!function_exists('display_404')) {
        function display_404()
        {
            header("Location:" . base_url('display_404'));
            exit();
        }
    } 

    if (!function_exists('getInput')) {
        function getInput($value = null, $field_label, $field_name, $field_type = false, $field_gen, $ck = false, $array = false){
            if (!empty($array)) {
                extract($array);
            }

            $field_col = !empty($field_col) ? $field_col : 'col-sm-11';
            $label_col = !empty($label_col) ? $label_col : 'col-sm-1';

            $form_control = '';
            switch ($field_gen) {
                case 'input':   
                    $input_val = !empty($value[$field_name]) ? $value[$field_name] : null;
                    $form_control .= '<div class="form-group lang-area" id="field">
                               <label class="'.$label_col.' control-label">'.$field_label.'</label>
                               <div class="'.$field_col.'">
                                  <input type="'.$field_type.'" class="form-control" id="'.@$id.'" name="'.$field_name.'" value="'.$input_val.'"> 
                               </div>
                            </div>';  
                    break;

                case 'textarea': 
                    $input_val = !empty($value[$field_name]) ? $value[$field_name] : null;
                        if (!$ck) {
                            $input_val = strip_tags($input_val);
                        }
                        $form_control .= '<div class="form-group lang-area" id="field">
                                    <label class="'.$label_col.' control-label">'.$field_label.'</label>
                                    <div class="'.$field_col.'">
                                        <textarea style="min-height:150px;" class="form-control '.$ck.'" name="'.$field_name.'">'.$input_val.'</textarea>  
                                    </div>
                                </div>';
                    break;
                
                default: 
                    break; 
            } 

            return $form_control;
        }
    }

    function datetotime ($date, $format = 'YYYY-MM-DD') { 
        if ($format == 'YYYY-MM-DD') list($year, $month, $day) = explode('-', $date);
        if ($format == 'YYYY/MM/DD') list($year, $month, $day) = explode('/', $date);
        if ($format == 'YYYY.MM.DD') list($year, $month, $day) = explode('.', $date);

        if ($format == 'DD-MM-YYYY') list($day, $month, $year) = explode('-', $date);
        if ($format == 'DD/MM/YYYY') list($day, $month, $year) = explode('/', $date);
        if ($format == 'DD.MM.YYYY') list($day, $month, $year) = explode('.', $date);

        if ($format == 'MM-DD-YYYY') list($month, $day, $year) = explode('-', $date);
        if ($format == 'MM/DD/YYYY') list($month, $day, $year) = explode('/', $date);
        if ($format == 'MM.DD.YYYY') list($month, $day, $year) = explode('.', $date);

        return mktime(0, 0, 0, $month, $day, $year); 
    } 

    function returnData($post, $field_lang){  
        $data = array();
        foreach ($post as $key => $value) {
            foreach ($field_lang as $key2 => $value2) {
                if (isset($post[$value2])) {
                    $data[$value2] = $post[$value2];
                }
            } 
        }  
        return $data;
    } 

    function current_url2() {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    } 
   
    function render($filename, $array){
        extract($array); 
        ob_start();
        include 'public/pdf/'.$filename.'.php';
        return ob_get_clean();
    }

    function setArr0($arr, $i){  
        $new_arr = array();
        $num=0;
        foreach ($arr as $item) {
            $new_arr[$num] = $item;
            $num++;
        } 
        return $new_arr[$i];
    }
 
    function developer(){ 
        $CI =& get_instance();
        switch ($CI->lang->lang()) {
            case 'ru':
                $dev = 'Разработка сайта ilab.md';
                $link = 'http://www.ilab.md/ru'; 
                break;

            case 'ro':
                $dev = 'Elaborarea siteului ilab.md';
                $link = 'http://www.ilab.md/ro/'; 
                break;

            case 'en':
                $dev = 'Site development ilab.md';
                $link = 'http://www.ilab.md/en/'; 
                break;

            default: 
                break;
        } 

        $content = '<div class="developer_link"><img src="/img/ilab_logo_footer.png" alt="">
              <a href="'.$link.'" target="blank" style="text-decoration:underline; display:inline;"> 
                  <span>'.$dev.'</span> 
              </a></div>';
        return $content;
    }

    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
 
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }

    function toFloat($s) {
        // convert "," to "."
        $s = str_replace(',', '.', $s);

        // remove everything except numbers and dot "."
        $s = preg_replace("/[^0-9\.]/", "", $s);

        // remove all seperators from first part and keep the end
       // $s = str_replace('.', '',substr($s, 0, -3)) . substr($s, -3);

        // return float
        return (float) $s;
    }  

    /**
    * Возвращает ответ в формате json
    */
    function alertSuccess($msg = 0, $session=false){  

        if ($session == true) {
            $_SESSION['msg'] = '<div class="alert alert-success">'.$msg.'</div>';
        }
 
        echo json_encode(array('msg' => $msg));   
        exit();
    } 

    /**
    * Возвращает ответ в формате json
    */
    function alertError($msg = 0, $session=false){ 
        if ($session == true) {
            $_SESSION['msg'] = '<div class="alert alert-danger">'.$msg.'</div>';
        }

        echo json_encode(array('msg' => "error", 'cause' => $msg));  
        exit();  
    }


    function alertGreen(){    
        echo json_encode(array('msg' => '1', 'onlyStatus' => true, 'check' => true));   
        exit();
    } 
 
    function alertRed(){   
        echo json_encode(array('msg' => "error", 'onlyStatus' => true, 'check' => false));  
        exit();  
    } 

    /**
    * Записывает ответ в сессию 
    */ 
    function showSuccess($msg = 'Error', $redirect){   
        $_SESSION['msg'] = '<div class="alert alert-success">'.$msg.'</div>'; 
        header('Location: /'.$redirect);
        exit();
    } 

    /**
    * Записывает ответ в сессию 
    */ 
    function showError($msg = 'Error', $redirect){   
        $_SESSION['msg'] = '<div class="alert alert-danger">'.$msg.'</div>'; 
        header('Location: /'.$redirect);
        exit();
    } 

    function priceString($price){ 
        if (empty($price)) return '0.00'; 
        return number_format($price, 0, ',', ' ');
    }
    
    //Устанавливаем цену 
    function formatPrice($id, $format=true){ 
        if (empty($id)) return '0.00'; 
        $CI=&get_instance();

        $getCatalogItem=$CI->db->query("SELECT catalog.price as price, catalog.price_ye 
                                        FROM catalog
                                        LEFT JOIN categories ON (categories.id=catalog.id_category)
                                        WHERE catalog.id='$id'
                                      ")->row_array();

        if (empty($getCatalogItem)) return '0.00'; 

        $curs=getCurs();

        if (!empty($getCatalogItem['price'])) {
            $price=$getCatalogItem['price'];
        }else if(!empty($getCatalogItem['price_ye'])){
            $price=!empty($curs) ? $getCatalogItem['price_ye']*getCurs() : $getCatalogItem['price_ye']; 
        }  

        if ($format) {
            return priceString($price);
        }

        return $price; 
    }

    function getPromoPercentage($id){
        if (empty($id)) return '0.00'; 
        $CI=&get_instance();

        $getCatalogItem=$CI->db->query("SELECT catalog.price as price, catalog.action, catalog.action_from, catalog.action_to, catalog.price_ye, categories.percentage as percentage
                                        FROM catalog
                                        LEFT JOIN categories ON (categories.id=catalog.id_category)
                                        WHERE catalog.id='$id'
                                      ")->row_array();

        if (empty($getCatalogItem['percentage'])) return null; 

        //если не вкл. акция возвращаем null
        if (empty($getCatalogItem['action']) or $getCatalogItem['action_from'] >= time() or $getCatalogItem['action_to'] <= time()) return null; 

        $percentage=$getCatalogItem['percentage'];
        $curs=getCurs();

        if (!empty($getCatalogItem['price'])) {
            $price=$getCatalogItem['price'];
        }else if(!empty($getCatalogItem['price_ye'])){
            $price=!empty($curs) ? $getCatalogItem['price_ye']*getCurs() : $getCatalogItem['price_ye']; 
        } 

        $finalPrice=countPercent($price, $percentage)+$price;

        return '<div class="old_price"><del>'.priceString($finalPrice).'<small>'.LEI_LABEL.'</small></del></div>'; 
    }  
 

    if (!function_exists('countPercent')) {
        function countPercent($from, $percent){
            return ($from*$percent) /100;
        }
    }

    function download_send_headers($filename) {
    // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

    function array2csv(array &$array, $titles) {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, $titles, ';');
        foreach ($array as $row) {
            fputcsv($df, $row, ';');
        }
        fclose($df);
        return ob_get_clean();
    }  

    function alertErrorOuth($msg='Error'){
        $_SESSION['message']='<div class="alert-error">'.$msg.'</div>';
        header('Location:/'); 
    }

    function alertSuccessOuth($msg='Error'){
        $_SESSION['message']='<div class="alert-success">'.$msg.'</div>';
        header('Location:/'); 
    }

    function isAjax(){
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) return true;
        return false;
    }

    function isPost(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') return true;
        return false;
    }

    function echoSession(){
        if (!empty($_SESSION['msg'])) {
            echo '<div class="row">
                  <div class="col-md-12">
                    '.$_SESSION['msg'].' 
                  </div>
               </div> ';
            unset($_SESSION['msg']);
        }
    }

    function alert($field){
        $array = array(
            'required_fields'  => 'Fill in required fields!',
            'saved_data'       => 'Data saved successfully!',
            'confirm_action'   => 'Confirm the action',
            'confirm_question' => 'Are you sure you want to delete?',
            'yes'              => 'Yes',
            'cancel'           => 'Cancel',
            'delete'           => 'Delete',
            'add'              => 'Add',
            'save'             => 'Save',
            'upload'           => 'Upload'
        );

        if (!empty($array[$field])) {
            return $array[$field];
        }

        return false;
    } 

    function getNextId($table){
        if (empty($table)) {
            return;
        }

        $CI = &get_instance(); 
        $getStatus = $CI->db->query("SHOW TABLE STATUS WHERE name = '{$table}' ");
        
        if ($getStatus->current_row == 0) {
            return 1;
        }else{
            return $getStatus->current_row+1;
        }
    }
    
    function sortValue($arr){
        if (empty($arr)) {
            return;
        }

        $data = array();
        foreach ($arr as $l_key => $l_value) {   
            $i=0;
            foreach ($l_value as $key => $value) {
                $data[$key][$l_key] = $arr[$l_key][$key];
                $i++;
            }
        } 

        return $data; 
    }

    function admin_404(){
        exit('404 Eror!');
    }

    function checkReqLang($langs, $fields, $post){
        if (empty($langs)) {
            return false;
        }

        foreach ($langs as $l_key => $l_val) {
            foreach ($fields as $field_name) {
                if (empty($post[$field_name.'_'.$l_val])) {
                    return false;
                }
            } 
        }

        return true;
    }

    function checkPassword($password){
        if(!preg_match("/([a-z]+)/", $password))
        {
            return 'The password should contain some lowercase letters!';  
        }
        
        if(!preg_match("/([A-Z]+)/", $password))
        {
            return 'The password must contain at least one capital letter!';
        } 

        if(!preg_match('/[^a-zA-Z\d]/', $password))
        {
            return 'The password must contain characters!';
        } 

        return true;
    }

    function getChildProjectsId($projects, $id_project, &$array, $verify = true){
          
        foreach ($projects as $item) { 
            if (!empty($item['id']) && $item['id'] == $id_project) {
                if (!empty($verify)) {
                    if (AccessProject($id_project) ==  true) {
                        $array[] = $item['id'];
                    }
                }else{
                    $array[] = $item['id'];
                } 
            } 
 
            if (!empty($item['parent_id']) && in_array($item['parent_id'], $array)) { 
                if (!empty($verify)) {
                    if (AccessProject($id_project) ==  true) {
                        $array[] = $item['id'];
                    }
                }else{
                    $array[] = $item['id'];
                } 
            } 

            if (!empty($item['childs'])) {  
                getChildProjectsId($item['childs'], $id_project, &$array, $verify);
            }
        }  

        return $array;
    }

    function checkBeginInterview($id_interview){
        $CI  = &get_instance(); 
        $get =  $CI->db->where('interview.delete', '0')
                         ->where('interview.activated', '1')
                         ->where('interview.status', '2') 
                         ->where('id', $id_interview) 
                         ->group_by('interview.id')
                         ->get('interview')
                         ->row_array();
 
        if (empty($get)) {
            return false;
        }
 
        $today = date('d.m.Y', time());
        if (date('d.m.Y', $get['date_start']) <= $today && date('d.m.Y', $get['date_end']) >= $today) {
            return true;
        }

        return false;
    }

    function uri($num){
        $CI  = &get_instance(); 
        return clear($CI->uri->segment($num));
    }

    function union_uri($uri){  
        if (!empty($_SESSION['key_access'])) {
            return $uri.'/?key_access='.$_SESSION['key_access'];
        }else{
            return $uri;
        }
    }

    function get_navigation($page, $count_mess, $perpage){
            define('C_LINKS', '2');  
        $n_pages = (int)($count_mess / $perpage);
      
        if($count_mess % $perpage != 0){  
            $n_pages ++;
        }

        // проверка на надобность постраничной навигации 
        if($count_mess < $perpage || $page > $n_pages){  
            return FALSE;  
        }
      
        $result = array(); 
        if($page != 1){ //если находимся не на первой стр
            $result['first'] = 1;
            $result['prev_page'] = $page - 1; //текущяя стр
        }
      
        //определяем сколько сслок выставляем с лево от текущей(то есть назад)
        if($page > C_LINKS + 1){
            for ($i = $page - C_LINKS; $i < $page; $i++) { 
                $result['previous'][] = $i;
            }
        }else{
            for ($i = 1; $i < $page; $i++) { 
                $result['previous'][] = $i;
            }
        } 
      
        $result['current'] = $page;
      
        //определяем сколько сслок выставляем с право от текущей(то есть вперед)
        if($page + C_LINKS <  $n_pages){ //если текущая стр + кол ссылок будет больше чем общее кол стр
            for ($i = $page +1; $i <= $page + C_LINKS; $i++) { 
                $result['next'][] = $i;
            }
        } else{ 
            for ($i = $page + 1; $i <= $n_pages; $i++) { 
                $result['next'][] = $i;
            }
        }
      
        if($page != $n_pages){
            $result['next_pages'][] = $page + 1; 
            $result['end'][] = $n_pages;
        }
      
        if ($page+1 < $n_pages-C_LINKS) {
            $result['last_dots'] = '...'; 
        }  
      
        if ($page > C_LINKS*2) {
            $result['prev_dots'] = '...'; 
        }
      
        if ($page > C_LINKS && $page != C_LINKS+1) {
            $result['prev_dots_page'] = true; 
        }
      
        if ($page < $n_pages-C_LINKS+1 && $page != $n_pages-C_LINKS) {
            $result['last_dots_page'] = true; 
        } 
      
        if ($page > 3) {
            $result['first_dots'] = '...';
        }  
       
        return $result;
    } 