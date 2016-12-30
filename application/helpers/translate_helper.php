<?php

	if (!function_exists('getInputLang')) {
	    function getInputLang($lang_arr = false, $value = null, $field_label, $field_name, $field_type = false, $field_gen, $ck = false, $array = false){
	        if (!empty($array)) {
	            extract($array);
	        }

	        $CI =& get_instance();

	        if (empty($lang_arr)) {
	        	$lang_arr = $CI->lang->languages; 
			    if (empty($lang_arr)) {
			    	return array();
			    }
	        } 

	        $field_col = !empty($field_col) ? $field_col : 'col-sm-11';
	        $label_col = !empty($label_col) ? $label_col : 'col-sm-1';
 
	        $form_control = '';
	        switch ($field_gen) {
	            case 'input': 
	                foreach ($lang_arr as $key => $val) { 
	                    $input_val = !empty($value[$field_name."_".strtolower($val)]) ? $value[$field_name."_".strtolower($val)] : null;
	                    $form_control .= '<div class="form-group lang-area field_'.$val.'">
	                               <label class="'.$label_col.' control-label">'.$field_label.'</label>
	                               <div class="'.$field_col.'">
	                                  <input type="'.$field_type.'" class="form-control" id="'.@$id.'" name="'.$field_name.'_'.strtolower($val).'" value="'.$input_val.'"> 
	                               </div>
	                            </div>'; 
	                }
	                break;

	            case 'textarea': 
	                foreach ($lang_arr as $key => $val) { 
	                    $input_val = !empty($value[$field_name."_".strtolower($val)]) ? $value[$field_name."_".strtolower($val)] : null;
	                    if (!$ck) {
	                        $input_val = strip_tags($input_val);
	                    }
	                    $form_control .= '<div class="form-group lang-area field_'.$val.'">
	                                <label class="'.$label_col.' control-label">'.$field_label.'</label>
	                                <div class="'.$field_col.'">
	                                    <textarea style="min-height:150px;" class="form-control '.$ck.'" name="'.$field_name.'_'.strtolower($val).'">'.$input_val.'</textarea>  
	                                </div>
	                            </div>';
	                }
	                break;
	            
	            default: 
	                break; 
	        } 

	        return $form_control;
	    }
	} 

	function returnDataLang($lang_arr, $post, $fields, $table, $id = false){ 
		/**
		* Массив с языками
		*/
		$CI =& get_instance();

		if (empty($lang_arr)) {
			$lang_arr = $CI->lang->languages; 
		    if (empty($lang_arr)) {
		    	return array();
		    }
		}  

		 //exit(print_arr($post));
  
	    $data = array(); 
	    $i    = 1;
	    foreach ($fields as $key => $field) {

	    	$field_data = array();
 
	    	$field_data[$field]['field'] = $field; 

	    	$field_data[$field]['union_id'] = getFieldVal($field, $table, $i, $id); 

	        foreach ($lang_arr as $l_key => $l_val) { 
	        	$fieldLangName  = $field.'_'.$l_val; 
        		$row = array();  
	        	$idLang         = $l_key;
	        	$fieldValueLang = $post[$fieldLangName];

	        	$row['id_lang'] = $idLang;
	        	$row['value']   = $fieldValueLang;
	            $field_data[$field]['translate'][] = $row;  
	        } 
 
	        $data[] = $field_data;   
	        $i ++;
	    }  
	    return $data;
	} 

	function insertDataLang($config){
		extract($config);
		if (empty($post) or empty($fields) or empty($post_id)) {
			return;
		}

		$CI =& get_instance();

		if (empty($lang_arr)) {
			$lang_arr = $CI->lang->languages; 
		    if (empty($lang_arr)) {
		    	return array();
		    }
		}   

		// $CI->db->where('delete', '0')->where('post_id', $post_id)->delete("{$db_table}"); 
		 
		foreach ($lang_arr as $l_key => $l_val) {
			$data = array();
			foreach ($fields as $field_name) {
				if (isset($post[$field_name.'_'.$l_val])) {
					$data[$field_name] = htmlspecialchars($post[$field_name.'_'.$l_val]);
				}
			} 
			$data['id_lang'] = $l_key;
			$data['post_id'] = $post_id;  

			if ($CI->db->where('delete', '0')->where('post_id', $post_id)->where('id_lang', $l_key)->get("{$db_table}")->num_rows() > 0) {
				$CI->db->where('delete', '0')->where('post_id', $post_id)->where('id_lang', $l_key)->update("{$db_table}", $data); 
			}else{
				$CI->db->insert("{$db_table}", $data); 
			}  
		} 
	} 
 
	/**
	* @param $array  
	* @param $return_fields 
	* @param $database
	* @return array()
	*/
	function getTranslateArray($array, $fields, $db_table, $multiple = true, $lang_arr = false){
        if (empty($array) or empty($fields)) return array();

        $CI       = & get_instance();

        if ($lang_arr == false) {
        	$lang_arr = $CI->lang->languages;  
        }
        
        if (empty($lang_arr)) return array();
 
        $new_array = array();
        $array = key_to_id($array);   
         
        foreach ($array as $item) {

            $getTranslate = $CI->db->where('post_id', $item['id']) 
            					   ->where('delete', '0') 
                                   ->get("{$db_table}")
                                   ->result_array(); 

            $byIdLang = array();
            foreach ($getTranslate as $value) { 
            	$byIdLang[$value['id_lang']] = $value; 
            }     //exit(print_arr($byIdLang));

            foreach ($lang_arr as $l_key => $l_val) {
            	foreach ($fields as $val_field) { 
                	if (!empty($byIdLang[$l_key])) {  
                    	$array[$item['id']][$val_field.'_'.$l_val] = $byIdLang[$l_key][$val_field];
                	} else{
                		$array[$item['id']][$val_field.'_'.$l_val] = '';
                	}
            	} 
            }  
        } 
 
        if ($multiple) {
        	return $array;
        }else{
        	$array = key_to_asc($array); 
        	return $array[0];
        }         
    }

    function getInterviewLangArr($id = false){
        if(empty($id)) return false;

        $CI    = &get_instance();
        $arrayLng = $CI->db->where('id_interview', $id)->get('interview_select_lang')->result_array(); 
        if (empty($arrayLng)) return false;
 
        $lang_arr = array();
        foreach ($arrayLng as $item) {
        	if (!empty($CI->lang->languages[$item['id_lang']])) {
        		$lang_arr[$item['id_lang']] = $CI->lang->languages[$item['id_lang']];
        	}
        }  
        return $lang_arr;
    }

    function getDefaultLanguage() {
       if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
          return parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
       else
          return parseDefaultLanguage(NULL);
    }

    function parseDefaultLanguage($http_accept, $deflang = "en") {
       if(isset($http_accept) && strlen($http_accept) > 1)  {
          # Split possible languages into array
          $x = explode(",",$http_accept);
          foreach ($x as $val) {
             #check for q-value and create associative array. No q-value means 1 by rule
             if(preg_match("/(.*);q=([0-1]{0,1}.\d{0,4})/i",$val,$matches))
                $lang[$matches[1]] = (float)$matches[2];
             else
                $lang[$val] = 1.0;
          }

          #return default language (highest q-value)
          $qval = 0.0;
          foreach ($lang as $key => $value) {
             if ($value > $qval) {
                $qval = (float)$value;
                $deflang = $key;
             }
          }
       }
       return strtolower($deflang);
    }

    function getDefLang($acceptLangs){
        if (empty($acceptLangs)) return;

        if (in_array(var_data_lang, $acceptLangs)) {
            return var_data_lang;
        }

        /**
        * Заменяем ключи массива по возрастанию
        */
        $keyToAsc = key_to_asc($acceptLangs);
        if (!empty($keyToAsc[0])) {
            return $keyToAsc[0];
        }
    }

    function getIdLang(){
    	$CI    = &get_instance();
    	$lang = $CI->lang->lang();    
    	$id_lang = array_search($lang, $CI->lang->languages);
    	return $id_lang;
    }