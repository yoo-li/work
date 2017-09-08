<?php
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
{
	$record = $_REQUEST['record'];
	$upload = XN_Content::load($record,"attachments");
	$upload->my->deleted = "1";
	$upload->save("attachments");
}

echo 'SUCCESS';

?>






