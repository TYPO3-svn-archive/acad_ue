<?php

t3lib_SpriteManager::addTcaTypeIcon('pages', '101', '../typo3conf/ext/service_spacer/ext_icon.gif');
	
array_splice(
	$TCA['pages']['columns']['doktype']['config']['items'],
	11,
	0,
	array(
		array('LLL:EXT:service_spacer/locallang.xml:pages.doktype.I.101', '101', t3lib_extMgm::extRelPath('service_spacer').'ext_icon.gif')
	)
);  
?>
