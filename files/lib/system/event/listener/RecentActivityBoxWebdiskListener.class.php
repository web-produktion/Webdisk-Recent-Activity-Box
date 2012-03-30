<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

// wbb imports
require_once(WBB_DIR.'lib/data/page/recentActivityBox/RecentActivityBoxManager.class.php');
require_once(WBB_DIR.'lib/data/page/recentActivityBox/WebdiskRecentActivityBox.class.php');

/**
 * Shows the lastest uploads in the recent activity box.
 * 
 * @author 		Jean-Marc Licht
 * @copyright	2011 web-produktion
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.web-produktion.webdisk.recentActivityBox
 * @subpackage	system.event.listener
 * @category 	Burning Board
 */
class RecentActivityBoxWebdiskListener implements EventListener {
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		RecentActivityBoxManager::getInstance()->addBox(new WebdiskRecentActivityBox());
	}
}
?>