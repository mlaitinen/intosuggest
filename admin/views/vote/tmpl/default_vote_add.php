<?php
/**
 * @version		$Id: default_vote_add.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title( JText::_( 'Vote value' ).': <small><small>['.JText::_('Add').']</small></small>', 'vote.png' );?>
<?php JToolBarHelper::save();?>
<?php //JToolBarHelper::apply();?>
<?php JToolBarHelper::cancel();?>
<script>
	function submitbutton(pressbutton){
		var form = document.adminForm;
		if(pressbutton == 'cancel'){
			submitform(pressbutton);
			return ;
		}else
			if (isNaN(form.vote_value.value) || form.vote_value.value == ""){
				alert('<?php echo JText::_('Please! Enter a number for vote')?>');
			} else
				submitform(pressbutton);
	}
</script>
<form name="adminForm" action="index.php?option=com_intosuggest&controller=vote" method="POST">
<table width="100%">
	<tr>
		<td valign="top" width="60%">
			<fieldset class="adminForm">
			<legend> <?php echo JText::_('Vote value')?> </legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('Vote value')?>:</td>
					<td>
						<input class="text_area" type="text" name="vote_value" id="vote_value"	size="10" maxlength="5"/>
					</td>
				</tr>
				<tr>
					<td class="key"><?php echo JText::_('Published')?></td>
					<td><?php 
						$published[] = JHTML::_('select.option', 0, JText::_('No'),'id','title');
						$published[] = JHTML::_('select.option', 1, JText::_('Yes'),'id','title');
						echo  JHTML::_('select.genericlist',  $published, 'published', 'class="inputbox" size="1"', 'id','title', 0);
						?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key"><?php echo JText::_('Note')?>:</td>
					<td>
						<textarea rows="2" cols="35" name="title" id="title"></textarea>
					</td>
				</tr>
			</table>
			</fieldset>	
		</td>				
	</tr>
</table>
<input type="hidden" name="task" value="" />
<input type="hidden" name="tmp" value="add" />
</form>
