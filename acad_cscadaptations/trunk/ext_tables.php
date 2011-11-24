<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
## WOP:[ts][1]
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Academic CSS Styled Content');
t3lib_extMgm::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:acad_cscadaptations/tsconfig/pageTSConfig.txt>');


/**
 * Reordering the items in CE Sitemap
 */

$TCA['tt_content']['columns']['menu_type']['config']['items'] = array(
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-optgroup-toc', '--div--'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-sections-current-page', '3'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-sections-subpage', '7'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-optgroup-plain', '--div--'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-selected-pages', '0'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-selected-pages-alphabet', '103'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-subpages', '1'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-subpages-alphabet', '102'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-optgroup-abstract', '--div--'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-subpages-description', '4'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-subpages-description-alphabet', '99'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-selected-pages-description', '100'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-selected-pages-description-alphabet', '101'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:menu-optgroup-special', '--div--'),
		array('LLL:EXT:cms/locallang_ttc.php:menu_type.I.4', '2'),
		array('LLL:EXT:cms/locallang_ttc.php:menu_type.I.6', '5'),
		array('LLL:EXT:cms/locallang_ttc.php:menu_type.I.7', '6')
);

/**
 * Bigger select list for Starting point in CE sitemap
 */
$TCA['tt_content']['columns']['pages']['config']['size'] = 7;
/**
 * Scale the height of Starting point in CE sitemap
 */
$TCA['tt_content']['columns']['pages']['config']['autoSizeMax'] = 200;


/**
 * Reordering the icons for image positions
 */

$TCA['tt_content']['columns']['imageorient']['config']['items'] = array (
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-optgroup-above', '--div--'),		
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.0', 0, 'EXT:acad_cscadaptations/res/imgpos-icons/img-above-center.gif'),
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.1', 1, 'EXT:acad_cscadaptations/res/imgpos-icons/img-above-right.gif'),
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.2', 2, 'EXT:acad_cscadaptations/res/imgpos-icons/img-above-left.gif'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-optgroup-left', '--div--'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-left-intext-hx-above', 18, 'EXT:acad_cscadaptations/res/imgpos-icons/img-intext-left-hx-above.gif'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-left-nowrap-hx-above', 20, 'EXT:acad_cscadaptations/res/imgpos-icons/img-cols-left-hx-above.gif'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-left-nowrap-hx-inside', 26, 'EXT:acad_cscadaptations/res/imgpos-icons/img-cols-left-hx-inside.gif'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-optgroup-right', '--div--'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-right-intext-hx-above', 17, 'EXT:acad_cscadaptations/res/imgpos-icons/img-intext-right-hx-above.gif'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-right-nowrap-hx-above', 19, 'EXT:acad_cscadaptations/res/imgpos-icons/img-cols-right-hx-above.gif'),
		array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-right-nowrap-hx-inside', 25, 'EXT:acad_cscadaptations/res/imgpos-icons/img-cols-right-hx-inside.gif'),
	array('LLL:EXT:acad_cscadaptations/locallang_db.xml:imageorient-optgroup-below', '--div--'),	
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.3', 8, 'EXT:acad_cscadaptations/res/imgpos-icons/img-below-center.gif'),
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.4', 9, 'EXT:acad_cscadaptations/res/imgpos-icons/img-below-right.gif'),
		array('LLL:EXT:cms/locallang_ttc.php:imageorient.I.5', 10, 'EXT:acad_cscadaptations/res/imgpos-icons/img-below-left.gif'),
);

/**
 * Image position: Make 'Left, not wrapped, headline above' the default selection   
 */
$TCA['tt_content']['columns']['imageorient']['config']['default'] = 0;

/**
 * All 12 icons in one row
 */
$TCA['tt_content']['columns']['imageorient']['config']['selicon_cols'] = 12;
?>