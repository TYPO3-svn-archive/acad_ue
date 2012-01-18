<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Ursula Renziehausen (ursula.renziehausen@uni-erfurt.de)
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

class tx_acad_ue_templates {

    /**
     * Returns the path to headerImage relative to document root /fileadmin/etc
     *
     * $conf keys:
     * default: path to a default image
     *
     * @param array $conf
     * @return string
     */
    function getHeaderImage($content, $conf) {
		$docRoot = PATH_site;
		$allowPaths = $GLOBALS['TYPO3_CONF_VARS']['FE']['addAllowedPaths'];
		
        $uid = $GLOBALS["TSFE"]->id;
        $mediaData = tx_dam_db::getReferencedFiles('pages',$uid,'tx_acaduebe_headerimage','tx_dam_mm_ref');
        $rootline = $GLOBALS["TSFE"]->sys_page->getRootLine($uid);
        $line = array_shift($rootline);
        while (($line) && (empty($mediaData['files']))) {
            $mediaData = tx_dam_db::getReferencedFiles('pages',$line['uid'],'tx_acaduebe_headerimage','tx_dam_mm_ref');
            $line = array_shift($rootline);
        }
        
        $filePath = '';
        $rows = $mediaData['rows'];
        if($mediaData['files']) {
            $file = array_slice($mediaData['files'],0);
            $filePath = '/' .$file[0];
        }
        if(!$filePath) {
            $filePath = $conf['default'];
        }

		if (strpos($filePath, $docRoot) === FALSE) {
			if (strpos($filePath, $allowPaths) === 1) {
				$damUid = array_keys($rows);
				$filePath = '/index.php?eID=tx_wmdbdamsecurefiles_delivery&uid=' . $damUid[0];
			}
			
		}

        return $filePath;
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_ue_templates/pi1/class.acad_ue_templates.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/acad_ue_templates/class.acad_ue_templates']);
}


?>