<?php
/**
 * Joom World Translate to automatically transfer the entire site into other languages
 *
 * @version 2.0
 * @author Dima Kuprijanov (ageent.ua@gmail.com)
 * @copyright (C) 2010 by Dima Kuprijanov (http://www.ageent.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');


class plgButtonAdd_joomworldtranslate extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @param       object $subject The object to observe
     * @param       array  $config  An array that holds the plugin configuration
     * @since 1.5
     */
    function plgAdd_joomworldtranslate(&$subject, $config) 
    {
        parent::__construct($subject, $config);
    }

    /**
     * Add Attachment button
     *
     * @return a button
     */
    function onDisplay($name)
    {   
        // Avoid displaying the button for anything except content articles
        global $option;
        if ( $option != 'com_content' ) {
            return new JObject();
            }
 
        // Get the article ID
        $cid = JRequest::getVar( 'cid', array(0), '', 'array');
        $id = 0;
        if ( count($cid) > 0 ) {
            $id = intval($cid[0]);
            }
        if ( $id == 0) {
            $nid = JRequest::getVar( 'id', null);
            if ( !is_null($nid) ) {
                $id = intval($nid);
                }
            }
        
        // Create the button object
        $button = new JObject();
            
        
        global $mainframe;
        $doc =& JFactory::getDocument();
        if ( $mainframe->isAdmin() ) {
            if ( $id == 0 ) {
                $msg = JText::_('SAVE ARTICLE BEFORE ATTACHING')."  ".JText::_('TRY APPLY BUTTON FIRST');
                $button->set('options', "{handler: 'iframe', size: {x: 400, y: 300}}");
                $link = "index.php?option=com_joomworldtranslate&view=error";
                }
            else {
                $button->set('options', "{handler: 'iframe', size: {x: 800, y: 530}}");
                $link = "index.php?option=com_joomworldtranslate&view=cache&article_id=$id";
                }
            $doc->addStyleSheet( $mainframe->getSiteURL() . 'plugins/editors-xtd/add_joomworldtranslate.css', 'text/css', null, array() );
        }
        else {
            if ( $id == 0 ) {
                $lang = & JFactory::getLanguage();
                $msg = JText::_('SAVE ARTICLE BEFORE ATTACHING');

                $button->set('options', "{handler: 'iframe', size: {x: 400, y: 300}}");
                $link = "index.php?option=com_joomworldtranslate&view=error";
                }
            else {
                $button->set('options', "{handler: 'iframe', size: {x: 800, y: 530}}");
                $link = "index.php?option=com_joomworldtranslate&view=cache&article_id=$id";
                }
                
                $uri = &JURI::getInstance();
                $doc->addStyleSheet( $uri->base().'plugins/editors-xtd/add_joomworldtranslate.css', 'text/css', null, array() );
            }

        $button->set('modal', true);
        $button->set('class', 'modal');
        $button->set('text', JText::_('Clean cache'));
        $button->set('name', 'add_joomworldtranslate');
        $button->set('link', $link);
        $button->set('image', 'add_joomworldtranslate.png');

        return $button;
    }
}
?>
