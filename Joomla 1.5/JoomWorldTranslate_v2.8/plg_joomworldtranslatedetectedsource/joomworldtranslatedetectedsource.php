<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 2.8
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
 
(defined('_VALID_MOS') OR defined('_JEXEC')) or die('Restricted access');

// define directory separator short constant
if (!defined( 'DS' )) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

jimport('joomla.event.plugin');


class plgButtonJoomworldtranslatedetectedsource extends JPlugin
	{
		function plgButtonJoomworldtranslatedetectedsource(& $subject, $config)
		{
			parent::__construct($subject, $config);
		}

		function onDisplay($name)
		{
			$getContent = $this->_subject->getContent($name);
			$js = "
				function insertDetectedSourceLangOn(editor) {
					var content = $getContent
					if (content.match(/{detectedsourcelang on}/)) {
						return false;
					} else {
						jInsertEditorText('{detectedsourcelang on}', editor);
					}
				}
				";

			$doc =& JFactory::getDocument();
			$doc->addScriptDeclaration($js);
			
			$button = new JObject();
			$button->set('modal', false);
			$button->set('onclick', 'insertDetectedSourceLangOn(\''.$name.'\');return false;');
			$button->set('text', 'Detectedsourcelang ON');
			$button->set('name', 'blank');
			$button->set('link', '#');
	
			return $button;
		}
}
?>