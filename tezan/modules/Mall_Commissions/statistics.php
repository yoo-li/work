<?php
global $currentModule;

try {
	$statistics = $_SESSION[strtoupper($currentModule.'_STATISTICS')];

	$query = unserialize(base64_decode($statistics)); 

	$statistics = $query->execute();
	if(count($statistics)>0)
	{
	    echo "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;消费金額总计：".$statistics[0]->my->totalprice . "，提成金額总计：".$statistics[0]->my->amount . "</font>";

 	} 
} 
catch (XN_Exception $e) 
{
    echo $e->getMessage()."<br>";
} 
?>
