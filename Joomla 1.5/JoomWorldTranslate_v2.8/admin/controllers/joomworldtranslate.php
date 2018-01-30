<?php
/**
 *  Joom World Translate
 * 
 * @license        GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class JoomworldtranslateControllerJoomworldtranslate extends JoomworldtranslateController
{
    function __construct()
    {
        parent::__construct();
    }

    function save()
    {
        $model = $this->getModel('joomworldtranslate');

        if ($model->store()) {
            $msg = JText::_( 'Changes saved successfully' );
        } else {
            $msg = JText::_( 'Error Saving Greeting' );
        }

        $link = 'index.php?option=com_joomworldtranslate';
        $this->setRedirect($link, $msg);
    }

}