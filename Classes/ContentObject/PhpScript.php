<?php

namespace Simonschaufi\PhpscriptCompatibility\ContentObject;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 Xavier Perseguers <typo3@perseguers.ch>
 *  (c) 2010-2011 Steffen Kamper <steffen@typo3.org>
 *  (c) 2016      Simon Schaufelberger <simonschaufi+typo3@gmail.com>
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
 * Contains PHP_SCRIPT class object.
 */
class PhpScript extends AbstractPhpScript()
{

    protected function render(string $incFile, string $content, array $conf, ContentObjectRenderer $contentObject)
    {
        $content = '';
        // Added 31-12-00: Make backup...
        $contentObject->oldData = $contentObject->data;
        $RESTORE_OLD_DATA = FALSE;
        // Include file
        // - must provide any results in the variable `$content`
        // - can optionally set $RESTORE_OLD_DATA to `true` for $contentObject->data
        include ('./' . $incFile);
        // Added 31-12-00: restore...
        if ($RESTORE_OLD_DATA) {
            $contentObject->data = $contentObject->oldData;
        }
        return $content;
    }
}
