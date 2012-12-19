<?php

/**
 * @version		$Id: intosuggest.php 152 2011-03-12 06:19:57Z thongta $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe, $option, $obIsJ15, $obIsJ16, $obIsJ17;
$version = new JVersion();
$obIsJ15 = ($version->RELEASE == '1.5');
$obIsJ16 = ($version->RELEASE == '1.6');
$obIsJ17 = ($version->RELEASE == '1.7');

if (!$obIsJ15)
{
    $option = 'com_intosuggest';
    $mainframe = &JFactory::getApplication();
    jimport('joomla.html.parameter');
} else
{
    // Add MooTools v1.24
    JHTML::script('mt.js', 'components/com_intosuggest/assets/js/', false);
}

require_once(JPATH_COMPONENT . DS . 'helper' . DS . 'router.php');

require_once(JPATH_COMPONENT . DS . "controllers" . DS . "default" . ".php");

// pagination class
require_once(JPATH_COMPONENT . DS . "helper" . DS . 'class.pagination.php');
require_once(JPATH_COMPONENT . DS . "helper" . DS . 'libs.php');
if (!class_exists("JPane"))
    require_once(JPATH_LIBRARIES . DS . "joomla" . DS . "html" . DS . "pane.php");

$c = JRequest::getCmd('controller', 'default');
if (is_file(JPATH_COMPONENT . DS . "controllers" . DS . $c . ".php"))
    require_once(JPATH_COMPONENT . DS . "controllers" . DS . $c . ".php");
else
    $c = 'default';
require_once(JPATH_ADMINISTRATOR . DS . "components" . DS . $option . DS . "helpers" . DS . "themes.php");
$theme = new Themes();
$theme->setTheme();

$c = "Controller" . $c;
$controller = new $c;
$controller->execute(JRequest::getVar('task'), 'display');
$controller->redirect();

if ($obIsJ15)
{
    // Remove the original MooTools from J!1.5 with this very very dirty hack.
    
    $doc = JFactory::getDocument();
    // looking for scripts
    $headerstuff = $doc->getHeadData();
    $scripts = $headerstuff['scripts'];
    // clear the original scripts
    $headerstuff['scripts'] = array();
    // delete joomla version of mootools
    if($scripts != null) {
        foreach ($scripts as $url => $type)
        {
            if (strpos($url, 'js/mootools.js') === false && strpos($url, 'js/caption.js') === false)
            {
                $headerstuff['scripts'][$url] = $type;
            }
        }
        
        // set the new head data
        $doc->setHeadData($headerstuff);
    }
    
}
?>


