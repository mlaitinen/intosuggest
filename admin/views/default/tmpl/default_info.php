<?php
/**
 * @version		$Id: default_info.php 341 2011-06-04 09:47:01Z phonglq $
 * @package		oblangs - Suggestion extension for Joomla.
 * @copyright	(C) 2007-2011 foobla.com. (C) 2012 Miku Laitinen. All rights reserved.
 * @author		foobla.com
 * @license		GNU/GPL, see LICENSE
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'media.php' );
$checkversion	=	&MediaHelper::getVersion();
$version	=	$checkversion['version'];
?>
<div style="padding: 7px 15px 0;">
	<table class="adminform" border="1">
		<tr>
			<td valign="top"><strong>Installed Version</strong></td>
			<td><strong><?php echo $version; ?></strong></td>
		</tr>
		
		<tr>
			<td valign="top"><strong>Copyright</strong></td>
			<td>Copyright (C) 2007-2012 <a href="http://foobla.com" target="_blank">foobla.com</a>. <br />
            Copyright (C) 2012 <a href="https://github.com/mlaitinen/intosuggest" target="_blank">Miku Laitinen</a>.<br />
            All rights reserved.</td>
		</tr>
		
		
		<tr>
			<td valign="top"><strong>License</strong></td>
			<td>GNU/GPL</td>
		</tr>
		
		<tr>
			<td valign="top"><strong>Credits</strong></td>
			<td><strong>obSuggest (the original component):</strong><br />
				<ul style="margin: 0; padding-left: 15px;">
					<li><strong>Phong Lo</strong> (developer)</li>
					<li><strong>Thong Tran</strong> (the product manager)</li>
				</ul><br />
                <strong>IntoSuggest:</strong>
                <ul style="margin: 0; padding-left: 15px;">
					<li><strong>Miku Laitinen</strong> (developer)</li>
				</ul>
			</td>
		</tr>
	</table>
</div>
