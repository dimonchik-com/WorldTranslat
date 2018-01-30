<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class JoomworldtranslateViewCache extends JView
{
	function display($tpl = null)
	{   
        $texturl =& $this->get('Cacherurl');
		$this->assignRef('texturl', $texturl);
        
		parent::display($tpl);
	}
}