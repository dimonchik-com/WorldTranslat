<?php 
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
 
defined('_JEXEC') or die('Restricted access'); 
$onlyou = JUtility::getHash(JURI::root());
?>
<style>
    .icon-48-earth{background: url(<?php echo JURI::root();?>administrator/components/com_joomworldtranslate/views/joomworldtranslate/tmpl/icon-48-fish.png) no-repeat left;}
    .hov_me{ display:inline-block; width: 400px; border: 0px; background: none; font-size: 11px; background: #ffcc66;}
    .india {
        background:#E2EDF4 none repeat scroll 0 0;
        clear:both;
        cursor:pointer;
        display:block;
        font-size: 12px;
        margin: 0px 10px 5px 10px;
        padding:3px;
    }
    .you { padding-left: 5px;}
</style>
<?php ob_start(); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform">
<legend>Basic options</legend>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo JURI::root();?>/modules/mod_joomworldtranslate/tmpl/mod_joomworldtranslate.css" type="text/css" />
<script type="text/javascript">
    function select_link() {
        selectall = document.getElementById("selectall");
        selectall.focus();
        selectall.select();
    }
    jQuery.noConflict();
    (function ($) {
        $(window).load(function () {
            offset = $("#translate_translate").offset();
            height = $("#translate_translate").height();
            translate_translate_width = $("#translate_translate").width();
            max_width = $(window).width();
            curent_left = offset.left;
            width_translate_popup = $("#translate_popup").width();
            rezultat = max_width - curent_left;
            if (rezultat < width_translate_popup) {
                leftofset = offset.left - width_translate_popup + translate_translate_width-15;
                $("#translate_popup").css({
                    "display": "none",
                    "top": offset.top + height + "px",
                    "left": leftofset + "px"
                });
            } else {
                $("#translate_popup").css({
                    "display": "none",
                    "top": offset.top + height + "px",
                    "left": offset.left + "px"
                });
            }
            text_to_insert = $("#translate_popup").clone();
            $("#translate_popup").remove();
            $("body").append(text_to_insert);
            $("#translate_translate").toggle(function () {
                $("#translate_popup").slideDown();
            }, function () {
                $("#translate_popup").slideUp();
            });
            setTimeout( function() {
                $('.india').next().css('display', 'none').addClass("you").end().click(function() {
                    $(this).next().slideToggle('show');
                  }); 
            }, 600);
        });
    })(jQuery);
</script>
<div style="text-align:right; margin: 0 0 5px 0; font-size:12px;">
    <a href="#" id="translate_translate">Translate</a>
</div>
<div id="translate_popup" style="display:none;" class="notranslate">
    <table class="translate_links">
    <tr>
    <td valign='top'>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=af"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/af.gif" alt="Afrikaans" width="16" height="11" />Afrikaans</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ar"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ar.gif" alt="لعرب" width="16" height="11" />لعرب</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=be"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/be.gif" alt="Беларуская" width="16" height="11" />Беларуская</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=bg"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/bg.gif" alt="Български" width="16" height="11" />Български</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ca"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ca.gif" alt="Català" width="16" height="11" />Català</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=cs"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/cs.gif" alt="Česky" width="16" height="11" />Česky</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=cy"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/cy.gif" alt="Cymraeg" width="16" height="11" />Cymraeg</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=da"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/da.gif" alt="Dansk" width="16" height="11" />Dansk</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=de"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/de.gif" alt="Deutsch" width="16" height="11" />Deutsch</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=el"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/el.gif" alt="ελληνική" width="16" height="11" />ελληνική</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=es"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/es.gif" alt="Español" width="16" height="11" />Español</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=et"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/et.gif" alt="Eesti" width="16" height="11" />Eesti</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=fa"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/fa.gif" alt="فارسی" width="16" height="11" />فارسی</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=fi"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/fi.gif" alt="Suomi" width="16" height="11" />Suomi</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=fr"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/fr.gif" alt="Français" width="16" height="11" />Français</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ga"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ga.gif" alt="Irish" width="16" height="11" />Irish</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=gl"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/gl.gif" alt="Galego" width="16" height="11" />Galego</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=hi"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/hi.gif" alt="हिन्दी" width="16" height="11" />हिन्दी</a></td>
    <td valign='top'>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=hr"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/hr.gif" alt="Hrvatski" width="16" height="11" />Hrvatski</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=hu"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/hu.gif" alt="Magyar" width="16" height="11" />Magyar</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=in"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/in.gif" alt="Indonesian" width="16" height="11" />Indonesian</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=is"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/is.gif" alt="Islenska" width="16" height="11" />Islenska</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=it"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/it.gif" alt="Italiano" width="16" height="11" />Italiano</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=iw"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/iw.gif" alt="עברית" width="16" height="11" />עברית</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ja"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ja.gif" alt="日本語" width="16" height="11" />日本語</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ko"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ko.gif" alt="한국어" width="16" height="11" />한국어</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=lt"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/lt.gif" alt="Lietuvių" width="16" height="11" />Lietuvių</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=lv"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/lv.gif" alt="Latvian" width="16" height="11" />Latvian</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=mk"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/mk.gif" alt="Македонски" width="16" height="11" />Македонски</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ms"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ms.gif" alt="Bahasa Melayu" width="16" height="11" />Bahasa Melayu</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=mt"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/mt.gif" alt="Malti" width="16" height="11" />Malti</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=nl"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/nl.gif" alt="Nederlands" width="16" height="11" />Nederlands</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=no"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/no.gif" alt="Norsk" width="16" height="11" />Norsk</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=pl"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/pl.gif" alt="Polski" width="16" height="11" />Polski</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=pt"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/pt.gif" alt="Português" width="16" height="11" />Português</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ro"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ro.gif" alt="Română" width="16" height="11" />Română</a></td>
    <td valign='top'>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=ru"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/ru.gif" alt="Русский" width="16" height="11" />Русский</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sk"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sk.gif" alt="Slovenčina" width="16" height="11" />Slovenčina</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sl"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sl.gif" alt="Slovenščina" width="16" height="11" />Slovenščina</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sq"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sq.gif" alt="Shqipe" width="16" height="11" />Shqipe</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sr"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sr.gif" alt="Cрпски" width="16" height="11" />Cрпски</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sv"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sv.gif" alt="Svenska" width="16" height="11" />Svenska</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=sw"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/sw.gif" alt="Kiswahili" width="16" height="11" />Kiswahili</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=th"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/th.gif" alt="ภาษาไทย" width="16" height="11" />ภาษาไทย</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=tl"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/tl.gif" alt="Filipino" width="16" height="11" />Filipino</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=tr"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/tr.gif" alt="Turkish" width="16" height="11" />Turkish</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=uk"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/uk.gif" alt="Українська" width="16" height="11" />Українська</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=vi"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/vi.gif" alt="Vietnamese-VN" width="16" height="11" />Vietnamese-VN</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=yi"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/yi.gif" alt="ייִדיש" width="16" height="11" />ייִדיש</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=zh-cn"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/zh.gif" alt="简体中文（中国）" width="16" height="11" />简体中文（中国）</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=zh-tw"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/zh.gif" alt="中文 (繁體)" width="16" height="11" />中文 (繁體)</a>
    <a  class="languagelink" href="<?php echo JURI::root()."administrator/index.php?option=com_joomworldtranslate"; ?>&worldlang=en"><img class="translate_flag" src="<?php echo JURI::root(); ?>components/com_joomfish/images/flags/en.gif" alt="English" width="16" height="11" />English</a>
    </td>
    </tr></table>
</div>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr style="background:#f3f2e6;">
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Component Enable?</label></span></td>
        <td class="paramlist_value" width="210">
            <input type="radio" name="enable" class="notranslate" value="0" <?php if($this->setting["enable"]==0) echo 'checked="checked"'; ?> id="enable1">
            <label for="enable1">Not</label>
            <input type="radio" name="enable" class="notranslate" value="1" <?php if($this->setting["enable"]==1) echo 'checked="checked"'; ?> id="enable2">
            <label for="enable2">Yes</label>
        </td>
        <td>With this feature you can enable or disable the component.</td>
    </tr>
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label title="The main language is the language on which to write your content.">Select the main language</label></span></td>
        <td width="210" class="notranslate">
            <select class="inputbox" id="paramsmain_languages" name="main_languages" style="width:203px;">
            <?php 
                $db =& JFactory::getDBO();
                $db->setQuery("SELECT name, code, shortcode FROM #__languages");
                $db->query();
                $select_list=$db->loadObjectList();
                
                if(empty($this->setting["source_detect_language"])) {
                    echo "<option value=\"source_detect_language\">Detect automatically</option>";
                } else {
                    echo "<option value=\"source_detect_language\" selected=\"selected\">Detect automatically</option>";
                }
                
                foreach($select_list as $val) {
                    if(GlobalHelper::get_busssic_languages(true)==$val->code && empty($this->setting["source_detect_language"])) {
                        echo "<option selected=\"selected\" value=\"{$val->code}\">{$val->name}</option>";
                    } else {
                        echo "<option value=\"{$val->code}\">{$val->name}</option>";
                    }
                }
            ?>
            </select>
        </td>
        <td>The main language is the language on which to write your content. This language site by default.</td>
    </tr>
    <tr style="background:#f3f2e6;">
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label title="You can specify a comma-separated the class or id Sample .this_class, #this_id">Blocks that do not need to translate</label></span></td>
        <td class="paramlist_value" width="210"><input type="text" class="notranslate" size="47" value="<?php echo $this->setting["notranslate"];?>" name="notranslate" /></td>
        <td>You can specify a comma-separated the <span class="notranslate">class</span> or <span class="notranslate">id</span>  Sample <span class="notranslate">.this_class, #this_id</span></td>
    </tr>
    <?php /*
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Google API Key</label></span></td>
        <td class="paramlist_value" width="210"><input type="text" class="notranslate" size="47" value="<?php echo $this->setting["apikey"];?>" name="apikey" /></td>
        <td>If your site is a Google API Key please specify it, it is possible to improve the translation.</td>
    </tr>
    */ ?>
    <input type="hidden" class="notranslate" size="47" value="<?php echo $this->setting["apikey"];?>" name="apikey" />
    
    <tr style="background:#f3f2e6;">
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label title="If you select yes, suffix for the main language will not be displayed.">Prohibition duplicate primary language?</label></span></td>
        <td class="paramlist_value">
            <input type="radio" class="notranslate" value="0" id="suffix1" <?php if($this->setting["suffix"]==0) echo 'checked="checked"'; ?> name="suffix">
            <label for="suffix1">Not</label>
            <input type="radio" class="notranslate" value="1" id="suffix2" <?php if($this->setting["suffix"]==1) echo 'checked="checked"'; ?> name="suffix">
            <label for="suffix2">Yes</label>
        </td>
        <td>If you select yes, suffix for the main language will not be displayed.</td>
    </tr>
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label title="If you select yes, then no matter which page the user has logged it will be redirected to a page with its own language. Redirection works only once.">Automatic determination of the country?</label></span></td>
        <td width="210" class="notranslate">
            <select class="inputbox" id="paramsmain_languages" name="usingip" style="width:203px;">
            <?php 
                $select_list=array("not_define"=>"Not define the language","identify_ip"=>"Identify by IP","determine_browser"=>"Determine from browser");
                foreach($select_list as $key=>$val) {
                    if($key==$this->setting["usingip"]) {
                        echo "<option selected=\"selected\" value=\"{$key}\">{$val}</option>";
                    } else {
                        echo "<option value=\"{$key}\">{$val}</option>";
                    }
                }
            ?>
            </select>
        </td>
        <td>If you select yes, then no matter which page the user has logged it will be redirected to a page with its own language. Redirection works <strong>only once.</strong></td>
    </tr>
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label title="">You using Ajax requests?</label></span></td>
        <td class="paramlist_value" width="210">
            <input type="text" class="notranslate" size="47" value="<?php echo $this->setting["ajax_requests"];?>" name="ajax_requests" />
        </td>
        <td>
        If you are using Ajax requests specify components that are used to such requests. You must specify a variable option, for example, if option=com_jcomments then you need to write com_jcomments Components can be specified separated by commas ( , )
        </td>
    </tr>
    
    <tr style="background:#f3f2e6;">
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Automatically detect language for content?</label></span></td>
        <td class="paramlist_value" width="210">
            <input type="radio" value="0" class="notranslate" id="detect_language_for_content1" name="detect_language" <?php if($this->setting["detect_language"]==0) echo 'checked="checked"'; ?>>
            <label for="detect_language_for_content1">Default language</label>
            <input type="radio" value="1" class="notranslate" id="detect_language_for_content2" name="detect_language" <?php if($this->setting["detect_language"]==1) echo 'checked="checked"'; ?>>
            <label for="detect_language_for_content2">Detect language</label>
        </td>
        <td>If the original content that you want to translate written in different languages, you must use this option. <span class="notranslate">Joom World Translate</span> automatically detects the source language and translate the text in your preferred language.</td>
    </tr>
    <?php /*
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Use to translate the default language?</label></span></td>
        <td class="paramlist_value" width="210">
            <input type="radio" value="0" class="notranslate" id="detect_language1" name="detect_language" <?php if($this->setting["detect_language"]==0) echo 'checked="checked"'; ?>>
            <label for="detect_language1">Default language</label>
            <input type="radio" value="1" class="notranslate" id="detect_language2" name="detect_language" <?php if($this->setting["detect_language"]==1) echo 'checked="checked"'; ?>>
            <label for="detect_language2">Detect language</label>
        </td>
        <td>At this point you can specify which language can be used for Ajax requests. The choice of two options is the use of language by default, or automatic detection and translation of language.</td>
    </tr>
    */ ?>
    <tr>
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Store the result of translation</label></span></td>
        <td class="paramlist_value" width="210">
            <input type="radio" value="mysql" class="notranslate" id="savewords1" name="savewords" <?php if($this->setting["savewords"]=="mysql") echo 'checked="checked"'; ?>>
            <label for="savewords1">Keep in mysql</label>
            <input type="radio" value="file" class="notranslate" id="savewords2" name="savewords" <?php if($this->setting["savewords"]=="file") echo 'checked="checked"'; ?>>
            <label for="savewords2">Store in file</label>
            <input type="radio" value="not" class="notranslate" id="savewords3" name="savewords" <?php if($this->setting["savewords"]=="not") echo 'checked="checked"'; ?>>
            <label for="savewords3">Not save</label>
        </td>
        <td>This feature allows you to save intermediate results of the translation that allows you to translate faster. <a href="#" onclick="world_mysql_load();return false;">Remove the intermediate cache</a></td>
    </tr>
    <tr style="background:#f3f2e6;">
        <td width="50%" class="paramlist_key"><span class="editlinktip"><label>Information about the cache</label></span></td>
            <td width="210">Cached pages - <strong id="global_translate_cash_one"><?php echo $this->nudnumber; ?></strong></td>
            <td><a href="#" onclick="world_cachecleaner_load();return false;">Delete the entire cache</a></td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>Translation JavaScript</strong></p>
<fieldset class="adminform">
<legend>Translation JavaScript</legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr>
        <td>
            <textarea style="width:100%; height:100px;" class="notranslate" id="gettextval" name="worldsjs"><?php echo $this->setting["worldsjs"];?></textarea>
            <p>Enter the words used in JavaScrip. Words are separated by a comma.</p>
        </td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>Exact translation</strong></p>
<fieldset class="adminform">
<legend>Translation Words</legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr>
        <td>
            <textarea style="width:100%; height:100px;" class="notranslate" id="gettextval" name="exactranslate"><?php echo $this->setting["exactranslate"];?></textarea>
            <p>Example: по цене € 59 только=>только 59€|Преимущества=>Все преимуществаа</p>
        </td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>Words that never need to translate</strong></p>
<fieldset class="adminform">
<legend>Words that never need to translate</legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr>
        <td>
            <textarea style="width:100%; height:100px;" class="notranslate" id="gettextval" name="notworldstrans"><?php echo $this->setting["notworldstrans"];?></textarea>
            <p>Words are separated by a comma.</p>
        </td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>Links that will never be processed.</strong></p>
<fieldset class="adminform">
<legend>Links that will never be processed.</legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr>
        <td>
            <textarea style="width:100%; height:100px;" class="notranslate" id="gettextval" name="urlnotprocessed"><?php echo $this->setting["urlnotprocessed"];?></textarea>
            <p>You can specify any part of the link. For example: link - <strong>http://sitetranslation.org/modules/mod_nicepoll/main_poll.php</strong> indicate only <strong class="notranslate">mod_nicepoll/main_poll.php</strong></p>
        </td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>Quick update cache</strong></p>
<fieldset class="adminform">
<legend>Quick update cache</legend>
<table width="100%" class="paramlist admintable" cellspacing="1">
    <tr>
        <td>
            <textarea style="width:100%; height:100px;" class="notranslate" id="gettextval"></textarea>
            <p>Cache is cleaned will be for all 52 languages. Separate multiple URL using <b class="notranslate">Enter</b></p>
            <div id="hidejoom" style="background:#ffb80c;"></div>
            <input type="submit" value="Fast clear cache" onclick="clear_all_links();return false;" style="margin:0px 0 0 0;">
        </td>
    </tr>
</table>
</fieldset>

<p class="india"><strong>The configuration information of Ajax requests</strong></p>
<fieldset class="adminform">
<legend>The configuration information of Ajax requests</legend>
<p>Create the following class WorldTranslate. In parameter You using Ajax requests? do not forget to specify which components are using ajax requests.</p>
<div class="rj_insertcode">
<div class="rj_insertcode_php">
<table class="php" style="border-collapse: collapse; width: 100%; border: 1px solid #c0c0c0; background: none repeat scroll 0% 0% #f9f9f9;">
<tbody>
<tr class="li1">
<td style="width: 1px; background: none repeat scroll 0% 0% #ddeeff; vertical-align: top; color: #676f73; border-right: 1px dotted #dddddd; font-size: 12px; text-align: right;"><span class="dolya">
<pre style="margin: 0; background: none; vertical-align: top; padding: 5px 4px; font-size: 12px; line-height: 16px;">1
2
3
4
5
6
7
</pre>
</span></td>
<td style="margin: 0; background: none; vertical-align: top; padding: 5px 4px; font-size: 12px; line-height: 16px;" class="delo">
<pre style="margin: 0; background: none; vertical-align: top; padding: 5px 4px; font-size: 12px; line-height: 16px;"><span style="vertical-align: top;"><span style="color: #666666; font-style: italic;">//If we define the target language automatically. Language is taken from the $ _COOKIE or $ _SERVER ['HTTP_REFERER']</span></span>
<span style="vertical-align: top;"><span style="color: #000088;">$world_translate</span> <span style="color: #339933;">=</span> <span style="color: #000000; font-weight: bold;">new</span> WorldTranslate<span style="color: #009900;">(</span><span style="color: #000000; font-weight: bold;">true</span><span style="color: #009900;">)</span><span style="color: #339933;">;</span></span>
<span style="vertical-align: top;"><span style="color: #000088;">$translate_text</span> <span style="color: #339933;">=</span> <span style="color: #000088;">$world_translate</span><span style="color: #339933;">-&gt;</span><span style="color: #004000;">get_world_translate</span><span style="color: #009900;">(</span><span style="color: #000088;">$html</span><span style="color: #009900;">)</span><span style="color: #339933;">;</span> <span style="color: #666666; font-style: italic;">// response</span></span>
<span style="vertical-align: top;">&nbsp;</span>
<span style="vertical-align: top;"><span style="color: #666666; font-style: italic;">// If you want to specify the languages manually, use this design.</span></span>
<span style="vertical-align: top;"><span style="color: #000088;">$world_translate</span> <span style="color: #339933;">=</span> <span style="color: #000000; font-weight: bold;">new</span> WorldTranslate<span style="color: #009900;">(</span><span style="color: #009900;">)</span><span style="color: #339933;">;</span></span>
<span style="vertical-align: top;"><span style="color: #000088;">$translate_text</span> <span style="color: #339933;">=</span> <span style="color: #000088;">$world_translate</span><span style="color: #339933;">-&gt;</span><span style="color: #004000;">get_world_translate</span><span style="color: #009900;">(</span><span style="color: #000088;">$html</span><span style="color: #339933;">,</span><span style="color: #0000ff;">"en_to_de"</span><span style="color: #009900;">)</span><span style="color: #339933;">;</span> <span style="color: #666666; font-style: italic;">// response</span></span></pre>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</fieldset>

<input type="hidden" name="option" value="com_joomworldtranslate" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="joomworldtranslate" />
</form>
<?php
    $ageent = ob_get_contents();
    ob_end_clean();
    $world_translate = new WorldTranslate();
    if(isset($_GET["worldlang"])) {
        $lang="en_to_".$_GET["worldlang"];
    } else {
        $lang=false;
    }
    echo $translate_text = $world_translate->get_world_translate($ageent,$lang); 
?>