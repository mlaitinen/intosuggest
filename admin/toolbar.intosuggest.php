<?php
/**
 * @version		$Id: toolbar.intosuggest.php 127 2011-03-08 03:00:29Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JHTML::stylesheet( 'intosuggest.css', 'administrator/components/com_intosuggest/assets/css/' );
require_once( JApplicationHelper::getPath( 'toolbar_html' ) );
$controller = JRequest::getVar('controller','default');
switch ($controller) {
	case 'forum':
		switch ($task){
			case 'add':
				TOOLBAR_intosuggest::_FORUM_ADD(false);
				break;
			case 'view':
				TOOLBAR_intosuggest::_FORUM_VIEW();
				break;
			case 'edit':
				TOOLBAR_intosuggest::_FORUM_EDIT(false);
				break;
			case 'import':
				TOOLBAR_intosuggest::_FORUM_IMPORT();
				break;
			default :
				TOOLBAR_intosuggest::_FORUM_DEFAULT();
				break;
		}
		break;
	case 'idea':
		switch ($task) {
			case 'add':			
				TOOLBAR_intosuggest::_IDEA_ADD();
				break;
			case 'edit':
				TOOLBAR_intosuggest::_IDEA_EDIT();
				break;
			case 'view':
				TOOLBAR_intosuggest::_IDEA_VIEW();
				break;
			default:
				TOOLBAR_intosuggest::_IDEA_DEFAULT();
				break;
		}
		break;	
	case 'permission':
		switch ($task) {
			case 'edit':
				TOOLBAR_intosuggest::_PERMISSION_EDIT();
				break;
			default:
				TOOLBAR_intosuggest::_PERMISSION_DEFAULT();
				break;			
		}
		break;			
	case 'exportimport':
		switch ($task) {
			case 'newExport':
				TOOLBAR_intosuggest::_EXPORTIMPORT_NEW_EXPORT();
				break;
			case 'addExport':
				TOOLBAR_intosuggest::_EXPORTIMPORT_EXPORT_ADD();
				break;
			case 'newImport':
				TOOLBAR_intosuggest::_EXPORTIMPORT_NEW_IMPORT();
				break;
			case 'showUserVoiceIdea':
				TOOLBAR_intosuggest::_EXPORTIMPORT_ADD_IMPORT();
				break;
			case 'display':
			default: 
				TOOLBAR_intosuggest::_EXPORTIMPORT();
				break;			
			
		}
		break;
	case 'config':
		switch ($task) {
			default:
				TOOLBAR_intosuggest::_CONFIG_EDIT();
				break;
		}
	break;	
	case 'upgrade':
		switch ($task) {
			default:
				TOOLBAR_intosuggest::_Upgrade();
				break;
		}	
		break;
	case 'report':
		TOOLBAR_intosuggest::_Report();
		break;
	case 'themes':
		TOOLBAR_intosuggest::_Themes();
		break;	
	default:
		break;	
}
/**
switch ($task)
{
	case 'add':
	case 'new_intosuggest_typed':
	case 'new_intosuggest_section':
		TOOLBAR_intosuggest::_EDIT(false);
		break;
	case 'edit':
	case 'editA':
	case 'edit_intosuggest_typed':
		TOOLBAR_intosuggest::_EDIT(true);
		break;
/*
	case 'showarchive':
		TOOLBAR_intosuggest::_ARCHIVE();
		break;

	case 'movesect':
		TOOLBAR_intosuggest::_MOVE();
		break;

	case 'copy':
		TOOLBAR_intosuggest::_COPY();
		break;

	default:
		TOOLBAR_intosuggest::_DEFAULT();
		break;

}
*/
