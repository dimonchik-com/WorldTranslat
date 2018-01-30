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
    $langcurrent=null;
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
            $activehref=$href;
            $langcurrent=$language->iso;
            $activeLangImg = array( 'img' => $langImg, 'code' => $languageCode, 'name' => $language->name );
        }
        if (isset($language->disabled) && $language->disabled){
            $disabled=" disabled='disabled'";
            $noscriptString .= '<span lang="' .$languageCode. '" xml:lang="' .$languageCode. '" style="opacity:0.5" class="opaque">' .$language->name. '</span>&nbsp;';
            $langOption=JFModuleHTML::makeOption($href , $language->name, $disabled." style='padding-left:25px;background-image: url(\"".JURI::base(true) . $langImg."\");background-repeat: no-repeat;background-position:center left;opacity:0.5;' class='opaque'" );
        }
        else {
            $disabled="";
            $noscriptString .= '<a href="' .$href. '"><span lang="' .$languageCode. '" xml:lang="' .$languageCode. '">' .$language->name. '</span></a>&nbsp;';
            $langOption=JFModuleHTML::makeOption($href , $language->name, $disabled." style='padding-left:23px;background-image: url(\"".JURI::base(true) . $langImg."\");background-repeat: no-repeat;background-position:center left;'" );
        }

        $langOption->iso = $language->iso;
        $langOptions[] = $langOption;

    }

        echo '
        <div id="worldone">
           <div id="worldinsertdiv" class="notranslate">
                <div class="worldcont_two"></div>
                <div class="worldcont_three">
        <table cellpadding="0" cellspacing="0" id="hovred"  border="0" class="top_table">';
        $tima_i = 0;
        array_unshift($langOptions, "");
        foreach($langOptions as $key=>$val) {
            if($key!=0) {
                if($tima_i==0) { 
                    echo "<tr>";
                    $tima_i = 1;
                }
                if($langcurrent==$val->iso) {
                    echo '<td><a href="'.$val->value.'" class="curlanguages" style="color:#e60000;"><span '.$val->style.'>'.$val->text."</span></a></td>";
                } else {
                    echo '<td><a href="'.$val->value.'"><span '.$val->style.'>'.$val->text."</span></a></td>";
                }
                if(($key%4)==0 && $key!=0) { 
                    echo "</tr>";
                    $tima_i = 0;
                }
            }
        }
        echo "</table>
                </div>
           </div>
        </div>";
}