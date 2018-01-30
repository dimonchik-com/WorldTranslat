<?php
define ('WORLDABSOLUTE_PATH', dirname(__FILE__) );
define( '_WorldTranslate', true);
include(WORLDABSOLUTE_PATH."/worldlibrary/workurl.php");
include(WORLDABSOLUTE_PATH."/worldmenu/world-menu-languages.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/translator.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/htmlibrary.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/prompt.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/params-translator.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/htmlhelper.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/library.php");
include(WORLDABSOLUTE_PATH."/worldlibrary/helper.php");

class WorldURI {
    function base() {
        $url=new xMSEhq();
        return $url->UFT();
    }
    
    function worldurl($name) {
        $url=new xMSEhq();
        return $url->YMSMS($name); 
    }
}
?>