<?php
/**
 * @version		$Id: default.php 444 2012-03-27 03:49:13Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
#echo '<div class="intosuggest-feedback-'.$params->get('button_position').'"><a href="#">'.$params->get('button_label').'</a></div>';
$select_forums = $params->get('select_forums');
?>
<div id="intosuggest-feedback-container">
	<div class="intosuggest-feedback-bottom">
		<a href="<?php echo JRoute::_('index.php?option=com_intosuggest&forumId='.$select_forums);?>" class="intosuggest-feedback-button-bottom"></a>
	</div>
</div>