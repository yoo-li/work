<?php
global $currentModule;

try {
	$statistics = $_SESSION[strtoupper($currentModule.'_STATISTICS')];

	$query = unserialize(base64_decode($statistics)); 

	$statistics = $query->execute();
	if(count($statistics)>0)
	{
	    echo "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;应付金额合计：￥".$statistics[0]->my->amount . "&nbsp;&nbsp;&nbsp;&nbsp;实付金额合计：￥" . $statistics[0]->my->total_fee ."</font>";
 	} 
} 
catch (XN_Exception $e) 
{
    echo $e->getMessage()."<br>";
} 
?>
