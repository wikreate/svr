<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 
function getUserdata($field=false){ 
    $CI=&get_instance(); 
    
    $sessionHash = clear($_SESSION['key_access']); 
    $sql =  $CI->db->select('survey_access.hash as key_access, survey_access.start_date, survey_access.id_user as id, emails_list.email')
                     ->from('survey_access') 
                     ->join('emails_list', "emails_list.id = survey_access.id_user", 'left') 
                     ->where('survey_access.hash', $sessionHash)
                     ->where('emails_list.delete', '0') 
                     ->where('emails_list.view', '1') 
                     ->group_by('survey_access.id')
                     ->get()
                     ->row_array();

    if (isset($sql[$field])) {
        return $sql[$field]; 
    }
    return $sql;   
}

function getAdminUser($field=false){  
    $CI=&get_instance(); 
    $sessionHash = clear($_SESSION['admin_user']['session']); 
    $sql = $CI->db->where('session_hash', $sessionHash)->where('active', '1')->get('admin_users')->row_array();
    if (isset($sql[$field])) {
        return $sql[$field]; 
    } 
    return $sql; 
}

function Can($priv_adm) {
    $userdata = getAdminUser();

    if (empty($userdata)) {
        return FALSE; 
    }

    $priv = getPriv($userdata['id']);
    if(!$priv) {
      $priv = array();
    }  
    
    //Вычислить схождение массивов и возвращает их(значения) 
    $arr = array_intersect($priv_adm, $priv);

    if($arr === $priv_adm) {
      return TRUE;
    }

    return FALSE; 
}

function getPriv($id) { 
    $CI =& get_instance();   
    $result = $CI->db->query("SELECT privilege.define as privilege
            FROM privilege
            LEFT JOIN user_privileges ON user_privileges.id_privilege = privilege.id
            WHERE user_privileges.id_user = '{$id}'
    ")->result_array();

    if(empty($result)) {
      return FALSE;
    }

    $arr = array_map(function($v){
        return $v['privilege'];
    }, $result);

 
    return $arr;    
}

function AccessProject($id_project){
    $CI =& get_instance();   
    $userData = getAdminUser(); 

    if ($userData['parent_id'] == 0) {
        return true;
    }

    $check = $CI->db->where('id_user', $userData['id'])->where('id_project', $id_project)->get('user_projects');
    if ($check->num_rows() > 0) {
        return true;
    }else{
        return false;
    }
}

function xorEncrypt( $InputString, $KeyString )
{
    $KeyStringLength = mb_strlen( $KeyString );
    $InputStringLength = mb_strlen( $InputString );
    for ( $i = 0; $i < $InputStringLength; $i++ )
    {
    // Если входная строка длиннее строки-ключа
      $rPos = $i % $KeyStringLength;
    // Побитовый XOR ASCII-кодов символов
      $r = ord( $InputString[$i] ) ^ ord( $KeyString[$rPos] );
    // Записываем результат - символ, соответствующий полученному ASCII-коду
      $InputString[$i] = chr($r);
    }
     return $InputString;
}
/**
* Вспомогательная функция для шифрования в строку, удобную для использования в ссылках
* @param string $InputString
* @return string
*/
function encrypt( $InputString )
{
    $str = xorEncrypt( $InputString, '964b07152d23' );
    $str = base64EncodeUrl( $str );
    return $str;
}
/**
* Вспомогательная функция для дешифрования из строки, удобной для использования в ссылках (парный к @link self::encrypt())
* @param string $InputString
* @return string
*/
function decrypt( $InputString )
{
$str = base64DecodeUrl( $InputString );
$str = xorEncrypt( $str, '964b07152d23' );
return $str;
}
/**
* Кодирование в base64 с заменой url-несовместимых символов
* @param string $Str
* @return string
*/
function base64EncodeUrl( $Str )
{
return strtr( base64_encode( $Str ), '+/=', '-_,' );
}
/**
* Декодирование из base64 с заменой url-несовместимых символов (парный к @link self::base64EncodeUrl())
* @param string $Str
* @return string
*/
function base64DecodeUrl( $Str )
{
return base64_decode( strtr( $Str, '-_,', '+/=' ) );
}