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
					<td valign="middle" align=left width=16 class="tabsubmenu"><div id="img_select_'.$i.'" style="display:none;"><i class="fa fa-caret-right"></i></div></td>
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
        $fld_module = $_REQUEST["tabs"];
        $field_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
            ->filter ( 'type', 'eic', 'fields' )
            ->filter ( 'my.tabid', '=',getTabid($fld_module) )
            ->order('my.sequence',XN_Order::ASC_NUMBER)
            ->begin(0)->end(-1)
            ->execute();
        $fieldConn = array();
        foreach($field_query as $info){
            if($info->my->displaytype == '2')
                $fieldConn["yes"][] = $info;
            else
                $fieldConn["no"][] = $info;
        }
        $SaveConn = array();
        $sequence = 1;
        if(is_array($fieldConn["no"])){
            foreach($fieldConn["no"] as $info){
                if ($info->my->sequence != $sequence){
                    $info->my->sequence = $sequence;
                    $SaveConn[] = $info;
                }
                $sequence++;
            }
        }
        $sequence += 10;
        if(is_array($fieldConn["yes"])){
            foreach($fieldConn["yes"] as $info){
                if ($info->my->sequence != $sequence){
                    $info->my->sequence = $sequence;
                    $SaveConn[] = $info;
                }
                $sequence++;
            }
        }
        if(count($SaveConn)>0)
            XN_Content::batchsave($SaveConn,"fields");

//获取块信息
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
        	->filter ( 'type', 'eic', 'blocks' )
        	->filter ( 'my.tabid', '=', getTabid($fld_module) )
        	->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
        	->execute ();
        $blocklist = array ();
        $blockindex = 0;
        foreach ( $blocks as $block_info ) {
            $blockindex ++;
        	$blockid = $block_info->my->blockid;
        	$blocklist["module"] = $fld_module;
        	$blocklist["blockinfo"][$blockid]["label"] = getTranslatedString($block_info->my->blocklabel,$fld_module);
        	$blocklist["blockinfo"][$blockid]["display"] = $block_info->my->display_status;
        	$blocklist["blockinfo"][$blockid]["iscustom"] = $block_info->my->iscustom;
            if($blockindex == 1){
        	    $blocklist["blockinfo"][$blockid]["down"] = true;
        	    $blocklist["blockinfo"][$blockid]["up"] = false;
        	}elseif($blockindex == count($blocks)){
        	    $blocklist["blockinfo"][$blockid]["down"] = false;
        	    $blocklist["blockinfo"][$blockid]["up"] = true;
        	}else{
        	    $blocklist["blockinfo"][$blockid]["down"] = true;
        	    $blocklist["blockinfo"][$blockid]["up"] = true;
        	}
        	if($block_info->my->columns == "")
        	    $blocklist["blockinfo"][$blockid]["columns"] = '2';
        	else
        	   $blocklist["blockinfo"][$blockid]["columns"] = $block_info->my->columns;
            if(is_array($fieldConn["no"])){
                $upid = "";
                foreach($fieldConn["no"] as $info){
                    $showtitle = "";
                    if($info->my->show_title != '1' && $info->my->fieldlabel != '')
                        $showtitle = " (<font color=blue>隐</font>)";
                    if ($info->my->uitype != '4' && $info->my->uitype != '35' && $info->my->block == $blockid){
                        if($info->my->presence == '0' || $info->my->presence == '2'){
                            if($info->my->deputy_column == '1' && !empty($upid)){
                                $blocklist["blockinfo"][$blockid]["fields"][$upid]["deputy"][$info->id]["label"] = getTranslatedString($info->my->fieldlabel,$fld_module).$showtitle;
                                $fieldtype =  explode("~",$info->my->typeofdata);
                                $blocklist["blockinfo"][$blockid]["fields"][$upid]["deputy"][$info->id]["fieldtype"] = $fieldtype[1];
                            }else{
                                $blocklist["blockinfo"][$blockid]["fields"][$info->id]["label"] = getTranslatedString($info->my->fieldlabel,$fld_module).$showtitle;
                                $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'field';
                                if($info->my->merge_column == '1')
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'merge';
                                if($info->my->merge_column == '2')
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'newrow';
                                if($info->my->uitype == '444')
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'line';
                                if(!empty($upid))
                                    $blocklist["blockinfo"][$blockid]["fields"][$upid]["nexttype"] = $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"];
                                $upid = $info->id;
                                $fieldtype =  explode("~",$info->my->typeofdata);
                                $blocklist["blockinfo"][$blockid]["fields"][$info->id]["fieldtype"] = $fieldtype[1];
                            }
                        }else{
                            $blocklist["blockinfo"][$blockid]["hiddenfields"][$info->id] = getTranslatedString($info->my->fieldlabel,$fld_module);
                        }
                    }
                }
            }
        }
        require_once('Smarty_setup.php');
    	$smarty=new vtigerCRM_Smarty;
    	$smarty->assign("MOD",$mod_strings);
    	$smarty->assign("APP",$app_strings);
    	$smarty->assign("BLOCKS",$blocklist);
        $smarty->display('Settings/ModuleFieldLayoutEntries.tpl');
    }elseif($_REQUEST["operatingtype"] == "showhideblock"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $showhide = $_REQUEST["showhide"];
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', getTabid($fld_module) )
            ->filter ( 'my.blockid', '=', $blockid )
            ->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
            ->execute ();
        if(count($blocks)>0){
            if($showhide == 'show')
                $blocks[0]->my->display_status = '1';
            else
                $blocks[0]->my->display_status = '0';
            $blocks[0]->save('blocks');
        }
        $params = array("module"=>$fld_module,"blockid"=>$blockid);
        echo json_encode($params);
    }elseif($_REQUEST["operatingtype"] == "showblockinfo"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', getTabid($fld_module) )
            ->filter ( 'my.blockid', '=', $blockid )
            ->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
            ->execute ();
        $blabel = '';
        $bcolumns = '';
        if(count($blocks)>0){
            $blabel = getTranslatedString($blocks[0]->my->blocklabel,$fld_module);
            $bcolumns = $blocks[0]->my->columns;
        }
        $html = '
			<form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
				<div class="bjui-pageContent"> 
	    			<input type="hidden" value="Settings" name="module">
	                <input type="hidden" value="'.$fld_module.'" name="tabs">
	                <input type="hidden" value="'.$blockid.'" name="blockid">
	    			<input type="hidden" value="ModuleFieldLayout" name="action">
	    			<input type="hidden" value="blockinfosave" name="operatingtype">
	                <input type="hidden" value="edit" name="savetype"> 
                    <table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0" >
                        <tr>
    						<td>'.getTranslatedString('LBL_BLOCK_NAME').'：</td>
    						<td style="padding: 0 2px;" colspan="3"><input name="blkLabel" value="'.$blabel.'" type="text" style="width:200px;" class="textInput required" data-rule="required"></td>
                        </tr>
                        <tr>
    						<td>'.getTranslatedString('LBL_BLOCK_COLUMN').'：</td>
    						<td style="padding: 0 2px;" colspan="3"><input name="blkColumn" value="'.$bcolumns.'" type="text" style="width:200px;" class="textInput required" data-rule="required;number"></td>
                        </tr>
    				</table>
                </div>
				<div class="bjui-pageFooter">
				    <ul>
				        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
						<li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
				    </ul>
				</div>  
    			</form>
        ';
        echo $html;
    }elseif($_REQUEST["operatingtype"] == "addnewblockinfo"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $html = '
			<form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
				<div class="bjui-pageContent"> 
	    			<input type="hidden" value="Settings" name="module">
	                <input type="hidden" value="'.$fld_module.'" name="tabs">
	                <input type="hidden" value="'.$blockid.'" name="blockid">
	    			<input type="hidden" value="ModuleFieldLayout" name="action">
	    			<input type="hidden" value="blockinfosave" name="operatingtype">
	                <input type="hidden" value="add" name="savetype"> 
                    <table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0">
                        <tr>
    						<td>'.getTranslatedString('LBL_BLOCK_NAME').'：</td>
    						<td style="padding: 0 2px;" colspan="3"><input name="blkLabel" value="" type="text" style="width:200px;" class="textInput required" data-rule="required"></td>
                        </tr>
                        <tr>
    						<td>'.getTranslatedString('LBL_BLOCK_COLUMN').'：</td>
    						<td style="padding: 0 2px;" colspan="3"><input name="blkColumn" value="" type="text" style="width:200px;" class="textInput required" data-rule="required;number"></td>
                        </tr>
    				</table>
                </div>
				<div class="bjui-pageFooter">
				    <ul>
				        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
						<li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
				    </ul>
				</div>
    			</form>
        ';
        echo $html;
    }elseif($_REQUEST["operatingtype"] == "blockinfosave"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $blkLabel = $_REQUEST["blkLabel"];
        $blkColumn = $_REQUEST["blkColumn"];
        $savetype = $_REQUEST["savetype"];
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', getTabid($fld_module) )
            ->filter ( 'my.blockid', '=', $blockid )
            ->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
            ->execute ();
        if(count($blocks)){
            if($savetype == 'add'){
                $block_sequence = intval($blocks[0]->my->sequence);
                $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
                    ->filter ( 'type', 'eic', 'blocks' )
                    ->filter ( 'my.tabid', '=', getTabid($fld_module) )
                    ->filter ( 'my.sequence', '>', $block_sequence )
                    ->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
                    ->execute ();
                $saveConn = array();
                foreach($blocks as $info){
                    $info->my->sequence = intval($info->my->sequence)+1;
                    $saveConn[] = $info;
                }
                if(count($saveConn)>0)
                    XN_Content::batchsave($saveConn,'blocks');
                $max_blockid=getUniqueID('blocks','blockid');
                XN_Content::create('blocks', 'blocks',false)
                    ->my->add('tabid',getTabid($fld_module))
                    ->my->add('blockid',$max_blockid)
                    ->my->add('sequence',$block_sequence+1)
                    ->my->add('blocklabel',$blkLabel)
                    ->my->add('iscustom','1')
                    ->my->add('show_title','0')
                    ->my->add('visible','0')
                    ->my->add('create_view','0')
                    ->my->add('edit_view','0')
                    ->my->add('detail_view','0')
                    ->my->add('display_status','1')
                    ->my->add('columns',$blkColumn)
                    ->save("blocks");
            }elseif($savetype == 'edit'){
                $blocks[0]->my->blocklabel = $blkLabel;
                $blocks[0]->my->columns = $blkColumn;
                $blocks[0]->save('blocks');
            }
        }
        $params = array("module"=>$fld_module);
         echo '{"statusCode":200,"message":null,"divid":"picklistEntries","closeCurrent":"true"}';
    }elseif($_REQUEST["operatingtype"] == "deleteblockinfo"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
            ->filter ( 'type', 'eic', 'blocks' )
            ->filter ( 'my.tabid', '=', getTabid($fld_module) )
            ->filter ( 'my.blockid', '<=', $blockid )
            ->order ( 'my.sequence ', XN_Order::DESC_NUMBER )
            ->execute ();
        if(count($blocks)>1){
            if($blocks[0]->my->iscustom == '1'){
                $upbid = $blocks[1]->my->blockid;
                $field_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
                    ->filter ( 'type', 'eic', 'fields' )
                    ->filter ( 'my.tabid', '=',getTabid($fld_module) )
                    ->filter ( 'my.block', '=',$blockid )
                    ->begin(0)->end(-1)
                    ->execute();
                $saveConn = array();
                foreach($field_query as $info){
                    $info->my->block = $upbid;
                    $saveConn[] = $info;
                }
                if(count($saveConn)>0)
                    XN_Content::batchsave($saveConn,'fields');
                XN_Content::delete($blocks[0],'blocks');
            }
        }
        $params = array("module"=>$fld_module);
        echo json_encode($params);
    }elseif($_REQUEST["operatingtype"] == "showhiddenfields"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $field_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
            ->filter ( 'type', 'eic', 'fields' )
            ->filter ( 'my.tabid', '=',getTabid($fld_module) )
            ->filter ( 'my.block', '=',$blockid )
            ->filter ( 'my.presence', '!in', array('0','2') )
            ->order('my.sequence',XN_Order::ASC_NUMBER)
            ->begin(0)->end(-1)
            ->execute();
        $html = '
			<form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
				<div class="bjui-pageContent" style="padding:0px;"> 
	    			<input type="hidden" value="Settings" name="module">
	                <input type="hidden" value="'.$fld_module.'" name="tabs">
	                <input type="hidden" value="'.$blockid.'" name="blockid">
	    			<input type="hidden" value="ModuleFieldLayout" name="action">
	    			<input type="hidden" value="hiddenfieldssave" name="operatingtype">
	                <input type="hidden" value="" id="hiddenfields_select" name="hiddenfields_select">
	                <div style="height: 230px; overflow: auto;border-style: none;">
	                    <select id="hiddenfields" multiple="" size="14" style="width:100%;height:100%">';
	        foreach($field_query as $info){
	            $label = $info->my->fieldlabel;
	            if($info->my->uitype == '444' && $label == "")
	                $label = "分隔线";
	            $html .= '<option value="'.$info->id.'">&nbsp;'.getTranslatedString($label,$fld_module).'</option>';
	        }
	        $html .= '
	                    </select>
		 			</div>
                </div>
				<div class="bjui-pageFooter">
				    <ul>
				        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
						<li><button type="submit" class="btn-green" onclick="validateHiddenfields();" data-icon="save">取消隐藏字段</button></li>
				    </ul>
				</div>   
    			</form>
        ';
        echo $html;
    }elseif($_REQUEST["operatingtype"] == "hiddenfieldssave"){
        if(isset($_REQUEST["hiddenfields_select"]) && $_REQUEST["hiddenfields_select"] != ""){
            $hfids = explode(";",$_REQUEST["hiddenfields_select"]);
            $hfids = array_filter($hfids);
            try{
                $fields_query = XN_Content::load_Many($hfids,'fields');
                $saveConn = array();
                foreach($fields_query as $info){
                    $info->my->presence = '2';
                    $saveConn[] = $info;
                }
                if(count($saveConn) > 0)
                    XN_Content::batchsave($saveConn,"fields"); 
                echo '{"statusCode":200,"message":null,"divid":"picklistEntries","closeCurrent":"true"}';
            }catch(XN_Exception $ex){
                echo '{"statusCode":300,"message":"'.$ex->getMessage().'"}';
            }
        }else{
            echo '{"statusCode":300,"message":"需选择隐藏字段！"}';
        }
    }elseif($_REQUEST["operatingtype"] == "refreshblockinfo"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $field_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
            ->filter ( 'type', 'eic', 'fields' )
            ->filter ( 'my.tabid', '=',getTabid($fld_module) )
            ->filter ( 'my.displaytype','!=','2')
            ->filter ( 'my.block', '=',$blockid )
            ->order('my.sequence',XN_Order::ASC_NUMBER)
            ->begin(0)->end(-1)
            ->execute();
    //获取块信息
        $blocks = XN_Query::create ( 'Content' )->tag ( 'blocks' )
        	->filter ( 'type', 'eic', 'blocks' )
        	->filter ( 'my.tabid', '=', getTabid($fld_module) )
        	->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
        	->execute ();
        $blocklist = array ();
        $blockindex = 0;
        foreach ( $blocks as $block_info ) {
            $blockindex ++;
            if($block_info->my->blockid == $blockid){
            	$blockid = $block_info->my->blockid;
            	$blocklist["module"] = $fld_module;
            	$blocklist["blockinfo"][$blockid]["label"] = getTranslatedString($block_info->my->blocklabel,$fld_module);
            	$blocklist["blockinfo"][$blockid]["display"] = $block_info->my->display_status;
            	$blocklist["blockinfo"][$blockid]["iscustom"] = $block_info->my->iscustom;
            	if($blockindex == 1){
            	    $blocklist["blockinfo"][$blockid]["down"] = true;
            	    $blocklist["blockinfo"][$blockid]["up"] = false;
            	}elseif($blockindex == count($blocks)){
            	    $blocklist["blockinfo"][$blockid]["down"] = false;
            	    $blocklist["blockinfo"][$blockid]["up"] = true;
            	}else{
            	    $blocklist["blockinfo"][$blockid]["down"] = true;
            	    $blocklist["blockinfo"][$blockid]["up"] = true;
            	}
            	if($block_info->my->columns == "")
            	    $blocklist["blockinfo"][$blockid]["columns"] = '2';
            	else
            	   $blocklist["blockinfo"][$blockid]["columns"] = $block_info->my->columns;
                if(count($field_query)>0){
                    $upid = "";
                    foreach($field_query as $info){
                        $showtitle = "";
                        if($info->my->show_title != '1' && $info->my->fieldlabel != '')
                            $showtitle = " (<font color=blue>隐</font>)";
                        if ($info->my->uitype != '4' && $info->my->uitype != '35' && $info->my->block == $blockid){
                            if($info->my->presence == '0' || $info->my->presence == '2'){
                                if($info->my->deputy_column == '1' && !empty($upid)){
                                    $blocklist["blockinfo"][$blockid]["fields"][$upid]["deputy"][$info->id]["label"] = getTranslatedString($info->my->fieldlabel,$fld_module).$showtitle;
                                    $fieldtype =  explode("~",$info->my->typeofdata);
                                    $blocklist["blockinfo"][$blockid]["fields"][$upid]["deputy"][$info->id]["fieldtype"] = $fieldtype[1];
                                }else{
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["label"] = getTranslatedString($info->my->fieldlabel,$fld_module).$showtitle;
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'field';
                                    if($info->my->merge_column == '1')
                                        $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'merge';
                                    if($info->my->merge_column == '2')
                                        $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'newrow';
                                    if($info->my->uitype == '444')
                                        $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"] = 'line';
                                    if(!empty($upid))
                                        $blocklist["blockinfo"][$blockid]["fields"][$upid]["nexttype"] = $blocklist["blockinfo"][$blockid]["fields"][$info->id]["type"];
                                    $upid = $info->id;
                                    $fieldtype =  explode("~",$info->my->typeofdata);
                                    $blocklist["blockinfo"][$blockid]["fields"][$info->id]["fieldtype"] = $fieldtype[1];
                                }
                            }else{
                                $blocklist["blockinfo"][$blockid]["hiddenfields"][$info->id] = getTranslatedString($info->my->fieldlabel,$fld_module);
                            }
                        }
                    }
                }
            }
        }
        require_once('Smarty_setup.php');
    	$smarty=new vtigerCRM_Smarty;
    	$smarty->assign("MOD",$mod_strings);
    	$smarty->assign("APP",$app_strings);
    	$smarty->assign("BLOCKS",$blocklist);
        $smarty->display('Settings/ModuleFieldLayoutBlock.tpl');
    }elseif($_REQUEST["operatingtype"] == "addnewfieldinfo"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $html = '<form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
	   		    <div class="bjui-pageContent"> 
    			<input type="hidden" value="Settings" name="module">
    			<input type="hidden" value="ModuleFieldLayout" name="action">
                <input type="hidden" value="'.$fld_module.'" name="tabs">
                <input type="hidden" value="'.$blockid.'" name="blockid">
                <input type="hidden" value="" name="selectedfieldtype" id="selectedfieldtype">
    			<input type="hidden" value="addnewfieldsave" name="operatingtype">
    			
    				<table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0">
    					<tr valign="top">
                            <td valign="top" width="180px">'.
                               getTranslatedString('LBL_SELECT_FIELD_TYPE')
                               .':<div name="cfcombo" id="cfcombo" class="small"  style="margin-top:5px;width:175px; height:210px; overflow-y:auto ;overflow-x:hidden ; border:1px  solid #CCCCCC ;">
                                    <table>
                                        <tr><td align="left"><a id="field0_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/line.gif\');" 		onclick = "makeFieldSelected(this,0,'.$blockid.');">  '.getTranslatedString('Line').' </a></td></tr>
										<tr><td align="left"><a id="field1_'.$blockid.'"	href="javascript:void(0);" class="customMnuSelected" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/text.gif\');" 		onclick = "makeFieldSelected(this,1,'.$blockid.');">  '.getTranslatedString('Text').' </a></td></tr>
										<tr><td align="left"><a id="field2_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/number.gif\');" 		onclick = "makeFieldSelected(this,2,'.$blockid.')" >  '.getTranslatedString('Number').' </a></td></tr>
										<tr><td align="left"><a id="field3_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/percent.gif\');" 	    onclick = "makeFieldSelected(this,3,'.$blockid.');">  '.getTranslatedString('Percent').' </a></td></tr>
										<tr><td align="left"><a id="field4_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/cfcurrency.gif\');" 	onclick = "makeFieldSelected(this,4,'.$blockid.');">  '.getTranslatedString('Currency').' </a></td></tr>
										<tr><td align="left"><a id="field5_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/date.gif\');" 		onclick = "makeFieldSelected(this,5,'.$blockid.');">  '.getTranslatedString('Date').' </a></td></tr>
										<tr><td align="left"><a id="field6_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/email.gif\');" 		onclick = "makeFieldSelected(this,6,'.$blockid.');">  '.getTranslatedString('Email').' </a></td></tr>
										<tr><td align="left"><a id="field7_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/phone.gif\');" 		onclick = "makeFieldSelected(this,7,'.$blockid.');">  '.getTranslatedString('Phone').' </a>	</td></tr>
										<tr><td align="left"><a id="field8_'.$blockid.'" 	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/cfpicklist.gif\');" 	onclick = "makeFieldSelected(this,8,'.$blockid.');">  '.getTranslatedString('PickList').' </a></td></tr>
										<tr><td align="left"><a id="field9_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/url.gif\');" 		    onclick = "makeFieldSelected(this,9,'.$blockid.');">  '.getTranslatedString('LBL_URL').' </a></td></tr>
										<tr><td align="left"><a id="field10_'.$blockid.'" 	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;;text-decoration:none; background-image:url(\'Public/images/fields/checkbox.gif\');" 	onclick = "makeFieldSelected(this,10,'.$blockid.');">  '.getTranslatedString('LBL_CHECK_BOX').' </a></td></tr>
										<tr><td align="left"><a id="field11_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/text.gif\');" 		onclick = "makeFieldSelected(this,11,'.$blockid.');"> '.getTranslatedString('LBL_TEXT_AREA').' </a></td></tr>
										<tr><td align="left"><a id="field12_'.$blockid.'"	href="javascript:void(0);" class="customMnu" style="background-position: 4px center;text-decoration:none; background-image:url(\'Public/images/fields/cfpicklist.gif\');" 	onclick = "makeFieldSelected(this,12,'.$blockid.');"> '.getTranslatedString('LBL_MULTISELECT_COMBO').' </a></td></tr>
									</table>
                                </div>
                            </td>
                            <td valign="top">'.
                               getTranslatedString('LBL_PROVIDE_FIELD_INFORMATION')
                               .':<table width="100%" border="0" cellpadding="5" cellspacing="0">
									<tr>
										<td nowrap="nowrap" align="right"><b>'.getTranslatedString('LBL_LABEL').':</b></td>
										<td align="left" >
										      <input id="fldLabel" name="fldLabel" value="" type="text" style="width:62%" class="textInput required"  data-rule="required">
										</td>
									</tr>
                					<tr>
                						<td nowrap="nowrap" align="right"><b>'.getTranslatedString('LBL_MANDATORY_FIELD').': </b></td>
                						<td align="left" ><input id="fldmandatory" name="fldmandatory" type="checkbox" style="cursor:pointer;" '.($mandatory[1] == 'M'?'checked':'').'></td>
                					</tr>
                				    <tr>
                						<td nowrap="nowrap" align="right"><b>'.getTranslatedString('LBL_MERGE_COLUMN').':</b></td>
                						<td align="left" ><input id="fldmerge_column" name="fldmerge_column" type="checkbox" style="cursor:pointer;"></td>
                					</tr>
                					<tr>
                						<td nowrap="nowrap" align="right"><b>'.getTranslatedString('LBL_DISPLAY_WIDTH').':</b></td>
                						<td align="left" >
                						    <select name="fldwidth" style="cursor:pointer;">
                						        <option value="4"> 4'.getTranslatedString('LBL_BYTE').'</option>
                						        <option selected value="8"> 8'.getTranslatedString('LBL_BYTE').'</option>
                						        <option value="12"> 12'.getTranslatedString('LBL_BYTE').'</option>
                						        <option value="16"> 16'.getTranslatedString('LBL_BYTE').'</option>
                						        <option value="24"> 24'.getTranslatedString('LBL_BYTE').'</option>
                						        <option value="36"> 36'.getTranslatedString('LBL_BYTE').'</option>
                						    </select>
                						</td>
                					</tr>
                					<tr>
                						<td nowrap="nowrap" align="right"><b>'.getTranslatedString('LBL_DISPLAY_ALIGN').':</b></td>
                						<td align="left" >
                						    <select name="fldalign" style="cursor:pointer;">
                						        <option selected value="left">'.getTranslatedString('LBL_ALIGN_LEFT').'</option>
                						        <option value="right">'.getTranslatedString('LBL_ALIGN_RIGHT').'</option>
                						        <option value="center">'.getTranslatedString('LBL_ALIGN_CENTER').'</option>
                						    </select>
                						</td>
                					</tr>
									<tr id="picklistdetails_'.$blockid.'" style="visibility:hidden;height:30px;">
										<td nowrap="nowrap" align="right" valign="top"><b>'.getTranslatedString('LBL_PICK_LIST_VALUES').':</b></td>
										<td align="left" valign="top">
										      <textarea name="fldPickList" rows="10" class="txtBox" style="width: 85%;height:56px;"></textarea>
										</td>
									</tr>
								</table>
                            </td>
                        </tr>
    				</table>
    			</div>
				<div class="bjui-pageFooter">
				    <ul>
				        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>
						<li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
				    </ul>
				</div>  
	            <script>
					gselected_fieldtype = "#field1_'.$blockid.'";
	            </script>
    			</form>
    			';
        echo $html;
    }elseif($_REQUEST["operatingtype"] == "addnewfieldsave"){
        $fldType = 'Text';
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $tabid = getTabid($fld_module);
        $fldLabel = $_REQUEST["fldLabel"];
        $fldPickList = $_REQUEST["fldPickList"];
        $fldalign = $_REQUEST["fldalign"];
        if(isset($_REQUEST['selectedfieldtype']) && $_REQUEST['selectedfieldtype'] != '')
            $fldType = $_REQUEST['selectedfieldtype'];
        $fldwidth = $_REQUEST["fldwidth"];
        if(isset($_REQUEST["fldmandatory"]) && $_REQUEST["fldmandatory"] == "on")
            $fldmandatory = 'M';
        else
            $fldmandatory = 'O';
        if(isset($_REQUEST["fldmerge_column"]) && $_REQUEST["fldmerge_column"] == "on")
            $fldmerge_column = '1';
        else
            $fldmerge_column = '0';
        if(get_magic_quotes_gpc() == 1){
            $fldLabel = stripslashes($fldLabel);
        }
        $max_fieldid = getUniqueID("fields",'fieldid');
        $columnName = 'cf_'.$max_fieldid;
        $uichekdata='';
        $uitype='';
        if($fldType == 'Line'){
            $uichekdata='V~O';
            $uitype = 444;
            $fldmerge_column = '1';
        }elseif($fldType == 'Text'){
            $uichekdata='V~'.$fldmandatory;
            $uitype = 1;
        }elseif($fldType == 'Number'){
            $uitype = 7;
            $uichekdata='NN~'.$fldmandatory;
        }elseif($fldType == 'Percent'){
            $uitype = 9;
            $uichekdata='N~'.$fldmandatory.'~2~2';
        }elseif($fldType == 'Currency'){
            $uitype = 71;
            $uichekdata='N~'.$fldmandatory;
        }elseif($fldType == 'Date'){
            $uichekdata='D~'.$fldmandatory;
            $uitype = 5;
        }elseif($fldType == 'Email'){
            $uitype = 13;
            $uichekdata='E~'.$fldmandatory;
        }elseif($fldType == 'Phone'){
            $uitype = 11;
            $uichekdata='V~'.$fldmandatory;
        }elseif($fldType == 'Picklist'){
            $uitype = 15;
            $uichekdata='V~'.$fldmandatory;
        }elseif($fldType == 'URL'){
            $uitype = 17;
            $uichekdata='V~'.$fldmandatory;
        }elseif($fldType == 'Checkbox'){
            $uitype = 56;
            $uichekdata='C~'.$fldmandatory;
        }elseif($fldType == 'TextArea'){
            $uitype = 21;
            $uichekdata='V~'.$fldmandatory;
        }elseif($fldType == 'MultiSelectCombo'){
            $uitype = 33;
            $uichekdata='V~'.$fldmandatory;
        }elseif($fldType == 'Skype'){
            $uitype = 85;
            $uichekdata='V~'.$fldmandatory;
        }
        if(isset($blockid) && is_numeric($blockid) && $blockid > '0'){
            $max_fieldsequence_fields = XN_Query::create ( 'Content' )->tag ( 'fields' )
                ->filter ( 'type', 'eic', 'fields' )
                ->filter ( 'my.tabid', '=', $tabid )
                ->order('my.sequence',XN_Order::DESC_NUMBER)
                ->execute ();
            if(count($max_fieldsequence_fields)>0){
                $max_fieldsequence_field_info = $max_fieldsequence_fields[0];
                $max_seq = $max_fieldsequence_field_info->my->sequence;
            }else{
                $max_seq = '0';
            }
			XN_Content::create('fields', 'fields',false)
		       ->my->add('tabid',$tabid)
		       ->my->add('fieldid',$max_fieldid)
		       ->my->add('generatedtype','2')
		       ->my->add('uitype',$uitype)
		       ->my->add('fieldname',$columnName)
		       ->my->add('fieldlabel',$fldLabel)
		       ->my->add('readonly','0')
		       ->my->add('presence','2')
		       ->my->add('maximumlength','100')
		       ->my->add('sequence',$max_seq+1)
		       ->my->add('block',$blockid)
		       ->my->add('displaytype','1')
		       ->my->add('typeofdata',$uichekdata)
		       ->my->add('info_type','BAS')
		       ->my->add('merge_column',$fldmerge_column)
		       ->my->add('deputy_column','0')
		       ->my->add('show_title','1')
		       ->my->add('width',$fldwidth)
		       ->my->add('align',$fldalign)
		       ->my->add('iscustom','1')
		       ->save("fields");
        	if($fldType == 'Picklist' || $fldType == 'MultiSelectCombo'){
				$picklists = XN_Query::create ( 'Content' )->tag ( 'picklists' )
						->filter ( 'type', 'eic', 'picklists' )
						->filter ( 'my.name', '=', $columnName )
						->execute ();
				$picklist_Array = Array();
				$max_sequence = 1;
				$max_picklist_valueid = 1;
				foreach ($picklists as $picklist_info)
				{
					$pickvalue = $picklist_info->my->$columnName;
					if (!in_array($pickvalue, $picklist_Array))
						$picklist_Array[] = $pickvalue;
					$sequence = $picklist_info->my->sequence;
					$picklist_valueid = $picklist_info->my->picklist_valueid;
					if ($sequence > $max_sequence)	$max_sequence = $sequence;
					if ($picklist_valueid > $max_picklist_valueid)	$max_picklist_valueid = $picklist_valueid;
				}
				$pickArray = Array();
				$pickArray = explode("\n",$fldPickList);
				$count = count($pickArray);
				$SaveConn = array();
				for($i = 0; $i < $count; $i++)
				{
					$pickArray[$i] = trim(from_html($pickArray[$i]));
					if($pickArray[$i] != '')
					{
						if (!in_array($pickArray[$i], $picklist_Array))
						{
							$newcontent = XN_Content::create('picklists','',false)
								  ->my->add('name',$columnName);
							$newcontent->my->$columnName = $pickArray[$i];
							$newcontent->my->presence = '1';
							$newcontent->my->sequence = $max_sequence;
							$newcontent->my->picklist_valueid = $max_picklist_valueid;
							$SaveConn[] = $newcontent;
						    $max_sequence = $max_sequence + 1;
						    $max_picklist_valueid = $max_picklist_valueid +1;
						}
					}
				}
				if(count($SaveConn)>0)
				    XN_Content::batchsave($SaveConn,"picklists");
			}
        } 
         echo '{"statusCode":200,"message":null,"divid":"picklistEntries","closeCurrent":"true"}';
		 die();
    }elseif($_REQUEST["operatingtype"] == "modifyfieldinfo"){
        if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ""){
            try{
            	$field = XN_Content::load($_REQUEST["record"],'fields');
            	$mandatory = explode("~",$field->my->typeofdata);
            	$iscustom = false;
            	if($field->my->iscustom == '1')
            	   $iscustom = true;
            	elseif(InStrCount($field->my->fieldname,'cf_',treu) > 0)
            	   $iscustom = true;
            	$isline = false;
            	if($field->my->uitype == '444')
            	    $isline = true;
            	$deputy = false;
            	if($field->my->deputy_column == '1')
            	    $deputy = true;
            	$merge = false;
            	if($field->my->merge_column == '1')
            	    $merge = true;
            	$newrow = false;
            	if($field->my->merge_column == '2')
            	    $newrow = true;
            	$canDeputy = true;
                $field_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
                    ->filter ( 'type', 'eic', 'fields' )
                    ->filter ( 'my.tabid', '=',$field->my->tabid )
                    ->filter ( 'my.block', '=',$field->my->block )
                    ->filter ( 'my.uitype', '!in',array('4','35'))
                    ->filter ( 'my.displaytype', '!=','2')
                    ->filter ( 'my.sequence', '<',intval($field->my->sequence) )
                    ->order('my.sequence',XN_Order::DESC_NUMBER)
                    ->begin(0)->end(-1)
                    ->execute();
            	if(count($field_query)>0){
            	    if($field_query[0]->my->uitype == '444')
            	        $canDeputy = false;
            	}else{
            	    $canDeputy = false;
            	}
				
    			$html = '
	   			<form action="index.php" data-toggle="validate" data-alertmsg="false" method="post"> 
	   		    <div class="bjui-pageContent"> 
    			<input type="hidden" value="Settings" name="module">
    			<input type="hidden" value="ModuleFieldLayout" name="action">
    			<input type="hidden" value="'.$_REQUEST['record'].'" name="record">
                <input type="hidden" value="'.getModule($field->my->tabid).'" name="tabs">
                <input type="hidden" value="'.$field->my->block.'" name="blockid">
    			<input type="hidden" value="fieldinfosave" name="operatingtype">
    			 
    				<table class="table table-bordered table-hover table-striped" cellspacing="0" cellpadding="0" border="0" >'.
    				(($iscustom || $isline)?'
    				    <tr>
    						<td>'.getTranslatedString('LBL_LABEL').'</td>
    						<td align="left" colspan="3"><input name="fldLabel" value="'.$field->my->fieldlabel.'" type="text" style="width:60%" class="textInput '.($isline?'':'required').'"  data-rule="required"></td>
    					</tr>
    				':'')
    					.'
    				    <tr>
    						<td>'.getTranslatedString('LBL_HIDE').'：</td>
    						<td align="center"><input id="presence" name="presence" type="checkbox" style="cursor:pointer;" '.($field->my->presence == '1'?'checked':'').' '.($iscustom?'':($isline?'':'disabled')).'></td>
    						<td>'.getTranslatedString('LBL_MERGE_COLUMN').'：</td>
    						<td align="center"><input onclick="mergecolumnboxclick(this,'.($canDeputy?"true":"false").');" id="merge_column" name="merge_column" type="checkbox" style="cursor:pointer;" '.($merge?'checked':'').' '.(($isline || $deputy || $newrow)?'disabled':'').'></td>
    					</tr>
    					<tr>
    						<td>'.getTranslatedString('LBL_MANDATORY_FIELD').'：</td>
    						<td align="center"><input id="mandatory" name="mandatory" type="checkbox" style="cursor:pointer;" '.($mandatory[1] == 'M'?'checked':'').' '.($isline?'disabled':'').'></td>
    						<td>'.getTranslatedString('LBL_NEWROW_COLUMN').'：</td>
    						<td align="center"><input onclick="newrowcolumnboxclick(this,'.($canDeputy?"true":"false").');" id="newrow_column" name="newrow_column" type="checkbox" style="cursor:pointer;" '.($newrow?'checked':'').' '.(($isline || $deputy || $merge)?'disabled':'').'></td>
    					</tr>
    				    <tr>
    						<td>'.getTranslatedString('LBL_DISPLAY_LABLE').'：</td>
    						<td align="center"><input id="show_title" name="show_title" type="checkbox" style="cursor:pointer;" '.($field->my->show_title == '1'?'checked':'').'></td>
    						<td>'.getTranslatedString('LBL_DEPUTY_COLUMN').'：</td>
    						<td align="center"><input onclick="deputycolumnboxclick(this);" id="deputy_column" name="deputy_column" type="checkbox" style="cursor:pointer;" '.($deputy?'checked':'').' '.(($isline || $merge || $newrow || !$canDeputy)?'disabled':'').'></td>
    					</tr>
    				    <tr>
    						<td>'.getTranslatedString('LBL_EDIT_DISPLAY_WIDTH').'：</td>
    						<td  colspan="3"><input name="fldeidtwidth" value="'.$field->my->editwidth.'" type="text" style="width:64px;" class="textInput '.(($isline || $merge)?'disabled':'').'" '.(($isline || $merge)?'disabled':'').'>&nbsp;&nbsp;(<font color=blue>'.getTranslatedString('LBL_INEDIT').'</font>)</td>
    					</tr>
    				    <tr>
    						<td>'.getTranslatedString('LBL_DISPLAY_WIDTH').'：</td>
    						<td style="padding: 0 4px;" colspan="3">
    						    <select id="display_width" name="display_width" style="cursor:pointer;" '.($isline?'disabled':'').'>
    						        <option value="4" '.($field->my->width == '4'?'selected':'').'> 4'.getTranslatedString('LBL_BYTE').'</option>
    						        <option value="8" '.($field->my->width == '8'?'selected':'').'> 8'.getTranslatedString('LBL_BYTE').'</option>
    						        <option value="12" '.($field->my->width == '12'?'selected':'').'> 12'.getTranslatedString('LBL_BYTE').'</option>
    						        <option value="16" '.($field->my->width == '16'?'selected':'').'> 16'.getTranslatedString('LBL_BYTE').'</option>
    						        <option value="24" '.($field->my->width == '24'?'selected':'').'> 24'.getTranslatedString('LBL_BYTE').'</option>
    						        <option value="36" '.($field->my->width == '36'?'selected':'').'> 36'.getTranslatedString('LBL_BYTE').'</option>
    						    </select>&nbsp;&nbsp;(<font color=blue>'.getTranslatedString('LBL_INLISTVIEW').'</font>)
    						</td>
    					</tr>
    					<tr>
    						<td>'.getTranslatedString('LBL_DISPLAY_ALIGN').'：</td>
    						<td style="padding: 0 4px;" colspan="3">
    						    <select id="display_align" name="display_align" style="cursor:pointer;" '.($isline?'disabled':'').'>
    						        <option value="left" '.($field->my->align == 'left'?'selected':'').'>'.getTranslatedString('LBL_ALIGN_LEFT').'</option>
    						        <option value="right" '.($field->my->align == 'right'?'selected':'').'>'.getTranslatedString('LBL_ALIGN_RIGHT').'</option>
    						        <option value="center" '.($field->my->align == 'center'?'selected':'').'>'.getTranslatedString('LBL_ALIGN_CENTER').'</option>
    						    </select>&nbsp;&nbsp;(<font color=blue>'.getTranslatedString('LBL_INLISTVIEW').'</font>)
    						</td>
    					</tr>
    				</table>
    			</div>
				<div class="bjui-pageFooter">
				    <ul>
				        <li><button type="button" class="btn-close" data-icon="close">取消</button></li>'
						.($iscustom?'<li><button type="button" class="btn-red" data-icon="trash-o" onclick="return deleteCustomField(\''.$_REQUEST['record'].'\',\''.$field->my->fieldlabel.'\',\''.getModule($field->my->tabid).'\',\''.$field->my->block.'\');">删除</button></li>':'')
				        .'<li><button type="submit" class="btn-green" data-icon="save">保存</button></li>
				    </ul>
				</div> 
    			</form>
    			';
				 
    			echo $html;
            }
            catch (XN_Exception $ex){
                echo getTranslatedString('Field Information not found');
            }
        }else{
            echo getTranslatedString('Field Information not found');
        }
    }elseif($_REQUEST["operatingtype"] == "fieldinfosave"){
        if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ''){
            $record = $_REQUEST["record"];
            $fld_module = $_REQUEST["tabs"];
            $blockid = $_REQUEST["blockid"];
            try{
                $fieldConn = XN_Content::load($record,'fields');
                $deputy = '0';
                if(isset($_REQUEST['deputy_column']) && $_REQUEST['deputy_column'] == 'on')
                    $deputy = '1';
                $mandatory = explode("~",$fieldConn->my->typeofdata);
                if(isset($_REQUEST['mandatory']) && $_REQUEST['mandatory'] == 'on')
                    $mandatory[1] = 'M';
                else
                    $mandatory[1] = 'O';
                $mandatory = implode("~", $mandatory);
                if($fieldConn->my->uitype == '444')
                    $merge = '1';
                else{
                    $merge = '0';
                    if(isset($_REQUEST['newrow_column']) && $_REQUEST['newrow_column'] == 'on')
                        $merge = '2';
                    if(isset($_REQUEST['merge_column']) && $_REQUEST['merge_column'] == 'on')
                        $merge = '1';
                }
                $presence = '0';
            	if($fieldConn->my->iscustom == '1')
            	   $presence = '2';
            	elseif(InStrCount($fieldConn->my->fieldname,'cf_',true) > 0)
            	   $presence = '2';
                if(isset($_REQUEST['presence']) && $_REQUEST['presence'] == 'on')
                    $presence = '1';
                $showtitle = '0';
                if(isset($_REQUEST['show_title']) && $_REQUEST['show_title'] == 'on')
                    $showtitle = '1';
                $label = $fieldConn->my->fieldlabel;
                if(isset($_REQUEST['fldLabel']))
                    $label = $_REQUEST['fldLabel'];

                $fieldConn->my->align = $_REQUEST['display_align'];
                $fieldConn->my->deputy_column = $deputy;
                $fieldConn->my->fieldlabel = $label;
                $fieldConn->my->merge_column = $merge;
                $fieldConn->my->presence = $presence;
                $fieldConn->my->show_title = $showtitle;
                $fieldConn->my->typeofdata = $mandatory;
                $fieldConn->my->width = $_REQUEST['display_width'];
                $fieldConn->my->editwidth = $_REQUEST["fldeidtwidth"];
                $fieldConn->save('fields');
                $params = array("module"=>$fld_module,"blockid"=>$blockid);
                echo '{"statusCode":200,"message":null,"divid":"picklistEntries","closeCurrent":"true"}';
            }catch(XN_Exception $ex){
                echo '{"statusCode":300,"message":"'.$ex->getMessage().'"}';
            }
        }else{
            echo '{"statusCode":300,"message":"参数信息不全！"}';
        }
    }elseif($_REQUEST["operatingtype"] == "fieldinfodelete"){
        if(isset($_REQUEST["record"]) && $_REQUEST["record"] != ''){
            $record = $_REQUEST["record"];
            XN_Content::delete($record,'fields');
        }
        $params = array("module"=>$_REQUEST["tabs"],"blockid"=>$_REQUEST["blockid"]);
        echo json_encode($params);
    }elseif($_REQUEST["operatingtype"] == "blockmoveupdown"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $movetype = $_REQUEST["movetype"];
        $blocks_old = XN_Query::create ( 'Content' )->tag ( 'blocks' )
        	->filter ( 'type', 'eic', 'blocks' )
        	->filter ( 'my.tabid', '=', getTabid($fld_module) )
        	->filter ( 'my.blockid', '=', $blockid )
        	->order ( 'my.sequence ', XN_Order::ASC_NUMBER )
        	->execute ();
        if(count($blocks_old)>0){
            $blocks_old_sequence = $blocks_old[0]->my->sequence;
            $blocks_new = XN_Query::create ( 'Content' )->tag ( 'blocks' )
                ->filter ( 'type', 'eic', 'blocks' )
                ->filter ( 'my.tabid', '=', getTabid($fld_module) );
            if(isset($movetype) && $movetype == 'up'){
                $blocks_new->filter ( 'my.sequence', '<', intval($blocks_old_sequence) );
                $blocks_new->order ( 'my.sequence ', XN_Order::DESC_NUMBER );
            }elseif(isset($movetype) && $movetype == 'down'){
                $blocks_new->filter ( 'my.sequence', '>', intval($blocks_old_sequence) );
                $blocks_new->order ( 'my.sequence ', XN_Order::ASC_NUMBER );
            }
            $blocks_new = $blocks_new->execute();
            if(count($blocks_new)>0){
                $blocks_old[0]->my->sequence = $blocks_new[0]->my->sequence;
                $blocks_new[0]->my->sequence = $blocks_old_sequence;
                XN_Content::batchsave(array($blocks_old[0],$blocks_new[0]),"blocks");
                $params = array("module"=>$_REQUEST["tabs"],"blocks"=>array("block1"=>$blocks_old[0]->my->blockid,"block2"=>$blocks_new[0]->my->blockid));
            }else{
                $params = array("module"=>$_REQUEST["tabs"],"blocks"=>array("block1"=>"0","block2"=>"0"));
            }
        }else{
            $params = array("module"=>$_REQUEST["tabs"],"blocks"=>array("block1"=>"0","block2"=>"0"));
        }
        echo json_encode($params);
    }elseif($_REQUEST["operatingtype"] == "fieldmoveleftright"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $movetype = $_REQUEST["movetype"];
        $record = $_REQUEST["record"];
        $deputyids = array();
        $fieldFrom = array();
        $fieldTo = array();
        if(isset($_REQUEST["deputyids"]) && $_REQUEST["deputyids"] != ''){
            $deputyids = explode(';', $_REQUEST["deputyids"]);
            $deputyids = array_filter($deputyids);
            $deputyids[] = $record;
            $fields_query = XN_Content::load_Many($deputyids,'fields');
            foreach($fields_query as $info){
                $fieldFrom[$info->my->sequence] = $info;
            }
        }else{
            $fields_query = XN_Content::load($record,'fields');
            $fieldFrom[$fields_query->my->sequence] = $fields_query;
        }
        $fields_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
            ->filter ( 'type', 'eic', 'fields' )
            ->filter ( 'my.tabid', '=',getTabid($fld_module) )
            ->filter ( 'my.block', '=',$blockid )
            ->filter ( 'my.uitype', '!in',array('4','35'))
            ->filter ( 'my.deputy_column', '!=','1')
            ->filter ( 'my.displaytype', '!=','2');
        if($movetype == "left"){
            ksort($fieldFrom);
            $tmp = array_keys($fieldFrom);
            $fields_query->filter ( 'my.sequence', '<',intval($tmp[0]) );
            $fields_query->order('my.sequence',XN_Order::DESC_NUMBER);
        }elseif($movetype == "right"){
            krsort($fieldFrom);
            $tmp = array_keys($fieldFrom);
            $fields_query->filter ( 'my.sequence', '>',intval($tmp[0]) );
            $fields_query->order('my.sequence',XN_Order::ASC_NUMBER);
        }
        $fields_query = $fields_query->execute();
        if(count($fields_query)>0){
            $tosequence = $fields_query[0]->my->sequence;
            $fieldTo[$tosequence] = $fields_query[0];
            $fields_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
                ->filter ( 'type', 'eic', 'fields' )
                ->filter ( 'my.tabid', '=',getTabid($fld_module) )
                ->filter ( 'my.block', '=',$blockid )
                ->filter ( 'my.uitype', '!in',array('4','35'))
                ->filter ( 'my.displaytype', '!=','2')
                ->filter ( 'my.sequence', '>',intval($tosequence) )
                ->order('my.sequence',XN_Order::ASC_NUMBER)
                ->execute();
            foreach($fields_query as $info){
                if($info->my->deputy_column == '1')
                    $fieldTo[$info->my->sequence] = $info;
                else
                    break;
            }
            ksort($fieldTo);
        }
        if(count($fieldFrom)>0 && count($fieldTo)>0){
            ksort($fieldFrom);
            ksort($fieldTo);
            $fromKey = array_keys($fieldFrom);
            $toKey = array_keys($fieldTo);
            if($fromKey[0]>$toKey[0]){
                $ringKey = $fromKey;
                foreach($toKey as $info){
                    $ringKey[] = $info;
                }
                $oldKey = $toKey;
                foreach($fromKey as $info){
                    $oldKey[] = $info;
                }
            }else{
                $ringKey = $toKey;
                foreach($fromKey as $info){
                    $ringKey[] = $info;
                }
                $oldKey = $fromKey;
                foreach($toKey as $info){
                    $oldKey[] = $info;
                }
            }
            $saveConn = array();
            foreach($ringKey as $key => $se){
                if(array_key_exists($se, $fieldFrom)){
                    $info = $fieldFrom[$se];
                    $info->my->sequence = $oldKey[$key];
                    $saveConn[$se] = $info;
                }elseif(array_key_exists($se, $fieldTo)){
                    $info = $fieldTo[$se];
                    $info->my->sequence = $oldKey[$key];
                    $saveConn[$se] = $info;
                }
            }
            $tmp = $saveConn[$ringKey[0]]->my->merge_column;
            $saveConn[$ringKey[0]]->my->merge_column = $saveConn[$oldKey[0]]->my->merge_column;
            $saveConn[$oldKey[0]]->my->merge_column = $tmp;
            if(count($saveConn)>0)
                XN_Content::batchsave($saveConn,"fields");
        }
        $params = array("module"=>$fld_module,"blockid"=>$blockid);
        echo json_encode($params);
    }elseif($_REQUEST["operatingtype"] == "fieldmoveupdown"){
        $fld_module = $_REQUEST["tabs"];
        $blockid = $_REQUEST["blockid"];
        $movetype = $_REQUEST["movetype"];
        $record = $_REQUEST["record"];
        $b_columns = $_REQUEST["b_columns"];
        $f_columns = $_REQUEST["f_columns"];
        $deputyids = array();
        $fieldFrom = array();
        $fieldTo = array();
        if(isset($_REQUEST["deputyids"]) && $_REQUEST["deputyids"] != ''){
            $deputyids = explode(';', $_REQUEST["deputyids"]);
            $deputyids = array_filter($deputyids);
            $deputyids[] = $record;
            $fields_query = XN_Content::load_Many($deputyids,'fields');
            foreach($fields_query as $info){
                $fieldFrom[$info->my->sequence] = $info;
            }
        }else{
            $fields_query = XN_Content::load($record,'fields');
            $fieldFrom[$fields_query->my->sequence] = $fields_query;
        }
        $fromKey = array_keys($fieldFrom);
        sort($fromKey);
        $fields_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
        ->filter ( 'type', 'eic', 'fields' )
        ->filter ( 'my.tabid', '=',getTabid($fld_module) )
        ->filter ( 'my.block', '=',$blockid )
        ->filter ( 'my.uitype', '!in',array('4','35'))
        ->filter ( 'my.deputy_column', '!=','1')
        ->filter ( 'my.displaytype', '!=','2');
        if($movetype == "up"){
            ksort($fieldFrom);
            $tmp = array_keys($fieldFrom);
            $fields_query->filter ( 'my.sequence', '<',intval($tmp[0]) );
            $fields_query->order('my.sequence',XN_Order::ASC_NUMBER);
        }elseif($movetype == "down"){
            krsort($fieldFrom);
            $tmp = array_keys($fieldFrom);
            $fields_query->filter ( 'my.sequence', '>',intval($tmp[0]) );
            $fields_query->order('my.sequence',XN_Order::ASC_NUMBER);
        }
        $fields_query = $fields_query->execute();
        $tmparray = array();
        $fields = array();
        if(count($fields_query)>0){
            $tmpindex = 1;
            if($movetype == "down" && $fieldFrom[$fromKey[0]]->my->merge_column != '1' && $fieldFrom[$fromKey[0]]->my->uitype != '444'){
                $tmpindex = $f_columns + 1;
                if($tmpindex > $b_columns)
                    $tmpindex = 1;
            }
            $upcolumn = '0';
            foreach($fields_query as $info){
                if($info->my->merge_column != '0' || $info->my->uitype == '444' || $upcolumn != '0'){
                    $tmpindex = 1;
                }
                if($info->my->merge_column == '1' || $info->my->uitype == '444')
                    $upcolumn = $info->my->merge_column;
                else
                    $upcolumn = '0';
                $tmparray[$info->my->sequence] = $tmpindex;
                $fields[$info->my->sequence] = $info;
                $tmpindex++;
                if($tmpindex > $b_columns)
                    $tmpindex = 1;
            }
            if($movetype == "up")
                krsort($tmparray);
            $upkey = '';
            $uprow = false;
            $tosequence = '';
            foreach($tmparray as $key=>$value){
                if($fields[$key]->my->merge_column != '1' && $fields[$key]->my->uitype != '444'){
                    if($fieldFrom[$fromKey[0]]->my->merge_column != '1' && $fieldFrom[$fromKey[0]]->my->uitype != '444'){
                        if($uprow && $value < $f_columns && $movetype == "up"){
                            $tosequence = $upkey;
                            break;
                        }
                        if($uprow && $value == '1' && $value < $f_columns && $movetype == "down"){
                            $tosequence = $upkey;
                            break;
                        }
                        if($value == $f_columns){
                            $tosequence = $key;
                            break;
                        }
                    }else{
                        if($movetype == "up"){
                            if($value == $f_columns){
                                $tosequence = $key;
                                break;
                            }
                        }
                        if($movetype == "down"){
                            if($uprow && $value == '1'){
                                $tosequence = $upkey;
                                break;
                            }
                            if($uprow && $value == $f_columns){
                                $tosequence = $key;
                                break;
                            }
                        }else{
                            $uprow = false;
                        }
                    }
                    if(!$uprow && $value == '1')
                        $uprow = true;
                }else{
                    if($fieldFrom[$fromKey[0]]->my->merge_column != '1' && $fieldFrom[$fromKey[0]]->my->uitype != '444'){
                        if($movetype == "up"){
                            if($uprow && $value == $f_columns){
                                $tosequence = $key;
                                break;
                            }
                        }
                        if($movetype == "down"){
                            if($uprow && $value == '1'){
                                $tosequence = $upkey;
                                break;
                            }
                            if($uprow && $value == $f_columns){
                                $tosequence = $upkey;
                                break;
                            }else{
                                $uprow = false;
                            }
                        }
                    }else{
                        if($movetype == "up"){
                            $tosequence = $key;
                            break;
                        }
                        if($movetype == "down"){
                            if($upkey == ""){
                                $tosequence = $key;
                            }else
                                $tosequence = $upkey;
                            break;
                        }
                    }
                }
                $upkey = $key;
            }
            if($tosequence == "")
                $tosequence = $upkey;
            if($tosequence != ""){
                $fieldTo[$tosequence] = $fields[$tosequence];
                $fields_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
                ->filter ( 'type', 'eic', 'fields' )
                ->filter ( 'my.tabid', '=',getTabid($fld_module) )
                ->filter ( 'my.block', '=',$blockid )
                ->filter ( 'my.uitype', '!in',array('4','35'))
                ->filter ( 'my.displaytype', '!=','2')
                ->filter ( 'my.sequence', '>',intval($tosequence) )
                ->order('my.sequence',XN_Order::ASC_NUMBER)
                ->execute();
                foreach($fields_query as $info){
                    if($info->my->deputy_column == '1')
                        $fieldTo[$info->my->sequence] = $info;
                    else
                        break;
                }
                ksort($fieldFrom);
                ksort($fieldTo);
                $toKey = array_keys($fieldTo);
                $fromKey = array_keys($fieldFrom);
                $tmparray = array();
                $fields_query = XN_Query::create ( 'Content' )->tag ( 'fields' )
                ->filter ( 'type', 'eic', 'fields' )
                ->filter ( 'my.tabid', '=',getTabid($fld_module) )
                ->filter ( 'my.block', '=',$blockid )
                ->filter ( 'my.uitype', '!in',array('4','35'))
                ->filter ( 'my.displaytype', '!=','2')
                ->order('my.sequence',XN_Order::ASC_NUMBER);
                if($movetype == "up"){
                    rsort($toKey);
                    sort($fromKey);
                    $fields_query->filter ( 'my.sequence', '<',intval($fromKey[0]) );
                    $fields_query->filter ( 'my.sequence', '>',intval($toKey[0]) );
                }elseif($movetype == "down"){
                    rsort($fromKey);
                    sort($toKey);
                    $fields_query->filter ( 'my.sequence', '>',intval($fromKey[0]) );
                    $fields_query->filter ( 'my.sequence', '<',intval($toKey[0]) );
                }
                $fields_query = $fields_query->execute();
                foreach($fields_query as $info){
                    $tmparray[$info->my->sequence] = $info;
                }
                $fromKey = array_keys($fieldFrom);
                $toKey = array_keys($fieldTo);
                $tmpkey = array();
                if(count($tmparray)>0){
                    $tmpkey = array_keys($tmparray);
                }
                if($fromKey[0]>$toKey[0]){
                    $ringKey = $fromKey;
                    if($fieldFrom[$fromKey[0]]->my->merge_column == '1' || $fieldFrom[$fromKey[0]]->my->uitype == '444'){
                        foreach($toKey as $info){
                            $ringKey[] = $info;
                        }
                        foreach($tmpkey as $info){
                            $ringKey[] = $info;
                        }
                    }else{
                        foreach($tmpkey as $info){
                            $ringKey[] = $info;
                        }
                        foreach($toKey as $info){
                            $ringKey[] = $info;
                        }
                    }
                }else{
                    if($fieldFrom[$fromKey[0]]->my->merge_column == '1' || $fieldFrom[$fromKey[0]]->my->uitype == '444'){
                        $ringKey = $tmpkey;
                        foreach($toKey as $info){
                            $ringKey[] = $info;
                        }
                        foreach($fromKey as $info){
                            $ringKey[] = $info;
                        }
                    }else{
                        $ringKey = $toKey;
                        foreach($tmpkey as $info){
                            $ringKey[] = $info;
                        }
                        foreach($fromKey as $info){
                            $ringKey[] = $info;
                        }
                    }
                }
                $oldKey = $ringKey;
                sort($oldKey);
                $saveConn = array();
                foreach($ringKey as $key => $se){
                    if(array_key_exists($se, $fieldFrom)){
                        $info = $fieldFrom[$se];
                        $info->my->sequence = $oldKey[$key];
                        $saveConn[$se] = $info;
                    }elseif(array_key_exists($se, $fieldTo)){
                        $info = $fieldTo[$se];
                        $info->my->sequence = $oldKey[$key];
                        $saveConn[$se] = $info;
                    }elseif(array_key_exists($se, $tmparray)){
                        $info = $tmparray[$se];
                        $info->my->sequence = $oldKey[$key];
                        $saveConn[$se] = $info;
                    }
                }
                if($fieldFrom[$fromKey[0]]->my->merge_column != '1' && $fieldFrom[$fromKey[0]]->my->uitype != '444'){
                    if($saveConn[$ringKey[0]]->my->merge_column == '2' || $saveConn[$oldKey[0]]->my->merge_column == '2'){
                        $tmp = $saveConn[$ringKey[0]]->my->merge_column;
                        $saveConn[$ringKey[0]]->my->merge_column = $saveConn[$oldKey[0]]->my->merge_column;
                        $saveConn[$oldKey[0]]->my->merge_column = $tmp;
                    }
                }
                if(count($saveConn)>0)
                    XN_Content::batchsave($saveConn,"fields");
            }
        }

        $params = array("module"=>$fld_module,"blockid"=>$blockid,"from"=>array_keys($fieldFrom),"fieldTo"=>array_keys($fieldTo),"ringKey"=>$ringKey,"oldKey"=>$oldKey);
        echo json_encode($params);
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
	$smarty->display('Settings/ModuleFieldLayout.tpl');
}



function InStrCount($String,$Find,$CaseSensitive = false) {
    $i=0;
    $x=0;
    $substring = '';
    while (strlen($String)>=$i) {
        unset($substring);
        if ($CaseSensitive) {
            $Find=strtolower($Find);
            $String=strtolower($String);
        }
        $substring=substr($String,$i,strlen($Find));
        if ($substring==$Find) $x++;
        $i++;
    }
    return $x;
}

?>