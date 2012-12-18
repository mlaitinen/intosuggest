<?php
/**
 * @version		$Id: theme.php 232 2011-03-25 11:09:36Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

final class Theme {
	function __construct() { 		
	}
	
	public static function dispSubMenu() {
		JToolBarHelper::title( JText::_('FOOBLA_SUGGESTION'), 'intosuggest.png' );
		$default 		= 'index.php?option=com_intosuggest&controller=default';
		$forum 			= 'index.php?option=com_intosuggest&controller=forum';
		$idea 			= 'index.php?option=com_intosuggest&controller=idea';
		$permission 	= 'index.php?option=com_intosuggest&controller=permission';
		$export_import 	= 'index.php?option=com_intosuggest&controller=exportimport';
		$vote 			= 'index.php?option=com_intosuggest&controller=vote';
		$controller 	= &JRequest::getVar('controller');
		JSubMenuHelper::addEntry( JText::_('CONTROL_PANEL')	, $default	, ( $controller=='default' || !$controller ) );
		JSubMenuHelper::addEntry( JText::_('FORUM_MANAGER')	, $forum	, ( $controller=='forum') );
		JSubMenuHelper::addEntry( JText::_('IDEA_MANAGER')	, $idea		, ( $controller=='idea') );
		JSubMenuHelper::addEntry( JText::_('PERMISSION')	, $permission, ( $controller=='permission') );
		JSubMenuHelper::addEntry( JText::_('EXPORT_SLASH_IMPORT'), $export_import, ( $controller=='exportimport'));
		JSubMenuHelper::addEntry( JText::_('VOTE'), $vote, ( $controller=='vote') );
	}
    
	public static function dispSubMenuConFig() {
		$default = 'index.php?option=com_intosuggest&controller=default';		
		$forum = 'index.php?option=com_intosuggest&controller=forum';						
		$idea = 'index.php?option=com_intosuggest&controller=idea';		
		$permission = 'index.php?option=com_intosuggest&controller=permission';
		$export_import = 'index.php?option=com_intosuggest&controller=exportimport';
		$vote = 'index.php?option=com_intosuggest&controller=vote';
		$res = new stdClass();
		$res->default  		= $default;
		$res->forum 		= $forum;
		$res->idea 			= $idea;
		$res->permission	= $permission;
		$res->export_import = $export_import;
		$res->vote 			= $vote;
		return $res;
	}
	
}
?>

