<?php
include("worldtranslate/worldtranslate.php");

ob_start();
include("about-product.php");
$site = ob_get_contents();
ob_end_clean();

$world_translate = new WorldTranslate(array(
                "basic_languages"=>"en",
                "notranslate"=>"",
                "notworldstrans"=>"F.A.Q,World Site Translator,World Site Translater,script World Translate,World Translate,framework,Curl library,JoomFish,PHP memory limit 64mb - 128mb,ionCube Loader,PHP memory limit,World Site,Translator",
                "url_not_translate"=>"",
                "javascript_translate"=>"",
                "exactranslate"=>"", //по цене И 59 только=>только 59И|ѕреимущества=>нахуй
                "detect_language"=>false,
                "info"=>true,
                "apikey"=>""
),"");

echo $world_translate->get_world_translate($site,$_GET["worldlang"]); 
?>