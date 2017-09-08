<?php

if (!isset($_SESSION['LOGISTICS_ORDER_BY']) || $_SESSION['LOGISTICS_ORDER_BY'] == "")
{
	$_SESSION['LOGISTICS_ORDER_BY'] = "my.sequence";
}
if (!isset($_SESSION['LOGISTICS_SORT_ORDER']) || $_SESSION['LOGISTICS_SORT_ORDER'] == "")
{
	$_SESSION['LOGISTICS_SORT_ORDER'] = "asc";
}
 
	
	
require_once('Popup.php');
?>
