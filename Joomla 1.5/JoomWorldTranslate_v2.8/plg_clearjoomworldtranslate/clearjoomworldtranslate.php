<?php
/**
 * Clearjoomworldtranslate
 *
 * @version 2.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
 
// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.plugin.plugin');
class plgContentClearjoomworldtranslate extends JPlugin {
    function onAfterContentSave(&$article, &$params, $limitstart=0) {
        $db =& JFactory::getDBO();
        $artid=$article->id;
        $db->setQuery("SELECT addurl FROM #__global_cache WHERE articleid=$artid");
        $db->query();
        $get_result=$db->loadResult();
        
        if(!empty($get_result)) {
            $get_result=preg_replace("/;lol;/is","\n",$get_result);
            $get_result=trim($get_result);
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
                         echo GlobalHelper::fronted_page($get_array, $hash,$patchtocash,$nowurl);
                    break;
                    case "start":
                              $this->delfile();  
                         echo GlobalHelper::start_page($get_array, $hash,$patchtocash,$nowurl);
                    break;
                    default:
                              $this->delfile();  
                         echo GlobalHelper::clenbigpage($get_array, $hash,$patchtocash,$nowurl);
                    break;
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
}