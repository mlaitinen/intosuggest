<?php
/**
 * @version		$Id: default_backlink.php 272 2011-03-31 04:12:52Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="text_align_right"><a href="<?php echo JRoute::_( 'index.php?option=com_intosuggest&forumId='.$this->forum_info->id ); ?>"><b>[<?php echo JText::_("Back")?>]</b></a></div>