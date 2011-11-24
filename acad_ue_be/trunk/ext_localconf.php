<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// include default pageTSConfig
t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' .$_EXTKEY .'/tsconfig/pageTSConfig.txt">');

	// include default userTSConfig
t3lib_extMgm::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' .$_EXTKEY .'/tsconfig/userTSConfig.txt">');

	// Replacements and additions to tt_content labels
$TYPO3_CONF_VARS['SYS']['locallangXMLOverride']['EXT:cms/locallang_ttc.xml']['ttContentCore'] = 'EXT:'.$_EXTKEY.'/locallang_ttc.xml';

	// add tceforms-hook
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['getSingleFieldClass'][] = 'EXT:acad_ue_be/hooks/class.tx_acaduebe_tceforms_preprocsf.php:tx_acaduebe_tceforms_preprocsf';

	//you need to allow explicitly the available content elements for users
$TYPO3_CONF_VARS['BE']['explicitADmode'] = 'explicitAllow';


?>
