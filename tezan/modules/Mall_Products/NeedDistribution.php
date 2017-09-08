<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['rejectreason']) && $_REQUEST['rejectreason'] != "")
{
    try {
        $binds = $_REQUEST['record']; 
		$rejectreason = $_REQUEST['rejectreason']; 

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"supplier_takecashs_".$supplierid,7);
	        foreach($loadcontents as $supplier_takecashs_info)
	        {  
				$profileid = $supplier_takecashs_info->my->profileid; 
				$amount = $supplier_takecashs_info->my->amount; 
				require_once (dirname(__FILE__) . "/../Supplier_Profile/util.php"); 
				$profile_info = get_supplier_profile_info($profileid,$supplierid);
				
				if (count($profile_info) == 0)
				{
					echo '{"statusCode":"300","message":"无法获得用户信息，驳回失败！"}';
					die();
				}
				
				$supplier_takecashs_info->my->rejectreason = $rejectreason;
				$supplier_takecashs_info->my->tradestatus = 'notrade';
				$supplier_takecashs_info->my->supplier_takecashsstatus = '驳回申请';
				$supplier_takecashs_info->save("supplier_takecashs,supplier_takecashs_".$supplierid.",supplier_takecashs_".$profileid);
				
			 
				
				$money = $profile_info['money'];  
				$maxtakecash = $profile_info['maxtakecash'];
				$new_money = $money + floatval($amount);  
				$new_maxtakecash = $maxtakecash + floatval($amount); 
				$profile_info['money'] = $new_money;  
				$profile_info['maxtakecash'] = $new_maxtakecash;
				update_supplier_profile_info($profile_info);  
		
				$newcontent = XN_Content::create('mall_billwaters','',false,7);					  
				$newcontent->my->deleted = '0';  
				$newcontent->my->supplierid = $supplierid;  
				$newcontent->my->profileid = $profileid; 
				$newcontent->my->billwatertype = 'rejecttakecash';
				$newcontent->my->sharedate = '-';  
				$newcontent->my->orderid = '';
				$newcontent->my->amount = '+'.number_format($amount,2,".",""); 
				$newcontent->my->money = number_format($new_money,2,".","");
				$newcontent->save('mall_billwaters,mall_billwaters_'.$profileid.',mall_billwaters_'.$supplierid); 
				
				 
				XN_MemCache::delete("mall_badges_".$businesseid."_".$profileid);  
	        }  
		} 
        echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
    } catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{ 
	
    $binds = $_REQUEST['ids']; 
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
	if (count($binds) > 1)
	{
		$smarty = new vtigerCRM_Smarty;
		global $mod_strings;
		global $app_strings;
		global $app_list_strings;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings); 
	    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单个商品进行申请分销操作！</font></div>';  
		$smarty->assign("MSG", $msg);  
		$smarty->display("MessageBox.tpl");
		die();
	}
	else
	{
        $record = $_REQUEST['ids']; 
		$loadcontent =  XN_Content::load($record,"mall_products_".$supplierid);    
		$distributionstatus = $loadcontent->my->distributionstatus;
		if ($distributionstatus == "2" || $distributionstatus == "3")
		{
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">只能对“未分销,已退回”的商品进行申请分销操作!</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		} 
	}
	
	$msg =  '<div class="form-group">
	                 <label class="control-label x120">分销佣金:</label> 
					 <select id="distributionrate" name="distributionrate" style="width:200px;cursor: pointer;">
							    <option value="10">10%</option>
								<option value="11">11%</option>
								<option value="12">12%</option>
								<option value="13">13%</option>
								<option value="14">14%</option>
								<option value="15">15%</option>
								<option value="20">20%</option> 
							 </select> 
			 </div> ';
	 $categoryArray = GetCategory(0,"");
	 $categoryOption = '<option value=""></option>';

	 foreach ($categoryArray as $key => $value){
	     $key=substr($key,1,-1);
	     if(intval($_REQUEST['categorys_search_input'])==intval($key)){
	         $categoryOption .= '<option value='.$key.' selected="selected">'.$value.'</option>';
	     }else{
	         $categoryOption .= '<option value='.$key.'>'.$value.'</option>';
	     }
	 }
	$msg .=  '<div class="form-group">
	                 <label class="control-label x120">商品分类:</label> 
					<select id="categorys" name="categorys" class="required" style="cursor: pointer;width:200px;">'.$categoryOption.'</select>
     			   </div> ';
			  
 	$msg .=  '<div class="form-group">
 	                 <label class="control-label x150" style="vertical-align:top;padding-top:5px;">分销注意事项：</label> 
 					  <div style="padding-top:5px;color:red;width:400px;display:inline-block;"><span>1、提交申请审批通过后，商品自动参与分销；</span><br> 
					  <span>2、分销商品与商城内商品，会员佣金比率是完全相同；</span><br>
					  <span>3、分销佣金与会员佣金，独立计算；</span><br>
					  <span>4、分销商品的价格等相关参数与商城内商品自动同步；</span><br> 
					  <span>5、分销佣金固定为10%以上，特殊品类请与平台管理员联系；</span><br> 
					  <span>6、分销商品，请准时发货，维护售后服务，触犯分销管理条例就会有一定比例的罚款；</span><br> 
					  <span>7、分销商品，有最长7+7的结算账期；</span><br> 
					  </div>
 			 </div> ';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "申请分销");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Supplier_TakeCashs");
$smarty->assign("SUBACTION", "RejectTakeCash");

$smarty->display("MessageBox.tpl");

 

function GetCategory($depth,$exclude){
	global $supplierid;
    $mall_categorys = XN_Query::create ( 'Content' )->tag('tezan_categorys')
		    ->filter ( 'type', 'eic', 'tezan_categorys') 
		    ->filter ( 'my.deleted', '=', 0)
		    ->order("my.sequence",XN_Order::ASC_NUMBER)
		    ->end(-1)
		    ->execute();
	$categorys = array();
	foreach($mall_categorys as $category_info)
	{
		$categoryid = $category_info->id;
		$categorys[$categoryid] = array('pid'=>$category_info->my->pid,'categoryname'=>$category_info->my->categoryname);
	} 
	return Recursion_GetCategory($categorys,0,$depth,$exclude);
}
function Recursion_GetCategory($categorys,$pid,$depth,$exclude)
{ 
    $excludes = explode(',', $exclude); 
    $categoryOption = array();
    $Prefix = "";
    if($depth>0){
        $Prefix = "　┣━";
        for($i=2;$i<=$depth;$i++){
            $Prefix .= "━";
        }
    }
    foreach ($categorys as $categoryid => $info){ 
        if(!in_array($categoryid,$excludes))
		{
			if ($info['pid'] == $pid)
			{
	            $categoryOption['"'.$categoryid.'"'] = $Prefix . $info['categoryname'];
	            $categoryOption = array_merge($categoryOption,Recursion_GetCategory($categorys,$categoryid,$depth+1,$exclude));
			} 
        }
    }
    return $categoryOption;
}

?>