<?php
 
if (isset($_REQUEST['name']) && $_REQUEST['name'] != "" )
{
	$name = $_REQUEST['name'];

	$checks = XN_Query::create ( 'Content' )->tag("ma_registerusers")
		->filter ( 'type', 'eic', 'ma_registerusers' )
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.name', '=', $name )
		->end(1)
		->execute ();

	if (count($checks) == 0)
	{
		echo '{"ok":"Pass"}';
	}
	else
	{
		echo '{"error":"'.$name.'已经注册"}';
	}

}  
?>