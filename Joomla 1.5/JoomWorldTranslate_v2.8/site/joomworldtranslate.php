<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');


require_once (JPATH_COMPONENT.DS.'controller.php');

if($controller = JRequest::getVar('controller')) {
    require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

$classname    = 'JoomworldtranslateController'.$controller;
$controller = new $classname();

$controller->execute( JRequest::getVar('task'));

$controller->redirect();

?>
