<?php
include("worldtranslate/worldtranslate.php");

$href=isset($_POST["url"])?trim($_POST["url"]):"";
$lang=isset($_POST["lang"])?trim($_POST["lang"]):"";
$on=isset($_POST["on"])?trim($_POST["on"]):"";
$javascript_translate=isset($_POST["javascript_translate"])?trim($_POST["javascript_translate"]):"";
$notworldstrans=isset($_POST["notworldstrans"])?trim($_POST["notworldstrans"]):"";
$detect_language=($lang=="")?true:false;

$world_translate = new WorldTranslate(array(
                "basic_languages"=>$lang,
                "notranslate"=>"",
                "notworldstrans"=>$notworldstrans,
                "url_not_translate"=>"",
                "javascript_translate"=>$javascript_translate,
                "detect_language"=>$detect_language,
                "info"=>true,
                "apikey"=>""
),$href);

$site=get_content($href);

if(empty($site)) {
    echo "Sorry, try to enter another url <a href='http://sitetranslation.org/onlinedemo.html'>back</a>";
    exit;
}

preg_match_all("|charset=(.*?)\"|U", $site, $out, PREG_PATTERN_ORDER);
$utf8=strtolower($out[1][0]);
if(!preg_match("/utf-8/i",$utf8)) {
    echo "Sorry this demo only works with sites in utf-8 <a href='http://sitetranslation.org/onlinedemo.html'>back</a>";
    exit;    
}

echo $world_translate->get_world_translate($site,$on); 

function get_content($href) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$href);
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
}
?>