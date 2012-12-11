<?php
/**
* @version		$Id: extension.php 20196 2011-01-09 02:40:25Z ian $
* @package		Joomla.Framework
* @subpackage	Table
* @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
* @license		GNU General Public License, see LICENSE.php
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Extension table
 * Replaces plugins table
 *
 * @package		Joomla.Framework
 * @subpackage		Table
 * @since	1.6
 */
class JTableUVPermission extends JTable
{
	/**
	 * Contructor
	 *
	 * @access var
	 * @param database A database connector object
	 */
	function __construct(&$db) {
		parent::__construct( '#__intosuggest_permission', 'group_id', $db );
	}
}
