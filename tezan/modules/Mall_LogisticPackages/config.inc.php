<?php/** * securitycheck:1表示不进行权限校验 */$Create = false;$Delete = false; global $supplierid;if (isset($supplierid) && $supplierid != "0" ){	$Create = true;	$Delete = true; } 	if (!function_exists('check_SimulateApply')) {			function check_SimulateApply($module,$focus)	    {  			if ($focus->column_fields['author'] == XN_Profile::$VIEWER && $focus->column_fields['mall_logisticpackagesstatus'] == "JustCreated")			{ 					if($focus->column_fields['approvalstatus'] != '2')					{						return '<a class="btn btn-default" data-toggle="dialog" data-icon="lock" data-mask="true" data-maxable="false" data-resizable="false" href="index.php?module='.$module.'&amp;action=SimulateApply&amp;record='.$focus->id.'" class="button" ><span>提交上线</span></a>';	 				}					else					{						return '<a disabled class="btn btn-default" data-icon="lock" href="javascript:;" > 提交上线</a>';					}  			} 		}	}		if (!function_exists('isCanOn')) {	    function isCanOn(){	        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked"  href="index.php?module=Mall_LogisticPackages&action=enable" data-title="确实要启用吗?"><span>启用</span></a>';	    }	}	if (!function_exists('isCanOff')) {	    function isCanOff(){	        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked"  href="index.php?module=Mall_LogisticPackages&action=disable" data-title="确实要停用吗?"><span>停用</span></a>';	    }	}	if (!function_exists('check_packageprint')) {	    function check_packageprint($module,$focus) {	        if ($focus->mode == 'edit' )	        { 				 return '<a class="btn btn-default" data-title="打印线路标签" href="javascript:;"  onclick="logisticpackage_print(\''.$focus->id.'\');"><span>打印线路标签</span></a>';		    } 	    }	}			$actionmapping = array (   		array('actionname' => 'BarCode','securitycheck' => '1','type'=>'ajax','location'=>'bottom'),		array('actionname' => 'QrCode','securitycheck' => '1','type'=>'ajax','location'=>'bottom'),			    array('actionname' => 'enable','securitycheck' => '1','func'=>'isCanOn','type'=>'listview'),	    array('actionname' => 'disable','securitycheck'=>'1','func'=>'isCanOff','type'=>'listview'),		array('actionname' => 'SimulateApply','securitycheck' => '1','type'=>'button','func'=>'check_SimulateApply'),		array('actionname' => 'PackagePrint','securitycheck' => '1','type'=>'button','func'=>'check_packageprint'),	);?>