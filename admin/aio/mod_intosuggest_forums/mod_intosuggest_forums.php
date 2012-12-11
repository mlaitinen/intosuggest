<?php
/**
 * @version		$Id: mod_intosuggest_forums.php 164 2011-03-12 09:01:56Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');
require_once (dirname(__FILE__).DS.'element'.DS.'forum.php');
$list = modListUserVoiceHelper::getListUserVoice($params);
require(JModuleHelper::getLayoutPath('mod_intosuggest_forums'));
?>