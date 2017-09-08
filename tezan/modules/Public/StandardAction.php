<?php
/*+**********************************************************************************
 * The contents of this file are subject to the 361CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  361CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');



if (!function_exists('check_authorize')) {
	function check_authorize($key) {
        try{
            $authorize=XN_MemCache::get("authorize_".XN_Application::$CURRENT_URL);
            if( isset($authorize))
            {
                if (isset($authorize[$key]))
                {
                    if (in_array(XN_Profile::$VIEWER,$authorize[$key]))
                    {
                        return true;
                    }
                }
            }
        }
        catch(XN_Exception $e){
            return false;
        }
	}
}

$smarty = new vtigerCRM_Smarty;

global $panel;

$smarty->assign("MODULE",$currentModule);
$smarty->assign("PANEL",$panel);
$smarty->assign("APP",$app_strings);
$smarty->assign("MOD", $mod_strings);

$fields = array();

require_once("modules/$currentModule/config.field.php");

$readonly = "true";
if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] != '') 
{
	$readonly = $_REQUEST['readonly'];
}
if (check_authorize($panel))
{
	$readonly = "false";
}
else
{
	$readonly = "true";
}

$iscashier = check_authorize("cashier");

			 $msg .= "";
			 $msg .= "<table id='".$panel."_details_table' class='table table-bordered table-hover table-striped' width='100%' >";
			 $msg .= "<tbody><tr>";
			 foreach($fields[$panel] as  $fieldname => $fieldname_info)
			 {				
				  if ($fieldname == "oper")
				  {
					 if ($readonly == "false")
						$msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$fieldname_info['label']."</th>";					
				  }
				  else
				  {
					 $msg .= "<th align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$fieldname_info['label']."</th>";
				  }
				 
			 }
			
			 $msg .= "</tr>";
			 $auto_increment = 1;
			 $row_ids = array();
			 $content_ids = array();
			 if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
			 {
						$record = $_REQUEST['record'];
						$loadcontent = XN_Content::load($record,strtolower($currentModule));
						
						if ($iscashier || $loadcontent->author == XN_Profile::$VIEWER)
						{
							$details = XN_Query::create ( 'Content' )->tag($panel)
								->filter ( 'type', 'eic',$panel)
								->filter ( 'my.vehicleplate', '=', $record )
								->order("published",XN_Order::ASC)
								->execute ();
						}
						else
						{
							$details = XN_Query::create ( 'Content' )->tag($panel)
								->filter ( 'type', 'eic', $panel )
								->filter ( 'my.vehicleplate', '=', $record )
								->filter ( 'my.deleted', '=', '0' )
								->order("published",XN_Order::ASC)
								->execute ();
						}
						foreach ($details as $detail_info)
						{
							 $deleted = $detail_info->my->deleted;
							
							 if ($deleted == "0")
							 {
								 $msg .= "<tr id='".$panel."_row_".$auto_increment."'>";	
							 }
							 else
							 {
								 $msg .= "<tr style=\"color:#666666;\" id='".$panel."_row_".$auto_increment."'>";
							 }
							
							
							 foreach($fields[$panel] as  $fieldname => $fieldname_info)
							 {
									if ($fieldname == "oper")
									{			
										 if ($readonly == "false")
										{		
											    $value =  strtotime(date('Y-m-d H:i:s')) - strtotime($detail_info->published);
												if ($value > 3600)
											    {
													$msg .= '<td align="center"><i class="fa fa-trash" style="cursor: pointer;font-size:1.5em;" data-toggle="poshytip"  title="已经超过60分钟，不能删除"></i></td>';
												}
												else
												{
													$msg .= '<td align="center"><i class="fa fa-trash" onclick="'.$panel.'_delete_row(\''.$auto_increment.'\')" style="cursor: pointer;font-size:1.5em;" data-toggle="poshytip"  title="60分钟内可以删除【'.round($value/60).'分钟】"></i>
													 <input id="'.$panel.'_id_'.$auto_increment.'" name="'.$panel.'_id_'.$auto_increment.'" value="'.$detail_info->id.'" type="hidden">
													</td>';
												}
										}
									}									
									else
									{	
										if ($fieldname_info['type'] == "number")
										{
											$number = $detail_info->my->$fieldname;
											$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".formatnumber($number)."&nbsp;".$fieldname_info['suffixlabel']."</td>";
										}
										elseif ($fieldname_info['type'] == "hidden")
										{
											$number = $detail_info->my->$fieldname;
											$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".formatnumber($number)."&nbsp;".$fieldname_info['suffixlabel']."</td>";
										}
										else
										{
											if ($fieldname_info['type'] == "reference")
											{
												$table = $fieldname_info['table'];
												$field_name = $fieldname_info['fieldname'];
												$record = $detail_info->my->$fieldname;
												try
												{
													$loadcontent = XN_Content::load($record,$table);
													$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$loadcontent->my->$field_name."</td>";	
												} 
												catch ( XN_Exception $e ) {
													$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$record."</td>";
												}

											}
											else
											{
												$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>".$detail_info->my->$fieldname."</td>";
											}
										}
									}				  
							 }
							 $content_ids[] = $detail_info->my->budgetid;
							 $row_ids[] = $auto_increment;
							 $auto_increment ++;						
						}
			 }

			 if ($readonly == "false")
			 {
				 $msg .= "<tr class='row_add'>";			
				 foreach($fields[$panel]  as  $fieldname => $fieldname_info)
				 {
						if ($fieldname == "oper")
						{						
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'><i onclick='".$panel."_add_row()' class='fa fa-plus-circle' style='cursor: pointer;font-size:1.5em;' data-toggle='poshytip'  title='点击可以".getTranslatedString('LBL_ADD')."数据'></i></td>";
								
						}
						else
						{
							$msg .= "<td align='".$fieldname_info['align']."' width='".$fieldname_info['width']."'>&nbsp;</td>";
						}				  
				 }
				 $msg .= "</tr>";
			 }
			 $msg .= "</tbody></table>";
			
			 $msg .= '<input type="hidden" id="'.$panel.'_row_ids" name="'.$panel.'_row_ids" value="'.join(",",$row_ids).'">';
			 $msg .= '<input type="hidden" id="'.$panel.'_delete_ids" name="'.$panel.'_delete_ids" value="">';
			 $msg .= '<input type="hidden" id="'.$panel.'_auto_increment" value="'.$auto_increment.'">';
			 $smarty->assign("IDS", join(",",$content_ids));
			 $smarty->assign("PANELBODY", $msg);


$panelfields = array();
$paneltypes = array();
$requireds = array();
$widths = array();
$picklists = array();
$aligns = array();
$suffixlabels = array();
$s = array();
foreach($fields[$panel]  as  $fieldname => $fieldname_info)
{
	$panelfields[] = $fieldname;
	$paneltypes[] = $fieldname_info['type'];
	$requireds[] = $fieldname_info['required'];
	$widths[] = $fieldname_info['width'];
	$aligns[] = $fieldname_info['align'];
	$suffixlabels[] = $fieldname_info['suffixlabel'];
	if ($fieldname_info['type'] == "picklists")
	{		
			$picks = XN_Query::create ( 'Content' )
								->tag ( 'Picklists' )
								->filter ( 'type', 'eic', 'picklists' )
								->filter ( 'my.name', '=', $fieldname)
								->order("my.sequence",XN_Order::ASC_NUMBER)
								->execute ();
			$fldVal = Array();
			foreach ($picks as $picklist_info)
			{
				$fldVal [] = $picklist_info->my->$fieldname;		
			}

		$picklists[] = "<option>".join("</option><option>",$fldVal)."</option>";
	}
	elseif ($fieldname_info['type'] == "reference")
	{
		$table = $fieldname_info['table'];
		$field_name = $fieldname_info['fieldname'];
		$filters = $fieldname_info['filters'];	
		$query = XN_Query::create ( 'Content' )->tag ( $table )
								->filter ( 'type', 'eic', $table );
		if(is_array($filters))
		{
			foreach($filters as $filter_info)
			{
				$query->filter ($filter_info[0],$filter_info[1], $filter_info[2] );
			}
		}
		$result = $query->execute ();
		$fldVal = Array();
		$option = "";
		foreach ($result as $picklist_info)
		{
			$option .= "<option value='".$picklist_info->id."'>" . $picklist_info->my->$field_name . "</option>";		
		}
		$picklists[] = $option;
	}
	else
	{
		$picklists[] = "";
	}

}

$smarty->assign("SCRIPT", 
'


function '.$panel.'_make_td_innerhtml(id)
{
	 var fields= new Array("'.join('","',$panelfields).'");	
	 var types= new Array("'.join('","',$paneltypes).'");	
	 var requireds= new Array("'.join('","',$requireds).'");	
	 var widths= new Array("'.join('","',$widths).'");
	 var aligns= new Array("'.join('","',$aligns).'");
	 var picklists= new Array("'.join('","',$picklists).'");
	 var suffixlabels= new Array("'.join('","',$suffixlabels).'");
	 var html = "<tr id=\''.$panel.'_row_"+id+"\'>";
	 for(var i=0;i<fields.length;i++) {  			  		
			   if (fields[i] == "oper")
			   {	
				   html = html + \'<td align="center"><i onclick="'.$panel.'_delete_row(\'+id+\')" class="fa fa-trash" style="cursor: pointer;font-size:1.5em;" ></i>\';
				   html =  html + \'<input id="'.$panel.'_id_\'+id+\'" name="'.$panel.'_id_\'+id+\'" value="new" type="hidden">\';
				   html =  html + \'</td>\';
					
			   }			   
			   else if(types[i] == "text")
			   {
				    if(requireds[i])
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input style="float:none;width:98%" class="required" data-rule="required;"  id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text"></td>\';
					}
					else
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input style="float:none;width:98%"  id="'.$panel.'_\'+fields[i]+\'__\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text"></td>\';
					}
			   }
			   else if(types[i] == "number")
			   {
				    if(requireds[i])
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input style="float:none;width:80%"  data-rule="required;"  class="number required" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text">\'+suffixlabels[i]+\'</td>\';
					}
					else
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input style="float:none;width:80%"  class="number" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text">\'+suffixlabels[i]+\'</td>\';
					}
			   }
			   else if(types[i] == "calendar")
			   {
				    if(requireds[i])
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input readonly class=" required readonly"  data-rule="required;" data-toggle="datepicker"  data-pattern="yyyy-MM-dd"  style="float:left;width:70%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text"></td>\';
					}					
					else
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><input readonly class="date readonly" data-toggle="datepicker"  data-pattern="yyyy-MM-dd"  style="float:left;width:70%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" value="" type="text"></td>\';
					}
			   }
			   else if(types[i] == "picklists")
			   {
				    if(requireds[i])
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><select class="required" style="float:none;width:98%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" >\'+picklists[i]+\'</select></td>\';
					}					
					else
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><select style="float:none;width:98%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'"  >\'+picklists[i]+\'</select></td>\';
					}
			   }
			    else if(types[i] == "reference")
			   {
				    if(requireds[i])
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><select class="required" style="float:none;width:98%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'" >\'+picklists[i]+\'</select></td>\';
					}					
					else
					{
						html = html + \'<td align="\'+aligns[i]+\'" style="width:\'+widths[i]+\'px"><select style="float:none;width:98%" id="'.$panel.'_\'+fields[i]+\'_\'+id+\'" name="'.$panel.'_\'+fields[i]+\'_\'+id+\'"  >\'+picklists[i]+\'</select></td>\';
					}
			   }
			   else
			   {
					html = html + \'<td align="center">&nbsp;</td>\';		
			   }
	} 
	html = html + "</tr>";
	return html;
}

function '.$panel.'_add_row()
{	
	if(typeof $("#'.$panel.'_auto_increment") != "undefined" && typeof $("#details_table") != "undefined")
	{		
			var auto_increment = $("#'.$panel.'_auto_increment").val();
			var id = eval(auto_increment);
			$("#'.$panel.'_details_table  tr.row_add").before('.$panel.'_make_td_innerhtml(id)).initui();
			$("#'.$panel.'_row_"+id).initui();
			var ids = $("#'.$panel.'_row_ids").val();
			if (ids == "")
			{
				$("#'.$panel.'_row_ids").val(id);
			}
			else
			{
				$("#'.$panel.'_row_ids").val(ids+","+id);
			}
			$("#'.$panel.'_auto_increment").val( id + 1);	
	}
	$("#'.$panel.'_savetype").val("save");
}

function '.$panel.'_delete_row(cid){
	$("#'.$panel.'_savetype").val("save");
	var contentid = $("#'.$panel.'_id_"+cid).val();
	var delete_ids = $("#'.$panel.'_delete_ids").val();
	if (contentid != "new")
	{
		if (delete_ids == "")
		{
			$("#'.$panel.'_delete_ids").val(contentid);
		}
		else
		{
			$("#'.$panel.'_delete_ids").val(delete_ids+","+contentid);
		}
	}
    var row_ids = $("#'.$panel.'_row_ids").val();
	var ids_array = row_ids.split(",");
	var index = ids_array.indexOf(cid); 
	if (index >= 0)
	{
		ids_array.splice(index,1);
	}
	$("#'.$panel.'_row_ids").val(ids_array.join(","));

	var tableName = document.getElementById("'.$panel.'_details_table");
	var tbody=tableName.getElementsByTagName("tbody");
	var row = document.getElementById("'.$panel.'_row_"+cid);
	if(tbody!=null)
		tbody[0].removeChild(row);
	else
		tableName.removeChild(row);

   
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




'
);





$smarty->display('Panel.tpl');

?>