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
global $mainframe;
    
$db =& JFactory::getDBO();
if (!is_a($db,"JFDatabase")){
	echo JText::_("Joomfish System Plugin not enabled");
	return;
}

$db->_profile("langmod",true);

// Include the helper functions only once
JLoader::import('helper', dirname( __FILE__ ), 'jfmodule');
JLoader::register('JoomFishVersion', JOOMFISH_ADMINPATH .DS. 'version.php' );

$type = trim( $params->get( 'type', 'fallindown' ));

$layout = JModuleHelper::getLayoutPath('mod_joomworldtranslate',$type);

$type=trim( $params->get( 'type', 'fallindown' ));
$show_active=intval( $params->get( 'show_active', 1 ) );

$fallindowntwo=$params->get( 'fallindow_two', "click" );
$effect=$params->get( 'effect', "slideDown" );

$translator=$params->get( 'translator','Translator');

jimport('joomla.filesystem.file');

$jfManager = JoomFishManager::getInstance();
$langActive = $jfManager->getActiveLanguages(true);

// setup Joomfish plugins
$dispatcher	   =& JDispatcher::getInstance();
JPluginHelper::importPlugin('joomfish');
$dispatcher->trigger('onAfterModuleActiveLanguages', array (&$langActive));

$outString = '';
if( !isset( $langActive ) || count($langActive)==0) {
	// No active languages => nothing to show :-(
	return;
}

// check for unauthorised access to inactive language
$curLanguage = JFactory::getLanguage();
if (!array_key_exists($curLanguage->getTag(),$langActive)){
	reset($langActive);
	$registry =& JFactory::getConfig();
	$deflang = $registry->getValue("config.defaultlang");
	$mainframe->redirect(JRoute::_("index.php?lang=".$deflang));
	JError::raiseError('0', JText::_('NOT AUTHORISED').' '.$curLanguage->getTag());
	exit();
}

$db->_profile("langmod");
$db->_profile("langlayout",true);

$header="";
require($layout);
$header.='<link rel="stylesheet" href="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/mod_joomworldtranslate.css" type="text/css" />'."\n";
if($params->get( 'include_jquery', 1)) {
        $header.="  <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js'></script>\n";   
}
if($type=="fallindown") {
switch ($fallindowntwo) {
    case "click":
        switch ($effect) {
            case "slideDown":
                $header.='  <script type="text/javascript" src="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/js/click_slidedown.js"></script>'."\n";
            break;
            case "fadeIn":
                $header.='  <script type="text/javascript" src="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/js/click_fedein.js"></script>'."\n";
            break;
        }
    break;
    case "move_mouse":
        switch ($effect) {
            case "slideDown":
                $header.='  <script type="text/javascript" src="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/js/mouse_slidedown.js"></script>'."\n";
            break;
            case "fadeIn":
                $header.='  <script type="text/javascript" src="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/js/mouse_fedein.js"></script>'."\n";
            break;
        }
    break;
}
} elseif($type=="blackbar") {
        $header.='  <script type="text/javascript" src="'.JURI::base().'modules/mod_joomworldtranslate/tmpl/js/blackbar.js"></script>'."\n";
}

$mainframe->addCustomHeadTag($header);

$db->_profile("langlayout");
$version = new JoomFishVersion();
?>