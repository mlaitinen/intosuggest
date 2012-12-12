<?php
/**
 * @version		$Id: default_forums.php 272 2011-03-31 04:12:52Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="forum-select">
	<div>
<?php
	$forum_id = $this->output->forum->id;
	$listForum = Forum::getAllForum();				
	if (count($listForum)) {
		foreach ($listForum as $obj){
			$listsF[]  = JHTML::_("select.option", $obj->id, $obj->name, "id", "name");
		}
	}
	if(count($listsF))
	{
		if ($this->output->config->listbox == 1) {
            $listsFSlct = JHTML::_('select.genericlist',  $listsF, 'forumId', 'class="inputbox" size="1" onchange="changepage();"', 'id', 'name', $forum_id);
			echo $listsFSlct;
		} else {
            echo "<input type='hidden' name='forumId' id='forumId' value='$forum_id' />";
        }
	}
?>
	</div>
	<div class="clear_both"></div>
</div>