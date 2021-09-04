<?php

defined('TYPO3_MODE') or die();

$extensionKey = 'phpscript_compatibility';

/**
 * Example TypoScript for PHP_SCRIPT, PHP_SCRIPT_EXT or PHP_SCRIPT_INT
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript',
    'PHP Script'
);
