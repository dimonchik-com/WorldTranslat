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

class JoomworldtranslateViewJoomworldtranslate extends JView
{
	function display($tpl = null)
	{   
		JToolBarHelper::title(   JText::_( 'Joom World Translate'), 'earth.png');
		JToolBarHelper::save();
        
        $nudnumber =& $this->get('Getnumbecashfile');
		$this->assignRef('nudnumber', $nudnumber);
        
        $setting =& $this->get('Setting');
        $this->assignRef('setting', $setting);
        
		parent::display($tpl);
	}
}