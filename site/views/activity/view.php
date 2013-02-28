<?php
/**
 * @version		$Id: view.php 238 2011-03-25 12:17:30Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class ViewActivity extends JView {
	function __construct() {
		parent::__construct();
	}
	
	function display($tmp = null) {
		// status of idea
		//$status = $this->get('Status');
		
		// list of ideas
		$ideas = $this->get('Ideas');
		
		// list of comments
		$comments = $this->get('Comments');		
		
		// num of ideas
		$sumideas = $this->get('NumIdeas');
		
		//  num of comments
		$sumcomments = $this->get('NumComments');
		
		// some infomation...
		$output = $this->get('Output');
		
		// is not search
		$search = 0;
		
		// get cuurent page
		$page = JRequest::getInt("page", 1);
		
		// model instance
		$model = &$this->getModel('activity');
		
		$user = $model->getUser($model->user_id);			
		if(!$user)
		{
			global $mainframe, $option;
			$mainframe->redirect(JRoute::_("index.php?option=$option"));
			
		}
		if($sumideas>10)
		{
			$pagination = new Paging($sumideas, $page, 10, ("index.php?option=com_intosuggest&controller=activity&task=displayIdeas&format=raw&user_id=" . $model->user_id));		
			$pagination = $pagination->getPagination();
		}
		else 
			$pagination = "";
		
		if($sumcomments>10)	
		{
			$pageComment = new Paging($sumcomments, $page, 10, "index.php?option=com_intosuggest&controller=activity&format=raw&task=displayComments&user_id=" . $model->user_id);		
			$pageComment =  $pageComment->getPagination();
		}
		else $pageComment = "";
		
		// assign some variable
		
		$this->assignRef("pagination", $pagination); // pagination ideas
				
		$this->assignRef("pageComment", $pageComment); // pagination comments
		$this->assign('datetime_format', $model->getDatetimeConfig());
		$this->assignRef('status',$status);	
		$this->assignRef('total', $sumideas)	;
		$this->assignRef('user',$user);
		$this->assignRef('ideas',$ideas);
	
		$this->assignRef('comments',$comments);
		$this->assignRef('search',$search);
		$this->assignRef('sumideas',$sumideas);
		$this->assignRef('sumcomments',$sumcomments);
        
        $gconfig 	= $this->get( 'gconfig' );
        $this->assignRef('gconfig', $gconfig);
        
        $document 		= &JFactory::getDocument();
		$votebox_layout = isset($gconfig['votebox']->value) ? $gconfig['votebox']->value : 'default.php';
		$cssfile = JPATH_COMPONENT_SITE.DS.'vote_boxs'.DS.substr($votebox_layout, 0, -4).'.css';
		$jsfile = JPATH_COMPONENT_SITE.DS.'vote_boxs'.DS.substr($votebox_layout, 0, -4).'.js';
		if(JFile::exists($cssfile)) {
			$document->addStyleSheet('components/com_intosuggest/vote_boxs/'.substr($votebox_layout, 0, -4).'.css');
		}
		if(JFile::exists($jsfile)) {
			$document->addScript('components/com_intosuggest/vote_boxs/'.substr($votebox_layout, 0, -4).'.js');
		}
		
		$this->assignRef('output',$output);
		
		parent::display($tmp);
	}
	
	/**
	 * we use AJAX to call this function and get the content of idea and paging it!
	 *
	 */
	function displayIdeas()
	{
		// idea status
		$status = $this->get('Status');
		
		// list of ideas
		$ideas = $this->get('Ideas');
	
		// num of idea
		$sumideas = $this->get('NumIdeas');

		// some infomation
		$output = $this->get('Output');
		
		// is not search
		$search = 0;
		
		// get current page
		$page = JRequest::getInt("page", 1);
		
		// model instance
		$model = &$this->getModel('activity');
		
		$user = $model->getUser($model->user_id);
		if(!$user)
		{
			global $mainframe, $option;
			$mainframe->redirect(JRoute::_("index.php?option=$option"));
			
		}
		// add the path template to search
		$this->_addPath( 'template', JPATH_COMPONENT.DS.'views'.DS. 'idea'.DS.'tmpl' ); 		
		if($sumideas>10)
		{
			$pageIdea = new Paging($sumideas, $page, 10, "index.php?option=com_intosuggest&controller=activity&format=raw&task=displayIdeas&user_id=" . $model->user_id);		
			$pageIdea = $pageIdea->getPagination();
		}else
		{
			$pageIdea = "";
		}						
		// assign some variable
		$this->assignRef("pagination", $pageIdea);
		$this->assignRef('status',$status);	
		$this->assignRef('total', $sumideas)	;
		$this->assignRef('user',$user);
		$this->assignRef('ideas',$ideas);		
		$this->assignRef('search',$search);
		$this->assignRef('sumideas',$sumideas);		
		$this->assignRef('output',$output);
        
        $gconfig 	= $this->get( 'gconfig' );
        $this->assignRef('gconfig', $gconfig);
		
		// only display content of the ideas
		parent::display("ideas");
	}
	
	/**
	 * we use AJAX to call this function and get the content of comment and paging it!
	 *
	 */
	function displayComments($tmp = null) {
		
		// list comments
		$comments = $this->get('Comments');		

		// sum of comments
		$sumcomments = $this->get('NumComments');
		
		// sum infomation
		$output = $this->get('Output');
		
		// not is search
		$search = 0;
		
		$model = &$this->getModel('activity');
		$user = $model->getUser($model->user_id);			
		if(!$user)
		{
			global $mainframe, $option;
			$mainframe->redirect(JRoute::_("index.php?option=$option"));
			
		}
		$page = JRequest::getVar("page", 1)	;
		if($sumcomments>10)
		{
			$pageComment = new Paging($sumcomments, $page, 10, "index.php?option=com_intosuggest&controller=activity&format=raw&task=displayComments&user_id=" . $model->user_id);		
			$pageComment =  $pageComment->getPagination();
		}
		else
		{
			$pageComment = "";
		}
		// assign some variables
		$this->assignRef('status',		$status);	
		$this->assignRef('user',		$user);
		$this->assignRef('comments',	$comments);
		$this->assignRef('search',		$search);
		$this->assignRef('sumcomments',	$sumcomments);	
		$this->assignRef('output',		$output);
		$this->assignRef("pageComment", $pageComment);
        
        $gconfig 	= $this->get( 'gconfig' );
        $this->assignRef('gconfig', $gconfig);
		
		$this->_addPath( 'template', JPATH_COMPONENT.DS.'views'.DS. 'comment'.DS.'tmpl' ); 
		$this->loadTemplate("comment");

		// only need content of the comment
		parent::display("comment_activity");
	}
	function getUser($_user_id) {
		$model = $this->getModel('activity');
		return $model->getUser($_user_id);
	}
	public function getUserVoteIdea($_idea_id) {
		$model = $this->getModel('activity');
		$rs = $model->getUserVoteIdea($_idea_id);
		if ($rs != NULL)
			return $rs->vote;
		else return 0;
	}
	function canResponse(){
		return (($this->output->permission->response_idea_a == 1) || (($this->output->permission->response_idea_o == 1) && ($this->output->user->id == $idea->user_id)));	
	}
	function getIdeaId(){
		$idea = $this->ideas[$this->current_idea];
		return $idea->id;
	}
	function displayBox($box){
		$idea = $this->ideas[$this->current_idea];	
		$user = $this->getUser($idea->user_id); ;	
		switch ($box){
			case 'TITLE':
				echo '<a href="'.JRoute::_('index.php?option=com_intosuggest&controller=comment&idea_id='.$idea->id).'" id="title'.$idea->id.'">'.$idea->title.'</a>';
                	
				break;
			case 'CURRENTSTATUS':
				echo '
					<div id="status_title_' . $idea->id . '" class="' . 
						($idea->status ? str_replace(" ", "_",strtolower($idea->status)) : "none") .'">'.
						JText::_($idea->status ? $idea->status : 'No status').'</div>'.
					'';
				break;
			case 'CONTENT':
				echo '
					<div class="box-content" id="idea'.$idea->id.'">';
            		$content = htmlspecialchars_decode($idea->content); // convert quote to html tag
            		$content = strip_tags($content); // remove html tag
            		if(JRequest::getString("controller")=='comment')
            		{
            			echo $content;
            		}
            		else {
            			$content = Idea::cutString($content, 100);
            			echo $content['string'];
            		}
            	echo '</div>';
            	break;
			case 'USERNAME':
				$date = JHTML::_('date', strtotime($idea->createdate), JText::_('DATE_FORMAT_LC2'));
				if ($user->name != "anonymous") {
					$username = '<a href="'.JRoute::_(IntoSuggestHelperRouter::addItemId('index.php?option=com_intosuggest&controller=activity&user_id='.$idea->user_id)).'">'.$user->name.'</a>';
				} else { 
					$username = '<a href="javascript:void(0)">'.JText::_("anonymous ").'</a>';
				}
                
                echo JText::sprintf("CREATED_ON_DATE_BY_USER", $date, $username);
                
				break;
			case 'DATECREATED':
				break;	
			case 'BOXVOTE':
				$votebox = isset( $this->gconfig['votebox']->value ) ? $this->gconfig['votebox']->value : 'default.php' ;
				require JPATH_COMPONENT_SITE.DS.'vote_boxs'.DS.$votebox;

				break;
			case 'COMMENTCOUNT':
            	$idea_comment = Idea::getComments($idea->id);
	            ?>             
	            	<?php echo $idea_comment;
                    $comment_count_text = JText::_($idea_comment == 1 ? 'COMMENT_COUNT_SINGULAR' : 'COMMENT_COUNT_PLURAL'); ?>
	            	<a class="comment_text" href="<?php echo JRoute::_('index.php?option=com_intosuggest&controller=comment&idea_id='.$idea->id)?>"> <?php echo $comment_count_text; ?></a>	            	          
				<?php 
				break;
			case 'READMORE':
				$content = htmlspecialchars_decode($idea->content); // convert quote to html tag
        		$content = strip_tags($content); // remove html tag
        		$content = Idea::cutString($content, 100);
				if (isset($content['overflow']) && JRequest::getString('controller')!='comment') {
	            ?>
	            	<a class="read-more" href="index.php?option=com_intosuggest&controller=comment&idea_id=<?php echo $idea->id?>">Read more</a>	            	
	            <?php 
				}
				break;			
			case 'ACTIONS':
				?>
				<a id="frm_Edit_<?php echo $idea->id?>" href="<?php echo JRoute::_('index.php?option=com_intosuggest&controller=idea&task=editIdea&id='.$idea->id.'&format=raw')?>" rel="{handler: 'iframe',size: {x: 418, y: 310}}"></a> 
                <?php 
                    $edit = '';
                    if (
                        ($this->output->permission->edit_idea_a == 1) || 
                        (($this->output->permission->edit_idea_o == 1) && ($this->output->user->id == $idea->user_id))) 
                    {
                        //$edit = '<option value="onedit(\''.$idea->id.'\')">'.JText::_("Edit").'</option>';//  onClick="onedit(<?php echo $idea->id; 
                    	$edit='<input type="button" value="'.JText::_("Edit").'" onclick="onedit(\''.$idea->id.'\')">';
                    }
                ?>
                <?php 
                    $delete = '';
                    if (
                        ($this->output->permission->delete_idea_a == 1) || 
                        (($this->output->permission->delete_idea_o == 1) && ($this->output->user->id == $idea->user_id))
                    ) 
                    {
                        //delete = '<option value="ondel(\''.$idea->id.'\')">'.JText::_("Delete").'</option>';
                        $delete='<input type="button" value="'.JText::_("Delete").'" onclick="ondel(\''.$idea->id.'\')">';
                    }
                ?>
                <?php 
                    if( $edit!='' || $delete != '')
                    {
                ?>	
                    <!--<input type="button" value="Action" onClick="eval(document.getElementById('sl_<?php echo $idea->id?>').value)" />
                    <select id="sl_<?php echo $idea->id?>">-->
                        <?php echo $edit?>
                        <?php echo $delete?>
                    <!--</select>-->
                <?php 
                    }
                ?> 
				<?php 
				break;
			case 'CHANGESTATUS'	:
				?>
				<?php 
                if (
                    ($this->output->permission->change_status_a == 1) || 
                    (($this->output->permission->change_status_o == 1) && ($this->output->user->id == $idea->user_id))
                ) 
                {
                
                    echo JText::_('CHANGE_STATUS');
                ?>
                    <select onchange="updateIdeaStatus(<?php echo $idea->id?>,this.value)" >
                        <option selected="selected" value="0"><?php echo JText::_('STATUS_NO_STATUS'); ?></option>
                        <?php 
                        foreach ($this->status as $parent ) {
                            if($parent->parent_id==-1)
                            {
                                echo '<optgroup label="'.JText::_($parent->title).'">';
                                foreach($this->status as $child)
                                {		
                                    if($child->parent_id != $parent->id) continue;																										
                                    if ($child->id == $idea->status_id) {
                                        echo '<option value="'.$child->id.'"  selected="selected" class="'.str_replace(" ", "_",strtolower($idea->status)).'">' . JText::_($child->title) . '</option>';
                                    }		
                                    else
                                    {
                                        echo '<option value="'.$child->id.'">' . JText::_($child->title) . '</option>';
                                    }		
                                }						
                                echo '</optgroup>';
                            }													
                        }
                        ?>
                    </select>
                <?php 
                }
                ?>
				<?php 
				break;
			case 'ADDRESPONSE':
				break;
			case 'EDITRESPONSE':
				break;	
			case 'RESPONSE':
				?>				
            	<input type="hidden" name="_cache_rps_content<?php echo $idea->id; ?>" id="cache_rps_content<?php echo $idea->id; ?>" value="<?php echo $idea->response;?>" />
            	<div class="border" id="rps<?php echo $idea->id; ?>">	
				<?php 
				$can_response = (($this->output->permission->response_idea_a == 1) || (($this->output->permission->response_idea_o == 1) && ($this->output->user->id == $idea->user_id)));			
				if ($idea->response != NULL ) 
				{ 
				?>										
					<div id="rps-title<?php echo $idea->id; ?>" class="rs_title"><?php echo JText::_('ADMIN_RESPONSE')?></div>
					<div id="rps-content<?php echo $idea->id; ?>" class="rs_content"><?php echo $idea->response;?></div>
				<?php 			
					if ($can_response) 
					{
					?> 
						<a  class="rs_edit" href="javascript:void(0);" onClick="addRepose('rps<?php echo $idea->id; ?>')">- <?php echo JText::_("edit")?></a>
					<?php 
					}
					?>
					
				<?php
				} else {
				?>
					
				<?php 
				if ($can_response) {?>
					<a href="javascript:addRepose('rps<?php echo $idea->id; ?>')" class="rs_add"><?php echo JText::_("ADD_RESPONSE")?></a> 
				<?php }?>
				
					
				<?php 
				} ?>			
	            </div> 
	            <?php 
				break;
			default:
				echo "No content";	
		}
	}
}
?>
