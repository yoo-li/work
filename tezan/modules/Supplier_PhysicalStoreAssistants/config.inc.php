<?php/** * securitycheck:1表示不进行权限校验 */	$Create = false;	$Delete = false;	$actionmapping = array (		array('actionname' => 'ModifyAssistant','securitycheck' => '1','func'=>'ModifyAssistant','type'=>'listview'),		array('actionname' => 'CancelAssistant','securitycheck' => '1','func'=>'CancelAssistant','type'=>'listview'),	);		if (!function_exists('ModifyAssistant')) {	    function ModifyAssistant(){	        global  $supplierid,$supplierusertype;					$mall_settings = XN_Query::create ( 'Content' ) ->tag('mall_settings')			    ->filter ( 'type', 'eic', 'mall_settings') 				->filter ( 'my.supplierid', '=',$supplierid)				->filter ( 'my.allowphysicalstore', '=','0')			    ->filter ( 'my.deleted', '=', '0' )				->end(1)			    ->execute ();			if ( count($mall_settings) > 0)			{		        if (isset($supplierid) && $supplierid != "" )		            return '<a href="index.php?module=Supplier_PhysicalStoreAssistants&action=ModifyAssistant" data-title="修改店员分佣比率" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>修改店员分佣比率</a>';		        else		            return "";			}			else			{				 return "";			}	    }	}	if (!function_exists('CancelAssistant')) {	    function CancelAssistant(){	        global  $supplierid,$supplierusertype;					$mall_settings = XN_Query::create ( 'Content' ) ->tag('mall_settings')			    ->filter ( 'type', 'eic', 'mall_settings') 				->filter ( 'my.supplierid', '=',$supplierid)				->filter ( 'my.allowphysicalstore', '=','0')			    ->filter ( 'my.deleted', '=', '0' )				->end(1)			    ->execute ();			if ( count($mall_settings) > 0)			{		        if (isset($supplierid) && $supplierid != "" )		            return '<a href="index.php?module=Supplier_PhysicalStoreAssistants&action=CancelAssistant" data-title="取消店员资格" data-height="200" data-width="450" class="btn btn-default" data-group="ids" data-icon="edit" data-toggle="doajaxchecked" data-dialog=true>取消店员资格</a>';		        else		            return "";			}			else			{				 return "";			}	    }	}	?>