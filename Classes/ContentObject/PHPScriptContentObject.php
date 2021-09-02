<?php

namespace Simonschaufi\PhpscriptCompatibility\ContentObject;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Contains PHP_SCRIPT class object.
 */
class PHPScriptContentObject
{

    /**
     * Rendering the cObject, PHP_SCRIPT
     *
     * @param string $typoScriptObjectName (PHP_SCRIPT)
     * @param array $conf
     * @param string $typoScriptKey (ie. 10)
     * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject
     * @return string Output
     */
    public function cObjGetSingleExt($typoScriptObjectName, array $conf, $typoScriptKey, ContentObjectRenderer $contentObject)
    {
        $content = '';
        if (!empty($conf['file'])) {
            $content = $this->processIncludeFile($typoScriptObjectName, $conf, $typoScriptKey, $contentObject);
        }
        return $content;
    }

    protected function processIncludeFile($typoScriptObjectName, array $conf, $typoScriptKey, ContentObjectRenderer $contentObject)
    {
        $content = '';
        $file = isset($conf['file.'])
            ? $contentObject->stdWrap($conf['file'], $conf['file.'])
            : $conf['file'];

        // Note that allowed paths can be configured with
        //   $GLOBALS['TYPO3_CONF_VARS']['FE']['addAllowedPaths']
        if (version_compare(TYPO3_version, '9.4', '<')) {
            $incFile = $GLOBALS['TSFE']->tmpl->getFileName($file);
        } else {
            // v9.4 Deprecation: #85445 - TemplateService->getFileName
            $filePathSanitizer = GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Resource\FilePathSanitizer');
            $incFile = $filePathSanitizer->sanitize($file);
        }

        if ($incFile && $GLOBALS['TSFE']->checkFileInclude($incFile)) {
            // Added 31-12-00: Make backup...
            $contentObject->oldData = $contentObject->data;
            $RESTORE_OLD_DATA = FALSE;
            // Include file
            // - must provide any results in the variable `$content`
            // - can optionally set $RESTORE_OLD_DATA to `true`
            include ('./' . $incFile);
            // Added 31-12-00: restore...
            if ($RESTORE_OLD_DATA) {
                $contentObject->data = $contentObject->oldData;
            }
        }

        if (isset($conf['stdWrap.'])) {
            $content = $contentObject->stdWrap($content, $conf['stdWrap.']);
        }
        return $content;
    }
}
