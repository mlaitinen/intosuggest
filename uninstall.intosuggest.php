<?php
/**
 * @version		$Id: uninstall.intosuggest.php 357 2011-07-01 10:56:03Z phonglq $
 * @package		IntoSuggest - Yet another suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.installer.installer');
$database = &JFactory::getDBO();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_account`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP uv_section</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_comment`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP vote</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_config`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP comment</h1>".$database->getErrorMsg();

$qry =	"DROP TABLE IF EXISTS `#__intosuggest_forum`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP idea</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_idea`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP status</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_permission`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP permission</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_status`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP Status</h1>".$database->getErrorMsg();

$qry =	"DROP TABLE IF EXISTS `#__intosuggest_tab`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP Tab</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_vote`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP Vote</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_votes_value`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP Votes value</h1>".$database->getErrorMsg();

$qry = "DROP TABLE IF EXISTS `#__intosuggest_forum_article`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP forum_article</h1>".$database->getErrorMsg();    	
    
$qry = "DROP TABLE IF EXISTS `#__intosuggest_datetime_config`";
	$database->setQuery($qry);
	$database->query();
	if(!$database->query())
    	echo "<h1>1.DROP forum_article</h1>".$database->getErrorMsg();     
# uninstall module   	
$module_installer = new JInstaller;
$jversion = new JVersion();
$sversion = substr( $jversion->getShortVersion(), 0, 3 );

$db = &JFactory::getDBO();
$exts = array();
if($sversion == '1.6'){
	
} else {
	//----------------------------------------------------------------------
	// Uninstall modules and plugins of IntoSuggest component on Joomla 1.5
	//----------------------------------------------------------------------
	#TODO: get suggest modules 
	$sql = "SELECT id, module FROM #__modules WHERE module = 'mod_intosuggest_forums' OR module='mod_intosuggest_quicksuggest'";
	$db->setQuery($sql);
	$modules = $db->loadObjectList();
	
	if($modules) {
		$exts['module'] = array();
		foreach ( $modules as $module ) {
			if(isset($exts['module'][$module->module])) continue;
			$installer0 = new JInstaller();
			$res = $installer0->uninstall('module', $module->id, 0);
			$exts['module'][$module->module] = $res;
		}
	}

	#TODO: uninstall plugins
	$sql = "SELECT `id`, `element`, `folder` FROM #__plugins WHERE (element = 'intosuggest_feedback' AND folder='system') OR (element='intosuggest' AND folder='search')";
	$db->setQuery($sql);
	$plugins = $db->loadObjectList();

	if( $plugins ) {
		$exts['plugin'] = array();
		foreach ( $plugins as $plugin ) {
			if(isset($exts['plugin'][$plugin->element])) continue;
			$installer0 = new JInstaller();
			$res = $installer0->uninstall('plugin', $plugin->id, 0);
			$exts['plugin'][$plugin->element] = $res;
		}
	}
	
//	echo '<pre>'.print_r( $exts, true ).'</pre>';
}

//--------------------------------------------------------------------------------
// Display Table Uninstall status of modules and plugins of IntoSuggest
//--------------------------------------------------------------------------------
if( $exts ){
?>
<table class="adminlist">
	<thead>
		<tr>
			<td>Extension</td>
			<td>Client</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody>
	<?php 
	$keys = array_keys($exts['module']);
	foreach( $keys as $key) { ?>
		<tr>
			<td>Module: <?php echo $key; ?></td>
			<td>Site</td>
			<td><?php echo ($exts['module'][$key]) ? 'Uninstalled' : 'Error on uninstall'; ?></td>
		</tr>
	<?php 
	} ?>
	<?php 
	$keys = array_keys($exts['plugin']);
	foreach( $keys as $key) { ?>
		<tr>
			<td>Plugin: <?php echo $key; ?></td>
			<td>Site</td>
			<td><?php echo ($exts['plugin'][$key]) ? 'Uninstalled' : 'Error on uninstall'; ?></td>
		</tr>
	<?php 
	} ?>
	</tbody>
</table>
<?php 
} ?>