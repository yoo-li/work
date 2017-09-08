<?php
global $currentModule;
session_start(); 
try {
	$statistics = $_SESSION[strtoupper($currentModule.'_STATISTICS')];

	$query = unserialize(base64_decode($statistics)); 

	$statistics = $query->execute();
	if(count($statistics)>0)
	{
		
		$sumorderstotal = $statistics[0]->my->sumorderstotal;
		$paymentamount = $statistics[0]->my->paymentamount;
		$usemoney = $statistics[0]->my->usemoney; 
        echo "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;总额合计：￥".$sumorderstotal . "&nbsp;&nbsp;&nbsp;&nbsp;实际支付：￥" . $paymentamount ."&nbsp;&nbsp;&nbsp;&nbsp;余额支付：￥" . $usemoney ."</font>";
  	} 
	else
	{
        echo "<font color=blue>&nbsp;&nbsp;&nbsp;&nbsp;总额合计：￥0.00&nbsp;&nbsp;&nbsp;&nbsp;实际支付：￥0.00&nbsp;&nbsp;&nbsp;&nbsp;余额支付：￥0.00</font>";
 
	}
} 
catch (XN_Exception $e) 
{
    echo $e->getMessage()."<br>";
} 
?>
