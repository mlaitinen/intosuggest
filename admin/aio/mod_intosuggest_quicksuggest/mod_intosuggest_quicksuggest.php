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

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
require_once (dirname(__FILE__).DS.'element'.DS.'listforum.php');
$list 		= modListForumHelper::getListUserVoice($params);
$listForum 	= modListForumHelper::getAllForum($params);
require(JModuleHelper::getLayoutPath('mod_intosuggest_quicksuggest'));
?>