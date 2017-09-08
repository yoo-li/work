<?php
global $currentModule,$current_user;
 
 
if(isset($_REQUEST["record"]) && $_REQUEST["record"] != "" && 
   isset($_REQUEST["addmoney"]) && $_REQUEST["addmoney"] != "" && 
	$_REQUEST["type"] == "submit")
{
	 $id_lists = explode(",", $_REQUEST['record']); 
	 $addmoney = $_REQUEST['addmoney'];  
	 
	 $mall_officialshidubills = XN_Content::load($id_lists,"mall_officialshidubills",4);
	 foreach($mall_officialshidubills as $officialshidubill_info)
	 { 
		$profileid = $officialshidubill_info->my->profileid;
		$authorizedenterprisecurrency = $officialshidubill_info->my->authorizedenterprisecurrency;
		$remainingenterprisecurrency = $officialshidubill_info->my->remainingenterprisecurrency;
		$enterprisecurrencyid = $officialshidubill_info->my->enterprisecurrencyid;
		$supplierid = $officialshidubill_info->my->supplierid;
		
		 
		
		if(floatval($addmoney) <= 0 && abs(floatval($addmoney))> floatval($authorizedenterprisecurrency)){
			echo '{"status":300,"statusCode":300,"message":"当前余额不够扣除！"}';
			die();
		}  
		
		$new_authorizedenterprisecurrency = floatval($authorizedenterprisecurrency)+floatval($addmoney);

         $officialshidubill_info->my->authorizedenterprisecurrency = $new_authorizedenterprisecurrency;

         $officialshidubill_info->save('mall_officialshidubills,mall_officialshidubills_'.$profileid.',mall_officialshidubills_'.$supplierid);
	 
		 
		$newcontent = XN_Content::create('mall_officialshidubilllogs','',false,8);
		$newcontent->my->deleted = '0';  
		$newcontent->my->profileid = $profileid; 
		$newcontent->my->supplierid = $supplierid;  
		$newcontent->my->operator = XN_Profile::$VIEWER;
		//待处理
		$newcontent->my->submitdatetime = date('Y-m-d H:i:s');
		$newcontent->save('mall_officialshidubilllogs,mall_officialshidubilllogs_'.$profileid.',mall_officialshidubilllogs_'.$supplierid);
		 
		
	 }
		
	 echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

     die();
}
if(isset($_REQUEST["ids"]) && $_REQUEST["ids"] != "")
{

		$ids = $_REQUEST["ids"];
		$id_lists = explode(",", $_REQUEST['ids']);	
		$fields = array(
			'givenname' =>	array('label'=>'LBL_GIVENNAME','width'=>'10%',	'talign'=>'center',	'calign'=>'center'),
			'mobile' =>	array('label'=>'LBL_MOBILE','width'=>'10%',	'talign'=>'center',	'calign'=>'center'), 	 
			'rank' => array('label'=>'LBL_RANK','width'=>'5%','talign'=>'left','calign'=>'center'),
			'money' => array('label'=>'LBL_MONEY','width'=>'5%','talign'=>'left','calign'=>'center'),
			'accumulatedmoney' => array('label'=>'LBL_ACCUMULATEDMONEY','width'=>'5%','talign'=>'left','calign'=>'center'), 
			'published' => array('label'=>'LBL_PUBLISHED','width'=>'25%','talign'=>'center','calign'=>'center'),

		);
		 
		$officialshidubills = XN_Content::load($id_lists,"mall_officialshidubills",4);
		  
		    
		$tableRows = '';
		foreach($supplier_profiles as $supplier_profile_info)
		{
			$tableRows .= '<tr>';
			foreach($fields as $fed => $fvd)
			{ 
				if ($fed == "published")
				{
					$tmpValue = $supplier_profile_info->published;
				}
				else
				{
					$tmpValue = $supplier_profile_info->my->$fed;
				}
				$tableRows .= '<td '.(($fvd['calign']!="")?'align="'.$fvd['calign'].'"':"").'>'.$tmpValue.'</td>';
				 
			}
			$tableRows .= '</tr>'; 
		}
	
	
		$tableTitle = '';	
		foreach($fields as $fed => $fvd)
		{
				$tableTitle .= '<th '.(($fvd['talign']!="")?'align="'.$fvd['talign'].'"':"").' style="width:'.$fvd['width'].';white-space:nowrap;"><b>'.getTranslatedString($fvd['label']).'</b></th>';
		}	 		
 
		$html = '
			<ul class="searchContent">
				<li>
					<label class="control-label x120">金额：</label>
					<input type="text"  name="addmoney" id="addmoney" value="" data-rule="required;number;money;"  class="form-control  required">元
				</li>
			    <li style="padding-top:10px;padding-bottom:10px;"><label class="control-label x120">注意：</label><font color="red" size="2">请确定以下员工充值吗？【注意，当输入负数时，是扣除余额的反冲操作】</font></li> 
			</ul>
			<table class="table table-bordered table-hover table-striped" border="0" cellspacing="0" cellpadding="0">
					<tr id="cid_products" class="edit-form-tr">
						<td class="edit-form-tdinfo">
							<table id="acTab" class="table table-bordered table-hover table-striped" style="width:100%" name="acTab">
							<tbody>
								<tr id="listtitle">'.$tableTitle.'</tr>'.($tableRows!=""?$tableRows:'').'
							</tbody>
							</table>
						</td>
					</tr>
				</table>

		'; 
		
}
//echo $html;

require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $currentModule;
$smarty = new vtigerCRM_Smarty;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $html);
 
$smarty->assign("RECORD", $ids);
$smarty->assign("SUBMODULE", "Mall_OfficialEnterpriseCurrencysAuthorizes");
$smarty->assign("OKBUTTON", "确定员工充值");
$smarty->assign("SUBACTION", "AddMoney");

$smarty->display("MessageBox.tpl");



?>