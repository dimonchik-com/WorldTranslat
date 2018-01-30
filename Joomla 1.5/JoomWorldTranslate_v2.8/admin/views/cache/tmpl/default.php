<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
    body{font-size: 12px;}
    h1{ text-align: center; color: red;}
</style>
<form method="post" action="<?php echo JURI::root(); ?>administrator/index.php?option=com_joomworldtranslate" id="adminForm" name="adminForm">
    <input type="hidden" value="<?php echo JRequest::getVar('article_id'); ?>" name="article_id">
<fieldset class="adminform" style="margin: 0 0 10px 0;">
    <legend>Add link</legend>
    <div>
        <textarea style="width:100%; height:200px;" name="add_url"><?php echo $this->texturl; ?></textarea>
        <p>You can link to articles that will be updated when you save the article. Cache is cleaned will be for all 52 languages. Please some url separate <b>Enter</b></p>
    </div>
</fieldset>
    <input type="hidden" value="1" name="addnew"> 
    <input type="hidden" value="com_joomworldtranslate" name="option"> 
    <input type="submit" value="Save" class="button" name="Submit">      
</form>
<?php
    global $mainframe; 
    $mainframe->close();
?>