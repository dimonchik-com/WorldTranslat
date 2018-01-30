CREATE TABLE IF NOT EXISTS `#__global_cache` (
  `articleid` int(11) default NULL,
  `addurl` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__languages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  `iso` varchar(20) default NULL,
  `code` varchar(20) NOT NULL default '',
  `shortcode` varchar(20) default NULL,
  `image` varchar(100) default NULL,
  `fallback_code` varchar(20) NOT NULL default '',
  `params` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `#__configjoomwtranslate` (
  `enable` text NOT NULL,
  `notranslate` text NOT NULL,
  `apikey` text NOT NULL,
  `suffix` text NOT NULL,
  `usingip` text NOT NULL,
  `ajax_requests` text NOT NULL,
  `detect_language` text NOT NULL,
  `worldsjs` text NOT NULL,
  `notworldstrans` text NOT NULL,
  `exactranslate` text NOT NULL,
  `savewords` text NOT NULL,
  `urlnotprocessed` text NOT NULL,
  `source_detect_language` text NOT NULL,
  `JoomworldtranslatJoomlaVersion` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `#__langjoomwtranslate` (
  `lang` varchar(20) NOT NULL,
  `source_language` text NOT NULL,
  `translated_language` text NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
