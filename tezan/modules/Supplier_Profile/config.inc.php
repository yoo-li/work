<?php/** * securitycheck:1表示不进行权限校验 */$Create=false;$Delete = false;$addlink = false;$ExportExcel = false;$CustomMassDelete = false;if(!function_exists('tofrozenlist_func')){	function tofrozenlist_func(){        global  $supplierid,$supplierusertype;        if (isset($supplierid) && $supplierid != "" )            return '<a href="index.php?module=Supplier_Profile&action=ToFrozenList&ope=reason" data-height="300" data-width="450" data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true  data-title="确定拉入冻结名单？">拉入冻结名单</a>';        else            return "";			}}if(!function_exists('addmoney_func')){	function addmoney_func(){        global  $supplierid,$supplierusertype;        if (isset($supplierid) && $supplierid != "" && $supplierusertype=='boss')            return '<a href="index.php?module=Supplier_Profile&action=AddMoney&ope=reason" data-height="300" data-width="600" data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true  data-title="确定给这些会员会员充值？">会员充值</a>';        else            return "";			}}if (!function_exists('sendmessage')) {    function sendmessage(){        global  $supplierid,$supplierusertype;        if (isset($supplierid) && $supplierid != "" )            return '<a href="index.php?module=Supplier_Profile&action=sendmessage"  data-title="发送消息" data-height="300" data-width="450" data-id="edit" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>发送消息</a>';        else            return "";    }}if (!function_exists('ModifySourcer')) {    function ModifySourcer(){        global  $supplierid,$supplierusertype;        if (isset($supplierid) && $supplierid != "" )            return '<a href="index.php?module=Supplier_Profile&action=ModifySourcer" data-title="修改会员上线" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>修改会员上线</a>';        else            return "";    }}if (!function_exists('ModifyRankLevel')) {    function ModifyRankLevel(){        global  $supplierid,$supplierusertype;        if (isset($supplierid) && $supplierid != "" )            return '<a href="index.php?module=Supplier_Profile&action=ModifyRankLevel" data-title="修改会员积分与级别" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true></i>修改会员积分与级别</a>';        else            return "";    }}if (!function_exists('func_deleteprofile')) {    function func_deleteprofile(){        global $current_user;        if (is_admin($current_user))	        return '<a href="index.php?module=Supplier_Profile&action=DeleteProfile" data-title="确实要删除这些会员吗?" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true></i>删除会员</a>';		 else            return "";    }}if (!function_exists('ModifyPhysicalStore')) {    function ModifyPhysicalStore(){        global  $supplierid,$supplierusertype;				$mall_settings = XN_Query::create ( 'Content' ) ->tag('mall_settings')		    ->filter ( 'type', 'eic', 'mall_settings') 			->filter ( 'my.supplierid', '=',$supplierid)			->filter ( 'my.allowphysicalstore', '=','0')		    ->filter ( 'my.deleted', '=', '0' )			->end(1)		    ->execute ();		if ( count($mall_settings) > 0)		{	        if (isset($supplierid) && $supplierid != "" )	            return '<a href="index.php?module=Supplier_Profile&action=ModifyPhysicalStore" data-title="提拔为实体店店主" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>提拔为实体店店主</a>';	        else	            return "";		}		else		{			 return "";		}    }}if (!function_exists('VerifyLevelSourcer')) {    function VerifyLevelSourcer(){        global $currentModule,$supplierid,$supplierusertype;        if(isset($supplierid) && $supplierid !="" && $supplierusertype=='boss'){            return '<a data-id="edit" class="btn btn-default"  data-icon="edit" data-toggle="doajax" href="index.php?module='.$currentModule.'&action=VerifyLevelSourcer" data-title="校验会员关系链"><span>校验会员关系链</span></a>';        }else{            return false;        }    }}/*if (!function_exists('DisplayLevelSourcer')) {    function DisplayLevelSourcer(){        global  $supplierid,$supplierusertype; 	        if (isset($supplierid) && $supplierid != "" )	            return '<a href="index.php?module=Supplier_Profile&action=DisplayLevelSourcer" data-title="展示会员关系链" data-height="600" data-width="900" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>会员关系链</a>';	        else	            return "";		     }}*/if (!function_exists('ReduceProfileSourcer')) {    function ReduceProfileSourcer(){        global  $supplierid,$supplierusertype; 	        if (isset($supplierid) && in_array($supplierid,array("496790")))	            return '<a href="index.php?module=Supplier_Profile&action=ReduceProfileSourcer" data-title="裁减会员关系链" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>裁减会员关系链</a>';	        else	            return "";		     }}if (!function_exists('SetProfileCustomer')) {    function SetProfileCustomer(){        global  $supplierid,$supplierusertype; 		$mall_settings = XN_Query::create ( 'Content' ) ->tag('mall_settings')		    ->filter ( 'type', 'eic', 'mall_settings') 			->filter ( 'my.supplierid', '=',$supplierid)			->filter ( 'my.allowphysicalstore', '=','0')		    ->filter ( 'my.deleted', '=', '0' )			->end(1)		    ->execute ();		if ( count($mall_settings) > 0)		{	        if (isset($supplierid) && $supplierid != "" )	            return '<a href="index.php?module=Supplier_Profile&action=SetProfileCustomer" data-title="提定实体店顾客" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>提定实体店顾客</a>';	        else	            return "";		}		else		{			 return "";		}		     }}$actionmapping = array (	array('actionname' => 'ToFrozenList','securitycheck' => '1','func'=>'tofrozenlist_func','type'=>'listview'),	array('actionname' => 'AddMoney','securitycheck' => '1','func'=>'addmoney_func','type'=>'listview'),	array('actionname' => 'sendmessage','securitycheck' => '1','func'=>'sendmessage','type'=>'listview'),	array('actionname' => 'ModifySourcer','securitycheck' => '1','func'=>'ModifySourcer','type'=>'listview'),	array('actionname' => 'ModifyRankLevel','securitycheck' => '1','func'=>'ModifyRankLevel','type'=>'listview'), 	array('actionname' => 'DeleteProfile','securitycheck' => '1','func'=>'func_deleteprofile','type'=>'listview'),	array('actionname' => 'ModifyPhysicalStore','securitycheck' => '1','func'=>'ModifyPhysicalStore','type'=>'listview'),	array('actionname' => 'ReduceProfileSourcer','securitycheck' => '1','func'=>'ReduceProfileSourcer','type'=>'listview'),	array('actionname' => 'SetProfileCustomer','securitycheck' => '1','func'=>'SetProfileCustomer','type'=>'listview'),    array('actionname' => 'VerifyLevelSourcer','securitycheck' => '1','func'=>'VerifyLevelSourcer','type'=>'listview'),	//array('actionname' => 'DisplayLevelSourcer','securitycheck' => '1','func'=>'DisplayLevelSourcer','type'=>'listview'),);?>