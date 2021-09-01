<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "phpscript_compatibility".
 *
 * Auto generated | Identifier: 417ef28b12913a3eace08ce29b1f1d35
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'PHP_SCRIPT compatibility',
	'description' => 'Backwards compatibility of PHP_SCRIPT',
	'category' => 'misc',
	'author' => 'Simon Schaufelberger',
	'author_email' => 'simonschaufi+typo3@gmail.com',
	'state' => 'stable',
	'clearCacheOnLoad' => 1,
	'version' => '1.1.0',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '6.2.0-10.4.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'autoload' => 
	array (
		'classmap' => 
		array (
			0 => 'Classes',
		),
		'psr-4' => 
		array (
			'Simonschaufi\\PhpscriptCompatibility\\' => 'Classes',
		),
	),
	'uploadfolder' => false,
	'createDirs' => NULL,
	'clearcacheonload' => true,
	'author_company' => NULL,
	'_md5_values_when_last_written' => 'a:6:{s:8:"Classes/";s:4:"d41d";s:22:"Classes/ContentObject/";s:4:"d41d";s:48:"Classes/ContentObject/PHPScriptContentObject.php";s:4:"5ffc";s:13:"composer.json";s:4:"e406";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"6b85";}',
);

?>