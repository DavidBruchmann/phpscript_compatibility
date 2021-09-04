<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2009 Kasper Skårhøj (kasperYYYY@typo3.com)
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
 * postit.inc
 *
 * Creates graphical postit notes with text on them.
 *
 * Revised for TYPO3 3.6 June/2003 by Kasper Skårhøj
 * XHTML compliant
 *
 * @author    Kasper Skårhøj <kasperYYYY@typo3.com>
 */



if (!is_object($this)) die ('Error: No parent object present.');


/**
 * The following block of functions is copied from the old TYPO3 version 4.7.20,
 * so that the old example can be used despite the methods have been removed from TYPO3.
 * In TYPO3 versions < 9.0 the original methods are used.
 */
if (!version_compare(TYPO3_version, '9.0', '<')) {
    if (!function_exists('clearTSProperties')) {
        /**
         * Clears TypoScript properties listed in $propList from the input TypoScript array.
         *
         * @param	array		TypoScript array of values/properties
         * @param	string		List of properties to clear both value/properties for. Eg. "myprop,another_property"
         * @return	array		The TypoScript array
         * @see gifBuilderTextBox()
         */
        function clearTSProperties($TSArr, $propList) {
            $list = explode(',', $propList);
            foreach ($list as $prop) {
                $prop = trim($prop);
                unset($TSArr[$prop]);
                unset($TSArr[$prop . '.']);
            }
            return $TSArr;
        }
    }

    if (!function_exists('linebreaks')) {
        /**
         * Splits a text string into lines and returns an array with these lines but a max number of lines.
         *
         * @param	string		The string to break
         * @param	integer		Max number of characters per line.
         * @param	integer		Max number of lines in all.
         * @return	array		array with lines.
         * @access private
         * @see gifBuilderTextBox()
         */
        function linebreaks($string, $chars, $maxLines = 0) {
            $lines = explode(LF, $string);
            $lineArr = array();
            $c = 0;
            foreach ($lines as $paragraph) {
                $words = explode(' ', $paragraph);
                foreach ($words as $word) {
                    if (strlen($lineArr[$c] . $word) > $chars) {
                        $c++;
                    }
                    if (!$maxLines || $c < $maxLines) {
                        $lineArr[$c] .= $word . ' ';
                    }
                }
                $c++;
            }
            return $lineArr;
        }
    }


    if (!function_exists('gifBuilderTextBox')) {
        /**
         * This function creates a number of TEXT-objects in a Gifbuilder configuration in order to create a text-field like thing. Used with the script tslib/media/scripts/postit.inc
         *
         * @param	array		TypoScript properties for Gifbuilder - TEXT GIFBUILDER objects are added to this array and returned.
         * @param	array		TypoScript properties for this function
         * @param	string		The text string to write onto the GIFBUILDER file
         * @return	array		The modified $gifbuilderConf array
         * @see media/scripts/postit.inc
         */
        function gifBuilderTextBox($gifbuilderConf, $conf, $text) {
            $chars = intval($conf['chars']) ? intval($conf['chars']) : 20;
            $lineDist = intval($conf['lineDist']) ? intval($conf['lineDist']) : 20;
            $Valign = strtolower(trim($conf['Valign']));
            $tmplObjNumber = intval($conf['tmplObjNumber']);
            $maxLines = intval($conf['maxLines']);

            if ($tmplObjNumber && $gifbuilderConf[$tmplObjNumber] == 'TEXT') {
                $textArr = linebreaks($text, $chars, $maxLines);
                $angle = intval($gifbuilderConf[$tmplObjNumber . '.']['angle']);
                foreach ($textArr as $c => $textChunk) {
                    $index = $tmplObjNumber + 1 + ($c * 2);
                        // Workarea
                    $gifbuilderConf = clearTSProperties($gifbuilderConf, $index);
                    $rad_angle = 2 * pi() / 360 * $angle;
                    $x_d = sin($rad_angle) * $lineDist;
                    $y_d = cos($rad_angle) * $lineDist;

                    $diff_x_d = 0;
                    $diff_y_d = 0;
                    if ($Valign == 'center') {
                        $diff_x_d = $x_d * count($textArr);
                        $diff_x_d = $diff_x_d / 2;
                        $diff_y_d = $y_d * count($textArr);
                        $diff_y_d = $diff_y_d / 2;
                    }


                    $x_d = round($x_d * $c - $diff_x_d);
                    $y_d = round($y_d * $c - $diff_y_d);

                    $gifbuilderConf[$index] = 'WORKAREA';
                    $gifbuilderConf[$index . '.']['set'] = $x_d . ',' . $y_d;
                        // Text
                    $index++;
                    $gifbuilderConf = clearTSProperties($gifbuilderConf, $index);
                    $gifbuilderConf[$index] = 'TEXT';
                    $gifbuilderConf[$index . '.'] = clearTSProperties($gifbuilderConf[$tmplObjNumber . '.'], 'text');
                    $gifbuilderConf[$index . '.']['text'] = $textChunk;
                }
                $gifbuilderConf = clearTSProperties($gifbuilderConf, $tmplObjNumber);
            }
            return $gifbuilderConf;
        }
    }
}

/***************************************************************
TypoScript config:



.data              [string / stdWrap]     The data for the notes. Every line is a new note.
                                            Each line is divided by "|" where
                                            - the first part is the test
                                            - the second part is the type (1-)
                                            - the third part is the optional link (typolink-format)
.charsPerLine      [string]               The max number of chars per line of text on the note.
.images.[x]        [image-contentObjects] [x] is the type-number defined by the second parameter in each line of data.
.textBox {
    chars          [integer]              the number of chars on each line
    lineDist       [integer]              integer, the number of pixels between each line
    tmplObjNumber  [integer]              integer, pointer to the GIFBUILDER-OBJECT (of type TEXT!!) which
                                            serves as a TEMPLATE for the objects used to create the textlines
    Valign         [string]               string. If set to "center", the tmplObjNumber-TEXT-object is expected to be centeret
                                            in the image and calculations will be done to spred the lines above and below in case
                                            of multiple lines. (based on .angle of the TEXT object also.)
    maxLines       [integer]
  }


Example:


// Postit:
tt_content.php_script.20.post_it = PHP_SCRIPT
tt_content.splash.20 {
  file = media/scripts/postit.inc
  data.field = bodytext
  cols = 3
  textBox {
    chars = 16
    lineDist = 18
    tmplObjNumber = 100
    Valign = center
    maxLines = 5
  }
  typolink {
    parameter.current = 1
    extTarget = {$styles.content.links.extTarget}
    target = {$styles.content.links.target}
  }
  images.1 = IMAGE
  images.1.file = GIFBUILDER
  images.1.file {
    XY = [5.w],[5.h]
    5 = IMAGE
    5.file = media/uploads/postit_1.gif
    100 = TEXT
    100.text = Testing
    # 100.text.field = bodytext
    100.offset = -5,60
    100.fontFile = fileadmin/fonts/arial_bold.ttf
    100.fontSize = 15
    100.align=center
  }
  images.2 < .images.1
  images.2.file.5.file = media/uploads/postit_2.gif
  images.2.file.100.angle = 11
  images.2.file.100.offset = -2,79
  images.3 < .images.1
  images.3.file.5.file = media/uploads/postit_3.gif
  images.3.file.100.angle = -13
  images.3.file.100.offset = -7,81
}

****************************************************************/


# debug(['currentTable' => $cOBJ->getCurrentTable(), '$cOBJ->data' => $cOBJ->data, '$CONF' => $CONF], __FILE__ . __LINE__);

if ($cOBJ->getCurrentTable() == 'tt_content') {
    $data = $cOBJ->cObjGetSingle($CONF['data'], $CONF['data.']);
}
$cols = intval($CONF['cols']) ? intval($CONF['cols']) : 3;

if (empty($data)) {
    $data =
        'Text Line 1|1|https://typo3.org' . "\n" .
        'Text Line 2|2|https://typo3.com' . "\n" .
        'Text Line 3|3|https://typo3.org' . "\n" .
        'Text Line 4|1|https://typo3.com' . "\n" .
        'Text Line 5|2|https://typo3.org' . "\n" .
        'Text Line 6|3|https://typo3.com' . "\n";
}

$lines = explode(chr(10), $data);

# debug(['$data' => $data, 'lines' => $lines], __FILE__ . __LINE__);

$imageArr = array();
foreach ($lines as $key => $content) {
    $content = trim($content);
    if ($content)    {
        $parts = explode('|', $content);
        $text = trim($parts[0]);
        $type = \TYPO3\CMS\Core\Utility\MathUtility::forceIntegerInRange($parts[1], 1, 3);
        $link = trim($parts[2]);
        if ($text)    {
            $imgConf = $CONF['images.'][$type . '.'];
            if (version_compare(TYPO3_version, '9.0', '<')) {
                $imgConf['file.'] = $cOBJ->gifBuilderTextBox ($imgConf['file.'], $CONF['textBox.'], $text);
            } else {
                $imgConf['file.'] = gifBuilderTextBox ($imgConf['file.'], $CONF['textBox.'], $text);
            }

            $imageCobj = $cOBJ->getContentObject('IMAGE');
            $image = $imageCobj->render($imgConf);
            if ($image)    {
                $cOBJ->setCurrentVal($link);
                $imageArr[] = $cOBJ->typolink($image, $CONF['typolink.']);
            }
        }
    }
}


if (is_array($imageArr))    {
    reset($imageArr);
    if ($cols)    {
        $res = '';
        $rows = ceil(count($imageArr) / $cols);

        for ($a = 0; $a < $rows; $a++)    {
            $res .= '<tr>';
            for ($b = 0; $b<$cols; $b++)    {
                $res .= '<td>' . $imageArr[(($a * $cols) + $b)].'</td>';
            }
            $res .= '</tr>';
        }

        $content = '<table border="0" cellspacing="0" cellpadding="0">' . $res . '</table>';
    } else {
        $content .= implode($imageArr, '');
    }
}

?>