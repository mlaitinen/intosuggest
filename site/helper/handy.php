<?php
/**
 * @version		$Id: handy.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT.DS."helper".DS."dbase.php");
final class Handy {
	function __construct() {
	}
	
	public static function getDateTime() {
		return date("Y-m-d H:i:s");
	}
	
	public static function getUser($_user_id = 0) {		
		$query = "
			SELECT *
			FROM `#__users`
			WHERE `id` = $_user_id
		;";
		$user = DBase::getObject($query); 
		if ($_user_id == 0) $user->name = "anonymous";
		return $user;
	}
	public static function getStatus($forum_id) {
		$query = "
			SELECT s.id, s.title, s.parent_id FROM #__intosuggest_status AS s
            INNER JOIN #__intosuggest_tab AS t ON t.status_id = s.id
            WHERE t.forum_id = $forum_id
            UNION
            SELECT id, title, parent_id FROM #__intosuggest_status WHERE parent_id = -1
            ORDER BY id ASC
		;";		
		return DBase::getObjectList($query);
	}
}
?>
