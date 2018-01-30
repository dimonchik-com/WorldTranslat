<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JoomworldtranslateModelJoomworldtranslate extends JModel
{
    var $nudnumber;
    function __construct() {
        global $mainframe;
        $addnew = JRequest::getVar('addnew');
        if($addnew=="1") {
            $add_url = JRequest::getVar('add_url');
            $article_id = JRequest::getVar('article_id');
            if(!empty($article_id)) {
                $this->addalllink($add_url,$article_id);   
            }
            echo "<script language=\"javascript\" type=\"text/javascript\">window.parent.document.getElementById('sbox-window').close()</script>";
            $mainframe->close();  
        }
        $clear_all_links = JRequest::getVar( 'clear_all_links' );
        if($clear_all_links=="1") {
            $link=JRequest::getVar('link');
            $this->clearallink($link);
            $mainframe->close();   
        }
        $db =& JFactory::getDBO();
        $db->setQuery("SELECT link FROM #__components WHERE link='option=com_joomfish'");
        $db->query();
        $params_one=$db->loadResult();
        if($params_one!="option=com_joomfish") {   
            $mainframe->enqueueMessage('JoomFish not installed. Please install <a target="_blank" href="http://extensions.joomla.org/extensions/languages/multi-lingual-content/460">JoomFish</a>', 'error');
        }
        $this->closnot_translate();
        
        $defence = new GlobalHelper();
        if($defence->zend_guard()==false) {
            exit;
        }
        $file_extriply=ioncube_file_info();
        if(!empty($file_extriply["FILE_EXPIRY"])) {
            $mainframe->enqueueMessage("This is a demo version of the component, which will operate until ".date('Y-m-d', $file_extriply["FILE_EXPIRY"]), 'error');
        }              
        parent::__construct();
    }

    function addalllink($add_url,$article_id) {
        $add_url=explode("\n",$add_url);
        foreach($add_url as $key=>$val) {
            $add_url[$key]=trim($val);
        }
        $add_url=implode(";lol;",$add_url);
        $db =& JFactory::getDBO();
        
        $db->setQuery("SELECT articleid FROM #__global_cache WHERE articleid=$article_id");
        $db->query();
        $get_result=$db->loadResult();
        if(empty($get_result)) {
            $db->setQuery("INSERT INTO #__global_cache (articleid, addurl) VALUES ($article_id, '$add_url')");
            $db->query();  
        } else {
            $db->setQuery("UPDATE #__global_cache SET addurl='$add_url' WHERE articleid=$article_id");
            $db->query();  
        }
    }
    
    function &getGetnumbecashfile() {
        $patchtocash=JPATH_SITE."/cache/page";
        if(file_exists($patchtocash)) {
            $this->nudnumbernow($patchtocash);
        }
        $this->nudnumber=floor($this->nudnumber/2);
        return $this->nudnumber;
    }
     
    function nudnumbernow($path) { 
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) { 
           if ($file<>"." AND $file<>"..") {
            if ($file != "." && $file != "..") { 
              $this->nudnumber++; 
            } 
             if (is_dir($path.'/'.$file)) { 
              nudnumbernow($path.'/'.$file); 
             }
            }
          }
        }  
    } 
    
    function delfile() {
        $patchtocash=JPATH_SITE."/cache";
        if(file_exists($patchtocash)) {
            $this->delcache($patchtocash);
        }
    }
    
    function delcache($path) { 
        if ($handle = opendir($path)) {
          while (false !== ($file = readdir($handle))) { 
           if ($file<>"." AND $file<>"..") { 
             if (is_dir($path.'/'.$file)) { 
                 if($file!="page") {
                    $this->deltree($path.'/'.$file);
                 }
             }
            }
          }
        }  
    }
     
    function deltree($folder){
            if (is_dir($folder)){
                     $handle = opendir($folder);
                     while ($subfile = readdir($handle)){
                             if ($subfile == '.' or $subfile == '..') continue;
                             if (is_file($subfile)) unlink("{$folder}/{$subfile}");
                             else $this->deltree("{$folder}/{$subfile}");
                     }
                     closedir($handle);
                     rmdir ($folder);
             }
             else unlink($folder);
    }
    
    function &getSetting() {
        $get_result_array=GlobalHelper::get_setting();
        return $get_result_array;
    }
    
    function store() {    
        $db =& JFactory::getDBO();
        $data = JRequest::get('post');
        
        unset($data["option"]);
        unset($data["task"]);
        unset($data["controller"]);
        
        $main_languages=$data["main_languages"];

        if(!empty($main_languages)) {
            if($main_languages=="source_detect_language") {
                $source_detect_language="source_detect_language";
            } else {
                $params = JComponentHelper::getParams('com_languages');
                $params->set("site", $main_languages);
                
                $table =& JTable::getInstance('component');
                $table->loadByOption('com_languages');

                $table->params = $params->toString();

                // pre-save checks
                if (!$table->check()) {
                    JError::raiseWarning( 500, $table->getError() );
                    return false;
                }

                // save the changes
                if (!$table->store()) {
                    JError::raiseWarning( 500, $table->getError() );
                    return false;
                }
                $source_detect_language="";
                unset($data["main_languages"]);
            }
        }

        
        foreach($data as $key=>$val) {
                if(!empty($key)){
                    $data[$key]=addslashes($val);
                }
        }
        
        
        $db->setQuery('UPDATE #__configjoomwtranslate SET enable="'.$data["enable"].'",notranslate="'.$data["notranslate"].'",apikey="'.$data["apikey"].'",suffix="'.$data["suffix"].'",usingip="'.$data["usingip"].'",ajax_requests="'.$data["ajax_requests"].'",detect_language="'.$data["detect_language"].'",worldsjs="'.$data["worldsjs"].'",notworldstrans="'.$data["notworldstrans"].'",exactranslate="'.$data["exactranslate"].'",savewords="'.$data["savewords"].'",urlnotprocessed="'.$data["urlnotprocessed"].'",source_detect_language="'.$source_detect_language.'"');
        $db->query();

        return true;
    }
    
    function clearallink($get_result) {
            $db =& JFactory::getDBO();
            $get_result=trim($get_result);
            if(empty($get_result)) return;
            $get_result=explode("\n",$get_result);
            $site_url=JURI::root();
            $config =& JFactory::getConfig();
            $hash=$config->getValue('config.secret');
            
            $patchtocash=JPATH_SITE."/cache/page/";
            $db->setQuery("SELECT code, shortcode FROM #__languages");
            $db->query();
            $get_array=$db->loadObjectList();
            $arraylol=array("shortcode"=>"","code"=>GlobalHelper::get_busssic_languages(true));
            $arraylol=(object)$arraylol;
            array_push($get_array, $arraylol);
            
            
            $response="";
            foreach($get_result as $val) {
                $uri = &JFactory::getURI($val);
                $nowurl=$uri->toString(array('path', 'query'));
                
                $case="";
                if(preg_match("/\?start/i",$nowurl)) {
                    $case="start";
                }
                // if long url
                if($case=="") {
                foreach($get_array as $value) {
                    $onelang=$value->shortcode;
                    if(preg_match("/\/$onelang\//i",$nowurl)) {
                        $nowurl=str_replace("$onelang/","",$nowurl);
                        $case="big_page";
                        break;
                    } 
                }
                }
                //if fronted page
                if($case=="") {
                    $textnowurl=end(explode("/", $nowurl));
                    $textnowurl=preg_replace("/\.(.*)/i","",$textnowurl);
                    $endtnormal="";
                    foreach($get_array as $language) {
                        if($textnowurl==$language->shortcode) {
                            $endtnormal=$textnowurl;
                        }
                    }
                    if($endtnormal!="" || $textnowurl=="") {
                        $case="fronted_page";
                    }
                }
                
                switch ($case) {
                    case "fronted_page":
                              $this->delfile();  
                         $response.=GlobalHelper::fronted_page($get_array, $hash,$patchtocash,$nowurl);
                    break;
                    case "start":
                              $this->delfile();  
                         $response.=GlobalHelper::start_page($get_array, $hash,$patchtocash,$nowurl);
                    break;
                    default:
                              $this->delfile();  
                         $response.=GlobalHelper::clenbigpage($get_array, $hash,$patchtocash,$nowurl);
                    break;
                }
                $response.="\n";
            } 
            $response=trim($response);
            if(!empty($response)) echo $response;
    }
    
    function closnot_translate(){
        $db =& JFactory::getDBO();
        $db->setQuery("SELECT params FROM #__components WHERE link='option=com_joomfish'");
        $db->query();
        $params_one=$db->loadResult();
        if(!empty($params_one)) {
            $params_one=preg_replace("/noTranslation=./","noTranslation=0",$params_one);
            $db->setQuery("UPDATE #__components SET params='$params_one' WHERE link='option=com_joomfish'");
            $db->query();
        }
    }
}