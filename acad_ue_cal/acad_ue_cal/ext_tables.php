<?php
if (!defined ('TYPO3_MODE'))	die ('Access denied.');
unset($TCA['tx_cal_event']['columns']['category_id']['config']['wizards']);
unset($TCA['tx_cal_event']['columns']['location_id']['config']['wizards']);
unset($TCA['tx_cal_event']['columns']['organizer_id']['config']['wizards']);

$tempColumns = Array (
	'title2' => Array (		
		'exclude' => 1,
		'label' => 'LLL:EXT:acad_ue_cal/locallang_db.php:title2',
		'config' => Array (
			'type' => 'input',	
			'size' => '30',
			'max' => '128',
		)
	)
);

t3lib_div::loadTCA('tx_cal_event');
t3lib_extMgm::addTCAcolumns('tx_cal_event',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('tx_cal_event','title2', '', 'after:title');

$TCA['pages']['columns']['module']['config']['items'][] = array('Calendar Single View', 'cal-one', '../typo3conf/ext/acad_ue_cal/static/icons/cal-one.png');
$ICON_TYPES['cal-one']['icon'] = '../typo3conf/ext/acad_ue_cal/static/icons/cal-one.png';


// add static TS templates
t3lib_extMgm::addStaticFile($_EXTKEY,'static/ts/','acad ue configuration for cal');
?>