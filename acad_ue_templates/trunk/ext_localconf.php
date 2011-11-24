<?php

if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addTypoScript($_EXTKEY,'setup','includeLibs.tx_acad_ue_templates = EXT:acad_ue_templates/class.tx_acad_ue_templates.php');

/*
require_once(t3lib_extMgm::extPath('acad_ue_templates').'hooks/class.tx_acaduetemplates_tsparser.php');
	// add hook for getting the entryLevel dynamically
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tsparser.php']['preParseFunc']['prependDoktypeLevel']	= 'EXT:acad_ue_templates/hooks/class.tx_acaduetemplates_tsparser.php:tx_acaduetemplates_tsparser->prependDoktypeLevel';

function tx_akaduetemplates_doktypeLevel($params){
	$paramsArr = explode(';',$params);
	$doktypeLevel = tx_acaduetemplates_tsparser::getDoktypeLevel($paramsArr[0]);
	if($doktypeLevel == $paramsArr[1]) {
		return TRUE;
	} else {
		return FALSE;
	}
}
*/

?>