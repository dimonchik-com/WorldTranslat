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

/**
* Module that cleans cache
*/

global $mainframe;
$onlyou = JUtility::getHash(JURI::root());
// if current page is not an administrator page, return nothing
if ( !$mainframe->isAdmin() ) { return; }

$_document	=& JFactory::getDocument();

$_document->addStyleSheet( JURI::root( true ).'/administrator/modules/mod_worldcachecleaner/css/world.css' );

$uri = &JURI::getInstance();
$real_option=$uri->getVar("option","");
$real_task=$uri->getVar("task","");

        $component = JComponentHelper::getComponent('com_joomworldtranslate');
        $paramsnew = new JParameter( $component->params );
        $paramsnew=explode("\n",$paramsnew->_raw);
        $get_bigsetting=array();
        foreach($paramsnew as $val) {
            $value_1=preg_replace("/(.*?)=(.*)/i","$1",$val);
            $value_2=preg_replace("/(.*?)=(.*)/i","$2",$val);
            $get_bigsetting[$value_1]=trim($value_2);
        }

$gwtvalone=isset($get_bigsetting["clearingandupdate"])?1:"";
$gwtvaltwo=isset($get_bigsetting["clearcache"])?1:"";
if($real_option=="com_content" && $real_task=="edit" && $gwtvalone==1) {
    $reloadallpage="
        window.addEvent('domready',function() {
            $('toolbar-save').set({'events': {
            'click': function(){ 
            open('".JURI::root()."index.php?option=com_joomworldtranslate&view=joomworldtranslate&joom_world_translate=".$onlyou."&only_one_clear_cache=1', 'location,width=400,height=300,top=0')        }}});
            $('toolbar-apply').set({'events': {
            'click': function(){ 
            open('".JURI::root()."index.php?option=com_joomworldtranslate&view=joomworldtranslate&joom_world_translate=".$onlyou."&only_one_clear_cache=1', 'location,width=400,height=300,top=0')        }}});
        });
    ";
} elseif($real_option=="com_content" && $real_task=="edit" && $gwtvaltwo==1) {
    $reloadallpage="
            window.addEvent('domready',function() {
            pleiseadd=document.getElementsByName('adminForm');
            pleiseadd[0].innerHTML +=\"<input type='hidden' value='1' name='isayreplace'>\";
            });
    ";
} else {
    $reloadallpage="";
}

$_script = "
	window.addEvent( 'domready', function() {
		new Element( 'span', {
			'id': 'cachecleaner_msg',
		    'styles': { 'opacity': 0 }
		} )
		.injectInside( document.body )
		.addEvent( 'click', function(){ cachecleaner_show_end() } );
		cachecleaner_fx = new Fx.Styles( $( 'cachecleaner_msg' ), {wait: false} );
		cachecleaner_delay = false;
	} );
	var world_cachecleaner_load = function( id, editorname )
	{
        if (confirm('Are you sure you want to delete the entire cache on the site?')) {
		    cachecleaner_show_start();
		    var myXHR = new XHR( {
				    method: 'post',
				    onSuccess: function( data ) {
					    $( 'cachecleaner_msg' ).addClass( 'success' );
					    $( 'cachecleaner_msg' ).setText( '".JText::_( 'Cache cleaned' )."' );
					    cachecleaner_show_end( 2000 );
                        get_cash_count = document.getElementById('world_translate_cash_one');
                        if(get_cash_count.length!=0) {
                            get_cash_count.innerHTML='0';
                        }
				    },
				    onFailure: function() {
					    $( 'cachecleaner_msg' ).addClass( 'failure' );
					    $( 'cachecleaner_msg' ).setText( '".JText::_( 'Cache could not be cleaned' )."' );
					    cachecleaner_show_end( 2000 );
				    }
			    } );
		    myXHR.send( '".JURI::root()."/administrator/index.php?cleanworldcache=1' );
        }
	}
    
    var world_mysql_load = function( id, editorname )
    {
        if (confirm('Are you sure you want to delete the intermediate cache?')) {
            cachecleaner_show_start();
            var myXHR = new XHR( {
                    method: 'post',
                    onSuccess: function( data ) {
                        $( 'cachecleaner_msg' ).addClass( 'success' );
                        $( 'cachecleaner_msg' ).setText( '".JText::_( 'Cache cleaned' )."' );
                        cachecleaner_show_end( 2000 );
                    },
                    onFailure: function() {
                        $( 'cachecleaner_msg' ).addClass( 'failure' );
                        $( 'cachecleaner_msg' ).setText( '".JText::_( 'Cache could not be cleaned' )."' );
                        cachecleaner_show_end( 2000 );
                    }
                } );
            myXHR.send( '".JURI::root()."/administrator/index.php?cleanworldcachemysql=1' );
        }
    }
    
	var cachecleaner_show_start = function(one) {
        starttext='';
        if(one==1) {
            starttext='Start cleaning link';
        } else {
            starttext='Cleaning cache';
        }
		$( 'cachecleaner_msg' )
		.setHTML( '<img src=\"".JURI::root()."/administrator/modules/mod_worldcachecleaner/images/loading.gif\" alt=\"\" />'+starttext )
		.removeClass( 'success' ).removeClass( 'failure' )
		.addClass( 'visible' );
		
		\$clear( cachecleaner_delay );
		cachecleaner_fx.stop();
		cachecleaner_fx.start({
			'opacity': 0.8,
			duration: 400
		});
	};
	var cachecleaner_show_end = function( delay, two ) {
		if ( delay ) {
			cachecleaner_delay = ( function(){ cachecleaner_show_end(); } ).delay( delay );
		} else {
			\$clear( cachecleaner_delay );
			cachecleaner_fx.stop();
			cachecleaner_fx.start({
				'opacity': 0,
				duration: 1600
			});
		}
	};
    
    var clear_all_links = function( id, editorname )
    {
        cachecleaner_show_start(1);
        var myXHR = new XHR( {
                method: 'post',
                data: { 'do' : '1' },
                onSuccess: function( data ) {
                    get_cash_count_one = document.getElementById('hidejoom');
                    get_cash_count_one.innerHTML='<p><pre>'+data+'</pre></p>';
                    $( 'cachecleaner_msg' ).addClass( 'success' );
                    $( 'cachecleaner_msg' ).setText( '".JText::_( 'Files have been deleted' )."' );
                    cachecleaner_show_end( 2000, 1 );
                },
                onFailure: function() {
                    $( 'cachecleaner_msg' ).addClass( 'failure' );
                    $( 'cachecleaner_msg' ).setText( '".JText::_( 'Files have not be been deleted' )."' );
                    cachecleaner_show_end( 2000, 1 );
                }
            } );
        valuetext=document.getElementById('gettextval');
        valuetext=valuetext.value;
        valuetext=encodeURIComponent(valuetext);
        myXHR.send( '".JURI::root()."/administrator/index.php?option=com_joomworldtranslate&clear_all_links=1&link='+valuetext);
    }
    {$reloadallpage}
";
$_document->addScriptDeclaration( $_script );

$_class = 'joom_world_translate';
if ( !$params->get( 'show_icon', 1 ) ) {
	$_class = 'cachecleaner_no-icon-pro';
}

echo '<span id="cachecleaner_pro" class="'.$_class.'"><a href="#" onclick="world_cachecleaner_load();return false;">Clean cache</a></span>';