<?php

defined('TYPO3_MODE') || die();

call_user_func(function()
{
    $layoutLabel = 'Rubbel die Katz, wer hat\'s';
    
    $GLOBALS['TCA']['tt_content']['types']['php_script']['columnsOverrides'] = [
        'list_type' => [
            #'label' => $layoutLabel,
            #'exclude' => 1,
            'config' => [
                'type' => 'input',
                'renderType' => '',
                'size' => 30,
                'default' => '',
                'eval' => 'trim',
            ],
        ],
    ];

    $GLOBALS['TCA']['tt_content']['types']['php_script']['showitem'] = //'CType, select_key';
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, ' .
            '--palette--;;general, ' .
            'header;Name (not visible in frontend), ' . // 'header;LLL:EXT:cms/locallang_ttc.xml:header.ALT.script_formlabel, ' .
        '--div--;Script, ' . //LLL:EXT:cms/locallang_ttc.xml:tabs.script, ' .
            'list_type;PHP Script, ' . //LLL:EXT:cms/locallang_ttc.xml:select_key.ALT.script_formlabel, ' .
#            'pages;Starting Point for This Script, ' . // 'pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel, ' .
            'bodytext;Parameters to pass to the script;;nowrap, ' . //LLL:EXT:cms/locallang_ttc.xml:bodytext.ALT.script_formlabel;;nowrap, ' .
            'rowDescription;Comments, ' .
            //'recursive,' .
        '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance, ' .
            '--palette--;;frames, ' .
            '--palette--;;appearanceLinks, '.
#            'imagecaption;LLL:EXT:cms/locallang_ttc.xml:imagecaption.ALT.script_formlabel, ' .
#        '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance, ' .
#          '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames, ' .
        '--div--;Access, ' .  //LLL:EXT:cms/locallang_ttc.xml:tabs.access, ' .
          '--palette--;Visibility;hidden, ' . // LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility, ' .
          '--palette--;Publish Dates and Access Rights;access, ' . //LLL:EXT:cms/locallang_ttc.xml:palette.access;access, ' .
#        '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';
    '';

    // Adds the content element `script` to the "Type" dropdown
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
       'tt_content',
       'CType',
        [
            'PHP Script', //'LLL:EXT:your_extension_key/Resources/Private/Language/Tca.xlf:yourextensionkey_newcontentelement',
            'php_script', // field-value
            'mimetypes-text-php', // icon identifier
        ],
        'html',
        'after'
    );
});
