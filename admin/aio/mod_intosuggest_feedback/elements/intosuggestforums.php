<?php
/**
 * @version		$Id: forum.php 164 2011-03-12 09:01:56Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.helper');
global $obIsJ15;
$jversion = new JVersion();
$obIsJ15 = ($jversion->RELEASE == '1.5');

jimport("joomla.html.parameter.element");

if($obIsJ15): # Joomla 1.5

class JElementintosuggestforums extends JElement
{
	var   $_name = 'intosuggestforums';
	function fetchElement($name, $value, &$node, $control_name){
		$db = &JFactory::getDBO();
		$query = "SELECT `id` AS `value`, `name` AS `text` FROM  #__intosuggest_forum WHERE published=1";
		$db->setQuery($query);
		$forums = $db->loadObjectList();
		
		return JHTML::_('select.genericlist',  $forums, ''.$control_name.'['.$name.'][]', '', 'value', 'text', $value, $control_name.$name );
	}
}

else : # Joomla 1.6+
jimport('joomla.form.formfield');
global $mainframe;
$mainframe = JFactory::getDocument();
class JFormFieldintosuggestforums extends JFormField  {
	var $_name = "intosuggest_forums";
	function getInput(){
		global $mainframe;
		$db = &JFactory::getDBO();
		$query = "SELECT `id` AS `value`, `name` AS `text` FROM  #__intosuggest_forum WHERE published=1";
		$db->setQuery($query);
		$forums = $db->loadObjectList();
//		echo '<pre>' . print_r( $forums, true ) . '</pre>';
		
		return JHTML::_('select.genericlist', $forums, $this->name, '', 'value', 'text', $this->value, "forums");
	}
}
endif;
?>
