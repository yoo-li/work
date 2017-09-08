<?php
if (isset($_REQUEST['source']) && $_REQUEST['source'] == 'MainPage')
{
	$_SESSION['source'] = 'MainPage'; 
}
else
{
	$_SESSION['source'] = ''; 
}
include ('modules/Public/EditView.php');
?>