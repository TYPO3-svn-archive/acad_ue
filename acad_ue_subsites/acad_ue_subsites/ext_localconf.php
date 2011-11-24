<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// add both subsite fields to the rootline fields to get it from the rootline-array
$TYPO3_CONF_VARS['FE']['addRootLineFields'] .= ',tx_acaduesubsites_title, tx_acaduesubsites_uplink,doktype,uid';

	// add the title to the pageOvelayFields so it's translation is checked
$TYPO3_CONF_VARS['FE']['pageOverlayFields'] .= ',tx_acaduesubsites_title';
?>