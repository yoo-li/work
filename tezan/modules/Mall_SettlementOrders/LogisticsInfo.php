<?php

if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ""){
    //require_once ('web/kuaidi.php');
    $recordid = $_REQUEST["record"];
	$query = XN_Content::load($_REQUEST["record"],'mall_settlementorders',7);
	$logisticsname = $query->my->delivery;
	$logistics = XN_Content::load($logisticsname,'logistics');
	$logisticsname = $logistics->my->logisticsname; 
	$invoicenumber = $query->my->invoicenumber;
	

	
	$html = '
		<table id="memberTab" class="table table-bordered" border="0" cellspacing="0" cellpadding="0" style="width:100%" name="memberTab">
			<tr>
				<th style="white-space: nowrap;"><b>路由时间</b></th>
				<th style="white-space: nowrap;width:75%;text-align: center;"><b>路由信息</b></th>
			</tr>	
	';
	global  $supplierid;
	
	$mall_logisticbills =   XN_Query::create ( 'YearContent' )->tag("mall_logisticbills_".$supplierid)
		->filter ( 'type', 'eic', 'mall_logisticbills' ) 
		->filter ( 'my.logisticbills_no', '=', $invoicenumber )
		->filter ( 'my.deleted', '=', '0' )
		->end(1)
		->order('published',XN_Order::DESC)
		->execute (); 
		
	if (count ( $mall_logisticbills ) > 0) 
	{ 	
		$mall_logisticbill_info = $mall_logisticbills[0];
		$mall_logisticroutes =   XN_Query::create ( 'YearContent' )->tag("mall_logisticroutes_".$supplierid)
			->filter ( 'type', 'eic', 'mall_logisticroutes' ) 
			->filter ( 'my.logisticbillid', '=', $mall_logisticbill_info->id )
			->filter ( 'my.deleted', '=', '0' )
			->end(-1)
			->order('published',XN_Order::DESC)
			->execute ();  
		if (count ( $mall_logisticroutes ) > 0) 
		{  
			foreach($mall_logisticroutes as $logisticroute_info)
			{ 
				$html .= '<tr"> 
					<td align="center" style="text-align: center;" width="20%">'.$logisticroute_info->published.'</td>
					<td style="text-align: center;" align="center" width="80%">'.$logisticroute_info->my->route.'</td>
				    </tr>'; 
			}
		}
		else
		{
				$html .= '
					<tr>
						<td align="left" colspan="2"><font color=red>等待物流公司更新信息！</font></td>
					</tr>
				';
		}
	}        
	else
	{
			$html .= '
				<tr>
					<td align="left" colspan="2"><font color=red>等待物流公司更新信息！</font></td>
				</tr>
			';
	}
	$html .= '</table>';
	echo $html;
}

?>