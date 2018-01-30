<?php 
/**
 * Joom Global Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');
if ( count($langActive)>0 ) {
    $langOptions=array();
    $noscriptString='';
    $activeLangImg  = null;
    $current="";
    foreach( $langActive as $language )
    {
        $languageCode = $language->getLanguageCode();
        if( $language->code == $curLanguage->getTag() && !$show_active ) {
            continue;        // Not showing the active language
        }
        $href = JFModuleHTML::_createHRef ($language, $params);

        if( isset($language->image) && $language->image!="" ) {
            $langImg = '/images/' .$language->image;
        } else {
            $langImg = '/components/com_joomfish/images/flags/' .$languageCode .".gif";
        }
        if ($language->code == $curLanguage->getTag() ){
            $current=$language->name;
            $activehref=$href;
            $activeLangImg = array( 'img' => $langImg, 'code' => $languageCode, 'name' => $language->name );
        }
        if (isset($language->disabled) && $language->disabled){
            $disabled=" disabled='disabled'";
            $noscriptString .= '<span lang="' .$languageCode. '" xml:lang="' .$languageCode. '" style="opacity:0.5;" class="opaque">' .$language->name. '</span>&nbsp;';
            $langOption=JFModuleHTML::makeOption($href , $language->name, "" );
        }
        else {
            $disabled="";
            $langOption=JFModuleHTML::makeOption($href , $language->name, "" );
        }

        $langOption->iso = $language->iso;
        $langOption->img = '<img class="translate_flag" src="'.JURI::base(true) . $langImg.'" alt="'.$language->name.'" width="16" height="11" />';
        $langOptions[] = $langOption;
    }
    
    echo '
    <a href="#" id="translate_translate">'.$translator.'</a>
    <div id="translate_popup" style="display:none;  direction: ltr;" class="notranslate">
    <table class="translate_links">
    <tr>';
        foreach($langOptions as $key=>$val) {
                if($key==0) { 
                    echo "<td valign='top'>";
                }
                if($current==$val->text) {
                    echo '<a  class="languagelink" style="color:red" href="'.$val->value.'">'.$val->img.$val->text."</a>"; 
                } else {
                    echo '<a  class="languagelink" href="'.$val->value.'">'.$val->img.$val->text."</a>"; 
                }
                if($key==17) { 
                    echo "</td><td valign='top'>";
                }
                if($key==35) { 
                    echo "</td><td valign='top'>";
                }
        }
        echo "</td></tr></table></div>";
}