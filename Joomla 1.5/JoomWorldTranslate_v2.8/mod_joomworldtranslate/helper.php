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



if( !defined( 'JFMODULE_CLASS' ) ) {
	define( 'JFMODULE_CLASS', true );
    
	class JFModuleHTML {
		function makeOption( $value, $text='', $style='') {
			$obj = new stdClass;
			$obj->value = $value;
			$obj->text = $text;
			$obj->style = $style;
			return $obj;
		}

		function selectList( &$arr, $tag_name, $tag_attribs, $key, $text, $selected=NULL ) {
			if ( is_array( $arr ) ) {
				reset( $arr );
			}
			$html 	= "\n<select name=\"$tag_name\" $tag_attribs>";
			$count 	= count( $arr );
			for ($i=0, $n=$count; $i < $n; $i++ ) {
				$k = $arr[$i]->$key;
				$t = $arr[$i]->$text;
				$id = ( isset($arr[$i]->id) ? @$arr[$i]->id : null);
				$extra = ' '.$arr[$i]->style." ";
				$extra .= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
				if (is_array( $selected )) {
					foreach ($selected as $obj) {
						$k2 = $obj->$key;
						if ($k == $k2) {
							$extra .= " selected=\"selected\"";
							break;
						}
					}
				} else {
					$extra .= ($k == $selected ? " selected=\"selected\"" : '');
				}
				$html .= "\n\t<option value=\"".$k."\"$extra >" . $t . "</option>";
			}
			$html .= "\n</select>\n";
			return $html;
		}

		function _createHRef( $language , $modparams) {
			$db =& JFactory::getDBO();
			$pfunc = $db->_profile();
			$code = $language->getLanguageCode();
			$app	= &JFactory::getApplication();
			$router = &$app->getRouter();
			$vars = $router->getVars();
			$href= "index.php";
			$hrefVars = '';
			$vars['lang']=$code;
			$filter = & JFilterInput::getInstance();
			
            foreach ($vars as $k=>$v) {
				if( $hrefVars != "" ) {
					$hrefVars .= "&";
				}
				$hrefVars .= $k.'='.$filter->clean($v);
			}
			if( $hrefVars != "" ) {
				$href .= '?' .$hrefVars;
			}
			$app	= &JFactory::getApplication();
			$router = &$app->getRouter();
			$uri = &JURI::getInstance();
			$currenturl = $uri->toString();
			$params =& JComponentHelper::getParams("com_joomfish");
			if ($modparams->get("cache_href",1) && $params->get("transcaching",1)){
				$jfm =& JoomFishManager::getInstance();
				$cache = $jfm->getCache($language->code);
				$url = $cache->get( array("JFModuleHTML", '_createHRef2'), array($currenturl,$href, $code));
			}
			else {
				$url= JFModuleHTML::_createHRef2($currenturl,$href, $code);
			}
			$db->_profile($pfunc);
			return $url;
		}
		
		function _createHRef2($currenturl,$href, $code) {
			$registry =& JFactory::getConfig();
			$language = $registry->getValue("joomfish.language",null);
			if($language != null) {
				$jfLang = $language->getLanguageCode();
			} else {
				$jfLang = null;
			}
			if ( !is_null($code) && $code != $jfLang){
				$registry =& JFactory::getConfig();
				$sefLang = TableJFLanguage::createByShortcode($code, false);
				$registry->setValue("joomfish.sef_lang", $sefLang->code);
				$menu =& JSite::getMenu();
				$menu->_items = JFModuleHTML::getJFMenu($sefLang->code, false, $menu->_items);
				$url = JFModuleHTML::_route( $href, $sefLang);
				@$menu->_items = JFModuleHTML::getJFMenu($language->code, true);
				$registry->setValue("joomfish.sef_lang", false);
			}
			else {
				$url = JFModuleHTML::_route( $href ,$language);
			}
			return $url;
		}

		function _route($href,$sefLang){
			$jfm =& JoomFishManager::getInstance();
			$conf =& JFactory::getConfig();
			$code = $sefLang->code;
			if ($jfm->getCfg("transcaching",1) && $code!==$conf->getValue('config.defaultlang')){
				$cache = $jfm->getCache($code);
				$uri = &JURI::getInstance();
				$url = $cache->get( array("JFModuleHTML", 'getRoute'), array($href,$code,$uri->isSSL()));
			}
			else {
				$url = JFModuleHTML::getRoute($href,$code);
			}
			return $url;
		}

		function getRoute($href,$code=""){
			$ssl = 1; 
			$registry =& JFactory::getConfig();
			$registry->setValue("joomfish.sef_host", false);
			$url  = JRoute::_( $href, true, $ssl);
			$currenthost = $registry->getValue("joomfish.current_host", false);
			$sefhost = $registry->getValue("joomfish.sef_host", false);
			if ($sefhost && $currenthost) {
				$url = str_replace($currenthost, $sefhost, $url);
			}
			$uri = &JURI::getInstance();
			if (!$uri->isSSL()){
				$url = str_replace("https://", "http://", $url);
			}
			$registry->setValue("joomfish.sef_host", false);
			return $url;
		}

		function getJFMenu($lang, $getOriginals=true,  $currentLangMenuItems=false){
			static $instance;
			if (!isset($instance)){
				$instance = array();
				if (!$currentLangMenuItems){
					JError::raiseWarning('SOME_ERROR_CODE', "Error translating Menus - missing currentLangMenuItems");
					return false;
				}
				$db		= & JFactory::getDBO();
				$sql	= 'SELECT m.*, c.`option` as component' .
				' FROM #__menu AS m' .
				' LEFT JOIN #__components AS c ON m.componentid = c.id'.
				' WHERE m.published = 1 '.
				' ORDER BY m.sublevel, m.parent, m.ordering';
				$db->setQuery($sql);
				$registry =& JFactory::getConfig();
				$defLang = $registry->getValue("config.defaultlang");
				if (!($menu = $db->loadObjectList('id',true, $defLang))) {
					JError::raiseWarning('SOME_ERROR_CODE', "Error loading Menus: ".$db->getErrorMsg());
					return false;
				}
				$tempmenu = JSite::getMenu();
				$activemenu = $tempmenu->getActive();
				if ($activemenu && isset($activemenu->id) && $activemenu->id>0 && array_key_exists($activemenu->id,$menu)){
					$newmenu = array();
					$newmenu[$activemenu->id] = $menu[$activemenu->id];
					while ($activemenu->parent!=0 && array_key_exists($activemenu->parent,$menu)){
						$activemenu = $menu[$activemenu->parent];
						$newmenu[$activemenu->id] = $activemenu;
					}
					$menu = $newmenu;
				}
				$instance["raw"] = array("rows"=>$menu, "tableArray"=>$db->_getRefTables(),"originals"=>$currentLangMenuItems);
				JFModuleHTML::_setupMenuRoutes($instance["raw"]["rows"]);
				$instance["raw"] = serialize($instance["raw"]);
				$defLang = $registry->getValue("config.jflang");
				$instance[$defLang] = unserialize($instance["raw"]);
			}
			if (!isset($instance[$lang])){
				$instance[$lang] = unserialize($instance["raw"]);				
				JoomFish::translateList( $instance[$lang]["rows"], $lang, $instance[$lang]["tableArray"]);
				JFModuleHTML::_setupMenuRoutes($instance[$lang]["rows"]);
			}
			if ($getOriginals){
				return $instance[$lang]["originals"];
			}
			else {
				return $instance[$lang]["rows"];
			}
		}

		function _setupMenuRoutes(&$menus) {
			if($menus) {
				uasort($menus,array("JFModuleHTML","_menusort"));
				foreach($menus as $key => $menu) {
					$menus[$key]->route = $menus[$key]->alias;
				}
				foreach($menus as $key => $menu) {
					$parent_route = '';
					$parent_tree  = array();
					if(($parent = $menus[$key]->parent) && (isset($menus[$parent])) &&
					(is_object($menus[$parent])) && (isset($menus[$parent]->route)) && isset($menus[$parent]->tree)) {
						$parent_route = $menus[$parent]->route.'/';
						$parent_tree  = $menus[$parent]->tree;
					}
					array_push($parent_tree, $menus[$key]->id);
					$menus[$key]->tree   = $parent_tree;
					$route = $parent_route.$menus[$key]->alias;
					$menus[$key]->route  = $route;
					$url = str_replace('index.php?', '', $menus[$key]->link);
					if(strpos($url, '&amp;') !== false) {
						$url = str_replace('&amp;','&',$url);
					}
					parse_str($url, $menus[$key]->query);
				}
			}
		}
	
		function _menusort(&$a, $b){
			if ($a->sublevel==$b->sublevel) return 0;
			return ($a->sublevel>$b->sublevel)?+1:-1;
		}
	}
}