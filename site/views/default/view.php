<?php
/**
 * @version		$Id: view.php 294 2011-04-02 08:47:19Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');

class ViewDefault extends JView {
	function __construct() {
		parent::__construct();
	}
	
	function display($tmp = null) {

        $output = $this->get('Output');
		$model 		= &$this->getModel('default');
		$forum_id 	= $model->getForumId();
		$gconfig 	= $this->get('gconfig');
        
        $tabs = Forum::getTabForumById($forum_id);

		#TODO: load script và style cho vote box
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
		
		$this->assignRef('gconfig',$gconfig);
		
		$model_idea = &$this->getModel('idea');
		$limit = &JRequest::getVar('limit', 5);
		$limitstart = &JRequest::getVar('limitstart', 0);
		$model_idea->setLimitstart($limitstart);
		$model_idea->setLimit($limit);
		$tab = &JRequest::getVar( 'tab', 0);

        $idea_output 	= $model_idea->getOutput();
        $status         = $model_idea->getStatus();
        $forum_id 		= $model_idea->getForumId();
        $ideas 			= $model_idea->getIdeas($tab);
        $total 			= $model_idea->total;
        $cur_page 		= JRequest::getVar( "page", 1 );
        $this->assign( 'datetime_format', $model_idea->getDatetimeConfig() );

        if($total) {
            $pagin = new JPagination($total, $limitstart, $limit);
            $pagination = $pagin->getListFooter();
            $pagination = '<div class="pagination">'
                    .'<p class="counter">'.$pagin->getPagesCounter().'</p>'
                    .$pagin->getPagesLinks().'</div>';
        } else {
            $pagination = "";
        }
		
		$user = &JFactory::getUser();
		$user_id = $user->id;
        
        $remainingpoints = array();
        $forums = Forum::getAllForum();
        foreach ($forums as $forum) {
            $rempo = Forum::getRemainingPoint($forum->id, $user_id);
            $remainingpoints[$forum->id] = $rempo;
        }
        $this->assignRef( 'remainingpoints', $remainingpoints );
        
        $search = 0;
        $this->assignRef( 'total', $total);
        $this->assignRef( 'ideas',	$ideas);
        $this->assignRef( 'idea_output', $idea_output );	
        $this->assignRef( 'search',$search);	
        $this->assignRef( 'pagination', $pagination);
		$this->assignRef( 'forum_id', $forum_id );
		$this->assignRef( 'status', $status );
		$this->assignRef( 'output', $output );
        $this->assignRef( 'tabs',   $tabs);
		parent::display( $tmp );
	}
	function dispComment($tmp = null) {
		$status = $this->get('Status');
		$idea = $this->get('Idea');
		$page = $this->get('Page');
		$comments = $this->get('Comment');
		
		$page = 1;
		$this->assign('SearchCount',100);
		$this->assignRef('status',$status);
		$this->assignRef('page',$page);
		$this->assignRef('idea',$idea);
		$this->assignRef('comment',$comments);
			
		parent::display($tmp);
	}
	
	function dispTabs($tmp = null) {	
		$model = &$this->getModel('default');
		$forum_id = $model->getForumId();
		$this->assignRef('forum_id',$forum_id);	
		parent::display($tmp);
	}
	function getKeySearch(){
		return $this->output->forum->example;	
	}
}
?>
