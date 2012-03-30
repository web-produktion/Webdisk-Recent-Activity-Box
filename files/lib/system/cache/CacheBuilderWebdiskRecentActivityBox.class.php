<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches uploads (ids) for the recent activity box.
 * 
 * @author 	Jean-Marc Licht
 * @copyright	2011 - 2012 web-produktion
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.web-produktion.webdisk.recentActivityBox
 * @subpackage	system.cache
 * @category 	Burning Board
 */
class CacheBuilderWebdiskRecentActivityBox implements CacheBuilder {
	
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		// get item ids
		$uploadIDArray = array();
		$sql = "SELECT		di.itemID
			FROM		wcf".WCF_N."_database_item di
			WHERE		di.isDeleted = 0
					AND di.active = 1
			ORDER BY	di.createTime DESC";
		$result = WCF::getDB()->sendQuery($sql, RECENT_ACTIVITY_BOX_ITEMS * 10);
		while ($row = WCF::getDB()->fetchArray($result)) {
			$uploadIDArray[] = $row['itemID'];
		}
		
		return $uploadIDArray;
	}
}
?>