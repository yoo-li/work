<?php$Create = false;$Delete = false;$MassEdit = false;$CustomMassDelete = false;global $supplierid;if (isset($supplierid) && $supplierid != "0" ){	$Create = true;	$Delete = true; } if (!function_exists('check_SimulateApply')) {	function check_SimulateApply($module,$focus)    { 		if ($focus->column_fields['author'] == XN_Profile::$VIEWER && $focus->column_fields['mall_officialenterprisecurrencysstatus'] == "JustCreated")		{ 				if($focus->column_fields['approvalstatus'] != '2')				{					return '<a class="btn btn-default" data-toggle="dialog" data-icon="lock" data-mask="true" data-maxable="false" data-resizable="false" href="index.php?module='.$module.'&amp;action=SimulateApply&amp;record='.$focus->id.'" class="button" ><span>提交上线</span></a>'; 				}				else				{					return '<a disabled class="btn btn-default" data-icon="lock" href="javascript:;" > 提交上线</a>';				}  		} 	}}if (!function_exists('isCanOn')) {    function isCanOn(){        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" href="index.php?module=Mall_OfficialEnterpriseCurrencys&action=enable" ><i class="fa fa-edit"></i>启用</a>';    }}if (!function_exists('isCanOff')) {    function isCanOff(){        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked"  href="index.php?module=Mall_OfficialEnterpriseCurrencys&action=disable"><span>停用</span></a>';    }}$actionmapping = array (  array('actionname' => 'enable','securitycheck' => '1','func'=>'isCanOn','type'=>'listview'),array('actionname' => 'disable','securitycheck'=>'1','func'=>'isCanOff','type'=>'listview'),array('actionname' => 'SimulateApply','securitycheck' => '1','type'=>'button','func'=>'check_SimulateApply'),);	  ?>