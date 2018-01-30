<?php
defined( '_WorldTranslate' ) or die( 'Restricted access' );

function show_languages($languages_menu=false,$world_settting=false) {
    if($world_settting==false) {
        $world_settting=array("type"=>"justable","fallindowntwo"=>"move_mouse","effect"=>"fadeIn","translator"=>"World Translate","include_jquery"=>true);
    }
    
    if($languages_menu==false) {
    $languages_menu=array("af"=>"Afrikaans","ar"=>"لعرب","be"=>"Беларуская","bg"=>"Български","ca"=>"Català","cs"=>"Česky","cy"=>"Cymraeg","da"=>"Dansk","de"=>"Deutsch","el"=>"ελληνική","es"=>"Español","et"=>"Eesti","fa"=>"فارسی","fi"=>"Suomi","fr"=>"Français","ga"=>"Irish","gl"=>"Galego","hi"=>"हिन्दी","hr"=>"Hrvatski","hu"=>"Magyar","in"=>"Indonesian","is"=>"Islenska","it"=>"Italiano","iw"=>"עברית","ja"=>"日本語","ko"=>"한국어","lt"=>"Lietuvių","lv"=>"Latvian","mk"=>"Македонски","ms"=>"Bahasa Melayu","mt"=>"Malti","nl"=>"Nederlands","no"=>"Norsk","pl"=>"Polski","pt"=>"Português","ro"=>"Română","ru"=>"Русский","sk"=>"Slovenčina","sl"=>"Slovenščina","sq"=>"Shqipe","sr"=>"Cрпски","sv"=>"Svenska","sw"=>"Kiswahili","th"=>"ภาษาไทย","tl"=>"Filipino","tr"=>"Turkish","uk"=>"Українська","vi"=>"Vietnamese-VN","yi"=>"ייִדיש","zh-cn"=>"简体中文（中国）","zh-tw"=>"中文 (繁體)","en"=>"English");
    }
    
    $url=new WorldURI();
    
    $header="";
    
    if ( count($languages_menu)>0 ) 
    $text="";
        $count=0;
        $current=isset($_GET["worldlang"])?$_GET["worldlang"]:"";
        $current_lang=isset($_GET["worldlang"]) ? $_GET["worldlang"] : "";
         switch ($world_settting["type"]) {
             case "fallindown":
                $header.='<link rel="stylesheet" href="'.$url->base().'/worldmenu/world-menu-languages.css" type="text/css" />'."\n";
                if($world_settting["include_jquery"]==true) {
                        $header.="<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'></script>\n";   
                }
                switch ($world_settting["fallindowntwo"]) {
                    case "click":
                        switch ($world_settting["effect"]) {
                            case "slideDown":
                                $header.='<script type="text/javascript" src="'.$url->base().'/worldmenu/script/click_slidedown.js"></script>'."\n";
                            break;
                            case "fadeIn":
                                $header.='<script type="text/javascript" src="'.$url->base().'/worldmenu/script/click_fedein.js"></script>'."\n";
                            break;
                        }
                    break;
                    case "move_mouse":
                        switch ($world_settting["effect"]) {
                            case "slideDown":
                                $header.='<script type="text/javascript" src="'.$url->base().'/worldmenu/script/mouse_slidedown.js"></script>'."\n";
                            break;
                            case "fadeIn":
                                $header.='<script type="text/javascript" src="'.$url->base().'/worldmenu/script/mouse_fedein.js"></script>'."\n";
                            break;
                        }
                    break;
                }
                $text.='
                <a href="#" id="translate_translate">'.$world_settting["translator"].'</a>
                <div id="translate_popup" style="display:none;  direction: ltr;" class="notranslate">
                <table class="translate_links">
                <tr>';
                foreach($languages_menu as $key=>$val) {
                        if($count==0) { 
                            $text.="<td valign='top'>";
                        }
                        if($current==$key) {
                            $text.='<a  class="languagelink" style="color:red"  href="'.$url->worldurl($key).'"><img class="translate_flag" src="'.WorldURI::base().'/worldmenu/flags/'.$key.'.gif" alt="Afrikaans" width="16" height="11" />'.$val.'</a>'; 
                        } else {
                            $text.='<a  class="languagelink" href="'.$url->worldurl($key).'"><img class="translate_flag" src="'.WorldURI::base().'/worldmenu/flags/'.$key.'.gif" alt="Afrikaans" width="16" height="11" />'.$val.'</a>'; 
                        }
                        if($count==17) { 
                            $text.="</td><td valign='top'>";
                        }
                        if($count==35) { 
                            $text.="</td><td valign='top'>";
                        }
                        $count++;
                }
                $text.="</td></tr></table></div>";
             break;
             case "oneline":
                $text.="<div id='oneline' class='notranslate'>";
                foreach($languages_menu as $key=>$val) {
                    $text.='<a  href="'.$url->worldurl($key).'"><img src="'.WorldURI::base().'/worldmenu/flags/'.$key.'.gif" alt="Afrikaans" width="16" height="11" /></a>'; 
                }
                $text.="</div>";
             break;
             case "dropdown":
                echo '
                  <script type="text/javascript">
                        function doTranslate(link) {
                            window.location=link;
                        }
                  </script>
                ';
                $text.="<div id='dropdown' class='notranslate'>\n";
                $text.='<select onchange=doTranslate(this.value);>'."\n";  
                foreach($languages_menu as $key=>$val) {
                    if($current_lang==$key) {
                        $text.='<option value="'.$url->worldurl($key).'" selected="selected">'.$val.'</option>'."\n";
                    } else {
                        $text.='<option value="'.$url->worldurl($key).'">'.$val.'</option>'."\n";
                    }    
                }
                $text.="</select>\n</div>";
             break;
             case "justable":
                $text.='<table>';
                $tima_i = 0;
                $tima_two = 1;
                $countval=count($languages_menu);
                foreach($languages_menu as $key=>$val) {
                            if($tima_i==0) { 
                                $text.="<tr>";
                                $tima_i = 1;
                            }
                            if($current==$key) {
                            $text.='<td><a  class="languagelink" style="color:red"  href="'.$url->worldurl($key).'"><img class="translate_flag" src="'.WorldURI::base().'/worldmenu/flags/'.$key.'.gif" alt="Afrikaans" width="16" height="11" />'.$val.'</a></td>'; 
                            } else {
                            $text.='<td><a  class="languagelink" href="'.$url->worldurl($key).'"><img class="translate_flag" src="'.WorldURI::base().'/worldmenu/flags/'.$key.'.gif" alt="Afrikaans" width="16" height="11" />'.$val.'</a></td>';
                            }
                            if(($tima_two%4)==0 && $tima_two!=0 && $countval!=$tima_two) { 
                                $text.="</tr>";
                                $tima_i = 0;
                            }
                            $tima_two++;
                }
                $text.="</table>";
             break;
         }
        
        $text=$header.$text;
    return $text;
}

//echo show_languages($languages_menu);
?>