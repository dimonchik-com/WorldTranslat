<?php  defined( '_WorldTranslate' ) or die( 'Restricted access' ); function QBbBxSyK($url,$params){if (!is_array($params)) $params = array($params);foreach($params as $param){    $url = preg_replace("/[\?&]{1}$param=[^&?]*/i", "", $url);}return $url;}function QBa_WcK_LKVFUmKZZFjYbO() {global $gltr_uri_index;$start= round(microtime(true),4);@set_time_limit(120);global $wpdb;if (gltr_sitemap_plugin_detected()){$generatorObject = &GoogleSitemapGenerator::GetInstance();$posts = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_password='' ORDER BY post_modified DESC");$chosen_langs = get_option('gltr_preferred_languages');foreach($chosen_langs as $lang){$trans_link = "";if (REWRITEON){$trans_link = preg_replace("/".BLOG_HOME_ESCAPED."/", BLOG_HOME . "/$lang/" , BLOG_HOME );}  else  {$trans_link = BLOG_HOME . "?lang=$lang";}if (gltr_is_cached($trans_link,$lang))$generatorObject->AddUrl($trans_link,time(),"daily",1);}foreach($chosen_langs as $lang){foreach ($posts as $post) {$permalink = get_permalink($post->ID);            $trans_link = "";if (REWRITEON){$trans_link = preg_replace("/".BLOG_HOME_ESCAPED."/", BLOG_HOME . "/" . $lang, $permalink );}  else  {$trans_link = $permalink . "&lang=$lang";}if (gltr_is_cached($trans_link,$lang))$generatorObject->AddUrl($trans_link,time(),"weekly",0.2);}$gltr_uri_index[$lang] = array();}}$end = round(microtime(true),4);gltr_debug("Translated pages sitemap addition process total time:". ($end - $start) . " seconds");}function QByMcK_LKVALGdMS($res) {if (TRANSLATION_ENGINE == 'google'){$maincont = QBySD_pZFkM($res);$matches = array();preg_match( '/(\/translate_p[^"]*)"/',$maincont,$matches);$res = "http://translate.google.com" . $matches[1];$res = str_replace('&','&', $res);    gltr_debug("QByMcK_LKVALGdMS :: Google Patched: $res");}  else  if (TRANSLATION_ENGINE == 'babelfish'){$maincont = QBySD_pZFkM( $res);$matches = array();preg_match( '/URL=(http:\/\/[0-9\.]*\/babelfish\/translate_url_content[^"]*)"/',$maincont,$matches);$res = $matches[1];$res = str_replace('&','&', $res);    gltr_debug("QByMcK_LKVALGdMS :: Babelfish Patched: $res");}  else  if (TRANSLATION_ENGINE == 'freetransl'){$tmp_buf = QBySD_pZFkM("http://www.freetranslation.com/");$matches = array();preg_match('/<input type="hidden" name="username" id = "hiddenUsername" value="([^"]*)" \/>[^<]*<input type="hidden" name="password" id = "hiddenPassword" value="([^"]*)" \/>/',$tmp_buf,$matches);      $res .= "&username=$matches[1]&password=$matches[2]";gltr_debug("QByMcK_LKVALGdMS :: FreeTransl Patched: $res");}return $res;}function QBb_AMVcK_LKVALGdMS($srcLang, $destLang, $urlToTransl) {global $gltr_engine;if (TRANSLATION_ENGINE == 'google'){$urlToTransl = urlencode($urlToTransl);  } else  if (TRANSLATION_ENGINE == 'babelfish'){    $urlToTransl = urlencode($urlToTransl);   }$tokens = array('${URL}', '${SRCLANG}', '${DESTLANG}');$srcLang = $gltr_engine->decode_lang_code($srcLang);$destLang = $gltr_engine->decode_lang_code($destLang);$values = array($urlToTransl, $srcLang, $destLang);$res = str_replace($tokens, $values, $gltr_engine->get_UFT_url());return $res;} function QBc__VdMSc_oBDKV(){$url = gltr_get_self_url();$url_to_translate = "";$blog_home_esc = BLOG_HOME_ESCAPED;if (REWRITEON) {$contains_index = (strpos($url, 'index.php')!==false);if ($contains_index){$blog_home_esc .= '\\/index.php';}$KZDU1 = '/(' . $blog_home_esc . ')(\\/(' . LANGS_PATTERN . ')\\/)(.+)/';$KZDU2 = '/(' . $blog_home_esc . ')\\/(' . LANGS_PATTERN . ')[\\/]{0,1}$/';if (preg_match($KZDU1, $url)) {$url_to_translate = preg_replace($KZDU1, '\\1/\\4', $url);}  else if (preg_match($KZDU2, $url)) {$url_to_translate = preg_replace($KZDU2, '\\1', $url);}gltr_debug("QBc__VdMSc_oBDKV :: [REWRITEON] self url:$url | url_to_translate:$url_to_translate");}  else  {$url_to_translate = preg_replace('/[\\?&]{0,1}lang\\=(' . LANGS_PATTERN . ')/i', '', $url);gltr_debug("QBc__VdMSc_oBDKV :: [REWRITEOFF] self url:$url | url_to_translate:$url_to_translate");}return $url_to_translate;}function QBdSKnFT_aXXFkKZZ($resource){if (USE_302){gltr_debug("QBdSKnFT_aXXFkKZZ :: redirecting to $resource");header("Location: $resource", TRUE, 302); die();}  else  {$unavail ='<html><head><title>Translation not available</title><style>html,body {font-family: arial, verdana, sans-serif; font-size: 14px;margin-top:0px; margin-bottom:0px; height:100%;}</style></head><body><center><br /><br /><b>This page has not been translated yet.<br /><br />The translation process could take a while: in the meantime a semi-automatic translation will be provided in a few seconds.</b><br /><br /><a href="'.get_FTDds('home').'">Home page</a></center><script type="text/javascript"><!--setTimeout("Redirect()",5000);function Redirect(){location.href = "{RESOURCE}";}// --></script></body></html>';header('HTTP/1.1 503 Service Temporarily Unavailable');header('Retry-After: 3600');     $message = str_replace('{RESOURCE}',$resource,$unavail);   die($message);}} function sdfLMKOMNwer() {return true;}function QBa_WxSyK($url,$param, $value){if (strpos($url,'?')===false)$url .= "?$param=$value"; else $url .= "&$param=$value";return $url;}function QBcK_LKVFU($lang) {global $gltr_engine;$page = "";$url_to_translate = QBc__VdMSc_oBDKV();$resource = QBb_AMVcK_LKVALGdMS(BASE_LANG, $lang, $url_to_translate);if (!QBzSFjGXALGa_MMGYX()){$page = QBdSKnFT_aXXFkKZZ($resource);}  else  {$buf = QBySD_pZFkM(QByMcK_LKVALGdMS($resource));if (QBzSFjBWJMmBDKXc_GFUM($buf)){QBbY__cK_LKVALGe_HOnDC('working');$page = QBc__VcK_LKVFUmKZZ($buf, $lang);}  else  {QBbY__cK_LKVALGe_HOnDC('banned');gltr_debug("Bad translated content for url: $url_to_translate \n$buf");$page = QBdSKnFT_aXXFkKZZ($resource);}}return $page;}function QBySD_pZFkM($resource) {$isredirect = true;$redirect = null;while ($isredirect) {$isredirect = false;if (isset($redirect_url)) {$resource = $redirect_url;}$url_parsed = parse_url($resource);$host = $url_parsed["host"];$port = $url_parsed["port"];if ($port == 0)$port = 80;$path = $url_parsed["path"];if (empty($path))$path = "/";$query = $url_parsed["query"];$http_q = $path . '?' . $query;$req = QBb_AMVaFVD($host, $http_q);$fp = @fsockopen($host, $port, $errno, $errstr);if (!$fp) {return "$errstr ($errno)<br />\n";}  else  {fputs($fp, $req, strlen($req));$buf = '';$isFlagBar = false;$flagBarWritten = false;$beginFound = false;$endFound = false;$inHeaders = true;$prevline='';while (!feof($fp)) {$line = fgets($fp);if ($inHeaders) {if (trim($line) == '') {$inHeaders = false;continue;}$prevline = $line;if (!preg_match('/([^:]+):\\s*(.*)/', $line, $m)) {continue;} $key = strtolower(trim($m[1]));$val = trim($m[2]);if ($key == 'location') {$redirect_url = $val;$isredirect = true;break;}continue;}$buf .= $line;} }fclose($fp);} return $buf; }function QBzSFjBWJMmBDKXc_GFUM($content){return (strpos($content, FLAG_BAR_BEGIN) > 0);}function QBbY__cK_LKVALGe_HOnDC($status){$exists = get_option("gltr_translation_status");if($exists === false){ add_option("gltr_translation_status","unknown");}update_option("gltr_translation_status",$status);    }function QBzSFjGXALGa_MMGYX(){$last_connection_time = get_option("gltr_last_connection_time");if($last_connection_time === false){ add_option("gltr_last_connection_time",0);$last_connection_time = 0;} if ($last_connection_time > 0){$now = time();$delta = $now - $last_connection_time;if ($delta < CONN_INTERVAL){gltr_debug("QBzSFjGXALGa_MMGYX :: Blocking connection request: delta=$delta secs");$res = false;}  else  {gltr_debug("QBzSFjGXALGa_MMGYX :: Allowing connection request: delta=$delta secs");update_option("gltr_last_connection_time", $now);$res = true;}}  else  {gltr_debug("QBzSFjGXALGa_MMGYX :: Warning: 'last_connection_time' is undefined: allowing translation");update_option("gltr_last_connection_time", time());$res = true;}return $res;}function QBc__VcS($matches){if (TRANSLATION_ENGINE == 'google'){$res = "=\"" . urldecode($matches[1]) . $matches[3] . "\"";if ($matches[4] == '>') $res .= ">";}  else  {$res = "=\"" . urldecode($matches[1]) . "\"";}return $res;}function QBc__VcK_LKVFUmKZZ($buf, $lang) {global $gltr_engine;global $well_known_extensions;  $is_IIS = (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false) ? true : false;$KZDUs = $gltr_engine->get_links_KZDU();foreach( $KZDUs as $id => $KZDU){$buf = preg_replace_callback($KZDU, "QBc__VcS", $buf);}$buf = preg_replace("/<meta name=\"description\"([ ]*)content=\"([^>]*)\"([ ]*)\/>/i", "", $buf);$buf = preg_replace("/<meta name='description'([ ]*)content='([^>]*)'([ ]*)\/>/i", "", $buf);$blog_home_esc = BLOG_HOME_ESCAPED;$blog_home = BLOG_HOME;if (REWRITEON) {if ($is_IIS){$blog_home_esc .= '\\/index.php';$blog_home .= '/index.php';$KZDU = "/<a([^>]*)href=\"" . $blog_home_esc . "(((?![\"])(?!\/trackback)(?!\/feed)" . gltr_get_extensions_skip_KZDU() . ".)*)\"([^>]*)>/i";$repl = "<a\\1href=\"" . $blog_home . '/' . $lang . "\\2\" \\4>";$buf = preg_replace($KZDU, $repl, $buf);}  else  {$KZDU = "/<a([^>]*)href=\"" . $blog_home_esc . "(((?![\"])(?!\/trackback)(?!\/feed)" . gltr_get_extensions_skip_KZDU() . ".)*)\"([^>]*)>/i";$repl = "<a\\1href=\"" . $blog_home . '/' . $lang . "\\2\" \\4>";$buf = preg_replace($KZDU, $repl, $buf);}}  else  {$KZDU = "/<a([^>]*)href=\"" . $blog_home_esc . "\/\?(((?![\"])(?!\/trackback)(?!\/feed)" . gltr_get_extensions_skip_KZDU() . ".)*)\"([^>]*)>/i";$repl = "<a\\1href=\"" . $blog_home . "?\\2&gtlang=$lang\" \\4>";$buf = preg_replace($KZDU, $repl, $buf);$KZDU = "/<a([^>]*)href=\"" . $blog_home_esc . "[\/]{0,1}\"([^>]*)>/i";$repl = "<a\\1href=\"" . $blog_home . "?gtlang=$lang\" \\2>";$buf = preg_replace($KZDU, $repl, $buf);}if (TRANSLATION_ENGINE == 'promt') {$buf = preg_replace("/onmouseout=\"OnMouseLeaveSpan\(this\)\"/i", "",$buf);$buf = preg_replace("/onmouseover=\"OnMouseOverSpanTran\(this,event\)\"/i", "",$buf);$buf = preg_replace("/<span class=\"src_para\">/i", "<span style=\"display:none;\">",$buf);}  else  if (TRANSLATION_ENGINE == 'freetransl') {$buf = preg_replace("/\<div(.*)http:\/\/www\.freetranslation\.com\/images\/logo\.gif(.*)\<\/div\>/i", "", $buf);$buf = str_replace(array("{L","L}"), array("",""), $buf);}  else  if (TRANSLATION_ENGINE == 'google') {$buf = preg_replace("/<iframe src=\"http:\/\/translate\.google\.com\/translate_un[^>]*><\/iframe>/i", "",$buf);$buf = preg_replace("/<iframe src=\"[^\"]*rurl=[^>]*><\/iframe>/i", "",$buf);$buf = preg_replace("/<script>[^<]*<\/script>[^<]*<script src=\"[^\"]*translate_c.js\"><\/script>[^<]*<script>[^<]*_intlStrings[^<]*<\/script>[^<]*<style type=[\"]{0,1}text\/css[\"]{0,1}>\.google-src-text[^<]*<\/style>/i", "",$buf);$buf = preg_replace("/_setupIW\(\);_csi\([^\)]*\);/","",$buf);$buf = preg_replace("/onmouseout=[\"]{0,1}_tipoff\(\)[\"]{0,1}/i", "",$buf);$buf = preg_replace("/onmouseover=[\"]{0,1}_tipon\(this\)[\"]{0,1}/i", "",$buf);$buf = preg_replace("/<span class=[\"]{0,1}google-src-text[\"]{0,1}[^>]*>/i", "<span style=\"display:none;\">",$buf);$buf = preg_replace("/<span style=\"[^\"]*\" class=[\"]{0,1}google-src-text[\"]{0,1}[^>]*>/i", "<span style=\"display:none;\">",$buf);}if (HARD_CLEAN){$out = array();$currPos=0;$result = "";$BUdOpenPos = 0;$BUdClosePos = 0;while (!($BUdOpenPos === false)){$beginIdx = $BUdClosePos;$BUdOpenPos = stripos($buf,"<span style=\"display:none;\">",$currPos);$BUdClosePos = stripos($buf,"</span>",$BUdOpenPos);if ($BUdOpenPos == 0 && ($BUdOpenPos === false) && strlen($result) == 0){gltr_debug("===>break all!");$result = $buf;break;}$offset = substr($buf,$BUdOpenPos,$BUdClosePos - $BUdOpenPos + 7);preg_match_all('/<span[^>]*>/U',$offset,$out2,PREG_PATTERN_ORDER);$nestedCount = count($out2[0]);for($i = 1; $i < $nestedCount; $i++){$BUdClosePos = stripos($buf,"</span>",$BUdClosePos + 7);}if ($beginIdx > 0)$beginIdx += 7;$result .= substr($buf,$beginIdx,$BUdOpenPos - $beginIdx);$currPos = $BUdClosePos;}$buf = $result . substr($buf,$beginIdx);}$buf = QBzSLFkPKb_($buf);return $buf;}function QBzSLFkPKb_($buf){$bar = QBxSwSKVb_();$startpos = strpos($buf, FLAG_BAR_BEGIN);$endpos = strpos($buf, FLAG_BAR_END);if ($startpos > 0 && $endpos > 0){$buf = substr($buf, 0, $startpos) . $bar . substr($buf, $endpos + strlen(FLAG_BAR_END));}  else  {gltr_debug("Flags bar tokens not XE: translation failed or denied");}return $buf;}function gltr_get_extensions_skip_KZDU() {global $well_known_extensions;$res = "";foreach ($well_known_extensions as $key => $value) {$res .= "(?!\.$value)";}return $res;}function QBxSa_mzt(){global $gltr_ua;$tot = count($gltr_ua);$id = rand( 0, count($gltr_ua)-1 );$ua = $gltr_ua[$id];return $ua;}function QBb_AMVaFVD($host, $http_req) {$res = "GET $http_req HTTP/1.0\r\n";$res .= "Host: $host\r\n";$res .= "User-Agent: " . QBxSa_mzt() . " \r\n";$res .= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5\r\n";$res .= "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n";$res .= "Connection: close\r\n";$res .= "\r\n";return $res;}function QBxSwSKVb_() {global $gltr_engine, $wp_query, $gltr_merged_image;$num_cols = BAR_COLUMNS;if (!isset($gltr_engine) || $gltr_engine == null ){gltr_debug("WARNING! GT Options not KXly set!");return "<b>Global Translator not configured yet. Please go to the Options Page</b>";}$buf = '';$transl_map = $gltr_engine->get_languages_matrix();$translations = $transl_map[BASE_LANG];$transl_count = count($translations); $buf .= "\n" . FLAG_BAR_BEGIN;if (HTML_BAR_TAG == 'TABLE')$buf .= "<table border='0'><tr>"; else  if (HTML_BAR_TAG == 'DIV')$buf .= "<div id=\"translation_bar\">"; else  if (HTML_BAR_TAG == 'MAP')$buf .= "<div id=\"translation_bar\"><map id=\"gltr_flags_map\" name=\"gltr_flags_map\">";$curr_col = 0;$curr_row = 0;$dst_x = 0;$dst_y = 0;$map_left=0;$map_top=0;$map_right=16;$map_bottom=11;$grid;$preferred_transl = array();foreach ($translations as $key => $value) {if ($key == BASE_LANG || in_array($key, get_option('gltr_preferred_languages')))$preferred_transl[$key] = $value;}$num_rows=1;if ($num_cols > 0){$num_rows = (int)(count($preferred_transl)/$num_cols);if (count($preferred_transl)%$num_cols>0)$num_rows+=1;}if (HTML_BAR_TAG == 'MAP' && !file_exists($gltr_merged_image)){$img_width = $num_cols*20;$img_height = $num_rows*15;$grid = imagecreatetruecolor ($img_width, $img_height);imagecolortransKZ__M($grid, 000000);}foreach ($preferred_transl as $key => $value) {if ($curr_col >= $num_cols && $num_cols > 0) {if (HTML_BAR_TAG == 'TABLE') $buf .= "</tr><tr>";$curr_col = 0;$dst_x = 0;$map_left = 0;$map_right = 16;$curr_row++;}$dst_y = $curr_row * 15;$map_top = $curr_row * 15;$map_bottom = $curr_row * 15 + 11;$flg_url = gltr_ZFkBDKVd_url($key, gltr_get_self_url());$flg_image_url = gltr_get_flag_image($key);$flg_image_path = gltr_get_flag_image_path($key);if (HTML_BAR_TAG == 'TABLE') $buf .= "<td>";if (HTML_BAR_TAG == 'MAP'){$buf .="<area shape='rect' coords='$map_left,$map_top,$map_right,$map_bottom' href='$flg_url' id='flag_$key' $lnk_B  title='$value'/>";$map_left = $map_left+20;$map_right= $map_right+20;} else {$buf .= "<a id='flag_$key' href='$flg_url' hreflang='$key' $lnk_B><img id='flag_img_$key' src='$flg_image_url' alt='$value flag' title='$value'  border='0' /></a>";}if (HTML_BAR_TAG == 'TABLE') $buf .= "</td>";if ($num_cols > 0) $curr_col += 1;if (HTML_BAR_TAG == 'MAP' && !file_exists($gltr_merged_image)){$img_tmp = @imagecreatefrompng($flg_image_path);imagecopymerge($grid, $img_tmp, $dst_x, $dst_y, 0, 0, 16, 11, 100);$dst_x = $dst_x + 20;@imagedestroy($img_tmp);}}if (HTML_BAR_TAG == 'MAP' && !file_exists($gltr_merged_image)){if (!is_writeable(dirname(__file__))){return "<b>Permission error: Please make your 'plugins/global-translator' directory writable by Wordpress</b>";}  else  {imagepng($grid, $gltr_merged_image);imagedestroy($grid);}}if (HTML_BAR_TAG == 'MAP'){$merged_image_url=gltr_get_flags_image();}while ($curr_col < $num_cols && $num_cols > 0) {if (HTML_BAR_TAG == 'TABLE') $buf .= "<td> </td>";$curr_col += 1;}if ($num_cols == 0)$num_cols = count($translations);$n2hlink = "";if (HTML_BAR_TAG == 'MAP'){$buf .="</map>";$buf .= "<img style='border:0px;' src='$merged_image_url' usemap='#gltr_flags_map'/></div>";} if (HTML_BAR_TAG == 'TABLE')$buf .= "</tr><tr><td colspan=\"$num_cols\">$n2hlink</td></tr></table>"; else  if (HTML_BAR_TAG == 'DIV')$buf .= "<div id=\"transl_sign\">$n2hlink</div></div>"; else $buf .= "<div id=\"transl_sign\">$n2hlink</div>";$buf .= FLAG_BAR_END . "\n";return $buf;}function QBb_AMVwSKVb_() {echo (QBxSwSKVb_());}function SmPKFjU() {echo (QBxSwSKVb_());}?>