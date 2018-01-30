<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 1.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class JoomworldtranslateModelCache extends JModel
{
    function __construct()
    {
        parent::__construct();
    }

    function &getCacherurl() {
        $db =& JFactory::getDBO();
        $article_id = JRequest::getVar('article_id');
        $db->setQuery("SELECT addurl FROM #__global_cache WHERE articleid=$article_id");
        $db->query();
        $get_result=$db->loadResult();
        $get_result=preg_replace("/;lol;/is","\n",$get_result);
        $get_result=trim($get_result);
        return $get_result;
    }
}