<?php
global $mod_strings,$app_strings,$theme;

if(isset($_REQUEST["operatingtype"])){
	if($_REQUEST["operatingtype"] == "selectparenttabs"){
		$parent_child_tab_rel_array = array();
         
		global $global_session; 
		$parent_tabdata  = $global_session['parent_tabdata'];  
        $parent_tab_info_array=$parent_tabdata['parent_tab_info_array'];
        $all_parent_tab_info_array=$parent_tabdata['all_parent_tab_info_array'];
        $parent_child_tab_rel_array=$parent_tabdata['parent_child_tab_rel_array'];
        $all_parent_child_tab_rel_array=$parent_tabdata['all_parent_child_tab_rel_array'];
         
		$parentmodule = $_REQUEST['tabs'];
		$html = '<table border=0 cellspacing=0 cellpadding=10 width=136>';
		if (isset($parent_child_tab_rel_array[$parentmodule]) && is_array($parent_child_tab_rel_array[$parentmodule]))
		{
			$alltabs = $parent_child_tab_rel_array[$parentmodule];
			$i = 1;
			foreach($alltabs as $tabs){
				$html .= '<tr style="height:35px;cursor: pointer;" onClick="selectTabClick(\''.$tabs.'\','.$i.','.count($alltabs).');" onmouseout="this.className=\'\'" onmouseover="this.className=\'tabsubmenuOver\'">
					<td id="tabs_select_'.$i.'" valign="bottom" align=right width=120 class="tabsubmenu">'.getTranslatedString($tabs).'</td>
					<td valign="center" align=left width=16 class="tabsubmenu"><div id="img_select_'.$i.'" style="display:none;"><i class="fa fa-caret-right"></i></div></td>
				</tr>';
				$i ++;
			}
			if(count($alltabs)>0)
				$html .= '</table><script>selectTabClick(\''.$alltabs[0].'\',1,'.count($alltabs).');</script>';
			else
				$html .= '</table>';
		}
		echo $html ;
	}elseif($_REQUEST["operatingtype"] == "selecttabs"){
		$fieldsQuery = XN_Query::create ( 'Content' )->tag ( 'fields' )
			->filter ( 'type', 'eic', 'fields' )
			->filter ('my.tabid','=',getTabid($_REQUEST["tabs"]))
			->filter (XN_Filter::any(
					XN_Filter('my.uitype','=','15'),
					XN_Filter('my.uitype','=','33'),
					XN_Filter('my.uitype','=','115')
				))
			->order('my.sequence',XN_Order::ASC_NUMBER)
			->execute();
		$pickList = array();
		foreach($fieldsQuery as $info){
			$picklistname = $info->my->picklist;
			if(isset($picklistname) && $picklistname != ""){
				$pickList[] = $picklistname;
			}else{
				$pickList[] = $info->my->fieldname;
			}
		}

		$picklists = XN_Query::create ( 'Content_Count' )->tag ( 'picklists' )
			->filter ( 'type', 'eic', 'picklists' )
			->filter ('my.tabid','=',getTabid($_REQUEST["tabs"])) 
			->end(-1)
			->rollup()
			->group("my.name")
			->execute();
	
		foreach($picklists as $info){			
				$pickList[] = $info->my->name;
		} 


		$html = '
			<span>选择数据字典:</span>
			<select id="tabspicklist" data-toggle="selectpicker" onchange="selectPicklist(this.value);">
		';
		$auto = "";
		if(count($pickList)>0){
			$html .= '';
			$i = 1;
			foreach(array_unique($pickList) as $fieldname ){
				if($i == 1){
					$html .= '<option value="'.$fieldname.'" selected> '. $fieldname . ' </option>';
					$auto = $fieldname;
				}else
					$html .= '<option value="'.$fieldname.'"> '. $fieldname . ' </option>';
				$i ++;
			}
		}else{
			$html .= '<option>此模块无数据字典</option>';
		}
		$html .= '</select>';
		if($auto != ""){
			$html .= '<script>selectPicklist(\''.$auto.'\');</script>';
		}
		echo $html;
	}elseif($_REQUEST["operatingtype"] == "selectpicklist"){
		$pickList = XN_Query::create('Content')->tag('picklists')
			->filter('type','eic','picklists')
			->filter('my.name','=',$_REQUEST["picklist"])
			->begin(0)->end(-1)
			->order('my.sequence',XN_Order::ASC_NUMBER)
			->execute();
		$html .= '<table class="table table-bordered table-hover table-striped"  data-width="100%" data-nowrap="true" cellspacing="0" cellpadding="0" border="0">
	        <thead>
	            <tr>
					<th class="center">选择项</th>
					<th class="center">编辑</th>
					<th class="center">删除</th>
					<th class="center">上移</th> 
					<th class="center">下移</th> 
	            </tr>
	        </thead>
	        <tbody>';
		$i = 1;
		foreach($pickList as $info){
			$label = $info->my->$_REQUEST["picklist"];
			if($label == "")
				$label = "[<span style='color:blue;'>空选项</span>]";
			$html .= '
			<tr>
				<td style="width:60%">'.$label.'</td>
				<td class="center" style="width:10%;"><div onclick="ModfiyPicklist(\''.$info->id.'\',\''.$_REQUEST["picklist"].'\');" style="cursor:pointer;"><i class="fa btn-default fa-edit"></i></div></td>
				<td class="center" style="width:10%;"><div onclick="DeletePicklist(\''.$info->id.'\',\''.$_REQUEST["picklist"].'\');" style="cursor:pointer;"><i class="fa btn-default fa-trash-o"></i></div></td>
				<td class="center" style="width:10%;">'.($i == 1?'':'<div onclick="movePicklist(\''.$info->id.'\',\''.$_REQUEST["picklist"].'\',\'up\');" style="cursor:pointer;"><i class="fa btn-default fa-arrow-circle-o-up"></i></div>').'</td>
				<td class="center" style="width:10%;">'.($i == count($pickList)?'':'<div onclick="movePicklist(\''.$info->id.'\',\''.$_REQUEST["picklist"].'\',\'down\');" style="cursor:pointer;"><i class="fa btn-default fa-arrow-circle-o-down"></i></div>').'</td>
			</tr>
			';
			$i++;
		}
		$html .= '</tbody></table>';
		echo $html;
	}elseif($_REQUEST["operatingtype"] == "modify"){
		if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
			$pickListConn = XN_Content::load($_REQUEST["record"],'picklists');
			$html = '
		 <form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
		 <div class="bjui-pageContent"> 
				<input type="hidden" value="Settings" name="module">
				<input type="hidden" value="PickListManage" name="action">
				<input type="hidden" value="'.$_REQUEST['record'].'" name="record">
				<input type="hidden" value="'.$_REQUEST['picklist'].'" name="picklist">
				<input type="hidden" value="save" name="operatingtype">
		
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85">'.getTranslatedString('LBL_PICKLIST_NAME').'：</label>
		            <input type="text" data-rule="required" class="required" name="picklistname" id="picklistname" value="'.$pickListConn->my->$_REQUEST["picklist"].'"  size="20" maxlength="100">
		        </div>  
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85">'.getTranslatedString('LBL_PICKLIST_VALUE').'：</label>
		            <input type="text" name="picklistvalue" id="picklistvalue" value="'.$pickListConn->my->picklist_valueid.'"  size="20" maxlength="100">
		        </div>  
		        <div class="form-group" style="margin: 20px 0 20px; ">
		            <label class="control-label x85"></label>
		            <font style="font-weight:bold;color:red;">注：</font>选项值为空时，默认选项名做为值处理
		        </div>  
		</div>
		<div class="bjui-pageFooter">
		    <ul>
		        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
		        <li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
		    </ul>
		</div>
		</form>'; 
			echo $html;
		}
	}elseif($_REQUEST["operatingtype"] == "save"){
		if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
			$pickListConn = XN_Content::load($_REQUEST["record"],'picklists');
			$pickListConn->my->$_REQUEST["picklist"] = $_REQUEST["picklistname"];
			if (!isset($_REQUEST["picklistvalue"]) || $_REQUEST["picklistvalue"] == '') {
				$pickListConn->my->picklist_valueid = $_REQUEST["picklistname"];
			}else{
				$pickListConn->my->picklist_valueid = $_REQUEST["picklistvalue"];
			}
			$pickListConn->save('picklists');
			echo '{"statusCode":200,"message":null,"divid":"tabpicklist","closeCurrent":true}';
		}
	}elseif($_REQUEST["operatingtype"] == "up"){
		if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
			$pickListConn = XN_Content::load($_REQUEST["record"],'picklists');
			$picklists_next = XN_Query::create ( 'Content' )->tag ( 'picklists' )
				      ->filter ( 'type', 'eic', 'picklists' )
				      ->filter ( 'my.name', '=', $_REQUEST["picklist"] )
				      ->filter ( 'my.sequence', '<', intval($pickListConn->my->sequence) )
				      ->order('my.sequence',XN_Order::DESC_NUMBER)
				      ->execute();
			if(count($picklists_next)>0){
				$current_sequence=$pickListConn->my->sequence;
				$pickListConn->my->sequence = $picklists_next[0]->my->sequence;
				$picklists_next[0]->my->sequence = $current_sequence;
				$pickListConn->save('picklists');
				$picklists_next[0]->save('picklists');
			}
		}
		$_REQUEST["operatingtype"] = "selectpicklist";
		include 'PickListManage.php';
	}elseif($_REQUEST["operatingtype"] == "down"){
		if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
			$pickListConn = XN_Content::load($_REQUEST["record"],'picklists');
			$picklists_next = XN_Query::create ( 'Content' )->tag ( 'picklists' )
				      ->filter ( 'type', 'eic', 'picklists' )
				      ->filter ( 'my.name', '=', $_REQUEST["picklist"] )
				      ->filter ( 'my.sequence', '>', intval($pickListConn->my->sequence) )
				      ->order('my.sequence',XN_Order::ASC_NUMBER)
				      ->execute();
			if(count($picklists_next)>0){
				$current_sequence=$pickListConn->my->sequence;
				$pickListConn->my->sequence = $picklists_next[0]->my->sequence;
				$picklists_next[0]->my->sequence = $current_sequence;
				$pickListConn->save('picklists');
				$picklists_next[0]->save('picklists');
			}
		}
		$_REQUEST["operatingtype"] = "selectpicklist";
		include 'PickListManage.php';
	}elseif($_REQUEST["operatingtype"] == "delete"){
		if(isset($_REQUEST["record"]) && $_REQUEST["record"]){
			XN_Content::delete($_REQUEST["record"],'picklists');
		}
		$_REQUEST["operatingtype"] = "selectpicklist";
		include 'PickListManage.php';
	}elseif($_REQUEST["operatingtype"] == "add"){
		$html = '
	 <form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
	 <div class="bjui-pageContent"> 
			<input type="hidden" value="Settings" name="module">
			<input type="hidden" value="PickListManage" name="action">
			<input type="hidden" value="'.$_REQUEST['picklist'].'" name="picklist">
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
	</div>
	<div class="bjui-pageFooter">
	    <ul>
	        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
	        <li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
	    </ul>
	</div>
	</form>';
		echo $html;
	}elseif($_REQUEST["operatingtype"] == "addsave"){
		$picklists = XN_Query::create ( 'Content' )->tag ( 'picklists' )
			      ->filter ( 'type', 'eic', 'picklists' )
			      ->filter ( 'my.name', '=', $_REQUEST["picklist"] )
			      ->filter ( 'my.'.$_REQUEST["picklist"], '=', $_REQUEST["picklistname"] )
			      ->execute();
		if(count($picklists) <= 0){
			$pickList = XN_Query::create('Content')->tag('picklists')
				->filter('type','eic','picklists')
				->filter('my.name','=',$_REQUEST["picklist"])
				->begin(0)->end(-1)
				->order('my.sequence',XN_Order::ASC_NUMBER)
				->execute();
			$sequence = count($pickList)+1;
			$pickList = XN_Content::create('picklists','',false);
			$name = $_REQUEST["picklist"];
			$picklistname = $_REQUEST["picklistname"];
			if (!isset($_REQUEST["picklistvalue"]) || $_REQUEST["picklistvalue"] == '') {
				$picklistvalue = $picklistname;
			}else{
				$picklistvalue = $_REQUEST["picklistvalue"];
			}
			$pickList->my->name = $name;
			$pickList->my->$name = $picklistname;
			$pickList->my->sequence = $sequence;
			$pickList->my->picklist_valueid = $picklistvalue;
			$pickList->my->presence = '1';
			$pickList->save('picklists');
		}
		echo '{"statusCode":200,"message":null,"divid":"tabpicklist","closeCurrent":true}';
	}
}else{
	require_once('Smarty_setup.php');
	require_once('include/utils/UserInfoUtil.php');
	require_once('include/utils/utils.php');
	
	$smarty=new vtigerCRM_Smarty;
	$smarty->assign("MOD",$mod_strings);
	$smarty->assign("APP",$app_strings);
	
	$tab_datas = array();
	$tabs = XN_Query::create ( 'Content' )->tag ( 'tabs' )
					->filter ( 'type', 'eic', 'tabs' )
					->filter ( 'my.presence', '=', '0') 
					->end(-1)
					->execute ();
	foreach($tabs as $tab_info)
	{
		$tab_datas[] = $tab_info->my->tabname;
	}
	
	$header_array = array();
	$tabs = XN_Query::create ( 'Content' )->tag ( 'parenttabs' )
					->filter ( 'type', 'eic', 'parenttabs' )
					->filter ( 'my.presence', '=', '0')
					->order("my.sequence",XN_Order::ASC)
					->execute ();
	if (count($tabs) >0)
	{
		foreach($tabs as $tab_info)
		{
			$tabname = $tab_info->my->tabname;
			if ($tab_info->my->parenttabname != "Settings" && $tab_info->my->parenttabname != "Tools")
			{
				if (count(array_intersect($tab_datas,(array)$tabname)) > 0)
				{
					$header_array[] = $tab_info->my->parenttabname;
				} 
			}
		}
	}
	$smarty->assign("HEADERS",$header_array);
	$smarty->display('Settings/PickListLayout.tpl');
}
?>