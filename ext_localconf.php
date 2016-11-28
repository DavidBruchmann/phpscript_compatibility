<?php

defined('TYPO3_MODE') or die();

# implement PHP_SCRIPT
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_content.php']['cObjTypeAndClass'][] = [
    'PHP_SCRIPT',
    \Simonschaufi\PhpscriptCompatibility\ContentObject\PHPScriptContentObject::class
];
