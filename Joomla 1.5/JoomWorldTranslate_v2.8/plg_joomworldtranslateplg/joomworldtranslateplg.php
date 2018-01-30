<?php
/**
 * Joom Global Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!class_exists('GTranslate')) require (JPATH_PLUGINS."/system/worldtranslate/worldhelpertranlate/worldhelpertranlate.php");
if(!class_exists('simple_html_dom_node')) require (JPATH_PLUGINS."/system/worldtranslate/worldhelperparserhtml/worldhelperparserhtml.php");

ini_set("memory_limit","128M");


class  plgSystemJoomworldtranslateplg  {
    var $filename;
    var $setting;
    var $onlyou_url;
    
    function plgSystemJoomworldtranslateplg() {
        global $mainframe;
        
        $uri = &JURI::getInstance();
        $this->onlyou_url = JUtility::getHash(JURI::root());
        $this->setting=GlobalHelper::get_setting();
        
        GlobalHelper::detectlangbrouser($this->setting);
        GlobalHelper::set_busic_languages();
        
        GlobalHelper::clearallcash(); 
        
        if($mainframe->isAdmin()) {
            return;
        }

        if (empty($this->setting["JoomworldtranslatJoomlaVersion"])) {
          $this->save_need_file();  
        } else {
              if($this->setting["JoomworldtranslatJoomlaVersion"]!=JVERSION) {
                  $this->save_need_file(true);  
              }  
        }
        
        GlobalHelper::deletecore(JPATH_ROOT);
    }
    
    function save_need_file() {
            $db =& JFactory::getDBO();
            $patch_libraries = JPATH_LIBRARIES."/joomla/document/html/html.php";
            @chmod($patch_libraries, 0777);
            
            $html_file = fopen($patch_libraries, "r+");
            $get_html_file = "";
            while(!feof($html_file)) {
               $get_html_file .= fgets($html_file, 1024); 
            }
            if(!preg_match('/new WorldTranslate/is', $get_html_file)) {
                $text_to_write = '
                    $data = $this->_parseTemplate($data);
                    if (class_exists("WorldTranslate")) {
                        $get_translate = new WorldTranslate();
                        $data = $get_translate->get_world_translate($data);
                    }';
                $get_html_file = str_replace('$data = $this->_parseTemplate($data);', $text_to_write, $get_html_file);
                $html_file = fopen($patch_libraries, "w+");
                fwrite($html_file, $get_html_file);
            }
            
            $this->setting["JoomworldtranslatJoomlaVersion"]=JVERSION;

            $db->setQuery('UPDATE #__configjoomwtranslate SET JoomworldtranslatJoomlaVersion="'.$this->setting["JoomworldtranslatJoomlaVersion"].'"');
            $db->query(); 
        
            @chmod($this->filename, 0444); 
            @chmod($patch_libraries, 0444);  
    }
}

class WorldTranslate {
    var $not_replace = array("noscript","label",".notranslate",'#jflanguageselection',".rj_insertcode","a","img","textarea","input","script","style",'comment','option',"link","meta");
    var $not_replace_filter = array("noscript","script","style",'comment',".rj_insertcode",".notranslate");
    var $correct;
    var $main_languages;
    var $setting;
    var $translate_languages;
    var $max_letters=5000;
    var $max_query=127;
    var $javascript_tran=array();
    
    function WorldTranslate($one=false) {
        if($one==true) {
            GlobalHelper::set_busic_languages();
        }
    }
    
    function get_world_translate($content,$default_languages=false) {
        global $mainframe;
        $finisarray=null;
        $defence = new GlobalHelper();
        if($defence->zend_guard()==false) {
            return $content;
        }
        $this->setting=GlobalHelper::get_setting();

        if(($mainframe->isAdmin() || $this->setting["enable"]==0) && $default_languages==false) {
            return $content;
        }
        
        $this->javascript_tran=explode(",",$this->setting["worldsjs"]);
        
        $plugin = &JPluginHelper::getPlugin('system', 'joomworldtranslateplg');
        $params_now = new JParameter($plugin->params);

        $uri = &JURI::getInstance();
        $lang=$_REQUEST["lang"];
        
        $this->main_languages = GlobalHelper::get_busssic_languages();
        $dont_tranlate = $this->setting["notranslate"];
        
        if(!empty($_POST["globalajaxlang"])) {
            $lang = $_POST["globalajaxlang"];
        }
        if(is_array($content)) {
            $fortesteditor=implode("",$content);
        } else {
            $fortesteditor=$content;
        }
        if ((!empty($lang) && $lang!=$this->main_languages) || $default_languages!=false || $this->setting["source_detect_language"]=="source_detect_language" ||preg_match("{detectedsourcelang on}",$fortesteditor) || $this->texturl($uri)==true) {
            
            if(is_string($content)) {
                $finisarray=1;
                $content=array($content);
            }
        
            if(!empty($this->main_languages)) {
                // for ajax_requests
                $explode_lang=explode(",",$this->setting["ajax_requests"]);
                $explode_lang=array_diff($explode_lang,array(""));
                $find_vareb=0;
                foreach($explode_lang as $getval) {
                    if(preg_match("/$getval/i",$uri->toString())) {
                        $find_vareb=1;
                        break;
                    }
                }
                
                $this->translate_languages=$lang;
                if(($find_vareb==1) || $this->setting["detect_language"]==1) {      
                    $lang = "_to_".$lang;
                } else {
                    $lang = $this->main_languages."_to_".$lang;
                }
            } else {
                return $content;
            } 
            
            if(!empty($dont_tranlate)) {
                $dont_tranlate = explode(",", $dont_tranlate);
                $this->array_trim($dont_tranlate);
            }
            if($default_languages!=false) {
                $lang=$default_languages;
                $this->translate_languages=preg_replace("/(.*?)_(.*?)_/is","",$default_languages);
            }
            
            if(($this->setting["source_detect_language"]=="source_detect_language" || preg_match("{detectedsourcelang on}",$fortesteditor)) && $this->translate_languages=="") {
                $lang="_to_".$this->main_languages;
                if(is_string($content)) {
                    $content=str_replace("{detectedsourcelang on}","",$content);
                } else {
                    $content=implode("{dividethearray}",$content);
                    $content=str_replace("{detectedsourcelang on}","",$content);
                    $content=explode("{dividethearray}",$content);
                }
            }
            unset($fortesteditor);
            
            $content = $this->get_translate($content, $lang, $dont_tranlate);
            
            if($finisarray==1) {
                $content=implode("",$content);
            }
            
        } 
        
        // if site disable support for two languages
        if($this->setting["suffix"]==1) {
            $content=$this->clearnamesite($content);
        }
            
        return $content;
    }
    
    function texturl($uri) {
        $explode_lang=explode(",",$this->setting["ajax_requests"]);
        $explode_lang=array_diff($explode_lang,array(""));
        foreach($explode_lang as $getval) {
            if(preg_match("/$getval/i",$uri->toString())) {
                return true;
            }
        }
        return false;
    }
     
    function clearnamesite($content) {
        $languages=GlobalHelper::get_busssic_languages();
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
            $content[$key] = (string) $html;
            $html->clear(); 
            unset($html);
        }
        
        if($finisarray==1) {
            $content=implode("",$content);
        }
            
        return $content;
    }
    
    function array_trim(&$a){
        foreach( $a as $k => $v )
        {    
            if ( is_array( $a[$k] ) ) array_trim( $a[$k] );
            else $a[$k] = trim( $v );
            if ( empty($a[$k]) ) unset( $a[$k] );
        }
    } 

    function get_translate($content, $lang, $not_replace=false) {   
            $defence = new GlobalHelper();
            if($this->zend_guard_time()==false) return $content;
            $defence->getalltrusite();
            if($defence->zend_guard()==false) {
                return $content;
            }
            if($not_replace!=false) {
                $this->not_replace = array_merge($not_replace, $this->not_replace);
                $this->not_replace_filter = array_merge($not_replace, $this->not_replace_filter);   
            }
            
            $array_href = "";
            foreach($content as $href_val) {
                $array_href .= $href_val."<span class=+you mast be replace+></span>";
            }
            $content=array($array_href);
            
            foreach($content as $key=>$val) {
                 if(!empty($val)) {
                    /* if(preg_match("/<title>(.*?)<\/title>/is", $val)) {
                        if(preg_match("/<meta name=.keywords./is", $val)) {
                            $val = preg_replace("/<\/title>/is", "</title>\n  <!-- This page is generated JoomWorldTtranslate www.ageent.ru -->", $val);
                            $content[$key] = $val;
                        }
                    } */
                    if(!empty($this->setting["notworldstrans"])) {
                        $notworldstrans=explode(",",$this->setting["notworldstrans"]);
                        $notworldstrans=array_diff($notworldstrans,array(""));
                        foreach($notworldstrans as $notkey=>$notrval) {
                            $val=str_replace($notrval,'__ageent'.$notkey.'__',$val);
                        }
                    }
                    
                    $one_text_to_translit = $val;
                    if(!empty($one_text_to_translit)){ 
                        $find_and_replace_text = $this->find_and_replace_content($this->not_replace,$one_text_to_translit); // cut content that will not be replaced. return aray (content, cut text)
                             
                        $test_empty = preg_replace("/<(.*?)>/is", "", $find_and_replace_text[0]);
                        $test_empty = trim($test_empty);
                        
                        if(!empty($test_empty)) {
                            $two_time_stamp = $this->world_translite_and_replace($find_and_replace_text[0], $lang); // translation method  
                            $end_content = implode("",$two_time_stamp);
                        } else {
                            $end_content = $find_and_replace_text[0];
                        }
                    }
                    //print_r($find_and_replace_text);   
                    foreach($find_and_replace_text[1] as $key_replace=>$real_repace_val) {
                        $end_content = str_replace('<p class="-_1_2_3_4_-" value="'.$key_replace.'">', $real_repace_val, $end_content);
                    }
                    $content[$key] = $end_content;
                    unset($two_time_stamp);
                 }
            }     
             // End replace content 
             
             $find_and_replace_text = $this->find_and_replace_content($this->not_replace_filter, $content[0], $lang);

             $array_href = $find_and_replace_text[0];
             $html = new simple_html_dom;
             $html->load($array_href, true);
             
             // cut image and alt
             $replace_img = array();
             $replace_img_alt = array();
             foreach($html->find('img') as $element) {
             $replace_img[] = $element->outertext;
                if(!empty($element->alt)) {
                    $replace_img_alt[] = $element->alt;
                }
             }    
             //print_r($replace_img_alt);
                 
             // replace cut image
             /*foreach($replace_img as $key_replace=>$img_rep_val) {
                $array_href = str_replace("$img_rep_val","<ageent_img_id_$key_replace>", $array_href); 
             }*/

             foreach($html->find('a') as $element) {
                $worlds=$element->innertext;
                $worlds=preg_replace("/<img(.*?)>/is","",$worlds);
                if(!empty($worlds)) {
                    $replace_href[] = $element->innertext;
                }
             }
             
             // alt in href
             $replace_href_alt = array(); 
             foreach($html->find('a') as $element) {
                if(!empty($element->alt)) {
                    $replace_href_alt[] = trim($element->alt);
                }
             }
             //print_r($replace_href); 
                      
             // title in href
             $replace_href_title = array();
             foreach($html->find('a') as $element) {
                 if(!empty($element->title)) {
                    $replace_href_title[] = trim($element->title);
                 }
             }
             //print_r($replace_title);
                 
             // replace meta      
             $replace_meta = array(); 
             foreach($html->find('meta[name=keywords],meta[name=description],meta[name=title]') as $element) {
                if(!empty($element->content)) {    
                    $replace_meta[] = trim($element->content);
                }
             }
             // print_r($replace_meta)
                     
             // replace title      
             $replace_title = array(); 
             foreach($html->find('title') as $element) {
                if(!empty($element->innertext)) {
                    $replace_title[] = $element->innertext;
                }
             }
             // print_r($replace_meta)
            
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
             
             $all_massiv_replace = array_merge_recursive($replace_href, $replace_href_alt, $replace_href_title, $replace_meta, $replace_title, $replace_textarea, $replace_label,$replace_option,$replace_input, $replace_img_alt,$this->javascript_tran); // get all infa for replace href, img
                $all_massiv_replace = $this->translate_href_img_other($all_massiv_replace, $lang); // get translate array
             $count_i = 0;
             foreach($html->find('a') as $element) {
                $worlds=$element->innertext;
                $worlds=preg_replace("/<img(.*?)>/is","",$worlds);
                if(!empty($worlds)) {
                        $element->innertext = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             foreach($html->find('a') as $element) {
                if(!empty($element->alt)) {
                          $element->alt = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             foreach($html->find('a') as $element) {
                if(!empty($element->title)) {
                    $element->title = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             foreach($html->find('meta[name=keywords],meta[name=description],meta[name=title]') as $element) {
                if(!empty($element->content)) {
                    $element->content = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             foreach($html->find('title') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             foreach($html->find('textarea') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace[$count_i++]);
                }
             }
             
             foreach($html->find('label') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace[$count_i++]);
                }
             }
             
             foreach($html->find('option') as $element) {
                if(!empty($element->innertext)) {
                    $element->innertext = trim($all_massiv_replace[$count_i++]);
                }
             }
             
             foreach($html->find('input') as $element) {
                if(is_string($element->value) && !is_numeric($element->value) && (strlen(trim($element->value))>0) && !preg_match("/_/s", $element->value) && !preg_match("/=/s", $element->value) && ($element->type!="hidden")) {
                    $element->value = trim($all_massiv_replace[$count_i++]);
                }
             }
                 
             /*$html_not_empty = $html;
             foreach($replace_img as $key_replace=>$img_rep_val) {
                    $html_not_empty = str_replace("<ageent_img_id_$key_replace>","$img_rep_val", $html_not_empty); 
             }
             
             $html_not_empty = (string) $html_not_empty;
             
             if(!empty($html_not_empty)) {
                $html->load($html_not_empty, true);
             }
             */
             
             foreach($html->find('img') as $element) {
                if(!empty($element->alt)) {
                    $element->alt = $all_massiv_replace[$count_i++];
                }
             } 
             
             if(preg_match("/ar|iw|yi|fa|ur/",$this->translate_languages)) {
                 foreach($html->find("body") as $element) {
                        $element->style = "text-align: right";
                        $element->dir = "rtl";
                 }
             }
             
             $uri = &JURI::getInstance();
             $blockjoomword=$uri->base();
             if(!empty($this->setting["urlnotprocessed"])) {
                 $urlnotprocessed=$this->setting["urlnotprocessed"];
                 $urlnotprocessed=$this->clean_reguler($urlnotprocessed);
                 $urlnotprocessed=str_replace(",","|",$urlnotprocessed);
                 $urlnotprocessed="|".str_replace(" ","",$urlnotprocessed);
             } else {
                 $urlnotprocessed="";
             }
             
             if($this->translate_languages!="") {
                 
                 foreach($html->find('a') as $element) {
                        if(preg_match("|$blockjoomword|i", $element->href) || !preg_match("|http://|i", $element->href)) {
                            if(!preg_match('/&lang|\?lang|lang=/i', $element->href)) {
                                    if(!preg_match("/\/af\/|\/ar\/|\/be\/|\/bg\/|\/ca\/|\/cs\/|\/cy\/|\/da\/|\/de\/|\/el\/|\/es\/|\/et\/|\/fa\/|\/fi\/|\/fr\/|\/ga\/|\/gl\/|\/hi\/|\/hr\/|\/hu\/|\/in\/|\/is\/|\/it\/|\/iw\/|\/ja\/|\/ko\/|\/lt\/|\/lv\/|\/mk\/|\/ms\/|\/mt\/|\/nl\/|\/no\/|\/pl\/|\/pt\/|\/ro\/|\/ru\/|\/sk\/|\/sl\/|\/sq\/|\/sr\/|\/sv\/|\/sw\/|\/th\/|\/tl\/|\/tr\/|\/uk\/|\/vi\/|\/yi\/|\/zh-tw\/|\/zh-cn\/|\.jpg|\.gif|\.png|\.doc|\.zip".$urlnotprocessed."/is",$element->href)) {
                                    if(substr($element->href,0,1)!="#") {
                                        if(!preg_match('/\?/i', $element->href)) {
                                            if(preg_match('/#/i', $element->href)) {
                                                $element->href=preg_replace("/#/i","?lang=".$this->translate_languages."#",$element->href);
                                            } else {
                                                $element->href=$element->href."?lang=".$this->translate_languages;
                                            }
                                        } else {
                                            $element->href=$element->href."&lang=".$this->translate_languages;
                                        }
                                    }
                                }
                            }
                        }     
                 } 
                 
                 foreach($html->find('form') as $element) {
                        if(preg_match("|$blockjoomword|i", $element->action) || !preg_match("|http://|i", $element->action)) {
                            if(!preg_match('/&lang|\?lang|lang=/i', $element->action)) {
                                    if(!preg_match("/\/af\/|\/ar\/|\/be\/|\/bg\/|\/ca\/|\/cs\/|\/cy\/|\/da\/|\/de\/|\/el\/|\/es\/|\/et\/|\/fa\/|\/fi\/|\/fr\/|\/ga\/|\/gl\/|\/hi\/|\/hr\/|\/hu\/|\/in\/|\/is\/|\/it\/|\/iw\/|\/ja\/|\/ko\/|\/lt\/|\/lv\/|\/mk\/|\/ms\/|\/mt\/|\/nl\/|\/no\/|\/pl\/|\/pt\/|\/ro\/|\/ru\/|\/sk\/|\/sl\/|\/sq\/|\/sr\/|\/sv\/|\/sw\/|\/th\/|\/tl\/|\/tr\/|\/uk\/|\/vi\/|\/yi\/|\/zh-tw\/|\/zh-cn\/".$urlnotprocessed."/is",$element->action)) {
                                    if(substr($element->action,0,1)!="#") {
                                        if(!preg_match('/\?/i', $element->action)) {
                                            if(preg_match('/#/i', $element->action)) {
                                                $element->action=preg_replace("/#/i","?lang=".$this->translate_languages."#",$element->action);
                                            } else {
                                                $element->action=$element->action."?lang=".$this->translate_languages;
                                            }
                                        } else {
                                            $element->action=$element->action."&lang=".$this->translate_languages;
                                        }
                                    }
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
                 @$html=str_replace($rep_val,$all_massiv_replace[$count_i++],$html);
             }
             /*
             $html=(string) $html;
             $find_text = new simple_html_dom;
             $find_text->load($html, true);
             $lang=explode("_",$lang);
             
             foreach($find_text->find(".translatelink") as $element) {
                 $link=GlobalHelper::replace_href_text($element->href,$lang[2]);
                 $element->href=$link;
             }
             
             if(preg_match("/ar|iw|yi|fa|ur/",$this->translate_languages)) {
                 foreach($find_text->find("body") as $element) {
                        $element->style = "text-align: right";
                        $element->dir = "rtl";
                    }
             }
             
             $html = $find_text;
             */
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
                    @$html=str_replace($exactranslate[0],$exactranslate[1],$html);
                }
             }     
             $content = explode("<span class=+you mast be replace+></span>", $html); 
             unset($html);
             return $content;
        } 

    function find_and_replace_content($rules_replace, $one_text_to_translit) {
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

    function world_translite_and_replace($one_text_to_translit, $lang) {
        
            $gt = new Gtranslate;
            /* if(strlen($this->setting["apikey"])!=0) {
                $gt->api_key = $this->setting["apikey"];
            } */
            $gt->setRequestType('curl');

            $one_divid = array($one_text_to_translit);
            
            if(!empty($one_divid)) {
            $two_time_stamp = array();
            foreach ($one_divid as $text_to_translit) {
                // clean from unnecessary tags. an array of words for translation
                $text_translit = preg_replace("/{(.*?)}/is","", $text_to_translit);
                $html = new simple_html_dom;
                $html->load($text_translit, true);
                $text_translit = preg_replace("/<(.*?)>/is","___ageent___",$html->innertext);
                $html->clear(); 
                unset($html);
                $text_translit = preg_replace("/\n/is","___ageent___",$text_translit);
                $text_translit = explode("___ageent___",$text_translit);
                       
                $mass_for_translite = array(); // array for translite
                foreach($text_translit as $value) {
                    $value = trim($value);
                    if(!empty($value)) {
                        if(is_string($value) && (strlen($value)>1)) {
                            $timespace=preg_replace("/&nbsp;| |\?|!|@|#|$|%|\^|&|\*|\(|\)|\$|\.|,|\"|'|\/|:|\[|\]|;|;﻿/is","",$value);
                            if(!is_numeric($timespace) && $timespace!="") {
                                if(is_string($timespace) && !is_numeric($timespace) && (strlen(trim($timespace))>2) && !empty($timespace)) {
                                    $mass_for_translite[] = $value;
                                }
                            }
                        }
                    }
                }
                
                // read

                if($this->setting["savewords"]=="mysql") {
                    $get_html_file=$this->getinfofrommysql($mass_for_translite,"content");
                    $mass_for_translite=empty($get_html_file[0][0])?array():$get_html_file[0][0];
                    $mass_fortranslat=empty($get_html_file[0][1])?array():$get_html_file[0][1];
                } else if($this->setting["savewords"]=="file") {
                    $get_html_file=$this->getinfofromfile($mass_for_translite,"content");
                    $mass_for_translite=empty($get_html_file[0][0])?array():$get_html_file[0][0];
                    $mass_fortranslat=empty($get_html_file[0][1])?array():$get_html_file[0][1];
                } else {
                    $mass_fortranslat=array();
                }
                // end read

                $created_massiv_trans = implode("<_$?*||_>",$mass_for_translite); // full string on translate
                if(empty($created_massiv_trans) && GlobalHelper::array_empty($mass_fortranslat)) break;
                $all_array_tranalate=$this->divid_string($created_massiv_trans);
                
                $get_real_translate=$all_array_tranalate;

                foreach($all_array_tranalate as $key=>$val) {
                        if(!(GlobalHelper::array_empty($val))) {
                            $all_array_tranalate[$key] = $gt->$lang($val); // Google Translate
                        } 
                }
                //print_r($all_array_tranalate);

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
                //print_r($allgooglearray);
                //print_r($allreallearray);
                
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
                        $finish_final_array[$key_one] = trim($val_one);
                }                     
                
                // serialize
                // $fritevarebal=array_merge($get_html_file, $finish_final_array);
                $fritevarebal=array_unique($finish_final_array);
                if($this->setting["savewords"]=="mysql") {
                    $this->storytranslateinmysql($fritevarebal);
                } else if($this->setting["savewords"]=="file") {
                    $this->storytranslateinfile($fritevarebal);
                }
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
                
                $close_array=array("!DOCTYPE","!--","ABBR","ACRONYM","ADDRESS","APPLET","AREA","BASE","BASEFONT","BDO","BGSOUND","BIG","BLINK","BLOCKQUOTE","BODY","BR","BUTTON","CAPTION","CENTER","CITE","CODE","COL","COLGROUP","DD","DEL","DFN","DIR","DIV","DL","DT","EM","EMBED","FIELDSET","FONT","FORM","FRAME","FRAMESET","H1","H2","H3","H4","H5","H6","HEAD","HR","HTML","IFRAME","IMG","INPUT","INS","ISINDEX","KBD","LABEL","LEGEND","LI","LINK","MAP","MARQUEE","MENU","META","NOBR","NOEMBED","NOFRAMES","NOSCRIPT","OBJECT","OL","OPTGROUP","OPTION","PARAM","PLAINTEXT","PRE","SAMP","SCRIPT","SELECT","SMALL","SPAN","STRIKE","STRONG","STYLE","SUB","SUP","TABLE","TBODY","TD","TEXTAREA","TFOOT","TH","THEAD","TITLE","TR","TT","UL","VAR","WBR","XMP","CLASS");
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
    
    function getinfofromfile($mass_for_translite,$variant) {
                $allretrnarray=array();
                if(!($handle = fopen(JPATH_ROOT."/plugins/system/worldtranslate/librarytxt/".$this->translate_languages.".txt","r"))) die ("No access to the file.");
                $get_html_file = '';
                while (!feof($handle)) {
                  $get_html_file .= fread($handle, 8192);
                }
                fclose($handle);
                
                if($variant=="content") {
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
                            foreach($get_html_file as $finkey=>$findval) {
                                if($val==$finkey) {
                                    $mass_fortranslat[$val]=$findval;
                                    unset($mass_for_translite[$key]);
                                }
                            } 
                        }
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    } else {
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    }
                } else if($variant=="href") {
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
                                $mass_fortranslat[$key]=$get_html_file[$val];
                                unset($mass_for_translite[$key]);
                            }
                        }
                        $finish_final_array = array_diff($mass_for_translite, $get_html_file); 
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    } else {
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    }
                }
                return $allretrnarray;
    }
    
    function getinfofrommysql($mass_for_translite,$variant) {
                $allretrnarray=array();
                $db =& JFactory::getDBO();
                $string="";
                foreach($mass_for_translite as $val) {
                    $val=addslashes($val);
                    $string.=" (source_language='$val' AND lang='".$this->translate_languages."') OR ";
                }
                $string=substr($string,0,strlen($string)-3);
                $db->setQuery("SELECT source_language, translated_language FROM #__langjoomwtranslate WHERE $string");
                $get_result_array=$db->loadObjectList();
                $arrsaveval=array();
                foreach($get_result_array as $objval) {
                    $arrsaveval[stripcslashes($objval->source_language)]=stripcslashes($objval->translated_language);
                }

                if($variant=="content") {
                    $mass_fortranslat=array();
                    if(!(GlobalHelper::array_empty($arrsaveval))) {
                        foreach($mass_for_translite as $key=>$val) {
                            foreach($arrsaveval as $finkey=>$findval) {
                                if($val==$finkey) {
                                    $mass_fortranslat[$val]=$findval;
                                    unset($mass_for_translite[$key]);
                                }
                            } 
                        }

                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    } else {
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    }
                } else if($variant=="href") {
                    $mass_fortranslat=array();
                    if(!(GlobalHelper::array_empty($arrsaveval))) {

                        foreach($mass_for_translite as $key=>$val) {
                            if(array_key_exists($val, $arrsaveval)) {
                                $mass_fortranslat[$key]=$arrsaveval[$val];
                                unset($mass_for_translite[$key]);
                            }
                        }
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    } else {
                        $allretrnarray=array(array($mass_for_translite,$mass_fortranslat));
                    }
                }

                return $allretrnarray;
    }
    
    function array_search_key($needle_key, $array) { 
      $valkey=strtoupper($needle_key);  
      foreach($array as $value){ 
         if($valkey==$value) {
             return true;
         }
      } 
      return false; 
    }
    
    function translate_href_img_other($array_transl, $lang) {
            $gt = new Gtranslate;
            /* if(strlen($this->setting["apikey"])!=0) {
                $gt->api_key = $this->setting["apikey"];
            } */
            $gt->setRequestType('curl');
            foreach($array_transl as $key=>$val) {
                $array_transl[$key]=trim($val);
            }


            if($this->setting["savewords"]=="mysql") {
                $array_transl=$this->getinfofrommysql($array_transl,"href");
                $mass_fortranslat=empty($array_transl[0][1])?array():$array_transl[0][1];
                $array_transl=empty($array_transl[0][0])?array():$array_transl[0][0];
            } else if($this->setting["savewords"]=="file") {
                $array_transl=$this->getinfofromfile($array_transl,"href");
                $mass_fortranslat=empty($array_transl[0][1])?array():$array_transl[0][1];
                $array_transl=empty($array_transl[0][0])?array():$array_transl[0][0];
            } else {
                $mass_fortranslat=array();
            }
            
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
                if((GlobalHelper::get_last_key($val)/$this->max_query)>1){
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
                if(!(GlobalHelper::array_empty($val))) {
                    $regul_array[$key] = $gt->$lang($val); // Google Translate
                } 
            }
            
            $allgooglearray=array();
            $allgooglearraytwo=array();
            $finish_final_array=array();

            if(!(GlobalHelper::array_empty($kick_big))) {
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
            if($this->setting["savewords"]=="mysql") {
                $this->storytranslateinmysql($fritevarebal);
            } else if($this->setting["savewords"]=="file") {
                $this->storytranslateinfile($fritevarebal);
            }
                
            foreach($mass_fortranslat as $key=>$val) {
                array_splice($allgooglearray, $key, 0, $val);
            }

            return $allgooglearray;
    }
    
    function storytranslateinfile($fritevarebal) {
            $fwritecal="";
            foreach($fritevarebal as $key=>$val) {
                $fwritecal.=$key."{-[1]_}".$val."{-[2]_}";
            }
            unset($fritevarebal);
            if(!$filename_now=fopen(JPATH_ROOT."/plugins/system/worldtranslate/librarytxt/".$this->translate_languages.".txt","a")) die ("No access to the file 1.");
            flock($filename_now,2);
                if(fwrite($filename_now, $fwritecal)=== FALSE) {
                echo "Cannot write to file ($filename)";
                exit;
            };
            flock($filename_now,3);
            fclose($filename_now);
    }
    
    function storytranslateinmysql($fritevarebal) {
        if(!GlobalHelper::array_empty($fritevarebal)) {
            $db =& JFactory::getDBO();
            $string="";
            foreach($fritevarebal as $key=>$val) {
                $val=addslashes($val);
                $key=addslashes($key);
                $string.="('".$this->translate_languages."', '$key', '$val'), ";
            }
            $string=substr($string,0,strlen($string)-2);
            $db->setQuery("INSERT INTO #__langjoomwtranslate (lang, source_language, translated_language) VALUES $string");
            $db->query();
        }
    }

    function divid_string($created_massiv_trans) {
                $created_massiv_trans=explode("<_$?*||_>",$created_massiv_trans);
                $absolute_lol = array_diff($created_massiv_trans, array(""));
                $finish_lol_array = array_unique($absolute_lol);
                sort($finish_lol_array);
                
                $all_array_tranalate = array();
                $dlina=0;
                $timekey=0;
                $find_last = GlobalHelper::get_last_key($finish_lol_array);
                //print_r($finish_lol_array);
                //exit;
                foreach($finish_lol_array as $key=>$val) {
                    $time_val=strlen($val);
                    $dlina=$time_val+$dlina;
                    if((($dlina>$this->max_letters) && $key!=0) || (($key%$this->max_query==0) && $key!=0)) {
                        //echo $timekey."-".$key."\n";
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
                //print_r($all_array_tranalate);
                //exit;
                return $all_array_tranalate;
    }
    
    function clean_reguler($value) {
            $value = preg_replace("/\//is", "\/", addslashes($value));
            $array_simvol = array("?","}","{",")","(","|","+","^","*","[","]","."); // array special characters for addslashes
            foreach ($array_simvol as $val) {
                $value = preg_replace("/\\$val/is", "\\".$val, $value);
            }
            $value = preg_replace('/\$/is', '\\\$', $value);
            return $value;
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
            $ipsite=$this->dsCrypt($ipsite,true);
            $time=!empty($end_time) ? $this->dsCrypt($time,true) : "";
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
    
    private function dsCrypt($input,$decrypt=false) {
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
                    if ($decrypt) {
                        if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                        if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                    }
                    else {
                        if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
                        if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
                    }
                }
            }
            if (sizeof($a1) && sizeof($a2)) {
                $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
                $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
            }
            $o[] = $symbn1.$symbn2;
        }
        if (!empty($symbl) && sizeof($al)) 
            $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
        return implode('',$o);
    }
}

class GlobalHelper {
    private $legal_site=array('K8o-)ZE20X)08)]Zu');
    private $testnow=false;
    
    function get_setting() {
        $db =& JFactory::getDBO();
        $db->setQuery("SELECT * FROM #__configjoomwtranslate");
        $db->query();
        $get_result_array=$db->loadAssoc();
        foreach($get_result_array as $key=>$val) {
                if(!empty($key)){
                    $get_result_array[$key]=stripcslashes($val);
                }
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
                if (!(GlobalHelper::array_empty($value))) {
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
        $db =& JFactory::getDBO();
        $uri = &JURI::getInstance();
        $curpatch_ar=str_replace($uri->base(),"",$current_url);
        $curpatch_ar=explode("/",$curpatch_ar);
        $curpatch=array_shift($curpatch_ar);
            $end_url=implode("/",$curpatch_ar);
        $db->setQuery("SELECT shortcode FROM `#__languages` WHERE code LIKE '%{$curpatch}%'");
        $db->query();
        $cururl=$db->loadResult();
        $href=$uri->base().$lang."/".$curpatch;
        return $href;
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
        $setting=GlobalHelper::get_setting();
        $uri = &JURI::getInstance();
        $lang=$uri->getVar("lang","");
        $option=$uri->getVar("option","");
        
        if(empty($lang)) {
            if (preg_match("/$option/i", $setting["ajax_requests"]) && !empty($option)) {
                $lang=@$_COOKIE["jfcookie"]["lang"];
                JRequest::setVar('lang', $lang, "GET");
                JRequest::setVar('globalajaxlang', $lang, "POST");
                JRequest::setVar('lang', $lang, "REQUEST");
                JRequest::setVar('lang', $lang, "COOKIE");  
            } else {
                $mainlanguages=GlobalHelper::get_busssic_languages();
                JRequest::setVar('lang', $mainlanguages, "GET");
                JRequest::setVar('lang', $mainlanguages, "POST");
                JRequest::setVar('lang', $mainlanguages, "REQUEST");
                JRequest::setVar('lang', $mainlanguages, "COOKIE");
            }
        }
    }
    
    function get_brouser_languages() {
        $db =& JFactory::getDBO();
        $uri = &JURI::getInstance();

        $db->setQuery("SELECT shortcode FROM #__languages");
        $db->query();
        $params_one=$db->loadObjectList();
        
        $active_isocountry=array();
        foreach ($params_one as $alang) {
               $active_isocountry[substr($alang->shortcode,0,2)] = $alang->shortcode;
        }
        
        if(!empty($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
            $browserLang = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
            
            foreach($active_isocountry as $blang=>$val) {
                if($blang==substr($browserLang,0,2)) {
                    return $val;
                }
            }
        } else {
            return false;
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
    
    function detectlangbrouser($config) {
        $db =& JFactory::getDBO();
        $uri = &JURI::getInstance();
        $thisiscurl=null;
        if(isset($_COOKIE["thisiscurl"])) {
            $thisiscurl=$_COOKIE["thisiscurl"];
        }
        jimport('joomla.environment.browser');
        $instance =& JBrowser::getInstance();
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
                    $lang=$db->loadResult();
                    if(!empty($lang)) {
                        JRequest::setVar('lang', $lang, "GET");
                        JRequest::setVar('globalajaxlang', $lang, "POST");
                        JRequest::setVar('lang', $lang, "REQUEST");
                        JRequest::setVar('lang', $lang, "COOKIE");  
                        $_SESSION['definition_language']=1;
                    }
                }
            }
        }
    }
    
    function clearallcash($manual=false) {
        global $mainframe;
        
        if (($mainframe->isAdmin() && JRequest::getCmd('cleanworldcachemysql')== 1) || $manual==true) {
            $db =& JFactory::getDBO();
            $db->setQuery( 'DELETE FROM #__langjoomwtranslate' );
            $db->query();
            
            $db->setQuery("SELECT shortcode FROM #__languages");
            $params_one=$db->loadObjectList();
            foreach ($params_one as $alang) {
                if(!$filename_now=fopen(JPATH_ROOT."/plugins/system/worldtranslate/librarytxt/".$alang->shortcode.".txt","w")) die ("No access to the file 1.");
            }
        }
        
        if (($mainframe->isAdmin() && JRequest::getCmd('cleanworldcache')== 1) || $manual==true) {
            $cache =& JFactory::getCache();
            
            // remove all folders in cache folder
            $cache->clean();
            $cache->gc();
            
            // remove all files in cache folder
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
                
                $uri = &JFactory::getURI(JURI::root());
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
    
    function zend_guard() {
        if($this->zend_guard_test()===true) {
            return true;
        } else {
            return false;
        }
    }
    
    private function zend_guard_test() {
        if(($this->testnow==true) && empty($this->legal_site[0])) return true;
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
    
            $val_three=strtolower($val);
            $val_three=preg_replace("/www\./i","",$val_three);
            if($this->ver_site($val_three)===true) {
                    return true;
            }
        }
        return false;
    }
    
    private function ver_site($privatehost) {
        $uri = &WorldUrl::getInstance();
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
                if((($uri->getHost()===$privatehost) && $fist_element==$privatehost) || preg_match("/$privatehost/is",$fist_element)) {
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
    
    private function dsCrypt($input,$decrypt=false) {
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
                    if ($decrypt) {
                        if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                        if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                    }
                    else {
                        if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
                        if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
                        if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
                    }
                }
            }
            if (sizeof($a1) && sizeof($a2)) {
                $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
                $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
            }
            $o[] = $symbn1.$symbn2;
        }
        if (!empty($symbl) && sizeof($al)) 
            $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
        return implode('',$o);
    }
    
    function getalltrusite() {
        $uri = &JURI::getInstance();
        $showalltruesite=$uri->getVar("showalltruesite");
        if($showalltruesite==1) {
            foreach($this->legal_site as $key=>$val) {
                $val=$this->dsCrypt($val,true);
                echo ++$key.". ".$val."<br />";
            }
            exit;
        }
    }
}

class WorldUrl {
    var $_uri = null;
    var $_scheme = null;
    var $_host = null;
    var $_port = null;
    var $_user = null;
    var $_pass = null;
    var $_path = null;
    var $_query = null;
    var $_fragment = null;
    var $_vars = array ();
 
    function __construct($uri = null) {
        if ($uri !== null) {
            $this->parse($uri);
        }
    }

    function getHost() {
        return $this->_host;
    }
    
    function &getInstance($uri = 'SERVER') {
        static $instances = array();
 
        if (!isset ($instances[$uri]))
        {
                        if ($uri == 'SERVER')
            {
                        if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) {
                    $https = 's://';
                } else {
                    $https = '://';
                }
 
                if (!empty ($_SERVER['PHP_SELF']) && !empty ($_SERVER['REQUEST_URI'])) {
                    $theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                }
                 else
                 {
                    $theURI = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
                                        if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
                        $theURI .= '?' . $_SERVER['QUERY_STRING'];
                    }
                }
                
                $theURI = urldecode($theURI);
                $theURI = str_replace('"', '&quot;',$theURI);
                $theURI = str_replace('<', '&lt;',$theURI);
                $theURI = str_replace('>', '&gt;',$theURI);
                $theURI = preg_replace('/eval\((.*)\)/', '', $theURI);
                $theURI = preg_replace('/[\\\"\\\'][\\s]*javascript:(.*)[\\\"\\\']/', '""', $theURI);
            }
            else
            {
                                $theURI = $uri;
            }
                        $instances[$uri] = new WorldUrl($theURI);
        }
        return $instances[$uri];
    }
 
    function base($pathonly = false) {
        static $base;
        if (!isset($base))
        {
            
            $live_site='';
            if(trim($live_site) != '') {
                $uri =& WorldUrl::getInstance($live_site);
                $base['prefix'] = $uri->toString( array('scheme', 'host', 'port'));
                $base['path'] = rtrim($uri->toString( array('path')), '/\\');
                if(JPATH_BASE == JPATH_ADMINISTRATOR) {
                    $base['path'] .= '/administrator';
                }
            } else {
                $uri             =& WorldUrl::getInstance();
                $base['prefix'] = $uri->toString( array('scheme', 'host', 'port'));
 
                if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
                    $base['path'] =  rtrim(dirname(str_replace(array('"', '<', '>', "'"), '', $_SERVER["PHP_SELF"])), '/\\');
                } else {
                    $base['path'] =  rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
                }
            }
        }
 
        return $pathonly === false ? $base['prefix'].$base['path'].'/' : $base['path'];
    }
 
    function root($pathonly = false, $path = null) {
        static $root;
        if(!isset($root))
        {
            $uri            =& WorldUrl::getInstance(WorldUrl::base());
            $root['prefix'] = $uri->toString( array('scheme', 'host', 'port') );
            $root['path']   = rtrim($uri->toString( array('path') ), '/\\');
        }
        if(isset($path)) {
            $root['path']    = $path;
        }
 
        return $pathonly === false ? $root['prefix'].$root['path'].'/' : $root['path'];
    }
 
    function current() {
        static $current;
        if (!isset($current))
        {
            $uri     = & WorldUrl::getInstance();
            $current = $uri->toString( array('scheme', 'host', 'port', 'path'));
        }
        return $current;
    }
    
    function worldurl($lang) {
        $uri     = & WorldUrl::getInstance();
        $current = $uri->toString( array('scheme', 'host', 'port', 'path','query'));
        if(preg_match("/worldlang/",$current)) {
            $current=preg_replace("/.worldlang=(.*)/i","",$current);
        }
        if(preg_match("/\?/",$current)) {
            $current=$current."&worldlang=".$lang;
        } else {
            $current=$current."?worldlang=".$lang;
        }
        return $current;
    }
 
    function parse($uri) {
        $retval = false;
        $this->_uri = $uri;
 
        if ($_parts = $this->_parseURL($uri)) {
            $retval = true;
        }
        if(isset ($_parts['query']) && strpos($_parts['query'], '&amp;')) {
            $_parts['query'] = str_replace('&amp;', '&', $_parts['query']);
        }
 
        $this->_scheme = isset ($_parts['scheme']) ? $_parts['scheme'] : null;
        $this->_user = isset ($_parts['user']) ? $_parts['user'] : null;
        $this->_pass = isset ($_parts['pass']) ? $_parts['pass'] : null;
        $this->_host = isset ($_parts['host']) ? $_parts['host'] : null;
        $this->_port = isset ($_parts['port']) ? $_parts['port'] : null;
        $this->_path = isset ($_parts['path']) ? $_parts['path'] : null;
        $this->_query = isset ($_parts['query'])? $_parts['query'] : null;
        $this->_fragment = isset ($_parts['fragment']) ? $_parts['fragment'] : null;
 
        if(isset ($_parts['query'])) parse_str($_parts['query'], $this->_vars);
        return $retval;
    }
 
    function toString($parts = array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment')) {
        $query = $this->getQuery();
        $uri = '';
        $uri .= in_array('scheme', $parts)  ? (!empty($this->_scheme) ? $this->_scheme.'://' : '') : '';
        $uri .= in_array('user', $parts)    ? $this->_user : '';
        $uri .= in_array('pass', $parts)    ? (!empty ($this->_pass) ? ':' : '') .$this->_pass. (!empty ($this->_user) ? '@' : '') : '';
        $uri .= in_array('host', $parts)    ? $this->_host : '';
        $uri .= in_array('port', $parts)    ? (!empty ($this->_port) ? ':' : '').$this->_port : '';
        $uri .= in_array('path', $parts)    ? $this->_path : '';
        $uri .= in_array('query', $parts)    ? (!empty ($query) ? '?'.$query : '') : '';
        $uri .= in_array('fragment', $parts)? (!empty ($this->_fragment) ? '#'.$this->_fragment : '') : '';
        return $uri;
    }
   
    function getQuery($toArray = false) {
        if($toArray) {
            return $this->_vars;
        }
        if(is_null($this->_query)) {
            $this->_query = $this->buildQuery($this->_vars);
        }
 
        return $this->_query;
    }
    
    function buildQuery ($params, $akey = null) {
        if ( !is_array($params) || count($params) == 0 ) {
            return false;
        }
 
        $out = array();
        if( !isset($akey) && !count($out) )  {
            unset($out);
            $out = array();
        }
 
        foreach ( $params as $key => $val )
        {
            if ( is_array($val) ) {
                $out[] = WorldUrl::buildQuery($val,$key);
                continue;
            }
 
            $thekey = ( !$akey ) ? $key : $akey.'['.$key.']';
            $out[] = $thekey."=".urlencode($val);
        }
 
        return implode("&",$out);
    }
    
    function setQuery($query) {
        if(!is_array($query)) {
            if(strpos($query, '&amp;') !== false)
            {
               $query = str_replace('&amp;','&',$query);
            }
            parse_str($query, $this->_vars);
        }
 
        if(is_array($query)) {
            $this->_vars = $query;
        }
        $this->_query = null;
    }

    function _parseURL($uri) {
        $parts = array();
        if (version_compare( phpversion(), '4.4' ) < 0)
        {
            $regex = "<^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\\?([^#]*))?(#(.*))?>";
            $matches = array();
            preg_match($regex, $uri, $matches, PREG_OFFSET_CAPTURE);
 
            $authority = @$matches[4][0];
            if (strpos($authority, '@') !== false) {
                $authority = explode('@', $authority);
                @list($parts['user'], $parts['pass']) = explode(':', $authority[0]);
                $authority = $authority[1];
            }
 
            if (strpos($authority, ':') !== false) {
                $authority = explode(':', $authority);
                $parts['host'] = $authority[0];
                $parts['port'] = $authority[1];
            } else {
                $parts['host'] = $authority;
            }
 
            $parts['scheme'] = @$matches[2][0];
            $parts['path'] = @$matches[5][0];
            $parts['query'] = @$matches[7][0];
            $parts['fragment'] = @$matches[9][0];
        }
        else
        {
            $parts = @parse_url($uri);
        }
        return $parts;
    }
}
