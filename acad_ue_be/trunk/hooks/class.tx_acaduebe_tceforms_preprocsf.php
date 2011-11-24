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
/**
 * Class 'tx_acaduebe_tceforms_preprocsf' for the acad_ue_be extension.
 *
 * @author     Irene Höppner <irene.hoeppner@abezet.de>
 */
class tx_acaduebe_tceforms_preprocsf {
	function getSingleField_preProcess($table, $field, &$row, $altName, $palette, $extra, $pal, $pObj) {
			// get TSconfig-settings for the field
		$fieldTSconfig = $pObj->setTSconfig($table,$row,$field);
		// set the default-value only, if some TSconfig is set and the field ist still empty
			// take care: this does NOT override the TCA. If there is a default-setting in TCA you have to remove that first.
		if($row[$field]==='' && $fieldTSconfig['config.']['default']) {
			$row[$field] = $fieldTSconfig['config.']['default'];
		}
	}
}
?>
