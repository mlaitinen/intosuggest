<?php
/**
 * @version		$Id: default_forum_add.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

#$forum_id = $this->output->forum->id;
$forum_id = 0;
?>
<form name="adminForm" id="adminForm" action="index.php?option=com_intosuggest&controller=forum&id=<?php echo $forum_id ?>" method="POST">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" valign="top">
			<?php echo $this->loadTemplate('forum_info'); ?>
		</td>
		<td width="50%" valign="top">
			<?php echo $this->loadTemplate('forum_status'); ?>
		</td>
	</tr>		
</table>
<input type="hidden" name="task" value="addForum">
</form>
