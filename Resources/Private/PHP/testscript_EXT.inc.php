<?php

if (!is_object($this)) die ('Error: No parent object present.');

/**
 * Printing current time dynamically
 *
 * @param	string		Content (ignore)
 * @param	array		TypoScript configuration passed
 * @return	string		Current time wrapped in <font> tags with red color
 */
if (!function_exists('user_printTimeExt')) {

    function user_printTimeExt($content, $conf)	{
        return '<span style="color:red;">Dynamic time: '. date('H:i:s') .'</span>.';
    }

}

ob_start();

?>

<h2>This is output from an external script!</h2>

<p>In contrast to early TYPO3 versions it's not advised anymore to display the script-result directly, but to collect it in the variable <strong>$content</strong>.</p>
<p>Technically it's done in this script by usage of the PHP-functions ob_start(), ob_get_contents() and ob_end_clean(), but it can be achieved in many ways and it's just a simple solution.</p>

<br />

<p>You can get the content of the record, that included this script in <strong>$cOBJ->data</strong>.</p>
<p><strong>IMPORTANT:</strong> If this script was included by TypoScript only, then the data of the page are displayed. You can get the current table name with <strong>$cOBJ->getCurrentTable()</strong></p>
<br />


<?php
    debug(['$cOBJ->data' => $cOBJ->data], __FILE__ . ':' . __LINE__);
?>

<br />
<br />
The configuration for the script is in the array, $CONF:<br />
<br />

<?php
debug(['$CONF' => $CONF], __FILE__ . ':' . __LINE__);

?>

<br />
<br />
These are global variables!

<br />
<br />
Good luck....
<br />
<br />



<?php if ($CONF['showTime']) {
    echo 'BTW: The time: <br>' . user_printTimeExt('','') . '<br>';
    echo '<em style="font-size:smaller;">Ok, you\'d expect it to count up, so that it\'s always correct, but it\'s transferred by the server only when you populate this page.<br>
        You\'re free though to include some JavaScript to polpulate the time if you like.</em>';
} ?>
<br />
<br />

<?php

$content = ob_get_contents();
ob_end_clean();


?>