<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

/*************************************************************
** Additional Pagetype Subsite
**************************************************************/
		// Add pagetype to the pagetree (see typo3-core-api)
		// Restrict this doktype to certain tables
	$PAGES_TYPES['77'] = Array(
	  'type' => 'web',
	  'allowedTables' => '*',
	);
	
	t3lib_SpriteManager::addTcaTypeIcon('pages', '77', '../typo3conf/ext/acad_ue_subsites/gfx/i/subsite.gif');

	
	t3lib_div::loadTCA('pages');
		// add item with new pagetype to the doktype-field in the backend
		// todo uschi: nach advanced einfügen (mantis #)
	$TCA['pages']['columns']['doktype']['config']['items'][] = array(
		0 => 'LLL:EXT:'. $_EXTKEY .'/locallang_db.xml:pages.doktype.I.77',
		1 => 77,
		2 => t3lib_extMgm::extRelPath($_EXTKEY).'gfx/i/subsite.gif',
	);
	
	// use the same items as type standard
$TCA['pages']['types']['77']['showitem'] = $TCA['pages']['types']['1']['showitem'];
	
	
	// additional fields in pages: subsites title and uplink
$tempColumns = array (
	'tx_acaduesubsites_title' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:acad_ue_subsites/locallang_db.xml:pages.tx_acaduesubsites_title',		
		'config' => array (
			'type' => 'text',
			'cols' => '30',	
			'rows' => '3',
		)
	),
	'tx_acaduesubsites_uplink' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:acad_ue_subsites/locallang_db.xml:pages.tx_acaduesubsites_uplink',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'wizards' => array(
				'_PADDING' => 2,
				'link' => array(
					'type' => 'popup',
					'title' => 'Link',
					'icon' => 'link_popup.gif',
					'script' => 'browse_links.php?mode=wizard',
					'JSopenParams' => 'height=600,width=800,status=0,menubar=0,scrollbars=1'
				),
			),
		)
	),
);


t3lib_div::loadTCA('pages');
t3lib_extMgm::addTCAcolumns('pages',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('pages','tx_acaduesubsites_title, tx_acaduesubsites_uplink','77','subtitle');
// show field tx_realurl_pathsegment also in doktype 77
t3lib_extMgm::addToAllTCAtypes('pages','tx_realurl_pathsegment','77','after:nav_title');

	// additional field in pages_language_overlay: subsites title, as this is going to be translated 
$tempColumns = Array (
    "tx_acaduesubsites_title" => Array (        
        "exclude" => 1,        
        "label" => "LLL:EXT:acad_ue_subsites/locallang_db.xml:pages_language_overlay.tx_acaduesubsites_title",        
        "config" => Array (
            "type" => "text",
            "cols" => "30",    
            "rows" => "3",
        )
    ),
);
t3lib_div::loadTCA("pages_language_overlay");
t3lib_extMgm::addTCAcolumns("pages_language_overlay",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("pages_language_overlay","tx_acaduesubsites_title;;;;1-1-1",77);
?>