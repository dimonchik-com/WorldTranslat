<?php defined('_JEXEC') or die('Restricted access'); ?>
<style>
body{font-size: 12px;}
h1{ text-align: center; color: red;}
</style>
<div class="warning"><h1>Warning</h1><h2 id="warning_msg">You must save the article at least once before files can be add link to it! Use the [Apply button to save the article then try again.</h2></div>
<?php
    global $mainframe; 
    $mainframe->close();
?>