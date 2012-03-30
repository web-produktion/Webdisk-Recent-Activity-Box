<?php
// wbb imports
require_once(WBB_DIR.'lib/data/page/recentActivityBox/RecentActivityBox.class.php');

// wcf imports
require_once(WCF_DIR."lib/data/database/DatabaseStructure.class.php");
require_once(WCF_DIR."lib/data/database/DatabaseFileIdentifier.class.php");

/**
 * Implementation of RecentActivityBox to show the lastest webdisk uploads.
 * 
 * @author 	Jean-Marc Licht
 * @copyright	2011 - 2012 web-produktion
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.web-produktion.webdisk.recentActivityBox
 * @subpackage	system.event.listener
 * @category 	Burning Board
 */
class WebdiskRecentActivityBox implements RecentActivityBox {
	
	/**
	 * Cached webdisk uploards
	 * @var array<>
	 */
	protected $cachedUploads = null;
	
	/**
	 * number of new uploads
	 * @var integer
	 */
	protected $newItems = 0;
	
	/**
	 * Loads the cache.
	 */
	protected function initCache() {
		$this->cachedUploads = array();
		
		// register cache
		WCF::getCache()->addResource('webdiskRecentActivityBox', WBB_DIR.'cache/cache.webdiskRecentActivityBox.php', WBB_DIR.'lib/system/cache/CacheBuilderWebdiskRecentActivityBox.class.php', 0, 180);
		
		// get cache
		$cachedItemIDArray = WCF::getCache()->get('webdiskRecentActivityBox');
		
		// get webdisk items
		if (count($cachedItemIDArray)) {
			// get items
			$sql = "SELECT	dc.icon, dc.name AS cName, di.*
				FROM		wcf".WCF_N."_database_item di
				LEFT JOIN	wcf".WCF_N."_database_category dc
				ON			(di.categoryID = dc.categoryID)
				WHERE		di.itemID IN (".implode(',', $cachedItemIDArray).")
				GROUP BY	itemID
				ORDER BY	di.createTime DESC";
			$result = WCF::getDB()->sendQuery($sql, RECENT_ACTIVITY_BOX_ITEMS);
			while ($row = WCF::getDB()->fetchArray($result)) {
				// get webdisk item
				if(DatabaseStructure::checkAccess($row['itemID'],$row) == true) {
					$this->cachedUploads[] = $row;
				}
			}
		}
	}
	
	/**
	 * @see RecentActivityBox::getIdentifier()
	 */
	public function getIdentifier() {
		return 'com.viecode.webdisk.items';
	}
	
	/**
	 * @see RecentActivityBox::getTitle()
	 */
	public function getTitle() {
		return WCF::getLanguage()->get('wbb.board.webdisk.title');
	}
	
	/**
	 * @see RecentActivityBox::getNewItems()
	 */
	public function getNewItems() {
		return $this->newItems;
	}
	
	/**
	 * @see RecentActivityBox::hasContent()
	 */
	public function hasContent() {
		if ($this->cachedUploads === null) $this->initCache();
		
		if (count($this->cachedUploads)) {
			return true;
		}
		return false;
	}
	
	/**
	 * @see RecentActivityBox::getContent()
	 */
	public function getContent() {
		if ($this->hasContent()) {
			WCF::getTPL()->assign('databaseItems', $this->cachedUploads);
			return WCF::getTPL()->fetch('webdiskRecentActivityBox');
		}
		return '';
	}
}
?>