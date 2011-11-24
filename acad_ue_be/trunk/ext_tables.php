<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_div::loadTCA('fe_users');

// doing it better than sr_feuser_register (replace title with more fields like first_name, last_name etc.)
$tx_acadsubsites_feusersArr = t3lib_div::trimExplode(',',$TCA['fe_users']['palettes']['2']['showitem']);
unset($tx_acadsubsites_feusersArr[array_search('title',$tx_acadsubsites_feusersArr)]);
$tx_acadsubsites_feusersAdditionalFields = array('gender','first_name','last_name','title');
$TCA['fe_users']['palettes']['2']['showitem'] = implode(',',array_merge($tx_acadsubsites_feusersArr,$tx_acadsubsites_feusersAdditionalFields));

    // New icons for the pagetree
t3lib_spritemanager::addTcaTypeIcon('pages',1, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',3, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_link.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',4, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_shortcut.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',5, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_notinmenu.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',7, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_mountpoint.gif');

t3lib_spritemanager::addTcaTypeIcon('pages',77, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_subsite.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',101, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_servicespacer.gif');

t3lib_spritemanager::addTcaTypeIcon('pages',199, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/spacer_icon.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',254, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/sysf.gif');
t3lib_spritemanager::addTcaTypeIcon('pages',255, t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/recycler.gif');

 // New field for headerimage in table pages
$tempColumns = array (
	'tx_acaduebe_headerimage' => txdam_getMediaTCA('image_field', 'tx_acaduebe_headerimage'),
);

$tempColumns['tx_acaduebe_headerimage']['label'] = 'LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_headerimage';
$tempColumns['tx_acaduebe_headerimage']['config']['maxitems'] = 1;
$tempColumns['tx_acaduebe_headerimage']['config']['size'] = 1;

$tempColumns['tx_acaduebe_imprint_page'] = array(
    'exclude' => 1,
        'label' => 'LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_imprint_page',
        'config' => array (
            'type' => 'input',
            'size' => '5',
            'max' => '5',
            'wizards' => array(
                '_PADDING' => 2,
                'link' => array(
                    'type' => 'popup',
                    'title' => 'Link',
                    'icon' => 'link_popup.gif',
                    'script' => 'browse_links.php?mode=wizard',
                    'JSopenParams' => 'height=700,width=750,status=0,menubar=0,scrollbars=1',
                ),
            ),
            'eval' => 'int,nospace',
     ),
);

t3lib_div::loadTCA('pages');

t3lib_extMgm::addTCAcolumns('pages',$tempColumns,1);
unset($tempColumns);

$TCA['pages']['types']['1']['showitem'] = str_replace('media,', 'tx_acaduebe_headerimage,media,', $TCA['pages']['types']['1']['showitem']);
$TCA['pages']['types']['77']['showitem'] = str_replace('media,', 'tx_acaduebe_headerimage,media,', $TCA['pages']['types']['1']['showitem']);

	// reorganize the doktype select list
$TCA['pages']['columns']['doktype']['config']['items'] = array(
    array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.page','--div--'),
    array('LLL:EXT:lang/locallang_tca.php:doktype.I.0', '1', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages.gif'),
    array('LLL:EXT:acad_ue_subsites/locallang_db.xml:pages.doktype.I.77', '77', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_subsite.gif'),
    array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.4', '6', 'i/be_users_section.gif'),
	array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.link', '--div--'),
    array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.8', '3', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_link.gif'),
	array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.2', '4', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_shortcut.gif'),
	array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.5', '7', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_mountpoint.gif'),
	array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.div.special', '--div--'),
    array('LLL:EXT:lang/locallang_tca.php:doktype.I.1', '254', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/sysf.gif'),
	array('LLL:EXT:lang/locallang_tca.php:doktype.I.2', '255', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/recycler.gif'),
	array('LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.7', '199', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/spacer_icon.gif'),
	array('LLL:EXT:service_spacer/locallang.xml:pages.doktype.I.101', '101', t3lib_extMgm::extRelPath($_EXTKEY) . 'gfx/pages_servicespacer.gif'),
 );
 

	// getting rid of checkbox in front of nav_title
unset($TCA['pages']['columns']['nav_title']['config']['checkbox']);

	// making navtitle a little smaller
$TCA['pages']['columns']['nav_title']['config']['size'] = 15;
	// making real_url_pathsegment smaller
$TCA['pages']['columns']['tx_realurl_pathsegment']['config']['size'] = 15;
    // bigger select field for fe-groups
$TCA['pages']['columns']['fe_group']['config']['size'] = 20;
$TCA['pages']['columns']['fe_group']['config']['foreign_table_where'] = 'ORDER BY fe_groups.title';

	// New palettes for table pages

    // General, first palette for standard ans subsites
$TCA['pages']['palettes']['20'] = array(
	'showitem' => 'doktype,layout,module,hidden,nav_hide',
	'canNotCollapse'  => 1
);

    // General, start time and end time for all types
$TCA['pages']['palettes']['21'] = array(
	'showitem' => 'starttime,endtime',
	'canNotCollapse'  => 1
);

    // General, title and subtitle in one row
$TCA['pages']['palettes']['22'] = array(
	'showitem' => 'title,subtitle',
	'canNotCollapse'  => 1
);

    // General, nav_title and url stuff in one palette below title and subtitle
    // Special for doktypes that might need to be excluded from URL
    // Not used!
$TCA['pages']['palettes']['23'] = array(
	'showitem' => 'nav_title,tx_realurl_pathsegment,tx_cooluri_exclude,alias',
	'canNotCollapse'  => 1
);

    // General, nav_title and url stuff for pages that may not be excluded from URL,
    // i.e. doktypes standard (3) and subsite (77)
$TCA['pages']['palettes']['24'] = array(
	'showitem' => 'nav_title,tx_realurl_pathsegment,alias,target',
	'canNotCollapse'  => 1
);

$TCA['pages']['palettes']['25'] = array(
	'showitem' => 'lastUpdated,newUntil',
	'canNotCollapse'  => 1
);

$TCA['pages']['palettes']['26'] = array(
	'showitem' => 'no_cache, cache_timeout,no_search',
	'canNotCollapse'  => 1
);


$TCA['pages']['palettes']['27'] = array(
	'showitem' => 'lastUpdated,newUntil',
	'canNotCollapse'  => 1
);

$TCA['pages']['palettes']['28'] = array(
	'showitem' => 'tx_acaduesubsites_title, tx_acaduesubsites_uplink',
	'canNotCollapse'  => 1
);

	//  General>Type for doktype External URL
$TCA['pages']['palettes']['29'] = array(
	'showitem' => 'doktype,hidden,nav_hide',
	'canNotCollapse'  => 1
);

	// Special palette for doktype External URL saves us one TAB
$TCA['pages']['palettes']['30'] = array(
	'showitem' => 'nav_title,url,urltype,alias',
	'canNotCollapse'  => 1
);

	//  Special General first palette for doktype Spacer and Service Folder
$TCA['pages']['palettes']['31'] = array(
	'showitem' => 'doktype,hidden',
	'canNotCollapse'  => 1
);

	//  For Spacer and Service Folder: No nav_title, no url segment
$TCA['pages']['palettes']['32'] = array(
	'showitem' => 'tx_cooluri_exclude,alias',
	'canNotCollapse'  => 1
);

	//  Special General first palette for doktype Service Folder
$TCA['pages']['palettes']['33'] = array(
	'showitem' => 'doktype,module,hidden',
	'canNotCollapse'  => 1
);


	//  Special General first palette for doktype Shortcut
$TCA['pages']['palettes']['34'] = array(
	'showitem' => 'doktype,layout,nav_hide,hidden',
	'canNotCollapse'  => 1
);

	// Special nav_title palette for doktype Shortcut
$TCA['pages']['palettes']['35'] = array(
	'showitem' => 'nav_title,alias,target',
	'canNotCollapse'  => 1
);

	//  General>Type for SysFolder
$TCA['pages']['palettes']['36'] = array(
	'showitem' => 'doktype,module,hidden',
	'canNotCollapse'  => 1
);


	// Some labels redone
$TCA['pages']['columns']['doktype']['label'] = 'LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_doktype';
$TCA['pages']['columns']['tx_realurl_pathsegment']['label'] = 'LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_tx_realurl_pathsegment';
$TCA['pages']['columns']['tx_cooluri_exclude']['label'] = 'LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_tx_cooluri_exclude';


	// doktype Standard
$TCA['pages']['types']['1']['showitem'] = '
		--palette--;LLL:EXT:lang/locallang_general.php:LGL.type;20,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_title;22,
		--palette--;;24,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
		--palette--;;27,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_caching;26,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
 		--palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3,
 		abstract,
 		keywords,
 		description,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
 		tx_dampages_files,tx_acaduebe_headerimage,tx_acaduebe_imprint_page,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
 		TSconfig;;6;nowrap;6-6-6,
 		storage_pid;;7,
 		l18n_cfg,
 		content_from_pid,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
 		fe_login_mode,
 		fe_group,
 		extendToSubpages,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,	
 		tx_templavoila_ds;;;;1-1-1,
 		tx_templavoila_to,
 		tx_templavoila_next_ds,
 		tx_templavoila_next_to,
 		tx_templavoila_flex;;;;1-1-1';

	// doktype Subsite
$TCA['pages']['types']['77']['showitem'] = '
		--palette--;LLL:EXT:lang/locallang_general.php:LGL.type;20,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_title;22,
		--palette--;;24,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_subsite;28,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
		--palette--;;27,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_caching;26,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
 		--palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3,
 		abstract,
 		keywords,
 		description,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
 		tx_dampages_files,tx_acaduebe_headerimage,tx_acaduebe_imprint_page,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
 		TSconfig;;6;nowrap;6-6-6,
 		storage_pid;;7,
 		l18n_cfg,
 		content_from_pid,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
 		fe_login_mode,
 		fe_group,
 		extendToSubpages,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,	
 		tx_templavoila_ds;;;;1-1-1,
 		tx_templavoila_to,
 		tx_templavoila_next_ds,
 		tx_templavoila_next_to,
 		tx_templavoila_flex;;;;1-1-1';


    // doktype External URL
$TCA['pages']['types']['3']['showitem'] = '
		--palette--;LLL:EXT:lang/locallang_general.php:LGL.type;29,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_title;22,
		--palette--;;30,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
		 --palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3,
		 abstract,
		 keywords,
		 description,		
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
		media,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
		TSconfig;;6;nowrap;5-5-5,
		storage_pid;;7,
		l18n_cfg,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
 		fe_group,
 		extendToSubpages,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		tx_templavoila_ds;;;;1-1-1,
		tx_templavoila_to,
		tx_templavoila_next_ds,
		tx_templavoila_next_to,
		tx_templavoila_flex;;;;1-1-1';


	// doktype Service Folder
$TCA['pages']['types']['101']['showitem'] = '
		--palette--;LLL:EXT:lang/locallang_general.php:LGL.type;31,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_title;22,
		--palette--;;32,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
		--palette--;;27,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_caching;26,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata,
 		--palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3,
 		abstract,
 		keywords,
 		description,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
 		media,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
 		TSconfig;;6;nowrap;6-6-6,
 		storage_pid;;7,
 		l18n_cfg,
 		content_from_pid,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, 
 		fe_login_mode,
 		fe_group,
 		extendToSubpages,
 	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,	
 		tx_templavoila_ds;;;;1-1-1,
 		tx_templavoila_to,
 		tx_templavoila_next_ds,
 		tx_templavoila_next_to,
 		tx_templavoila_flex;;;;1-1-1';

	// doktype Visual Menu Separator same as Service Folder
$TCA['pages']['types']['199']['showitem'] = $TCA['pages']['types']['101']['showitem'];

	// doktype SysFolder
$TCA['pages']['types']['254']['showitem'] = '
    --palette--;LLL:EXT:lang/locallang_general.php:LGL.type;36,
	title;LLL:EXT:lang/locallang_general.xml:LGL.title,
    --palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
	--palette--;;27,
	--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_caching;26,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
		TSconfig;;6;nowrap;5-5-5,
		storage_pid;;,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		,
		tx_templavoila_ds;;;;1-1-1,
		tx_templavoila_to,
		tx_templavoila_next_ds,
		tx_templavoila_next_to,
		tx_templavoila_flex;;;;1-1-1';

	// doktype  Shortcut
$TCA['pages']['types']['4']['showitem'] = '
		--palette--;LLL:EXT:lang/locallang_general.php:LGL.type;34,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_title;22,
		--palette--;;35,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_dates;21,
		--palette--;LLL:EXT:acad_ue_be/locallang_db.xml:pages.tx_acaduebe_palette_caching;26,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.shortcut,
		shortcut;;;;3-3-3,
		shortcut_mode,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files,
		media,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,
		TSconfig;;6;nowrap;5-5-5,
		storage_pid;;7,
		l18n_cfg,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
		fe_group,
		extendToSubpages,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,
		,
		tx_templavoila_ds;;;;1-1-1,
		tx_templavoila_to,
		tx_templavoila_next_ds,
		tx_templavoila_next_to,
		tx_templavoila_flex;;;;1-1-1';


t3lib_div::loadTCA('pages_language_overlay');

	// dividers2tabs for pages_language_overlay
$TCA['pages_language_overlay']['ctrl']['divider2tabs'] = 1;
$TCA['pages_language_overlay']['columns']['doktype']['config']['items'] = $TCA['pages']['columns']['doktype']['config']['items'];

    // Show subsite title in language overlay for doktype 77
$TCA['pages_language_overlay']['types']['77']['showitem'] = '
    doktype;;;;1-1-1, hidden, sys_language_uid, title;;;;2-2-2, subtitle, nav_title, tx_acaduesubsites_title,
    --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.metadata, --palette--;LLL:EXT:lang/locallang_general.xml:LGL.author;5;;3-3-3, abstract, keywords, description,
    --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.files, media;;;;4-4-4,
    --div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime';


	// tt_content
t3lib_div::loadTCA('tt_content');

    // Bigger Popup for field header_link
$TCA['tt_content']['columns']['header_link']['config']['wizards']['link']['JSopenParams'] = 'height=600,width=800,status=0,menubar=1,scrollbars=1';

	// Allow more than the default 22 items in field pages
$TCA['tt_content']['columns']['pages']['config']['maxitems'] = 40;

	// New palettes for tt_content
$TCA['tt_content']['palettes']['20'] = array('showitem' => 'hidden, starttime, endtime, sys_language_uid, l18n_parent', 'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['21'] = array('showitem' => 'section_frame, spaceBefore, spaceAfter, text_size, tx_rgaccordion_accordion', 'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['22'] = array('showitem' => 'CType, linkToTop, sectionIndex, colPos', 'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['23'] = array('showitem' => 'header_layout, header_link, date, header_position',  'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['24'] = array('showitem' => 'CType, sectionIndex, colPos', 'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['25'] = array('showitem' => 'imagewidth, imageheight, imagecaption_position, imageborder', 'canNotCollapse' => 1);
$TCA['tt_content']['palettes']['26'] = array('showitem' => 'imageorient, imagecols, image_noRows', 'canNotCollapse' => 1);

	// Making tt_content.imagecaption an excludefield
	// We don't need it because caption comes from dam
$TCA['tt_content']['columns']['imagecaption']['exclude'] = 1;


	// Header only
$TCA['tt_content']['types']['header']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;24,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access
';

	// Text
$TCA['tt_content']['types']['text']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_ttc.xml:CType.I.1,
			bodytext;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3,
			rte_enabled,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access';


	// Text with image
$TCA['tt_content']['types']['textpic']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.text,
		bodytext;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css];3-3-3,
		rte_enabled,
	--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media,
		tx_damttcontent_files;;;;5-5-5,
		tx_damlightbox_flex,
		--palette--;Bildposition und nochwas;26;;1-1-1,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgDimensions;25;;3-3-3,
		;;;;6-6-6,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgLinks;7,
		--palette--;Bildposition, Anordnung und Vergrößern;26,
		altText;;;;7-7-7,
		titleText,
		longdescURL,
		;;;;8-8-8,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgOptions;11,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access';

	// Images only
$TCA['tt_content']['types']['image']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.media,
		tx_damttcontent_files;;;;5-5-5,
		tx_damlightbox_flex,
		--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:imageorient_arrangement;26;;1-1-1,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgDimensions;25;;3-3-3,
		;;;;6-6-6,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgLinks;7,
		--palette--;LLL:EXT:acad_ue_be/locallang_tcc.xml/imageorient_arrangement;26,
		altText;;;;7-7-7,
		titleText,
		longdescURL,
		;;;;8-8-8,
		--palette--;LLL:EXT:cms/locallang_ttc.php:ALT.imgOptions;11,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access
';

	// Menu/Sitemap
$TCA['tt_content']['types']['menu']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_ttc.xml:CType.I.12,
		menu_type;;;;4-4-4,
		pages,
		tx_acadcscadaptations_add_pages_by_id,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access
';

	// Flexible content elements
$TCA['tt_content']['types']['templavoila_pi1']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;;;2-2-2,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	tx_templavoila_ds,
	tx_templavoila_to,
	--div--;TV,	
		tx_templavoila_flex;;;;2-2-2,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access
';


	// Plugins (CType list)
$TCA['tt_content']['types']['list']['showitem'] = '
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_type_settings;22,
	header;;23;button;1-1-1,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_design_options;21;;3-3-3,
	--palette--;LLL:EXT:acad_ue_be/locallang_ttc.xml:palette_visibility;20;;1-1-1,
	--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.plugin,
		 list_type;;;;3-3-3,
		 layout,
		 select_key,
		 pages;;12,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
';

	// Filebrowser instead of input field for filemounts
t3lib_div::loadTCA('sys_filemounts');

$TCA['sys_filemounts']['columns']['path']['config']['wizards'] = array(
 '_PADDING' => 2,
 'link' => array (
  'type' => 'popup',
  'title' => 'Link',
  'icon' => 'link_popup.gif',
  'script' => 'browse_links.php?mode=wizard&amp;act=file',
  'params' => array (
    'blindLinkOptions' => 'page,url,mail,spec,file',
  ),
  'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
 )
);

    // Wider pagetree
$TBE_STYLES['dims']['navFrameWidth'] = 340;

	// Additions and modifications to tt_content CSH
t3lib_extMgm::addLLrefForTCAdescr('tt_content', 'EXT:' . $_EXTKEY . '/locallang_csh_ttcontent.xml');


	// register the csh-file
	// see sysext/lang/ for core-csh-files, find the right one and copy/paste to have the property keys
//t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:'.$_EXTKEY.'/locallang_csh_pages.xml');


$TCA['pages']['columns']['module']['config']['items'][] = array('Pr&auml;senzspezifische Gruppen', 'praespecg', '../typo3conf/ext/acad_ue_be/gfx/asterisk_orange.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Suche', 'find', '../typo3conf/ext/acad_ue_be/gfx/find.png');
$TCA['pages']['columns']['module']['config']['items'][] = array('Akronyme', 'acronym', '../typo3conf/ext/acad_ue_be/gfx/plugin-acronym.gif');


t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-praespecg', '../typo3conf/ext/acad_ue_be/gfx/asterisk_orange.png');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-find', '../typo3conf/ext/acad_ue_be/gfx/plugin-searchpage.gif');
t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-acronym', '../typo3conf/ext/acad_ue_be/gfx/plugin-acronym.gif');

	// Indexed search: more levels please
	// todo: remove this, as we do not use indexed search anymore
t3lib_div::loadTCA('index_config');
$TCA['index_config']['columns']['depth']['config']['items']['4']['0'] = '20 Levels';
$TCA['index_config']['columns']['depth']['config']['items']['4']['1'] = 20;


t3lib_div::loadTCA('tx_dam');
	// wider and higher category tree when adding categories to a file
$TCA['tx_dam']['columns']['category']['config']['itemListStyle'] = 'width:380px;height:400px;';
$TCA['tx_dam']['columns']['category']['config']['selectedListStyle'] = 'width:260px';

t3lib_div::loadTCA('tx_dam_cat');

	// category tree always sorted alpha
unset($TCA['tx_dam_cat']['ctrl']['sortby']);
$TCA['tx_dam_cat']['ctrl']['default_sortby'] = 'title';

	// wider and higher category tree when adding a parent category to a category
$TCA['tx_dam_cat']['columns']['parent_id']['config']['itemListStyle'] = 'width:380px;height:400px;';
$TCA['tx_dam_cat']['columns']['parent_id']['config']['selectedListStyle'] = 'width:260px';


t3lib_div::loadTCA('be_groups');

	// wider and higher category tree when adding dam mount to be-user group
$TCA['be_groups']['columns']['tx_dam_mountpoints']['config']['itemListStyle'] = 'width:380px;height:400px;';
$TCA['be_groups']['columns']['tx_dam_mountpoints']['config']['selectedListStyle'] = 'width:260px';

?>