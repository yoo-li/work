<?php

echo '<input type="hidden" id="template_data" name="template_data" value="" />';

require_once('include/utils/utils.php');
global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

$tabid = getTabid($currentModule);
$record = $_REQUEST['record'];
if(isset($record) && $record !='') 
{

	 echo '<object id="ExpressFormDesigner" height="440" width="100%" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,29,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
	<param value="modules/'.$currentModule.'/Main.swf" name="movie">
	<param value="high" name="quality">
	<param value="transparent" name="wmode">
	<param name="bgcolor" value="#869ca7" />
	<param name="FlashVars" value="path=/modules/'.$currentModule.'/&record='.$record.'" />
	<param name="allowScriptAccess" value="sameDomain" />
	<embed name="ExpressFormDesigner" bgcolor="#869ca7" height="540" width="100%" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="modules/'.$currentModule.'/Main.swf" 	swliveconnect="true" 
	FlashVars="path=/modules/'.$currentModule.'/&record='.$record.'"
	>
	</object>';
}

?>