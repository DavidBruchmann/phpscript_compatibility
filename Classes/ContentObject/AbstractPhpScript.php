<?php

namespace Simonschaufi\PhpscriptCompatibility\ContentObject;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021      David Bruchmann <david.bruchmann@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Contains PHP_SCRIPT_INT class object.
 *
 * @author David Bruchmann <david.bruchmann@gmail.com>
 */
class AbstractPhpScript
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
        $this->cObj = $contentObject;
        if (!empty($conf['file'])) {
            if ($incFile = $this->getIncFile($conf)) {
                $content = $this->render($incFile, $content, $conf);
                $content = $this->stdWrap($content, $conf);
            }
		}
        return $content;
    }

    protected function getIncFile($conf)
    {
        $file = isset($conf['file.'])
            ? $this->cObj->stdWrap($conf['file'], $conf['file.'])
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
        return $incFile ? $incFile : null;
    }

    protected function stdWrap($content, $conf)
    {
        if (isset($conf['stdWrap.'])) {
			$content = $this->cObj->stdWrap($content, $conf['stdWrap.']);
		}
        return $content;
    }
}
