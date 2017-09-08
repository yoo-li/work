<?php
if(isset($_REQUEST["operatingtype"]) && $_REQUEST["operatingtype"] == "add"){
	$html = '
		<div class="bjui-pageContent tableContent">
			<form method="post" action="index.php" data-callback="picklist_popup_submit_callback" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
				<input type="hidden" value="Settings" name="module">
				<input type="hidden" value="EditViewAddPicklist" name="action">
				<input type="hidden" value="'.$_REQUEST['picklist'].'" name="picklist">
				<input type="hidden" value="'.$_REQUEST['sequence'].'" name="sequence">
				<input type="hidden" value="'.$_REQUEST['add_module'].'" name="add_module">
				<input type="hidden" value="addsave" name="operatingtype">
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85">'.getTranslatedString('LBL_PICKLIST_NAME').'：</label>
		            <input type="text" data-rule="required" class="required" name="picklistname" id="picklistname" value="" size="20" maxlength="100">
		        </div>  
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85">'.getTranslatedString('LBL_PICKLIST_VALUE').'：</label>
		            <input type="text" name="picklistvalue" id="picklistvalue" value=""  size="20" maxlength="100">
		        </div>  
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85"></label>
		            <font style="font-weight:bold;color:red;">注：</font>选项值为空时，默认选项名做为值处理
		        </div>  
			</form>
		</div>
		<div class="bjui-pageFooter">
			<ul>
				<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
				<li><button type="submit" class="btn-green" data-icon="save">确定</button></li>
			</ul>
		</div>
		<script language="javascript" type="text/javascript">
			function picklist_popup_submit_callback(json){
				$("#"+json.params.obj).empty();
				for(var i=0;i<json.params.option.length;i++) {
					var options = json.params.option[i];
					if((options[0]).indexOf("add_")>=0)
						$("#"+json.params.obj).append("<option style=\'color:blue;\' value=\'"+options[0]+"\' "+options[2]+"> "+options[1]+" </option>");
					else
						$("#"+json.params.obj).append("<option value=\'"+ options[0] +"\' "+options[2]+"> "+options[1]+" </option>");
				}
				$("#"+json.params.obj).selectpicker("refresh");
				$(this).dialog("closeCurrent");
			}
		</script>
	';
	echo $html;
}elseif(isset($_REQUEST["operatingtype"]) && $_REQUEST["operatingtype"] == "addsave"){
	$picklists = XN_Query::create ( 'Content' )->tag ( 'picklists' )
		      ->filter ( 'type', 'eic', 'picklists' )
		      ->filter ( 'my.name', '=', $_REQUEST["picklist"] )
		      ->filter ( 'my.'.$_REQUEST["picklist"], '=', $_REQUEST["picklistvalue"] )
		      ->execute();
	if(count($picklists) <= 0){
		$pickList = XN_Content::create('picklists','',false);
		$pickList->my->name = $_REQUEST["picklist"];
		$pickList->my->$_REQUEST["picklist"] = $_REQUEST["picklistname"];
		$pickList->my->sequence = $_REQUEST["sequence"];
		if (!isset($_REQUEST["picklistvalue"]) || $_REQUEST["picklistvalue"] == '') {
			$pickList->my->picklist_valueid = $_REQUEST["picklistname"];
		}else{
			$pickList->my->picklist_valueid = $_REQUEST["picklistvalue"];
		}
		$pickList->my->presence = '1';
		$pickList->save('picklists');
	}
	$picklists = XN_Query::create ( 'Content' )->tag ( 'picklists' )
		      ->filter ( 'type', 'eic', 'picklists' )
		      ->filter ( 'my.name', '=', $_REQUEST["picklist"] )
		      ->order('my.sequence',XN_Order::ASC_NUMBER)
		      ->execute();
	$option["obj"] = $_REQUEST["picklist"];
	foreach ($picklists as $info){
		if($info->my->$_REQUEST["picklist"] == $_REQUEST["picklistvalue"])
			$option["option"][] = array($info->my->$_REQUEST["picklist"],getTranslatedString($info->my->$_REQUEST["picklist"],$_REQUEST['add_module']),'selected');
		else
			$option["option"][] = array($info->my->$_REQUEST["picklist"],getTranslatedString($info->my->$_REQUEST["picklist"],$_REQUEST['add_module']),'');
	}
	if(check_authorize('picklist')){
		$option["option"][] = array('add_'.$_REQUEST["picklist"],'新建','');
	}
	echo '{"statusCode":200,"closeCurrent":"true","params":'.json_encode($option).'}';
}?>