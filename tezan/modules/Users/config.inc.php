<?php/** * securitycheck:1表示不进行权限校验 */$Create = true;$Delete = true;$MassEdit = false;$CustomMassDelete = true;if (!function_exists('checkPasswordButton')) {	function checkPasswordButton($module,$focus) { 		 		if ($focus->mode == 'edit') {			return '<a  class="btn btn-default" data-toggle="dialog" data-icon="lock" data-mask="true" data-maxable="false" data-resizable="false" href="index.php?module=Users&amp;action=ChangePassword&amp;record='.$focus->id.'" > 修改密码</a>';			//return '<a fresh="false" height="180"  mask="true" target="dialog" href="index.php?module=Users&amp;action=ChangePassword&amp;record='.$focus->id.'" class="button" ><span>修改密码</span></a>';		}		else		{			return '<a disabled class="btn btn-default" data-icon="lock" href="javascript:;" > 修改密码</a>';		} 	}}if (!function_exists('ModifyUserName')) {    function ModifyUserName(){        global  $current_user;        if (is_admin($current_user))            return '<a href="index.php?module=Users&action=ModifyUserName" data-title="修改账号名称" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>修改账号名称</a>';        else            return "";    }}$actionmapping = array( 	array('actionname' => 'ChangePassword','securitycheck' => '1','type'=>'button','func'=>'checkPasswordButton'),	array('actionname' => 'ModifyUserName','securitycheck' => '1','func'=>'ModifyUserName','type'=>'listview'),    array('actionname' => 'Enable','securitycheck' => '1','func'=>'check_module_enable','type'=>'listview'),    array('actionname' => 'Disable','securitycheck'=>'1','func'=>'check_module_disable','type'=>'listview'),);if (!function_exists('check_module_enable')) {    function check_module_enable(){        global  $current_user;        if (is_admin($current_user))		{	        global $currentModule;	        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" href="index.php?module='.$currentModule.'&action=Enable" data-confirm-msg="确实要启用吗?"><span>启用</span></a>';					}		else		{			return "";		}    }}if (!function_exists('check_module_disable')) {    function check_module_disable(){        global  $current_user;        if (is_admin($current_user))		{	        global $currentModule;	        return '<a data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" href="index.php?module='.$currentModule.'&action=Disable" data-confirm-msg="确实要停用吗?"><span>停用</span></a>';	      		}		else		{			return "";		}     }}?>