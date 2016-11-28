<?php
namespace Simonschaufi\PhpscriptCompatibility\ContentObject;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Contains PHP_SCRIPT class object.
 */
class PHPScriptContentObject {

	/**
	 * Rendering the cObject, PHP_SCRIPT
	 *
	 * @param string $typoScriptObjectName (PHP_SCRIPT)
	 * @param array $conf
	 * @param string $typoScriptKey (ie. 10)
	 * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $contentObject
	 * @return string Output
	 */
	public function cObjGetSingleExt($typoScriptObjectName, array $conf, $typoScriptKey, ContentObjectRenderer $contentObject) {
		$file = isset($conf['file.'])
			? $contentObject->stdWrap($conf['file'], $conf['file.'])
			: $conf['file'];

		$incFile = $GLOBALS['TSFE']->tmpl->getFileName($file);
		$content = '';
		if ($incFile && $GLOBALS['TSFE']->checkFileInclude($incFile)) {
			// Added 31-12-00: Make backup...
			$contentObject->oldData = $contentObject->data;
			$RESTORE_OLD_DATA = FALSE;
			// Include file..
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
