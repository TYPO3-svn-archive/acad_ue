<?php

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// making the header field required in content elements
t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['columns']['header']['config']['eval'] = 'required';
?>