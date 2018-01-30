<?php
ini_set("memory_limit","128M");
 
define('HDOM_TYPE_ELEMENT', 1);
define('HDOM_TYPE_COMMENT', 2);
define('HDOM_TYPE_TEXT',    3);
define('HDOM_TYPE_ENDTAG',  4);
define('HDOM_TYPE_ROOT',    5);
define('HDOM_TYPE_UNKNOWN', 6);
define('HDOM_QUOTE_DOUBLE', 0);
define('HDOM_QUOTE_SINGLE', 1);
define('HDOM_QUOTE_NO',     3);
define('HDOM_INFO_BEGIN',   0);
define('HDOM_INFO_END',     1);
define('HDOM_INFO_QUOTE',   2);
define('HDOM_INFO_SPACE',   3);
define('HDOM_INFO_TEXT',    4);
define('HDOM_INFO_INNER',   5);
define('HDOM_INFO_OUTER',   6);
define('HDOM_INFO_ENDSPACE',7);

class WorldTranslateTwo {
    var $not_replace = array("noscript","label",".notranslate",'#jflanguageselection',"pre","a","img","textarea","input","script","style",'comment','option',"link","meta");
    var $not_replace_filter = array("noscript",".notranslate","script","style",'comment');
    var $correct;
    var $main_languages;
    var $translate_languages;
    var $setting;
    var $max_letters=5000;
    private $legal_site=array('AKFUB322DK823)M$K7d');
    var $max_query=127;
    var $base=null;
    var $javascript_tran=array();
    private $time=null;
    
    function __construct($option=false,$base=false) {     
        if($option!=false) {
            $this->setting=$option;
        } else {
            $this->setting=array(
                "basic_languages"=>"en",
                "notranslate"=>"",
                "url_not_translate"=>"",
                "javascript_translate"=>"",
                "detect_language"=>false,
                "info"=>false,
                "apikey"=>""
            );
        }
        if(!empty($base)) {
            $this->base=$base;
        }

        $this->javascript_tran=explode(",",$this->setting["javascript_translate"]);
        if($this->setting["info"]==true) {
            $this->time=microtime(1);   
        }
   }
    
    function get_world_translate($content="",$lang="") {
        if (!class_exists('xMSEhq')) {
            return $content;
        }
        $uri = &xMSEhq::ZZkLBUMXV();
        $url_not_translate=explode(",", $this->setting["url_not_translate"]);
        $url_not_translate=array_diff($url_not_translate,array(""));
        
        foreach($url_not_translate as $val) {
            if (preg_match("/$val/i", $uri->toString())) {
                return $content;
            } 
        }
        
        $get_info=new WorldGTranslate; 
        if(empty($lang) || empty($content) || $lang==$this->setting["basic_languages"] || $get_info->isValidLanguage(array($this->setting["basic_languages"],$lang))==false || $this->zend_guard()==false) {
            return $content;
        }
        
        if(!function_exists('rBXMaX_lBFV') || !function_exists('RQQRQHKRRILTP') || !function_exists('sdfLMKOMNwer') || !function_exists('qwertjkasdfi')) {
            return $content;
        } else {
            if(rBXMaX_lBFV()!=true || RQQRQHKRRILTP()!=true || sdfLMKOMNwer()!=true || qwertjkasdfi()!=true) {
                return $content;
            }
        }
        $this->translate_languages=$lang;
        if($this->setting["detect_language"]==true) {
            $lang="_to_".$lang;
        } else {
            $lang=$this->setting["basic_languages"]."_to_".$lang;
        }

        if(is_string($content)) {
            $finisarray=1;
            $content=array($content);
        }
        
        $content = $this->get_translate($content, $lang);
            
        if($finisarray==1) {
            $content=implode("",$content);
        }
    
        return $content;
    }
  
    private function clearnamesite($content) {
        $languages=WorldHelper::get_busssic_languages();
        $finisarray=null;
        if(is_string($content)) {
            $finisarray=1;
            $content=array($content);
        }
        
        foreach ($content as $key=>$val) {
            $html = new simple_html_dom;
            $html->load($val, true);
            foreach($html->find('a') as $element) {
                if(!empty($element->href)) {
                    $element->href=preg_replace("/\/$languages\//is","/", $element->href);
                }
            }
            foreach($html->find('option') as $element) {
                if(!empty($element->value)) {
                    $element->value=preg_replace("/\/$languages\//is","/", $element->value);
                }
            }
            $content[$key] = $html->save();
            $html->clear(); 
            unset($html);
        }
        
        if($finisarray==1) {
            $content=implode("",$content);
        }
            
        return $content;
    }
    
    private function array_trim(&$a){
        foreach( $a as $k => $v )
        {    
            if ( is_array( $a[$k] ) ) array_trim( $a[$k] );
            else $a[$k] = trim( $v );
            if ( empty($a[$k]) ) unset( $a[$k] );
        }
    } 

    private function get_translate($content, $lang) {   
            
            if($this->zend_guard_time()==false) return $content;
            $this->getalltrusite();
                     
            if(!empty($this->setting["notranslate"])) {
                $not_replace=explode(",",$this->setting["notranslate"]);
                $not_replace=array_diff($not_replace,array(""));
                $this->not_replace = array_merge($not_replace, $this->not_replace);
                $this->not_replace_filter = array_merge($not_replace, $this->not_replace_filter);   
            }
            
            foreach($content as $key=>$val) {
                 if(!empty($val)) {
                     
                 if(!empty($this->base)) {
                    if(preg_match("/<title>(.*?)<\/title>/is", $val)) {
                            $val = preg_replace("/<head(.*?)>/is", "<head>\n  <base href=\"".$this->base."\" />", $val);
                            $content[$key] = $val;
                    }
                 }
                 
                    if(!empty($this->setting["notworldstrans"])) {
                        $notworldstrans=explode(",",$this->setting["notworldstrans"]);
                        $notworldstrans=array_diff($notworldstrans,array(""));
                        foreach($notworldstrans as $notkey=>$notrval) {
                            $val=str_replace($notrval,'__ageent'.$notkey.'__',$val);
                        }
                    }
                    
                    $one_text_to_translit = $val;
                    if(!empty($one_text_to_translit)){ 
                        $find_and_replace_text = $this->find_and_replace_content($this->not_replace,$one_text_to_translit); 
                        
                        $test_empty = preg_replace("/<(.*?)>/is", "", $find_and_replace_text[0]);
                        $test_empty = trim($test_empty);
                        
                        if(!empty($test_empty)) {
                            $two_time_stamp = $this->world_translite_and_replace($find_and_replace_text[0], $lang);  
                            $end_content = implode("",$two_time_stamp);
                        } else {
                            $end_content = $find_and_replace_text[0];
                        }
                    }

                    foreach($find_and_replace_text[1] as $key_replace=>$real_repace_val) {
                        $end_content = str_replace('<p class="-_1_2_3_4_-" value="'.$key_replace.'">', $real_repace_val, $end_content);
                    }
                    $content[$key] = $end_content;
                    unset($two_time_stamp);
                 }
            }     

             $array_href = "";
             foreach($content as $href_val) {
                 $array_href .= $href_val."<span class=+you mast be replace+></span>";
             }
             $find_and_replace_text = $this->find_and_replace_content($this->not_replace_filter, $array_href, $lang);
             
             $array_href = $find_and_replace_text[0];
             $html = new simple_html_dom;
             $html->load($array_href, true);
             
             $replace_img = array();
             $replace_img_alt = array();
             foreach($html->find('img') as $element) {
             $replace_img[] = $element->outertext;
                if(!empty($element->alt)) {
                    $replace_img_alt[] = $element->alt;
                }
             }    

             /*foreach($replace_img as $key_replace=>$img_rep_val) {
                $array_href = str_replace("$img_rep_val","<ageent_img_id_$key_replace>", $array_href); 
             }*/

             $replace_href = array(); 
             foreach($html->find('a') as $element) {
                $worlds=$element->innertext;
                $worlds=preg_replace("/<img(.*?)>/is","",$worlds);
                if(!empty($worlds)) {
                    $replace_href[] = $element->innertext;
                }
             }
             
             $replace_href_alt = array(); 
             foreach($html->find('a') as $element) {
                if(!empty($element->alt)) {
                    $replace_href_alt[] = trim($element->alt);
                }
             }

             $replace_href_title = array();
             foreach($html->find('a') as $element) {
                 if(!empty($element->title)) {
                    $replace_href_title[] = trim($element->title);
                 }
             }
   
             $replace_meta = array(); 
             foreach($html->find('meta[name=keywords],meta[name=description],meta[name=title]') as $element) {
                if(!empty($element->content)) {    
                    $replace_meta[] = trim($element->content);
                }
             }
     
             $replace_title = array(); 
             foreach($html->find('title') as $element) {
                if(!empty($element->innertext)) {
                    $replace_title[] = $element->innertext;
                }
             }
            
             $replace_textarea = array(); 
             foreach($html->find('textarea') as $element) {
                 if(!empty($element->innertext)) {
                     $replace_textarea[] = $element->innertext;
                 }
             }
                 
             $replace_label= array(); 
             foreach($html->find('label') as $element) {
                 if(!empty($element->innertext)) {
                     $replace_label[] = $element->innertext;
                 }
             }
             
             $replace_option= array(); 
             foreach($html->find('option') as $element) {
                 if(!empty($element->innertext)) {
                     $replace_option[] = $element->innertext;
                 }
             }
             
             $replace_input = array(); 
             foreach($html->find('input') as $element) {
                if(is_string($element->value) && !is_numeric($element->value) && (strlen(trim($element->value))>0) && !preg_match("/_/s", $element->value) && !preg_match("/=/s", $element->value) && ($element->type!="hidden")) {
                    $replace_input[] = $element->value;
                }
             }  
             
             $all_massiv_replace = array_merge_recursive($replace_href, $replace_href_alt, $replace_href_title, $replace_meta, $replace_title, $replace_textarea, $replace_label,$replace_option,$replace_input, $replace_img_alt,$this->javascript_tran); 
                $all_massiv_replace_two = $this->translate_href_img_other($all_massiv_replace, $lang);
             $count_i = 0;
             foreach($html->find('a') as $element) {
                $worlds=$element->innertext;
                $worlds=preg_replace("/<img(.*?)>/is","",$worlds);
                if(!empty($worlds)) {
                        $element->innertext = trim($all_massiv_replace_two[$count_i++]);
                }
             }

             foreach($html->find('a') as $element) {
                if(!empty($element->alt)) {
                          $element->alt = trim($all_massiv_replace_two[$count_i++]);
                }
             }
                 
             foreach($html->find('a') as $element) {
                if(!empty($element->title)) {
                    $element->title = trim($all_massiv_replace_two[$count_i++]);
                }
             }
                 
             foreach($html->find('meta[name=keywords],meta[name=description],meta[name=title]') as $element) {
                if(!empty($element->content)) {
                    $element->content = trim($all_massiv_replace_two[$count_i++]);
                }
             }
                 
             foreach($html->find('title') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace_two[$count_i++]);
                }
             }
                 
             foreach($html->find('textarea') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace_two[$count_i++]);
                }
             }
             
             foreach($html->find('label') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace_two[$count_i++]);
                }
             }
             
             foreach($html->find('option') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace_two[$count_i++]);
                }
             }
             
             foreach($html->find('input') as $element) {
                if(is_string($element->value) && !is_numeric($element->value) && (strlen(trim($element->value))>0) && !preg_match("/_/s", $element->value) && !preg_match("/=/s", $element->value) && ($element->type!="hidden")) {
                    $element->value = trim($all_massiv_replace_two[$count_i++]);
                }
             }
             
             
             //$html_not_empty = $html;
             /*foreach($replace_img as $key_replace=>$img_rep_val) {
                    $html_not_empty = str_replace("<ageent_img_id_$key_replace>","$img_rep_val", $html_not_empty); 
             }*/
             
             /*$html_not_empty = $html->save();
             
             if(!empty($html_not_empty)) {
                $html->load($html_not_empty, true);
             }*/
             
             foreach($html->find('img') as $element) {
                if(!empty($element->alt)) {
                    $element->alt = $all_massiv_replace_two[$count_i++];
                }
             }
             
             if(!empty($this->setting["baseurl"])) { 
                 $blockjoomword=$this->setting["baseurl"];  
                 foreach($html->find('a') as $element) {
                    if(preg_match("|$blockjoomword|i", $element->href) || !preg_match("|http://|i", $element->href)) {
                        if(!preg_match('/worldlang/i', $element->href)) {
                            if(substr($element->href,0,1)!="#") {
                                if(!preg_match('/\?/i', $element->href)) {
                                    $element->href=$element->href."?worldlang=".$this->translate_languages;
                                } else {
                                    $element->href=$element->href."&worldlang=".$this->translate_languages;
                                }
                            }
                        }
                    }
                 } 
                 
                 foreach($html->find('form') as $element) {
                    if(preg_match("|$blockjoomword|i", $element->action) || !preg_match("|http://|i", $element->action)) {
                        if(!preg_match('/worldlang/i', $element->action)) {
                            if(!preg_match('/\?/i', $element->action)) {
                                $element->action=$element->action."?worldlang=".$this->translate_languages;
                            } else {
                                $element->action=$element->action."&worldlang=".$this->translate_languages;
                            }
                        }
                    }
                 } 
             }
             
             $html=$html->save();
             foreach($find_and_replace_text[1] as $key_replace=>$real_repace_val) {
                    $html = str_replace('<p class="-_1_2_3_4_-" value="'.$key_replace.'">', $real_repace_val, $html);
             }
            
             foreach($this->javascript_tran as $rep_val) {
                 $html=str_replace($rep_val,$all_massiv_replace_two[$count_i++],$html);
             }
             
             /*
             $find_text = new simple_html_dom;
             $find_text->load($html, true);
             $lang=explode("_",$lang);
             
             foreach($find_text->find(".translatelink") as $element) {
                 $link=WorldHelper::replace_href_text($element->href,$lang[2]);
                 $element->href=$link;
             }
             
             if(!empty($this->correct)) {
                 foreach($find_text->find($this->correct." a") as $element) {
                      $time_element = str_replace(JURI::base(),JURI::base().$lang[2],$element->href);
                      $element->href = str_replace(JURI::base().$lang[2].$lang[2],JURI::base().$lang[2],$time_element);
                 }
             }       
             
             if(preg_match("/ar|iw|yi|fa|ur/",$this->translate_languages)) {
                 foreach($find_text->find("body") as $element) {
                        $element->style = "text-align: right";
                        $element->dir = "rtl";
                    }
             }
                
             $html = $find_text;
             */
             
             if($this->setting["info"]==true) {
             $html=$html."\n\n<!--\n     generated by Wtranslator \n     time generated - ".sprintf("%0.2f",microtime(1)-$this->time)." seconds \n     memory_get_usage - ".$this->convert(memory_get_usage())."\n     memory_get_peak_usage - ".$this->convert(memory_get_peak_usage())."\n     date generated - ".date('l jS \of F Y h:i:s A')."\n     visit http://www.sitetranslation.org \n-->";
             //$html.=" time generated - ".sprintf("%0.2f",microtime(1)-$this->time);
             }
             
             
             if(!empty($this->setting["notworldstrans"])) {
                $notworldstrans=array_diff($notworldstrans,array(""));
                foreach($notworldstrans as $notkey=>$notrval) {
                    $html=str_replace('__ageent'.$notkey.'__',$notrval,$html);
                }
             }
             if(!empty($this->setting["exactranslate"])) {
                $exactrane=explode("|",$this->setting["exactranslate"]);
                foreach($exactrane as $xlone) {
                    $exactranslate=explode("=>",$xlone);
                    $html=str_replace($exactranslate[0],$exactranslate[1],$html);
                }
             }
             $content = explode("<span class=+you mast be replace+></span>", $html); 
             unset($html);
             unset($all_massiv_replace);
             unset($all_massiv_replace_two);
             return $content;
        } 

    private function convert($size) {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
     }

    private function find_and_replace_content($rules_replace, $one_text_to_translit) {
        $i = 0;
        $all_massiv_replace = array();
        $html = new simple_html_dom;
        $html->load($one_text_to_translit, true);
        foreach ($rules_replace as $replace_rul) {
            $all_massiv_replace_time = array();
            foreach($html->find($replace_rul) as $element) {
                $all_massiv_replace_time[] = $element->outertext;
                $all_massiv_replace[] = $element->outertext;
            }
            foreach ($all_massiv_replace_time as $two_val) {
                $one_text_to_translit = str_replace("$two_val",'<p class="-_1_2_3_4_-" value="'.$i.'">', $one_text_to_translit);   
                $i++;
            }      
        }
        $html->clear(); 
        unset($html);
        return array($one_text_to_translit, $all_massiv_replace);
    }

    private function world_translite_and_replace($one_text_to_translit, $lang) {
            $gt = new WorldGtranslate;
            if(strlen($this->setting["apikey"])!="") {
                $gt->api_key = $this->setting["apikey"];
            }
            $gt->setRequestType('curl');

            $one_divid = array($one_text_to_translit);
            
            if(!empty($one_divid)) {
            $two_time_stamp = array();
            foreach ($one_divid as $text_to_translit) {
                $text_translit = preg_replace("/{(.*?)}/is","", $text_to_translit);
                $html = new simple_html_dom;
                $html->load($text_translit, true);
                $text_translit = preg_replace("/<(.*?)>/is","___ageent___",$html->innertext);
                $html->clear(); 
                unset($html);
                $text_translit = preg_replace("/\n/is","___ageent___",$text_translit);
                $text_translit = explode("___ageent___",$text_translit);
                       
                $mass_for_translite = array();
                foreach($text_translit as $value) {
                    $value = trim($value);
                    if(!empty($value)) {
                        if(is_string($value) && (strlen($value)>1)) {
                            $timespace=preg_replace("/&nbsp;| |\?|!|@|#|$|%|\^|&|\*|\(|\)|\$|\.|,|\"|'|\/|:|\[|\]/is","",$value);
                            if(!is_numeric($timespace) && $timespace!="") {
                                $mass_for_translite[] = $value;
                            }
                        }
                    }
                }
                
                // read
                $handle = fopen(WORLDABSOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt","r");
                $get_html_file = '';
                while (!feof($handle)) {
                    $get_html_file .= fread($handle, 8192);
                }
                fclose($handle);
                //fclose($filename_now);

                $mass_fortranslat=array();
                if(!(empty($get_html_file))) {
                    $get_time_html_file=explode("{-[2]_}",$get_html_file);
                    $get_html_file=array();
                    foreach($get_time_html_file as $val) {
                        $val=explode("{-[1]_}",$val);
                        $onetimemom="";
                        foreach($val as $keytwo=>$twoval) {
                            if($keytwo==0) {
                                $onetimemom=$twoval;
                            } else {
                                $get_html_file[$onetimemom]=$twoval;
                            }
                        }
                    }

                    unset($get_time_html_file);
                    foreach($mass_for_translite as $key=>$val) {
                        if(array_key_exists($val, $get_html_file)) {
                            $mass_fortranslat[$val]=$get_html_file[$val];
                            unset($mass_for_translite[$key]);
                        }
                    }
                } else $get_html_file=array();
                // end read
                
                $finish_final_array = array_diff($mass_for_translite, $get_html_file);                 
    
                $created_massiv_trans = implode("<_$?*||_>",$mass_for_translite);
                if(empty($created_massiv_trans) && WorldHelper::array_empty($mass_fortranslat)) break;

                $all_array_tranalate=$this->divid_string($created_massiv_trans);

                $get_real_translate=$all_array_tranalate;
    
                $getmetranlation=array();
                foreach($all_array_tranalate as $key=>$val) {
                        if(!(WorldHelper::array_empty($val))) {
                            $all_array_tranalate[$key] = $gt->$lang($val);
                        } 
                }
                $getmetranlation=$all_array_tranalate;
                
                $allgooglearray=array();
                foreach($all_array_tranalate as $valarray) {
                    foreach($valarray as $renta) {
                        $allgooglearray[]=$renta;
                    }
                }
                
                $allreallearray=array();
                foreach($get_real_translate as $valarray) {
                    foreach($valarray as $renta) {
                        $allreallearray[]=$renta;
                    }
                }
                
                $find_key = array();
                foreach($allreallearray as $key_two=>$val_two) {
                    $len = strlen($val_two);
                    $find_key[$key_two] = $len;
                }
                arsort ($find_key);
                
                $final_array = array(); 
                foreach($find_key as $key_lol=>$val_lol) {
                    $final_array[$allreallearray[$key_lol]] = $allgooglearray[$key_lol];    
                }

                $finish_final_array = array(); 
                foreach ($final_array as $key_one=>$val_one) {
                    if(is_string($val_one) && !is_numeric($val_one) && (strlen(trim($key_one))>2) ) {
                        $finish_final_array[$key_one] = trim($val_one);
                    }
                }
                
                $finish_final_array = array_diff($finish_final_array, array("")); 
                
                // serialize
                // $fritevarebal=array_merge($get_html_file, $finish_final_array);
                $fritevarebal=array_unique($finish_final_array);
                $fwritecal="";
                foreach($fritevarebal as $key=>$val) {
                    $fwritecal.=$key."{-[1]_}".$val."{-[2]_}";
                }
                unset($fritevarebal);
                // end serialize
                
                $finish_final_array=array_merge($finish_final_array, $mass_fortranslat);
                
                $find_key = array();
                foreach($finish_final_array as $key_two=>$val_two) {
                    $len = strlen($val_two);
                    $find_key[$key_two] = $len;
                }
                arsort ($find_key);
                
                $final_array = array(); 
                foreach($find_key as $key_lol=>$val_lol) {
                    $final_array[$key_lol] = $finish_final_array[$key_lol];    
                }
                $finish_final_array=$final_array;
                unset($final_array);
                
                // write
                if(!$filename_now=fopen(WORLDABSOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt","a")) die ("No access to the file ".SOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt");
                flock($filename_now,2);
                fwrite($filename_now, $fwritecal);
                flock($filename_now,3);
                fclose($filename_now);
                // end write
                
                $close_array=array("!DOCTYPE","!--","ABBR","ACRONYM","ADDRESS","APPLET","AREA","BASE","BASEFONT","BDO","BGSOUND","BIG","BLINK","BLOCKQUOTE","BODY","BR","BUTTON","CAPTION","CENTER","CITE","CODE","COL","COLGROUP","DD","DEL","DFN","DIR","DIV","DL","DT","EM","EMBED","FIELDSET","FONT","FORM","FRAME","FRAMESET","H1","H2","H3","H4","H5","H6","HEAD","HR","HTML","IFRAME","IMG","INPUT","INS","ISINDEX","KBD","LABEL","LEGEND","LI","LINK","MAP","MARQUEE","MENU","META","NOBR","NOEMBED","NOFRAMES","NOSCRIPT","OBJECT","OL","OPTGROUP","OPTION","PARAM","PLAINTEXT","PRE","SAMP","SCRIPT","SELECT","SMALL","SPAN","STRIKE","STRONG","STYLE","SUB","SUP","TABLE","TBODY","TD","TEXTAREA","TFOOT","TH","THEAD","TITLE","TR","TT","UL","VAR","WBR","XMP","CLASS","form");
                foreach ($finish_final_array as $key_one=>$val_one) {
                    if(strlen($key_one)>1) {
                        if(($this->array_search_key($key_one,$close_array))===false){
                            $key_one = $this->clean_reguler($key_one);
                            $one_text_to_translit = preg_replace("/$key_one/s", $val_one, $one_text_to_translit); 
                        }
                    }
                }
                $one_text_to_translit;
                $two_time_stamp[] = $one_text_to_translit;
            }
               
               return $two_time_stamp;   
            }
    } 
    
    private function array_search_key($needle_key, $array) { 
      $valkey=strtoupper($needle_key);  
      foreach($array as $value){ 
         if($valkey==$value) {
             return true;
         }
      } 
      return false; 
    }

    private function translate_href_img_other($array_transl, $lang) {
            $gt = new WorldGtranslate;
            if(strlen($this->setting["apikey"])!="") {
                $gt->api_key = $this->setting["apikey"];
            }
            
            $gt->setRequestType('curl');
            foreach($array_transl as $key=>$val) {
                $array_transl[$key]=trim($val);
            }
    
            $handle = fopen(WORLDABSOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt","r");
            $get_html_file = '';
            while (!feof($handle)) {
                $get_html_file .= fread($handle, 8192);
            }
            fclose($handle);

            $mass_fortranslat=array();
            if(!(empty($get_html_file))) {
                $get_time_html_file=explode("{-[2]_}",$get_html_file);
                $get_html_file=array();
                foreach($get_time_html_file as $val) {
                    $val=explode("{-[1]_}",$val);
                    $onetimemom="";
                        foreach($val as $keytwo=>$twoval) {
                        if($keytwo==0) {
                            $onetimemom=$twoval;
                        } else {
                            $get_html_file[$onetimemom]=$twoval;
                        }
                    }
                }

                unset($get_time_html_file);
                foreach($array_transl as $key=>$val) {
                    if(array_key_exists($val, $get_html_file)) {
                        $mass_fortranslat[$key]=$get_html_file[$val];
                        unset($array_transl[$key]);
                    }
                }
            } else $get_html_file=array();
            
            $full_string=implode("<_$?*||_>",$array_transl);
            $kick_big=array();
            if(strlen($full_string)>$this->max_letters) {
                    while (strlen($full_string)>$this->max_letters) {
                            $nano_i=0;
                            do {
                                $seach_gap=substr($full_string,$this->max_letters-$nano_i,9);
                                if($seach_gap=="<_$?*||_>") {
                                    $nano=true;
                                    $nanorealtime=substr($full_string,0,$this->max_letters-$nano_i);
                                    $kick_big[]=$nanorealtime;
                                    $full_string=substr($full_string,$this->max_letters-$nano_i,strlen($full_string)-($this->max_letters-$nano_i));
                                } else {
                                    $nano=false;
                                }                  
                                $nano_i++;
                            } while ($nano==false);    
                    }

                    $kick_big[]=$full_string;
            } else {
                    $kick_big[] = $full_string;
            }

            foreach($kick_big as $key=>$val) {
                $kick_big[$key]=explode("<_$?*||_>",$val);
            }

            foreach($kick_big as $key=>$val) {
                    if($key!=0){
                        if($kick_big[$key][0]==""){
                            $kick_big[$key]=array_slice($kick_big[$key],1);
                        }
                    }
            }
            
            $regul_array=array();
            foreach($kick_big as $key=>$val) {
                if((WorldHelper::get_last_key($val)/$this->max_query)>1){
                    $time_val=array_chunk($val, $this->max_query);
                    foreach($time_val as $dentimeval) {
                        $regul_array[]=$dentimeval;
                    }
                } else {
                    $regul_array[]=$val;
                }
            }

            $regul_arraytwo=$regul_array;
            foreach($regul_array as $key=>$val) {
                if(!(WorldHelper::array_empty($val))) {
                    $regul_array[$key] = $gt->$lang($val);
                } 
            }
            
            $allgooglearray=array();
            $allgooglearraytwo=array();
            $finish_final_array=array();

            if(!(WorldHelper::array_empty($kick_big))) {
                foreach($regul_array as $valarray) {
                    foreach($valarray as $renta) {
                        $allgooglearray[]=$renta;
                    }
                }
                foreach($regul_arraytwo as $valarray) {
                    foreach($valarray as $renta) {
                        $allgooglearraytwo[]=$renta;
                    }
                }
                $finish_final_array=array_combine($allgooglearraytwo,$allgooglearray);
            }
            
            $fritevarebal=array_unique($finish_final_array);
            $fwritecal="";
            foreach($fritevarebal as $key=>$val) {
                $fwritecal.=$key."{-[1]_}".$val."{-[2]_}";
            }
            unset($fritevarebal);
            
            if(!$filename_now=fopen(WORLDABSOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt","a")) die ("No access to the file ".SOLUTE_PATH."/worldlibrary/librarytxt/".$this->translate_languages.".txt");
            flock($filename_now,2);
            fwrite($filename_now, $fwritecal);
            flock($filename_now,3);
            fclose($filename_now);
                
            foreach($mass_fortranslat as $key=>$val) {
                array_splice($allgooglearray, $key, 0, $val);
            }

            return $allgooglearray;
    }

    private function clean_reguler($value) {
            $value = preg_replace("/\//is", "\/", addslashes($value));
            $array_simvol = array("?","}","{",")","(","|","+","^","*","[","]",".");
            foreach ($array_simvol as $val) {
                $value = preg_replace("/\\$val/is", "\\".$val, $value);
            }
            $value = preg_replace('/\$/is', '\\\$', $value);
            return $value;
        }
       
    private function divid_string($created_massiv_trans) {
                $created_massiv_trans=explode("<_$?*||_>",$created_massiv_trans);
                $absolute_lol = array_diff($created_massiv_trans, array(""));
                $finish_lol_array = array_unique($absolute_lol);
                foreach($finish_lol_array as $key=>$val) {
                    $val=preg_replace("/&(.*?);/is","",$val);
                    if((strlen(trim($val))<2) ) {
                        unset($finish_lol_array[$key]);  
                    }
                }
                sort($finish_lol_array);
                
                $all_array_tranalate = array();
                $dlina=0;
                $timekey=0;
                $find_last = WorldHelper::get_last_key($finish_lol_array);
                foreach($finish_lol_array as $key=>$val) {
                    $time_val=strlen($val);
                    $dlina=$time_val+$dlina;
                    if((($dlina>$this->max_letters) && $key!=0) || (($key%$this->max_query==0) && $key!=0)) {
                            if($timekey!=0) {
                                $raznica=($key-1)-$timekey;
                            } else {
                                $raznica=$key-1;
                            }
                        $all_array_tranalate[]=array_slice($finish_lol_array,$timekey,$raznica);
                        $timekey=$key-1;
                        $dlina=$time_val;
                    }
                    if($find_last==$key) {
                        $all_array_tranalate[]=array_slice($finish_lol_array,$timekey,127);
                    }
                }
                return $all_array_tranalate;
    }
    
    private function zend_guard() {
        if($this->zend_guard_test()===true) {
            return true;
        } else {
            return false;
        }
    }
    
    private function zend_guard_test() {
        foreach($this->legal_site as $val) {
            
            $val=$this->dsCrypt($val,true);
            if($this->ver_site($val)===true) {
                    return true;
            }
            $time_val=strtolower($val);
            if($this->ver_site($time_val)===true) {
                    return true;
            }
            
            $time_val_www=preg_replace("/www\./i","",$val);
            if($this->ver_site($time_val_www)===true) {
                    return true;
            }
    
            $val=strtolower($val);
            $val=preg_replace("/www\./i","",$val);
            if($this->ver_site($val)===true) {
                    return true;
            }
        }
        return false;
    }
    
    private function ver_site($privatehost) {
        $uri = &xMSEhq::ZZkLBUMXV();
        $array_host_zero=array();
        if(isset($_ENV["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($_ENV["HTTP_HOST"]);
        if(isset($HTTP_ENV_VARS["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($HTTP_ENV_VARS["HTTP_HOST"]);
        if(isset($HTTP_HOST["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($HTTP_HOST["HTTP_HOST"]);
        if(isset($_SERVER["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($_SERVER["HTTP_HOST"]);
        if(isset($HTTP_SERVER_VARS["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($HTTP_SERVER_VARS["HTTP_HOST"]);
        
        if(isset($GLOBALS["_ENV"]["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($GLOBALS["_ENV"]["HTTP_HOST"]);
        if(isset($GLOBALS["HTTP_ENV_VARS"]["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($GLOBALS["HTTP_ENV_VARS"]["HTTP_HOST"]);
        if(isset($GLOBALS["HTTP_HOST"]["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($GLOBALS["HTTP_HOST"]["HTTP_HOST"]);
        if(isset($GLOBALS["_SERVER"]["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($GLOBALS["_SERVER"]["HTTP_HOST"]);
        if(isset($GLOBALS["HTTP_SERVER_VARS"]["HTTP_HOST"])) $array_host_zero[]=$this->get_fast_name($GLOBALS["HTTP_SERVER_VARS"]["HTTP_HOST"]);
        
        $vert_empty=implode("",$array_host_zero);

        if(strlen($vert_empty)>1) {
            $array_host_zero=array_unique($array_host_zero);
            $array_host_zero=array_diff($array_host_zero,array(""));
            sort($array_host_zero);
            if(count($array_host_zero)==1 && !empty($array_host_zero)) {
                $fist_element=$array_host_zero[0];
                if((($uri->ZYkL()===$privatehost) && $fist_element==$privatehost) || preg_match("#$privatehost#i",$fist_element)) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }
    }
    
    private function get_fast_name($name) {
        $time_var="";
        if(empty($name)) {
            $time_var="";
        } else {
            $time_var=$name;
        }
        return $time_var;
    }
    
    private function dsCrypt($input) {
        $o = $s1 = $s2 = array();
        $basea = array('?','(','@',';','$','#',"]","&",'*'); 
        $basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
        $basea = array_merge($basea, array(')','!','_','|','+','/','%','.','[',' ') );
        $dimension=9; 
        for($i=0;$i<$dimension;$i++) { 
            for($j=0;$j<$dimension;$j++) {
                $s1[$i][$j] = $basea[$i*$dimension+$j];
                $s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
            }
        }
        unset($basea);
        $m = floor(strlen($input)/2)*2; 
        $symbl = $m==strlen($input) ? '':$input[strlen($input)-1];
        $al = array();
        for ($ii=0; $ii<$m; $ii+=2) {
            $symb1 = $symbn1 = strval($input[$ii]);
            $symb2 = $symbn2 = strval($input[$ii+1]);
            $a1 = $a2 = array();
            for($i=0;$i<$dimension;$i++) {
                for($j=0;$j<$dimension;$j++) {
                        if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                        if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                }
            }
            if (sizeof($a1) && sizeof($a2)) {
                $symbn1 = $s1[$a1[0]][$a2[1]];
                $symbn2 = $s2[$a2[0]][$a1[1]];
            }
            $o[] = $symbn1.$symbn2;
        }
        if (!empty($symbl) && sizeof($al)) 
            $o[] = $s1[$al[1]][$al[0]];
        return implode('',$o);
    }
    
    private function zend_guard_time() {
        $end_time="";
        $result="";
        $time="";
        //$end_time="2010.10.04";
        if(!empty($end_time)) {
            $url = "http://www.ageent.ru/paypal/sitetranslation/";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            $result = curl_exec($ch);
            curl_close($ch);
        }

        if(!empty($result)) {
            list($ipsite, $time) = explode("|-|",$result);
            $ipsite=$this->dsCrypt($ipsite);
            $time=!empty($end_time) ? $this->dsCrypt($time) : "";
        }

        if(!empty($time)){
            if(strlen($time)>1) {
                if($end_time<$time) {
                        return false;
                } 
            }
        }
        return true;
    }
    
    private function getalltrusite() {
        $showalltruesite=isset($_GET["showalltruesite"])?$_GET["showalltruesite"]:"";
        if($showalltruesite==1) {
            foreach($this->legal_site as $key=>$val) {
                $val=$this->dsCrypt($val,true);
                echo ++$key.". ".$val."<br />";
            }
            exit;
        }
    }
}

class WorldGTranslate {
        private $url = "http://ajax.googleapis.com/ajax/services/language/translate";      
        private $api_version = "1.0";
        private $request_type = "http";
        private $available_languages_file       = "languages.ini";
        private $available_languages = array();
        private $api_key = null;
        
        public function __construct() {
                    $this->available_languages["AFRIKAANS"]="af";
                    $this->available_languages["ALBANIAN"]="sq";
                    $this->available_languages["AMHARIC"]="am";
                    $this->available_languages["ARABIC"]="ar";
                    $this->available_languages["ARMENIAN"]="hy";
                    $this->available_languages["AZERBAIJANI"]="az";
                    $this->available_languages["BASQUE"]="eu";
                    $this->available_languages["BELARUSIAN"]="be";
                    $this->available_languages["BENGALI"]="bn";
                    $this->available_languages["BIHARI"]="bh";
                    $this->available_languages["BULGARIAN"]="bg";
                    $this->available_languages["BURMESE"]="my";
                    $this->available_languages["CATALAN"]="ca";
                    $this->available_languages["CHEROKEE"]="chr";
                    $this->available_languages["CHINESE"]="zh";
                    $this->available_languages["CHINESE_SIMPLIFIED"]="zh-CN";
                    $this->available_languages["CHINESE_TRADITIONAL"]="zh-TW";
                    $this->available_languages["CROATIAN"]="hr";
                    $this->available_languages["CZECH"]="cs";
                    $this->available_languages["DANISH"]="da";
                    $this->available_languages["DHIVEHI"]="dv";
                    $this->available_languages["DUTCH"]="nl";
                    $this->available_languages["ENGLISH"]="en";
                    $this->available_languages["ESPERANTO"]="eo";
                    $this->available_languages["ESTONIAN"]="et";
                    $this->available_languages["FILIPINO"]="tl";
                    $this->available_languages["FINNISH"]="fi";
                    $this->available_languages["FRENCH"]="fr";
                    $this->available_languages["GALICIAN"]="gl";
                    $this->available_languages["GEORGIAN"]="ka";
                    $this->available_languages["GERMAN"]="de";
                    $this->available_languages["GREEK"]="el";
                    $this->available_languages["GUARANI"]="gn";
                    $this->available_languages["GUJARATI"]="gu";
                    $this->available_languages["HEBREW"]="iw";
                    $this->available_languages["HINDI"]="hi";
                    $this->available_languages["HUNGARIAN"]="hu";
                    $this->available_languages["ICELANDIC"]="is";
                    $this->available_languages["INDONESIAN"]="id";
                    $this->available_languages["INUKTITUT"]="iu";
                    $this->available_languages["ITALIAN"]="it";
                    $this->available_languages["IRELAND"]="ga";
                    $this->available_languages["JAPANESE"]="ja";
                    $this->available_languages["KANNADA"]="kn";
                    $this->available_languages["KAZAKH"]="kk";
                    $this->available_languages["KHMER"]="km";
                    $this->available_languages["KOREAN"]="ko";
                    $this->available_languages["KURDISH"]="ku";
                    $this->available_languages["KYRGYZ"]="ky";
                    $this->available_languages["LAOTHIAN"]="lo";
                    $this->available_languages["LATVIAN"]="lv";
                    $this->available_languages["LITHUANIAN"]="lt";
                    $this->available_languages["MACEDONIAN"]="mk";
                    $this->available_languages["MALAY"]="ms";
                    $this->available_languages["MALAYALAM"]="ml";
                    $this->available_languages["MALTESE"]="mt";
                    $this->available_languages["MARATHI"]="mr";
                    $this->available_languages["MONGOLIAN"]="mn";
                    $this->available_languages["NEPALI"]="ne";
                    $this->available_languages["ORIYA"]="or";
                    $this->available_languages["PASHTO"]="ps";
                    $this->available_languages["PERSIAN"]="fa";
                    $this->available_languages["POLISH"]="pl";
                    $this->available_languages["PORTUGUESE"]="pt";
                    $this->available_languages["PUNJABI"]="pa";
                    $this->available_languages["ROMANIAN"]="ro";
                    $this->available_languages["RUSSIAN"]="ru";
                    $this->available_languages["SANSKRIT"]="sa";
                    $this->available_languages["SERBIAN"]="sr";
                    $this->available_languages["SINDHI"]="sd";
                    $this->available_languages["SINHALESE"]="si";
                    $this->available_languages["SLOVAK"]="sk";
                    $this->available_languages["SLOVENIAN"]="sl";
                    $this->available_languages["SPANISH"]="es";
                    $this->available_languages["SWAHILI"]="sw";
                    $this->available_languages["SWEDISH"]="sv";
                    $this->available_languages["TAJIK"]="tg";
                    $this->available_languages["TAMIL"]="ta";
                    $this->available_languages["TAGALOG"]="tl";
                    $this->available_languages["TELUGU"]="te";
                    $this->available_languages["THAI"]="th";
                    $this->available_languages["INDIA"]="in";
                    $this->available_languages["TIBETAN"]="bo";
                    $this->available_languages["TURKISH"]="tr";
                    $this->available_languages["UKRAINIAN"]="uk";
                    $this->available_languages["URDU"]="ur";
                    $this->available_languages["UZBEK"]="uz";
                    $this->available_languages["UIGHUR"]="ug";
                    $this->available_languages["ISRAEL"]="yi";
                    $this->available_languages["VIETNAMESE"]="vi";
                    $this->available_languages["WELSH"]="cy";
                    $this->available_languages["NORWEGIAN"]="no";
                    $this->available_languages["UNKNOWN"]="";
        }
        
        private function urlFormat($lang_pair,$array){
                $src_texts_query = "";
                foreach ($array as $src_text){
                    //$src_text=iconv("windows-1251", "UTF-8", $src_text);
                    $src_texts_query .= "&q=".urlencode($src_text);
                }
                $lang_pair=implode("|",$lang_pair);
                $parameters = array("v=".urlencode($this->api_version).$src_texts_query,"&langpair=".urlencode($lang_pair)."&");

                if(!empty($this->api_key)) {
                        $parameters["key"] = $this->api_key;
                }

                $url  = implode("",$parameters);
                return $url;
        }

        public function setRequestType($request_type = 'http') {
                if (!empty($request_type)) {
                        $this->request_type = $request_type;
                        return true;
                }
                return false;
        }

        public function setApiKey($api_key) {
                if (!empty($api_key)) {
                        $this->api_key = $api_key;
                        return true;
                }
                return false;
        }

        public function query($lang_pair,$string){
            $query_url = $this->urlFormat($lang_pair,$string);
            $response = $this->{"request".ucwords($this->request_type)}($query_url);
            return $response; 
        }

        private function requestHttp($url){
                return WorldGTranslate::evalResponse(json_decode(file_get_contents($this->url."?".$url)));
        }

        private function requestCurl($url){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_REFERER, !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $url);
                $body = curl_exec($ch);
                curl_close($ch);
                return WorldGTranslate::evalResponse(json_decode($body));
        }

        private function evalResponse($json_response){
                $all_translate=array();
                if(is_array($json_response->responseData)) {
                    foreach($json_response->responseData as $val) {
                        @$all_translate[]=$val->responseData->translatedText;
                    }
                } else {
                        $all_translate[]=$json_response->responseData->translatedText;
                }
                return $all_translate;
        }

        public function isValidLanguage($languages) {
                $language_list  = $this->available_languages;
                $languages              =       array_map( "strtolower", $languages );
                $language_list_v        =       array_map( "strtolower", array_values($language_list) );
                $language_list_k        =       array_map( "strtolower", array_keys($language_list) );
                $valid_languages        =       false;
                if( TRUE == in_array($languages[0],$language_list_v) AND TRUE == in_array($languages[1],$language_list_v) ) {
                        $valid_languages        =       true;   
                }
                if( FALSE === $valid_languages AND TRUE == in_array($languages[0],$language_list_k) AND TRUE == in_array($languages[1],$language_list_k) ) {
                        $languages      =       array($language_list[strtoupper($languages[0])],$language_list[strtoupper($languages[1])]);
                        $valid_languages        =       true;
                }
                if( FALSE === $valid_languages ) {
                        return false;
                }
                return $languages;
        }

        public function __call($name,$args) {
                $languages_list         =       explode("_to_",strtolower($name));
                $languages = $this->isValidLanguage($languages_list);
                $string         =       $args[0];
                return $this->query($languages,$string);;
        }
}

class WorldHelper {
    
    function get_setting() {
        $component = JComponentHelper::getComponent('com_joomglobaltranslate');
        $params = new JParameter( $component->params );
        $params=explode("\n",$params->_raw);
        $get_result_array=array();
        foreach($params as $val) {
            $value_1=preg_replace("/(.*?)=(.*)/i","$1",$val);
            $value_2=preg_replace("/(.*?)=(.*)/i","$2",$val);
            $get_result_array[$value_1]=trim($value_2);
        }

        return $get_result_array;
    }
    
    function get_cur_languages($referelpage) {
        $db =& JFactory::getDBO();
        $geturl=parse_url($referelpage);
        $getarraylang=explode("/",$geturl["path"]); 
        $getarraylang=array_diff($getarraylang,array(""));
        foreach($getarraylang as $val) {
            $db->setQuery("SELECT shortcode FROM #__languages WHERE shortcode='{$val}'");
            $db->query();
            $get_result=$db->loadResult();
            if(strlen($get_result)!=0) {
                return $get_result;  
            }
        } 
    } 
    
    function array_empty($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $value) {
                if (!(WorldHelper::array_empty($value))) {
                    return false;
                }
            }
        }
        elseif (!empty($mixed)) {
            return false;
        }
        return true;
    }
    
    function getlastindex($filename) {
        return end(explode(".", $filename));
    }
    
    function replace_href_text($current_url,$lang) {
        return $current_url;
    }
    
    function whois($ip) {
        if ($ip!="") {
            $sock = fsockopen ("whois.ripe.net",43,$errno,$errstr);
                if ($sock) {
                    fputs ($sock, $ip."\r\n");
                    $str="";
                    while (!feof($sock)) {
                    $str.=trim(fgets ($sock,128)." <br>");
                }
            }
                else {
                    $str.="$errno($errstr)";
                    return;
            }
            fclose ($sock);
        }
        $str=preg_replace("/(.*?)country:(.*?)\n(.*)/is","$2",$str);
        $str=strtolower(trim($str));
        $str=reset(explode(" ", $str));
        return $str;
  } 
  
    function get_busssic_languages($db=null) {
        if($db==null) {
            $params = JComponentHelper::getParams('com_languages');
            $params_one = $params->get("site", 'en-GB');
            $db =& JFactory::getDBO();
            $db->setQuery("SELECT shortcode FROM #__languages WHERE code='{$params_one}'");
            $db->query();
            $params_one=$db->loadResult();
        } else {
            $params = JComponentHelper::getParams('com_languages');
            $params_one = $params->get("site", 'en-GB');
        }
        return $params_one;
    }
    
    function set_busic_languages() {
        $setting=WorldHelper::get_setting();
        $uri = &xMSEhq::ZZkLBUMXV();
        $lang=$uri->getVar("lang","");
        $option=$uri->getVar("option","");
        
        if(empty($lang)) {
            if (preg_match("/$option/i", $setting["ajax_requests"]) && !empty($option)) {
                $lang=$_COOKIE["jfcookie"]["lang"];
                JRequest::setVar('lang', $lang, "GET");
                JRequest::setVar('globalajaxlang', $lang, "POST");
                JRequest::setVar('lang', $lang, "REQUEST");
                JRequest::setVar('lang', $lang, "COOKIE");  
            } else {
                $mainlanguages=WorldHelper::get_busssic_languages();
                JRequest::setVar('lang', $mainlanguages, "GET");
                JRequest::setVar('lang', $mainlanguages, "POST");
                JRequest::setVar('lang', $mainlanguages, "REQUEST");
                JRequest::setVar('lang', $mainlanguages, "COOKIE");
            }
        }
    }
    
    function get_brouser_languages() {
        $db =& JFactory::getDBO();
        $uri = &xMSEhq::ZZkLBUMXV();

        $db->setQuery("SELECT shortcode FROM #__languages");
        $db->query();
        $params_one=$db->loadObjectList();
        
        $active_isocountry=array();
        foreach ($params_one as $alang) {
               $active_isocountry[substr($alang->shortcode,0,2)] = $alang->shortcode;
        }
        
        $browserLang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        
        foreach($active_isocountry as $blang=>$val) {
            if($blang==substr($browserLang,0,2)) {
                return $val;
            }
        }
    }
    
    function deletecore($path) {
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) { 
            if ($file<>"." AND $file<>"..") {
                if ($file != "." && $file != "..") { 
                  if (preg_match("/core\.([0-9].*)/i", $file)) {
                        $real_file=$path."/".$file;
                        @chmod($real_file, 0777); 
                        @unlink($real_file);
                  }
                } 
             }
          }
        } 
    }
    
    function oneredirecting($config) {
        global $mainframe;
        $db =& JFactory::getDBO();
        $uri = &JURI::ZZkLBUMXV();
        $thisiscurl=null;
        if(isset($_COOKIE["thisiscurl"])) {
            $thisiscurl=$_COOKIE["thisiscurl"];
        }
        jimport('joomla.environment.browser');
        $instance =& JBrowser::ZZkLBUMXV();
        if($instance->isRobot()==false) {
        if($config["usingip"]!="not_define" && $thisiscurl!=1) {
            if(empty($_COOKIE["jfcookie"]["lang"]) && empty($_SESSION['definition_language'])) {
                if($config["usingip"]=="identify_ip") {
                    $whois = GlobalHelper::whois($_SERVER['REMOTE_ADDR']);
                } else {
                    $whois = GlobalHelper::get_brouser_languages();
                    if($whois==false) return false;
                }

                $db->setQuery("SELECT shortcode FROM `#__languages` WHERE code LIKE '%{$whois}%'");
                $db->query();
                $whois_life=$db->loadResult();
                if(!empty($whois_life)) {
                    $_SESSION['definition_language']=1;
                    $realconfig = new JConfig();
                    if($realconfig->sef==1) {
                        $curpatch_ar=str_replace($uri->base(),"",$uri->current());
                        $curpatch_ar=explode("/",$curpatch_ar);
                        $curpatch=array_shift($curpatch_ar);
                        $end_url=implode("/",$curpatch_ar);

                        $curpatch=preg_replace("/\.(.*)/i","",$curpatch);
                        $db->setQuery("SELECT shortcode FROM `#__languages` WHERE code LIKE '%{$curpatch}%'");
                        $db->query();
                        $cururl=$db->loadResult();
                        if(!empty($cururl)) {
                            if(!empty($end_url)) {
                                $href=$uri->base().$whois_life."/".$end_url;
                            } else {
                                $href=$uri->base().$whois_life;
                            }
                        } else {
                            $href=$uri->base().$whois_life."/".$curpatch."/".$end_url;
                        }
                        
                        if($config["suffix"]==1) {
                            if(GlobalHelper::get_busssic_languages()==$whois_life) {
                                $href=str_replace("/$whois_life","",$href);
                            }
                        }
                    } else {
                        $getask=$uri->getQuery();
                        if(empty($getask)) {
                            $href=$uri->base()."index.php?lang=".$whois_life;
                        } else {
                            parse_str($getask,$task);
                            $task["lang"]=$whois_life;
                            $needurl="";
                            foreach($task as $key=>$val) {
                                $needurl.="&".$key."=".$val;
                            }
                            $prevendurl=substr($needurl,1,strlen($needurl));
                            $href=$uri->base()."index.php?".$prevendurl;
                        } 
                    }
                        echo '<script type="text/javascript">window.location="'.$href.'";</script>';
                        $mainframe->close();       
                }
            }
        }
        }
    }
    
    function clearallcash($manual=false) {
        global $mainframe;
        if (($mainframe->isAdmin() && JRequest::getCmd('cleanglobalcache')== 1) || $manual==true) {
            $cache =& JFactory::getCache();
            $cache->clean();
            $cache->gc();
            jimport('joomla.filesystem.folder');
            jimport('joomla.filesystem.file');
            for ( $_i = 0; $_i < 2; $_i++) {
                $client     =& JApplicationHelper::getClientInfo($_i);
                $files = JFolder::files( $client->path.DS.'cache' );
                foreach ( $files as $file ) {
                    if ( $file != 'index.html' ) {
                        JFile::delete( $client->path.DS.'cache'.DS.$file );
                    }
                }
            }
            $_db =& JFactory::getDBO();
            $_db->setQuery( 'TRUNCATE TABLE `#__jrecache_repository`' );
            $_db->query();
        } else if($mainframe->isAdmin()) {
            return;
        }
    }
    
    function get_last_key($array) {
        if (!is_array($array)) return null;
        if (!count($array)) return false;
        end($array);
        return key($array);
    }
    
    function clenbigpage($get_array, $hash,$patchtocash,$nowurl) {
                $namedelfile=array();
                foreach($get_array as $language) {
                    if($language->shortcode!="") {
                         $id=$nowurl."?lang=".$language->shortcode;
                    } else {
                         $id=$nowurl;
                    }

                    $id_one=md5($id);
                    $name = md5('-'.$id_one.'-'.$hash.'-'.$language->code);
                    $delfile=array();
                    $delfile[]=$name.".php";
                    $delfile[]=$name.".php_expire";
                    
                    foreach($delfile as $file) {
                        if(file_exists($patchtocash.$file)) {
                            $namedelfile[]=$id;
                            chmod($patchtocash.$file, 0777);
                            unlink($patchtocash.$file);
                        }
                    }
                }
                $namedelfile=array_unique($namedelfile);
                $namedelfile=implode("\n",$namedelfile);
                return $namedelfile;
    }
    
    function fronted_page($get_array, $hash,$patchtocash,$nowurl) {
                
                $namedelfile=array();
                foreach($get_array as $language) {
                    $id_one=md5($nowurl);
                    $name = md5('-'.$id_one.'-'.$hash.'-'.$language->code);
                    $delfile=array();
                    $delfile[]=$name.".php";
                    $delfile[]=$name.".php_expire";
                    
                    foreach($delfile as $file) {
                        if(file_exists($patchtocash.$file)) {
                            $namedelfile[]=$nowurl;
                            chmod($patchtocash.$file, 0777);
                            unlink($patchtocash.$file);
                        }
                    }
                }
                
                $uri = &JFactory::getURI(xMSEhq::root());
                $nowurl=$uri->toString(array('path', 'query'));
                
                if(substr($nowurl,-1,1)=="/" && strlen($nowurl)>1) {
                     $nowurl=substr($nowurl,0,strlen($nowurl)-2);
                } else {
                    $nowurl="";
                }
                foreach($get_array as $language) {
                    $id=$nowurl."?lang=".$language->shortcode;
                    $id_one=md5($id);
                    $name = md5('-'.$id_one.'-'.$hash.'-'.$language->code);
                    $delfile=array();
                    $delfile[]=$name.".php";
                    $delfile[]=$name.".php_expire";
                    
                    foreach($delfile as $file) {
                        if(file_exists($patchtocash.$file)) {
                            $namedelfile[]=$id;
                            chmod($patchtocash.$file, 0777);
                            unlink($patchtocash.$file);
                        }
                    }
                }
                
                $namedelfile=array_unique($namedelfile);
                $namedelfile=implode("\n",$namedelfile);
                return $namedelfile;
    }
    
    function start_page($get_array, $hash,$patchtocash,$nowurl) {
                foreach($get_array as $language) {
                    $time_time=$language->shortcode;
                    if(preg_match("/\/$time_time/i",$nowurl)) {
                        $nowurl=preg_replace("/\/$time_time(.*?)\?/i","?",$nowurl);
                        break;
                    }
                }

                $namedelfile=array();
                foreach($get_array as $language) {
                    if($language->shortcode!="") {
                         $id=$nowurl."&lang=".$language->shortcode;
                    } else {
                         $id=$nowurl;
                    }

                    $id_one=md5($id);
                    $name = md5('-'.$id_one.'-'.$hash.'-'.$language->code);
                    $delfile=array();
                    $delfile[]=$name.".php";
                    $delfile[]=$name.".php_expire";
                    
                    foreach($delfile as $file) {
                        if(file_exists($patchtocash.$file)) {
                            $namedelfile[]=$id;
                            chmod($patchtocash.$file, 0777);
                            unlink($patchtocash.$file);
                        }
                    }
                }
                $namedelfile=array_unique($namedelfile);
                $namedelfile=implode("\n",$namedelfile);
                return $namedelfile;
    }
}
?>