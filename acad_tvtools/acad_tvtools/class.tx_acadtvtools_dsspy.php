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

/**
 * Contains methods to spy out templavoila datastructures
 *
 * @author	Uschi Renziehausen <ursula.renziehausen@uni-erfurt.de>
 * @package	TYPO3
 * @subpackage	tx_acadtvtools
 */
class tx_acadtvtools_dsspy {

	/**
	 * Get the <el> element directly under ROOT
	 *
	 * @param array	$dsArray: The DS in question transformed to an array
	 * @return array
	 */
	function getRootChildEl($dsArray) {
		$elArray = array();
		if(is_array($dsArray['ROOT']['el'])) {
			$elArray = $dsArray['ROOT']['el'];
		}
		return $elArray;
	}

	/**
	 * Get an array of fieldnames inside an el-element
	 *
	 * @param array	$dsArray: The DS in question transformed to an array
	 * @return array	array with the fieldnames or empty if no fields were found
	 */
	function getFieldNames($dsArray) {
		$fieldNamesArray = array();
		$elArray = tx_acadtvtools_dsspy ::getRootChildEl($dsArray);
		if(!empty($elArray)) {
			foreach($elArray as $field_name=>$value) {
				$fieldNamesArray[] = $field_name;
			}
		}
		return $fieldNamesArray;
	}
	
	/**
	 * Find out the eType of a field identified by it's name
	 *
	 * @param string 	$fieldName: The name of the field, e.g. field_col1
	 * @param array		$dsArray: The DS in question transformed to an array
	 * @return string	The eType, e.g. ce
	 */
	function getFieldEtype($fieldName, $dsArray) {
		$fieldType = '';
		$elArray = tx_acadtvtools_dsspy ::getRootChildEl($dsArray);
		if(is_array($elArray[$fieldName]))	{
			$fieldType = $elArray[$fieldName]['tx_templavoila']['eType'];
		}
		return $fieldType;
	}
	
}

if (defined('TYPO3_MODE') &&$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_tvtools/class.tx_acadtvtools_dsspy.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_tvtools/class.tx_acadtvtools_dsspy.php']);
}


?>