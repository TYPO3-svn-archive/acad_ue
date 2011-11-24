<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2007 Uschi Renziehausen <ursula.renziehausen@uni-erfurt.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');
/*
 require_once(PATH_t3lib.'class.t3lib_iconworks.php');
 require_once(t3lib_extMgm::extPath('templavoila').'class.tx_templavoila_api.php');
 */
require_once(t3lib_extMgm::extPath('acad_tvtools') . 'class.tx_acadtvtools_dsspy.php');

/**
 * Plugin 'pi1' for the 'acad_tvtools' extension.
 *
 * @author	Uschi Renziehausen <ursula.renziehausen@uni-erfurt.de>
 * @package	TYPO3
 * @subpackage	tx_acadtvtools
 */
class tx_acadtvtools_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_acadtvtools_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_acadtvtools_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'acad_tvtools';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * @var array - all CEs of current page, key is the uid
	 */
	var $tmpContents   = array();

	/**
	 * @var array - CEs 'used' in templavoila
	 */
	var $usedContents  = array(); // contains all elements used by the current page
	
	/**
	 * @var array - list of data structures used on current page; key is uid, value is dataprot xml 
	 */ 
	var $usedDS = array();
	
	/**
	 * @var array - key is TO-uid, value is uid of DS
	 */
	var $mapTODS = array();

	/**
	 * @var int - number or recursion when searching CEs/FCEs inside FCEs
	 */	
	var $maxRecursion  = 4;

	/**
	 * The main method of the PlugIn
	 *
	 * Planned entries in $conf
	 * - pageFields: csv list of TV fields in page DS to search, e.g. 'field_content,field_sidebar'.
	 * 				 If not set or empty, all fields will be searched
	 * - FCEFields:	 csv list of TV fields in FCE DS to search, e.g. 'field_left,field_right'.
	 * 				 If not set or empty, all fields will be searched
	 * - FCEexcludeTO: csv list of TOs that shall not be searched for CEs
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * 
	 * @see tx_acadtvtools_pi1::getUsedElements()
	 * @see tx_acadtvtools_dsspy::getFieldNames()
	 * @see tx_acadtvtools_dsspy::getFieldEtype($field, $dsArray)
	 * 
	 * @return	string - A list of CE-IDs or empty
	 */
	 
	function main($content,$conf)	{

        // Find out current Page TO
        $pageTO = $GLOBALS['TSFE']->page['tx_templavoila_to'];
        if($pageTO == 0) {
            $start=count($GLOBALS["TSFE"]->rootLine);
            foreach($GLOBALS["TSFE"]->rootLine as $v) {
                if($v['tx_templavoila_to'] > 0) {
                    $pageTO = $v['tx_templavoila_next_to'];
                    break;
                }
            }
        }

       // Get the uid and flexXML for the page in question
       // If the current page shows the content from another page, we need to get the data from that page
       if(!$GLOBALS['TSFE']->page['content_from_pid']) {
            $pageId = $GLOBALS['TSFE']->id;
            $pageFlex = $GLOBALS['TSFE']->page['tx_templavoila_flex'];
       } else {
           $pageId = $GLOBALS['TSFE']->page['content_from_pid'];
           $select = 'tx_templavoila_flex';
           $from_tables = 'pages';
           $where = 'pages.uid=' .$GLOBALS['TSFE']->page['content_from_pid']  .$this->cObj->enableFields('pages');

           $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from_tables,$where);

           while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
               $pageFlex = $row['tx_templavoila_flex'];
           }
       }

		
		// Which page fields we shall in look for content elements
		$pageFields = '';
		if($conf['searchFieldsInTo.'][$pageTO]) {
			$pageFields = $conf['searchFieldsInTo.'][$pageTO];
		}
	
		// Now, get a csv list of IDs of CEs used on page level
		$this->usedContents = $this->getUsedElements($pageFlex, $pageFields);

		// Fetch all undeleted Content elements of the page from DB
		$select = 'uid,header,cType,t3_origuid,tx_templavoila_to,tx_templavoila_ds,tx_templavoila_flex';
		$from_tables = 'tt_content';
		$where = 'tt_content.pid=' .$pageId  .$this->cObj->enableFields('tt_content');
		$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from_tables,$where);

		// Store the result in $this->tmpContents
		// Build an array that has the DS-IDs used in FCEs as key ($this->usedDS)
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
			$this->tmpContents[$row['uid']] = $row;
			// Collect datastructure IDs
			if ( $row['cType']=='templavoila_pi1' ) {
				if (!isset($this->usedDS[$row['tx_templavoila_ds']])) {
					$this->usedDS[$row['tx_templavoila_ds']]= array();
				}	
			}
		}
		
		if (count($this->usedDS)) {
			// Get the DS XML from DB (tx_templavoila_datastructure.dataprot).
			$strDatastructures = implode(',', array_keys($this->usedDS));
			$select = 'uid, dataprot';
			$from_tables = 'tx_templavoila_datastructure';
			$where = 'uid IN (' .$strDatastructures .')';
			$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from_tables,$where);

			// Store the DS XML in $this->usedDS
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
				$this->usedDS[$row['uid']] = $row['dataprot'];
			}

			// find out whether any of the elements stored in $this->tmpContents
			// are FCEs that contain other content elements and store this in key
			// subElements
			foreach($this->tmpContents as $k => $v) {
				if($v['cType'] == 'templavoila_pi1') {

					// Get an array of fieldnames available for the current DS.
						$ds = $this->usedDS[$v['tx_templavoila_ds']];
						$dsArray  = t3lib_div::xml2array($ds);
						$dsFields = tx_acadtvtools_dsspy::getFieldNames($dsArray);
					
					
					
					foreach($dsFields as $field) {
						$eType = tx_acadtvtools_dsspy::getFieldEtype($field, $dsArray);
						if($eType == 'ce' && !empty($v['tx_templavoila_flex'])) {
							$subElements = $this->getUsedElements($v['tx_templavoila_flex'], $field);
							foreach($subElements as $subEl) {
								$this->tmpContents[$k]['subElements'][$subEl] = array(
																	'field'=>$field
																);
							}
						}
					}
				}
			}
		}

			// Get CEs inside any FCEs
		$this->loopy($this->usedContents);
		
			// Clean $this->usedContents from any empty entries
			// that might be present because an FCE field does not contain
			// any CEs
		
		foreach($this->usedContents as $k=>$v) {
			if(!$v) {
				unset($this->usedContents[$k]);	
			}
		}

			// Now that we have collected all used CEs in the correct order
			// let us filter out those that are either 
			// - are not indexed
			// - or have a hidden header
			// - or are an FCE as FCE headers are not rendered
		$select = 'uid';
		$from_tables = 'tt_content';
		$where = 'uid IN (' . implode(',', $this->usedContents) . ") AND sectionIndex=1 AND NOT header_layout=100 AND NOT cType='templavoila_pi1'";
		$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from_tables,$where);
		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
			$validSectionElements[] = $row['uid'];
		}

		$ret = '';
		if($validSectionElements) {
			$validSectionElements = array_flip($validSectionElements);
			$this->usedContents = array_flip($this->usedContents);
			
			foreach($this->usedContents as $k=>$v) {
				if(!isset($validSectionElements[$k])) {
					unset($this->usedContents[$k]);			
				}
			}
			$this->usedContents = array_flip($this->usedContents);
			$ret = implode(',', $this->usedContents);
		}	
		return $ret;
	}
	

	/**
	 * Finds used CEs inside FCEs recursively and adds them to $this->usedContents
	 *
	 * @param array	$ce: list of UIDs from tt_content found on page level
	 */
	
	function loopy($ce) {
		static $level;
		if ($level >= $this->maxRecursion) {
			$level = 0;
			return;
		}
		@$level++;
		foreach($ce as $k => $uid) {
			if ( isset($this->tmpContents[$uid]['subElements']) ) {
				$p     = array_search($uid, $this->usedContents);
#debug($p, '$p');
				$subce = array_keys($this->tmpContents[$uid]['subElements']);
#debug($subce, '$subce');
				array_splice($this->usedContents, $p+1, 0, $subce);
				$this->loopy($subce);
			}
		}
	}



	/**
	 *  Gets the UIDs of content elements found in some tx_templavoila_flex xml
	 *
	 * 	@param string	$flexFormXML: The xml string
	 *  @param string	$fields: Comma separated string of TV-Fields to search in, e.g. 'field_content,field_sidebar'
	 *
	 *  @return array	Numerical Array with UIDs of elements found
	 *
	 *  @todo Find out about this sheet and lang staff in order to make it run under all circumstances
	 */
	function getUsedElements($flexformXML, $fields='') {
		$flexArray = t3lib_div::xml2array($flexformXML);
		$sheetKey = 'sDEF';
		$langKey = 'lDEF';

		// find out the tv fields to search for CEs
		$searchFields = array();
		if(!empty($fields)) {
			$searchFields = t3lib_div::trimExplode(',', $fields);
		} else {
			foreach($flexArray['data'][$sheetKey][$langKey] as $k=>$v) {
				$searchFields[] = $k;
			}
		}

		// build the array of uids
		$contentElements = array();
		foreach($searchFields as $field) {
			$arFlex = is_array($flexArray) && is_array($flexArray['data'][$sheetKey][$langKey][$field]);
			if(is_array($flexArray['data'][$sheetKey][$langKey][$field])) {
				$tempCEs = t3lib_div::trimExplode(',', $flexArray['data'][$sheetKey][$langKey][$field]['vDEF']);
				foreach($tempCEs as $v) {
					$contentElements[] = $v;
				}
			}
		}

		return $contentElements;
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_tvtools/pi1/class.tx_acadtvtools_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_tvtools/pi1/class.tx_acadtvtools_pi1.php']);
}

?>
