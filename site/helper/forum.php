<?php
/**
 * @version		$Id: forum.php 209 2011-03-24 09:18:43Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT.DS."helper".DS."dbase.php");
require_once(JPATH_COMPONENT.DS."helper".DS."idea.php");
require_once(JPATH_COMPONENT.DS."helper".DS."handy.php");

final class Forum {
	function __construct() {
	}
	
	public static function getAllForum() {
		$query = "
			SELECT *
			FROM `#__intosuggest_forum`
			WHERE `published` = 1
			ORDER BY `id` ASC
		;";
		return DBase::getObjectList($query);		
	}
	
	public static function getIdeaPerPage($forum_id) { 
		$query = "SELECT limit_idea_page FROM `#__intosuggest_forum` WHERE `id` = ".$forum_id;
		$result = DBase::getObjectResult($query);
		if (!$result or $result <= 0) $result = 10;
		return $result;
	}
	
	
	public static function getForumById($_id = null){
		$query = "
			SELECT * 
			FROM `#__intosuggest_forum`
			WHERE `id` = $_id
		;";		
		return DBase::getObject($query);
	}
	
	public static function getForumDefault() {
		$query = "
			SELECT * 
			FROM `#__intosuggest_forum`
			WHERE `default` = 1
		;";		
		return DBase::getObject($query);
	}
	public static function delete($_forum_id = null) {
		Idea::deleteIdeaByForumId($_forum_id);
		$query = "
			DELETE FROM `#__intosuggest_forum`
			WHERE `id` = $_forum_id
		;";
		DBase::querySQL($query);
	}
	public static function getTabForumById($_forum_id) {
		
        $query = "SELECT st.id, st.title, COUNT(i.id) AS ideacount FROM #__intosuggest_status AS st ".
				"INNER JOIN #__intosuggest_tab AS tab ON st.id = tab.status_id ".
                "LEFT JOIN #__intosuggest_idea AS i ON i.status_id = st.id AND i.forum_id = tab.forum_id AND i.published = 1 ".
				"WHERE tab.forum_id = ".$_forum_id. " ".
                "GROUP BY st.id, st.title ".
                "UNION "  .
                "SELECT 0 as id, 'STATUS_NO_STATUS' as title, COUNT(id) AS ideacount FROM #__intosuggest_idea ".
                "WHERE status_id = 0 AND forum_id = $_forum_id AND published = 1 ".
                "ORDER BY id ASC";
        
		$tab =  DBase::getObjectList($query);

		return $tab;
	}
	
	public static function getVotedPoint( $forum_id, $user_id ) {
		$db = &JFactory::getDBO();
		$sql = "SELECT SUM(jv.vote) `votedpoint` 
				FROM #__intosuggest_forum j 
					LEFT OUTER JOIN #__intosuggest_idea ji ON ji.forum_id=j.id 
					LEFT OUTER JOIN #__intosuggest_vote jv ON jv.idea_id=ji.id 
				WHERE jv.user_id = $user_id AND j.id=$forum_id LIMIT 1";
		$db->setQuery( $sql );
		$votedpoint 	= $db->loadResult();
		return $votedpoint;
	}
	
	public static function getRemainingPoint( $forum_id, $user_id ) {
		$limitpoint 	= self::getLimitPoint($forum_id);
		$votedpoint 	= self::getVotedPoint($forum_id, $user_id);
		$remainingpoint = $limitpoint - $votedpoint;
		return $remainingpoint;
	}
	
	public static function getLimitPoint( $forum_id ){
		$db 	= &JFactory::getDBO();
		$sql 	= "SELECT `j`.`limitpoint` FROM `#__intosuggest_forum` `j` WHERE `j`.`id`=$forum_id LIMIT 1";
		$db->setQuery( $sql );
		$limitpoint = $db->loadResult();

		if( !$limitpoint ) {
			$sql 		= "SELECT `value` FROM `#__intosuggest_gconfig` WHERE `key`='limitpoint'";
			$db->setQuery( $sql );
			$limitpoint = $db->loadResult();
		}
		return $limitpoint;
	}
	
	public static function getForumByIdeaId( $idea_id ) {
		$db = &JFactory::getDbo();
		$sql = "SELECT DISTINCT j.* 
				FROM #__intosuggest_forum j, #__intosuggest_idea ji
				WHERE ji.`forum_id` = j.id and ji.id = 662  LIMIT 1";
		$db -> setQuery($sql);
		$forum = $db->loadObject();
		return $forum;
	}
}
?>
