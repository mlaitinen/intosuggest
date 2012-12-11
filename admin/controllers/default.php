<?php
/**
 * @version		$Id: default.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ControllerDefault extends JController {
	function __construct() {
		parent::__construct();
	}
	
	function display() {
		$model = &$this->getModel('default');
		$view = &$this->getView('default');
		
		$view->setModel($model,true);
		$view->display();
	}
	
}
?>
