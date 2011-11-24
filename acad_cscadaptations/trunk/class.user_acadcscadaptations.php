<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Uschi Renziehausen (ursula.renziehausen@uni-erfurt.de)
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

require_once(PATH_tslib . 'class.tslib_content.php');

class user_acadcscadaptations {
	
	var $cObj;
    var $count;
    var $maxLevels;
    var $addWhere;
    
	/**
	 * Sorts a menu array alphabetically
	 * 
	 * Needed for menus of type special = list, because alternativeSortingField will not work there
	 *
	 * @param array $menuArray
	 * @param array $conf
	 * @return array The menu sorted alphabetically
	 * @todo Take care of the locales!
	 */
	function sortMenu($menuArray, $conf) {
		$titleArray = array();
		$menuArraySorted = array();
		foreach($menuArray as $k=>$v) {
			$titleArray[$k] = $v['title'];
		}
		asort($titleArray);
		foreach($titleArray as $k=>$v) {
			$menuArraySorted[] = $menuArray[$k];
		}

		return $menuArraySorted;
	}
	
	/**
	 * Sets register:doExpandAll dependending on the total of menuitems on all levels
	 * 
	 * $conf allows the following keys:
	 * start: the uid of the menu's parent page
	 * levels: how many levels shall be counted
	 * limit: int, the number of items allowed for doExpandAll = 1
	 * addWhere: some sql added to the where clause, e.g. AND nav_hide=0
	 * 
	 * @param mixed $content, not used
	 * @param array $conf (start,levels,limit,addWhere)
	 * @return void
	 */
	function countAllMenuItems($content,$conf) {
 		$this->cObj = t3lib_div::makeInstance('tslib_cObj');
		$this->maxLevels = $conf['levels'];
		$this->addWhere = $conf['addWhere'];
		$this->count = 0;
		$start = $this->cObj->stdWrap($conf['start'], $conf['start.']);
		$this->countAllMenuItemsRecursive($start);
		$content = $this->count;
		$GLOBALS['TSFE']->register['doExpandAll'] = ($this->count > intval($conf['limit'])) ? 0 : 1;
    }

    /**
     * Count menuitems on multiple levels recursively
     * 
     * @param int $pid, uid of the menues parent page
     * @param int $level internal counter for recursion
     * @return void
     * 
     * @see countAllMenuItems()
     */
    function countAllMenuItemsRecursive($pid, $level = 1) {
		$menu = $GLOBALS['TSFE']->sys_page->getMenu($pid, $fields='uid,pid,title', $sortField='sorting', $this->addWhere, $checkShortcuts=1);
		foreach($menu as $key => $item) {
		    $this->count++;
		    if ($level < $this->maxLevels) {
				$this->countAllMenuItemsRecursive($key, $level+1);
		    }
		}
    }
}
?>