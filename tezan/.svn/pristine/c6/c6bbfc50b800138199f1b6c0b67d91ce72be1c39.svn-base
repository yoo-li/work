<?php

echo '<input type="hidden" id="flowdata" name="flowdata" value="" />';

require_once('include/utils/utils.php');
global $currentModule;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');

$tabid = getTabid($currentModule);
$record = $_REQUEST['record'];
if(isset($record) && $record !='') 
{

	 echo '<object id="WorkFlowDesigner" height="340" width="100%" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,29,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
	<param value="modules/'.$currentModule.'/WorkFlowDesigner.swf" name="movie">
	<param value="high" name="quality">
	<param value="transparent" name="wmode">
	<param name="bgcolor" value="#869ca7" />
	<param name="FlashVars" value="tabid='.$tabid.'&tabname='.$currentModule.'&record='.$record.'" />
	<param name="allowScriptAccess" value="sameDomain" />
	<embed name="WorkFlowDesigner" bgcolor="#869ca7" height="340" width="100%" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="modules/'.$currentModule.'/WorkFlowDesigner.swf" 	swliveconnect="true" 
	FlashVars="route=1&tabid='.$tabid.'&tabname='.$currentModule.'&record='.$record.'"
	>
	</object>';
}

?>