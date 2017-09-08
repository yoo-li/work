<?php
global $currentModule,$current_user,$readOnly;
$html = '<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0"><tbody>';
if(isset($_REQUEST["profileid"]) && $_REQUEST["profileid"] != ""){
	$profileid = $_REQUEST["profileid"];
	$deliveraddress = XN_Query::create ( 'MainContent' ) ->tag('deliveraddress')
		->filter ( 'type', 'eic', 'deliveraddress') 
		->filter ( 'my.profileid', '=', $profileid) 
		->execute();
	foreach($deliveraddress as $info){
		if($html != "")
			$html .= '<tr class="edit-form-tr"><td class="edit-form-tdlabel" style="text-align:left;" colspan="4"><b><b><div class="divider"></div></b></b></td></tr>';
		$html .= '
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory"> 收货人:</td><td class="edit-form-tdinfo">'.$info->my->consignee.'</td>
				<td class="edit-form-tdlabel mandatory"> 联系电话:</td><td class="edit-form-tdinfo">'.$info->my->mobile.'</td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory"> 省份:</td><td class="edit-form-tdinfo">'.$info->my->province.'</td>
				<td class="edit-form-tdlabel mandatory"> 城市:</td><td class="edit-form-tdinfo">'.$info->my->city.'</td>
			</tr>
			<tr class="edit-form-tr">
				<td class="edit-form-tdlabel mandatory"> 地址:</td><td class="edit-form-tdinfo" colspan="3">'.$info->my->address.'</td>
			</tr>
		';
	}
}
$html .= '</tbody></table>';
echo $html;
?>