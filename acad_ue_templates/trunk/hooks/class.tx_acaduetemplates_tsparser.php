<?php
/***************************************************************
*  Copyright notice
*
*  (c) 1999-2007 Kasper Skaarhoj (kasperYYYY@typo3.com)
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/



class tx_acaduetemplates_tsparser {
	function prependDoktypeLevel($params) {
#debug('drin');
#return $params['currentValue'];
		$useLevel = $this->getDoktypeLevel($params['functionArgument']);
		return $useLevel.$params['currentValue'];
	}
		// get the level depending on the doktype
		// if no doktype is found, use level 0
		// go the rootline up until the first page with this doktype is found.
		// returns the level of this page
		// used in the hook-funktion prependDoktypeLevel (:=-Hook) and in the condition used for caching
	function getDoktypeLevel($doktype) {
		$useLevel = 0;
		if(is_array($GLOBALS['TSFE']->rootLine)) {
			foreach($GLOBALS['TSFE']->rootLine as $level=>$data)	{
				if($data['doktype']==$doktype) {
					$useLevel = $level;
					break;
				}
			}		
		}
		return $useLevel;
	}
}
?>