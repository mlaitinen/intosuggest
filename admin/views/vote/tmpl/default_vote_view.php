<?php
/**
 * @version		$Id: default_vote_view.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<table width="100%">
	<tr>
		<td width="50%" valign="top">
			<?php echo $this->loadTemplate('vote_info'); ?>
		</td>
		<td valign="top">
			<?php echo $this->loadTemplate('vote_comments'); ?>
		</td>
	</tr>
</table>
