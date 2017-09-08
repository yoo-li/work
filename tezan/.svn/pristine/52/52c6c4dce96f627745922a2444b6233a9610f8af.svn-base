<?php

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

$smarty = new vtigerCRM_Smarty;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY",getParentTab());

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='') 
{
	$readonly = $_REQUEST['readonly'];
//	$readonly = 'true';
	$smarty->assign("READONLY", $readonly);
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') {
    $record=$_REQUEST['record'];
    $productContent = XN_Content::load($_REQUEST['record'],strtolower($currentModule));
	
	$approvalstatus = $productContent->my->approvalstatus;
	if( $approvalstatus == '2')
	{
		$readonly = 'true';
	}
    $property_type="";
    $productContent->my->property_type!="" && $property_type=$productContent->my->property_type;
    $productContent->my->myproperty_type!="" && $property_type=$productContent->my->myproperty_type;

	if($property_type != "")
		$property_type = json_decode($property_type);
	$typelist = array();
	$picklists = XN_Query::create ( 'Content' )->tag('picklists')
		->filter ( 'type', 'eic', 'picklists' )
		->filter ( 'my.name', '=', 'property_type' )
		->order('my.sequence',XN_Order::ASC_NUMBER)
		->begin(0)->end(-1)	
		->execute ();
	foreach($picklists as $pl){
		$typelist[$pl->my->sequence] = $pl->my->property_type;
	}
    $propertys=XN_Query::create ( 'Content' )->tag('mall_propertys')
        ->filter ( 'type', 'eic', 'mall_propertys' )
		->filter ( 'my.status', '=', '0' )
        ->filter ( 'my.productid', '=', $record )
        ->begin(0)->end(-1)
        ->execute ();
    $property_records=array();
    if(count($propertys)){
        foreach($propertys as $property_info){
            $property_records[$property_info->my->property_value]=array("id"=>$property_info->id,"status"=>$property_info->my->status);
        }
    } 

	$datadiv = '<style>.gray{background-color: gray;}.white{background-color: #ffffff;}</style>
	            <table class="table table-bordered" style="width:70%;margin-left:15%;" border="0" cellspacing="0" cellpadding="0"><tr>';
	$datadiv .= '<td>属性类型：</td>';
	$datadiv .= '<td colspan="3">';
	$selected = array();
	foreach($typelist as $key => $pl){
		$selected[$pl] = 0;
		$isClecked = "";
		if(isset($property_type->$pl)){
			$isClecked = " checked ";
			$selected[$pl] = 1;
		}
		if($readonly == 'true')
			$isClecked .= ' disabled ';
		$datadiv .= '<span class="left" style="padding-right: 8px;">';
		$datadiv .= '<input id="property_type_'.$key.'" type="checkbox" '.$isClecked.' style="cursor: pointer;margin-top: 5px;" name="property_type" onclick="return propertyOnclick(this,\''.$pl.'\');">';
		$datadiv .= '<label for="property_type_'.$key.'" style="cursor: pointer;width:auto;padding: 0;">&nbsp;'.$pl.'</label>';
		$datadiv .= '</span>';
	}
	$datadiv .= '<input type="hidden" value=\''.json_encode($selected).'\' id="property_type_list" name="property_type_list"/>';
	$datadiv .= '</td></tr><tr>';
	$datadiv .= '<td>类型定义：</td>';
	$datadiv .= '<td colspan="3">';
	$datadiv .= '<table id="propertyTab" name="propertyTab" class="table table-bordered table-hover table-striped" style="width:70%"><tbody>';
	if($property_type != null){
		foreach($property_type as $key => $value){
			$datadiv .= '<tr height="25px" id="property_'.$key.'">';
			$datadiv .= '<td width="15%">'.$key.'：<input type="hidden" name="property_type[]" value="'.$key.'"></td>';
			$datadiv .= '<td width="85%">';
			$datadiv .= '<table id="delimit_'.$key.'_Tab" name="delimit_'.$key.'_Tab" class="table table-bordered" style="width:100%">';
			$cids = array();
            $records=array();
			$cid = 1;
			foreach($value as $info){
				$cids[] = $cid;
                $records[]=$property_records[$info]["id"];
                $status=$property_records[$info]["status"];
                if($status=="hidden"){
                    $class="gray";
                }else{
                    $class="";
                }
				$datadiv .= "<tr id='delimit_".$key."_".$cid."' class='".$class."'>";
				$datadiv .= "<td align='center' width='90%' >";
				$datadiv .= '
				<input type="hidden" name="property_type_'.$key.'[]" value="'.$info.'">
				<input style="width:100%;"  maxlength="20" value="'.$info.'" name="propertydesc_'.$key.'_'.$cid.'" id="propertydesc_'.$key.'_'.$cid.'" data-rule="required" class="required"';
				if($readonly == 'true')
					$datadiv .= ' disabled ';
				$datadiv .= ' onchange="propertychange();"/></td>';
				if($readonly != 'true'){
					$datadiv .= "<td align='center' width='10%'>";
					$datadiv .= '<button type="button" onclick="delete_property_delimit(\'delimit\',\''.$key.'\',\''.$cid.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
								</td>';
				}
				$datadiv .= "</tr>";
				$cid ++;
			}
			if ($readonly != 'true'){
				$datadiv .= "<tr id='row_".$key."_add' class='edit-form-tr'>";
				$datadiv .= "<td style='text-align:center;width:100%'>&nbsp;</td>";
				$datadiv .= "<td style='text-align:center' class=''>";
				$datadiv .= '<button type="button" onclick="add_property_delimit(\'delimit\',\''.$key.'\');" class="btn btn-green" data-icon="plus"><i class="fa fa-plus"></i></button>';
				$datadiv .= "</td></tr>";
			}
			$datadiv .= '</table>';
			$datadiv .= '<input type="hidden" value="'.implode(',',$cids).'" id="'.$key.'_list" name="'.$key.'_list"/>
            <input type="hidden" value="'.implode(',',$records).'" id="'.$key.'_record" name="'.$key.'_record"/>
			<input type="hidden" value="'.$cid.'" id="'.$key.'_auto" name="'.$key.'_auto"/>';
			$datadiv .= '</td></tr>';
		}
	}
	$datadiv .= '</tbody></table>';
	if ($readonly != 'true'){
		$datadiv .= '</td></tr><tr class="edit-form-tr">';
		$datadiv .= '<td class="edit-form-tdlabel mandatory">&nbsp;</td>';
		$datadiv .= '<td class="edit-form-tdinfo" colspan="3">';
		$isShow = "";
		if(!isset($property_type) || $property_type == "" || count($property_type)<= 0)
			$isShow = "display:none;";
		$datadiv .= '<a id="create_price_list_btn" style="width:100px;text-align:left;" class="btn btn-default" onclick="create_price_list(\''.$record.'\');" ><i class="fa fa-hand-pointer-o"></i> 创建价格列表</a>';
	}
	$datadiv .= '</td></tr><tr class="edit-form-tr">';
	$datadiv .= '<td class="edit-form-tdlabel mandatory">综合价格：</td>';
	$datadiv .= '<td class="edit-form-tdinfo" colspan="3">';
	$datadiv .= '<table id="priceTab" name="priceTab" class="table table-bordered" style="width:100%"><tbody><tr>';

	$contactsfields = array(array('LBL_PROPERTY_ID',''),array('LBL_PROPERTY_DESCRIPTION','30%'),array('LBL_PROPERTY_IMG','20%'),array('LBL_PROPERTY_MARKET','12%'),array('LBL_PROPERTY_PRICE','12%'),array('LBL_PROPERTY_INVENTORYS','12%'),array('LBL_PROPERTY_RECOMMEND',''));
	foreach($contactsfields as  $fieldname_cn )
	{
		$datadiv .= "<th align='center' width='".$fieldname_cn[1]."' style='white-space: nowrap;'><b>".getTranslatedString($fieldname_cn[0])."</b></th>";
	}
	$datadiv .= '</tr>';

	$details = XN_Query::create ( 'Content' )->tag('mall_product_property')
		->filter ( 'type', 'eic', 'mall_product_property' )
		->filter ( 'my.productid', '=', $_REQUEST['record'] )
		->filter ( 'my.status', '=', '0' )
        ->filter('my.deleted','=','0')
		->order('published',XN_Order::ASC)
		->begin(0)->end(-1)	
		->execute ();
	$cids = array();
	$cid = 1;
	foreach($details as $info){
		$cids[] = $cid;
        if($info->my->status=="hidden"){
            $class="edit-form-tr gray";
        }else{
            $class="edit-form-tr";
        }
		$datadiv .= "<tr id='complexpice_row_".$cid."' class='".$class."'>";
		$datadiv .= "<td align='center'><label style='width:99%;text-align:center;'>".$cid."</label></td>";
		$datadiv .= '<td align="center">';
		$propertydesc = $info->my->propertydesc; 
		$propertyids = $info->my->propertyids;
		 
		if (isset($propertyids) && $propertyids != "")
		{
			$newpropertydesc = array();
			foreach($property_records as $value => $perperty_record_info)
			{
				$propertyid = $perperty_record_info['id']; 
				if (in_array($propertyid,(array)$propertyids))
				{
					$newpropertydesc[] = $value;
				}
			}
			$newpropertydesc = join("~^~",$newpropertydesc);
		}	
		else
		{
			$newpropertydesc = $propertydesc;
		}
		$datadiv .= '<input id="complexpice_desc_'.$cid.'" type="hidden" name="complexpice_desc_'.$cid.'" value="'.$newpropertydesc.'">';
		if(isset($info->my->taobao_sku_id) && $info->my->taobao_sku_id!=''){
            $datadiv.='<input type="hidden" name="taobao_sku_id_'.$cid.'" value="'.$info->my->taobao_sku_id.'">
                        <input type="hidden" name="barcode_'.$cid.'" value="'.$info->my->barcode.'">';
        }
        $datadiv .= '<label style="width:99%;text-align:right;">'.$propertydesc.'</label>';
		$datadiv .= '</td>';

        $datadiv .= '<td style="text-align: center; width: 20%;">';
        if($info->my->imgurl!=""){
            $datadiv .= '<input type="hidden" name="complexpice_img_'.$cid.'" id="complexpice_img_'.$cid.'" value="'.$info->my->imgurl.'">
            <a id="complexpice_img_link_'.$cid.'" href="'.$info->my->imgurl.'"  data-lightbox="roadtrip">
                <img id="complexpice_img_view_'.$cid.'" align="absmiddle" height="20px" src="'.$info->my->imgurl.'"/>
            </a>';
        }else{
            $datadiv.='
               <input type="hidden" name="complexpice_img_'.$cid.'" id="complexpice_img_'.$cid.'" value="">
                <a id="complexpice_img_link_'.$cid.'" href=""  data-lightbox="roadtrip">
                    <img id="complexpice_img_view_'.$cid.'" align="absmiddle" height="20px" src=""/>
                </a>
            ';
        }
        if($readonly == 'false'){
            if($info->my->imgurl!=""){
                $datadiv.='
                <button type="button" id="complexpice_img_delete_'.$cid.'" onclick="delete_uploadinfo(\''.$cid.'\');" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
                <button type="button" style="display:none;" id="complexpice_img_select_'.$cid.'" onclick="show_upload_div(\''.$cid.'\',\''.$record.'\')" class="btn btn-green" data-icon="edit"><i class="fa fa-edit"></i></button>
                ';
            }else{
                $datadiv.='
                <button type="button" id="complexpice_img_delete_'.$cid.'" onclick="delete_uploadinfo(\''.$cid.'\');" style="display:none;" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
                <button type="button" style="display:inline;" id="complexpice_img_select_'.$cid.'" onclick="show_upload_div(\''.$cid.'\',\''.$record.'\')" class="btn btn-green" data-icon="edit"><i class="fa fa-edit"></i></button>
                ';
            }
        }
        $datadiv .= '</td>';

        $datadiv .= '<td style="text-align: center; width: 12%;">';
		$datadiv .= '<input style="width:100%;text-align:right;" value="'.$info->my->market.'" name="complexpice_market_'.$cid.'" id="complexpice_market_'.$cid.'" data-rule="required" class="required form-control" onkeypress="return isNumbers(event,true);"';
		if($readonly == 'true')
			$datadiv .= ' disabled ';
		$datadiv .= ' /></td>';
		$datadiv .= '<td style="text-align: center; width: 12%;">';
		$datadiv .= '<input style="width:100%;text-align:right;" value="'.$info->my->shop.'" name="complexpice_shop_'.$cid.'" id="complexpice_shop_'.$cid.'" data-rule="required" class="required form-control"  onkeypress="return isNumbers(event,true);"';
		if($readonly == 'true')
			$datadiv .= ' disabled ';
		$datadiv .= ' /></td>';
		$datadiv .= '<td style="text-align: center; width: 12%;">';
		$datadiv .= '<input style="width:100%;text-align:center;" value="'.$info->my->inventorys.'" name="complexpice_inventorys_'.$cid.'" id="complexpice_inventorys_'.$cid.'" data-rule="required" class="required form-control"  onkeypress="return isNumbers(event,false);"';
		if($readonly == 'true')
			$datadiv .= ' disabled ';
		$datadiv .= ' /></td>';
		$datadiv .= '<td style="text-align: center;">';
		$datadiv .= '<input name="complexpice_recommend_'.$cid.'" id="complexpice_recommend_'.$cid.'" type="checkbox" style="cursor: pointer;"';
		if($readonly == 'true')
			$datadiv .= ' disabled ';
		if($info->my->recommend == '1')
			$datadiv .= ' checked ';
		$datadiv .= ' /></td>';
		$datadiv .= "</tr>";
		$cid ++;
	}

	$datadiv .= '</tbody></table>';
	$datadiv .= '<input type="hidden" value="'.implode(',',$cids).'" id="complexpice_list" name="complexpice_list"/>';
	$datadiv .= '</td>';
	$datadiv .= '</tr></table>';
}

$script = '
function propertychange(){
	clear_pice_list();
}

function propertyOnclick(obj,type){
	if(obj.checked)
		add_property(type);
	else
		return delete_property(type);
}

function show_upload_div(cid,record){
	var url="index.php?module=Mall_Products&action=propertyalbum&mode=edit&cid="+cid+"&record="+record;
	$(this).dialog({id:"uploadpropertyimg", url:url, title:"上传属性图片",width:835,height:480,mask:true,resizable:false,drawable:false,maxable:false});
}

function delete_uploadinfo(cid){
    $("#complexpice_img_"+cid).val("");
    $("#complexpice_img_link_"+cid).attr("href","").css("display","none");
    $("#complexpice_img_view_"+cid).attr("src","");
    $("#complexpice_img_delete_"+cid).css("display","none");
    $("#complexpice_img_select_"+cid).css("display","inline");
}

function add_property(type){
	clear_pice_list();
	var tableName = document.getElementById("propertyTab");
	var prev = tableName.rows.length;
	var count = eval(prev);//As the table has two headers, we should reduce the count
	var row = tableName.insertRow(count);
	
	row.id = "property_"+type;
	row.className = "";
	row.style.height = "25px";
	row.style.width="15%";
	var coltwo = row.insertCell(0);
	var colthree = row.insertCell(1);
	
	coltwo.className = "edit-form-tdlabel mandatory";
	coltwo.innerHTML = type+"：";
	coltwo.style.width="15%";
	colthree.className = "edit-form-tdinfo";
	colthree.innerHTML = "<table id=\'delimit_"+type+"_Tab\' class=\'table table-bordered\' style=\'width:100%\' name=\'delimit_"+type+"_Tab\'><tbody>"+
			"<tr><td width=\'90%\'></td><td width=\'10%\' align=\'center\'>"+
			"<button type=\'button\' onclick=\'add_property_delimit(\"delimit\",\""+type+"\");\' class=\'btn btn-red\' data-icon=\'plus\'>"+
				"<i class=\'fa fa-plus\'></i>"+
			"</button>"+
			"</tbody></table>"+
			"<input type=\'hidden\' value=\'\' id=\'"+type+"_list\' name=\'"+type+"_list\'/>"+
			"<input type=\'hidden\' value=\'1\' id=\'"+type+"_auto\' name=\'"+type+"_auto\'/>"
			"</td></tr>";

	var delimitlist = $("#property_type_list").val();
	delimitlist = eval("("+delimitlist+")");
	for(var key in delimitlist)
		if(key == type){
			delimitlist[key] = 1;
			break;
		}
	$("#property_type_list").val(JSON.stringify(delimitlist));
	$("#create_price_list_btn").css("display","block");
}

function delete_property(type){
	var isdelete = false;
	var delimitlist = $("#"+type+"_list").val();
	if(delimitlist != "" && delimitlist != null)
		isdelete = confirm("'.getTranslatedString('DELETE_PROPERTY_NO_EMPTY').'\n\t"+type);
	else
		isdelete = true;
	if(isdelete){
		clear_pice_list();
		var tableName = document.getElementById("propertyTab");
		var tbody=tableName.getElementsByTagName("tbody");
		var row = document.getElementById("property_"+type);
		if(tbody!=null)
			tbody[0].removeChild(row);
		else
			tableName.removeChild(row);	
		var delimitlist = $("#property_type_list").val();
		delimitlist = eval("("+delimitlist+")");
		var isselect = false
		for(var key in delimitlist){
			if(key == type){
				delimitlist[key] = 0;
			}
			if(delimitlist[key] == 1)
				isselect = true;
		}
		$("#property_type_list").val(JSON.stringify(delimitlist));
		if(!isselect){
			$("#create_price_list_btn").css("display","none");
			clear_pice_list();
		}
	}
	return isdelete;
}


function add_property_delimit(table,type){
	var delimitlist = $("#"+type+"_list").val();
	if(delimitlist != ""){
		var select_global=new Array();
		select_global=delimitlist.split(",");
		var size=select_global.length;
		if(type == "颜色" && size >= 50){
			alertmsg("error",type + "属性最多添加49项！");
			return;
		}else if(type != "颜色" && size >= 50){
			alertmsg("error",type + "属性最多添加49项！");
			return;
		}
	}
	clear_pice_list();
	var tableName = document.getElementById(table+"_"+type+"_Tab");
	var auto_increment = $("#"+type+"_auto").val();
	var prev = tableName.rows.length;
	var count = eval(prev);//As the table has two headers, we should reduce the count
	var row = tableName.insertRow(count - 1);
	var cid = eval(auto_increment);
	$("#"+type+"_auto").val(cid + 1);
	row.id = table+"_"+type+"_"+cid;
	row.className = "edit-form-tr";
	
	var coltwo = row.insertCell(0);
	var colthree = row.insertCell(1);
	
	coltwo.style.textAlign = "center";
	coltwo.style.width = "90%";
	coltwo.innerHTML = "<input style=\'width:100%;\' maxlength=\'20\' value=\'\' name=\'propertydesc_"+type+"_"+cid+"\' id=\'propertydesc_"+type+"_"+cid+"\' data-rule=\'required\' class=\'required form-control\' onchange=\'propertychange();\'/>";
    
	colthree.style.textAlign = "center";
	colthree.style.width = "10%";
	colthree.innerHTML = "<button type=\'button\' onclick=\'delete_property_delimit(\""+table+"\",\""+type+"\",\""+cid+"\");\' class=\'btn btn-red\' data-icon=\'times\'><i class=\'fa fa-times\'></i></button>";

	var delimitlist = $("#"+type+"_list").val();
	if(delimitlist == "")
		$("#"+type+"_list").val(cid);
	else
		$("#"+type+"_list").val(delimitlist + "," + cid);
}

function add_complex_pice(desc,index,record){
	var tableName = document.getElementById("priceTab");
	var prev = tableName.rows.length;
	var count = eval(prev);
	var row = tableName.insertRow(count);
	var cid = eval(index)+1;
	row.id = "complexpice_row_"+cid;
	row.className = "edit-form-tr";
	
	var colone = row.insertCell(0);
	var coltwo = row.insertCell(1);
	var colthree = row.insertCell(2);
	var colfour = row.insertCell(3);
	var colfive = row.insertCell(4);
	var colsix = row.insertCell(5);
	var colseven = row.insertCell(6);

	colone.style.textAlign = "center";
	colone.innerHTML = "<label style=\'width:99%;text-align:center;\'>"+cid+"</label>";
	
	coltwo.style.textAlign = "center";
	coltwo.style.width = "30%";
	desclabel = desc.replace(/\~\^\~/g, "&nbsp;");
	coltwo.innerHTML = "<input value=\'"+desc+"\' name=\'complexpice_desc_"+cid+"\' id=\'complexpice_desc_"+cid+"\' type=\'hidden\'/>"+"<label style=\'width:99%;text-align:right;\'>"+desclabel+"</label>";

    colthree.style.textAlign = "center";
	colthree.style.width = "20%";
	colthree.innerHTML = "<input type=\'hidden\' name=\'complexpice_img_"+cid+"\' id=\'complexpice_img_"+cid+"\' value=\'\'>"+
		"<a id=\'complexpice_img_link_"+cid+"\' href=\'\' data-lightbox=\'roadtrip\'>"+
			"<img id=\'complexpice_img_view_"+cid+"\' align=\'absmiddle\' height=\'20px\' src=\'\'/>"+
		"</a>"+
		"&nbsp;<button style=\'display:none;\' type=\'button\' id=\'complexpice_img_delete_"+cid+"\' onclick=\'delete_uploadinfo(\""+cid+"\");\' class=\'btn btn-red\' data-icon=\'times\'><i class=\'fa fa-times\'></i></button>"+
		"&nbsp;<button type=\'button\' id=\'complexpice_img_select_"+cid+"\' onclick=\'show_upload_div(\""+cid+"\",\""+record+"\")\' style=\'height:22px;\' class=\'btn btn-green\' data-icon=\'edit\'><i class=\'fa fa-edit\'></i></button>";

	colfour.style.textAlign = "center";
	colfour.style.width = "12%";
	colfour.innerHTML = "<input style=\'width:100%;text-align:right;\' value=\'"+$("#market_price").val()+"\' name=\'complexpice_market_"+cid+"\' id=\'complexpice_market_"+cid+"\' class=\'form-control required\' data-rule=\'required\' onkeypress=\'return isNumbers(event,true);\'/>";

	colfive.style.textAlign = "center";
	colfive.style.width = "12%";
	colfive.innerHTML = "<input style=\'width:100%;text-align:right;\' value=\'"+$("#shop_price").val()+"\' name=\'complexpice_shop_"+cid+"\' id=\'complexpice_shop_"+cid+"\' class=\'form-control required\' data-rule=\'required\' onkeypress=\'return isNumbers(event,true);\'/>";

	colsix.style.textAlign = "center";
	colsix.style.width = "12%";
	colsix.innerHTML = "<input style=\'width:100%;text-align:center;\'  name=\'complexpice_inventorys_"+cid+"\' id=\'complexpice_inventorys_"+cid+"\' class=\'form-control required\' onkeypress=\'return isNumbers(event,false);\' data-rule=\'required\' value=\'1000\'/>";

	colseven.style.textAlign = "center";
	colseven.innerHTML = "<input style=\'cursor: pointer;\' name=\'complexpice_recommend_"+cid+"\' id=\'complexpice_recommend_"+cid+"\' type=\'checkbox\'/>";


	var delimitlist = $("#complexpice_list").val();
	if(delimitlist == "")
		$("#complexpice_list").val(cid);
	else
		$("#complexpice_list").val(delimitlist + "," + cid);    
}

function delete_property_delimit(table,type,cid){
	var obj = document.getElementById("propertydesc_"+type+"_"+cid);
	var strsel = obj.value;
	var isdelete = false;
	if(strsel == "")
		isdelete = true;
	else
		isdelete = confirm("'.getTranslatedString('SURE_DELETE_PROPERTY').': " + strsel + "？");
	if(isdelete)
	{
		clear_pice_list();
		var tableName = document.getElementById(table+"_"+type+"_Tab");
		var tbody=tableName.getElementsByTagName("tbody");
		var row = document.getElementById(table+"_"+type+"_"+cid);
		if(tbody!=null)
			tbody[0].removeChild(row);
		else
			tableName.removeChild(row);
		var delimitlist = $("#"+type+"_list").val();
		if(delimitlist != ""){
			var select_global=new Array();
			select_global=delimitlist.split(",");
			var size=select_global.length-1;
			var result="";
			var i=0;
			for(i=0;i<=size;i++){
				if(select_global[i] != cid)
					if(result != "") 
						result = result + "," + select_global[i];
					else
						result = select_global[i];
			}
			$("#"+type+"_list").val(result);
		}
	}
}

function clear_pice_list(){
	var tableName = document.getElementById("priceTab");
	var tbody=tableName.getElementsByTagName("tbody");
	var delimitlist = $("#complexpice_list").val();
	if(delimitlist != ""){
		var select_global=new Array();
		select_global=delimitlist.split(",");
		var size=select_global.length-1;
		var result="";
		var i=0;
		for(i=0;i<=size;i++){
			var row = document.getElementById("complexpice_row_"+select_global[i]);
			if(tbody!=null)
				tbody[0].removeChild(row);
			else
				tableName.removeChild(row);
		}
	}
	$("#complexpice_list").val("");
}

function create_price_list(record){
	var propertylist = $("#property_type_list").val();
	propertylist = eval("("+propertylist+")");
	var property_value = {};
	for(var key in propertylist){
		if(propertylist[key] == 1){
			var delimitlist = $("#"+key+"_list").val();
			property_value[key] = [];
			if(delimitlist != ""){
				var delimitArray = new Array();
				delimitArray = delimitlist.split(",");
				var ds = delimitArray.length-1;
				for(di=0;di<=ds;di++){
					var dv = $("#propertydesc_"+key+"_"+delimitArray[di]).val();
					//dv = dv.replace(/ /g, "");
					$("#propertydesc_"+key+"_"+delimitArray[di]).val(dv);
					property_value[key].push(dv);
				}
			}
		}
	}
	clear_pice_list();
	var ts = composeElement(property_value);
	var counts = ts.length;
	if(counts>160){
		alert("属性不能超过160条,请分成多个商品分批上传");
		return false;
	}
	$.each(ts,function(index,item){

			add_complex_pice(item,index,record);
	})
}

function composeElement(obj,vs){
	var rts = new Array();
	var prs = jsonshift(obj);
	if(typeof(vs)== "undefined")
		return composeElement(obj,prs);
	else{
		if(vs.length>0 && prs != null && prs != ""){
			for(var i in vs){
				$.each(prs,function(j,item){
					if(vs[i] != "" && (typeof(vs[i])=="string" || typeof(vs[i])=="number") && item != "" && (typeof(item)=="string" || typeof(item)=="number"))
						rts.push(vs[i]+ "~^~" + prs[j]);
				})
			}
		}
		if(prs == null || prs == "")
			return vs;
		else
			return composeElement(obj,rts);
	}
}
function jsonshift(obj){
	var rts = null;
	for(var i in obj){
		rts = obj[i];
		delete obj[i];
		break;
	}
	return rts;
}



function isNumbers(e,isFloat)
{
	var keynum;
	if(window.event) // IE
	{
		keynum = e.keyCode;
	}
	else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which;
	}
	if((keynum < 48 || keynum > 57) && (keynum >= 32))
		if(isFloat && (keynum == 46))
			return true;
		else
			return false;
	else
		return true;
}
';

$smarty->assign("DATA_DIV", $datadiv);
$smarty->assign("SCRIPT", $script);
$smarty->display('modules/Mall_Products/Property.tpl');

?>