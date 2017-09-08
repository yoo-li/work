<?php
global $currentModule,$current_user,$readOnly;
$html = '<table class="table table-bordered table-hover table-striped" border="0" cellspacing="0" cellpadding="0"><tbody>';
if(isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != ""){
	$profileid = $_REQUEST["profileid"];
	$deliveraddress = XN_Query::create ( 'MainContent' ) ->tag('deliveraddress')
		->filter ( 'type', 'eic', 'deliveraddress') 
		->filter ( 'my.profileid', '=', $profileid) 
		->execute();
	foreach($deliveraddress as $info){
		if($html != "")
			$html .= '<tr><td style="text-align:left;" colspan="4"><b><b><div class="divider"></div></b></b></td></tr>';
		$html .= '
			<tr>
				<td> 收货人:</td><td>'.$info->my->consignee.'</td>
				<td> 联系电话:</td><td>'.$info->my->mobile.'</td>
			</tr>
			<tr>
				<td> 省份:</td><td>'.$info->my->province.'</td>
				<td> 城市:</td><td>'.$info->my->city.'</td>
			</tr>
			<tr>
				<td> 地址:</td><td colspan="3">'.$info->my->address.'</td>
			</tr>
		';
	}
}
$html .= '</tbody></table>';
echo $html;
?>