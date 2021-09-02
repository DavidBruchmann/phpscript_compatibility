<?php

defined('TYPO3_MODE') or die();

$extensionKey = 'phpscript_compatibility';

/**
 * Example TypoScript for PHP_SCRIPT, PHP_SCRIPT_EXT or PHP_SCRIPT_INT
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript/Test',
    'PHP Script: Test'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript/TestInt',
    'PHP Script [INT]: Test'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript/TestExt',
    'PHP Script [EXT]: Test'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript/PostIt',
    'PHP Script: PostIt'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $extensionKey,
    'Configuration/TypoScript/FreesiteDummyMenu',
    'PHP Script: FreesiteDummyMenu'
);
