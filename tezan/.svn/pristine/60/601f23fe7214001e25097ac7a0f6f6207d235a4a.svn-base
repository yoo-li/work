<?php
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');


global  $currentModule,$supplierid;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit" &&
	isset($_REQUEST['sequence']) && $_REQUEST['sequence'] != "")
{
    try {
        $binds = $_REQUEST['record'];
        $sequence = $_REQUEST['sequence'];

        $binds = str_replace(";",",",$binds);
        $binds = explode(",",trim($binds,','));
        array_unique($binds);
		if (count($binds) > 0)
		{
			$loadcontents = XN_Content::loadMany($binds,"mall_products_".$supplierid);
	        foreach($loadcontents as $product_info)
	        { 
				if ($product_info->my->sequence != $sequence)
				{
					$product_info->my->sequence = $sequence;
					$product_info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
				} 
	        } 
	        //修改审批中心表中的审批状态
	        $mall_products = XN_Query::create("Content")
		            ->tag("mall_products_".$supplierid)
		            ->filter("type","eic","mall_products") 
		            ->filter('my.deleted',"=","0")
					->filter('my.supplierid',"=",$supplierid)
					->filter('my.approvalstatus',"=",'2')
					->filter('my.sequence',"<",1000)
					->order('my.sequence',XN_Order::ASC_NUMBER)
		            ->end(-1)
		            ->execute();
			$sequence = '1';
			$objs = array();
	        foreach($mall_products as $product_info)
			{
				if ($sequence != $product_info->my->sequence)
				{
					$product_info->my->sequence = $sequence;
					//$product_info->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
					try{
						XN_Content::create('mall_products_modify', '',false,2)	 
							  ->my->add('productid',$product_info->id) 
							  ->my->add('profileid',XN_Profile::$VIEWER)
							  ->my->add('module','mall_products')
							  ->my->add('action','productsmodify')
							  ->my->add('record',$product_info->id)
							  ->save("mall_products_modify");
					}
					catch(XN_Exception $e){}
					$objs[] = $product_info;
				} 
				$sequence = $sequence + 1; 
			}
			if (count($objs) > 0)
			{
				XN_Content::batchsave($objs,strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
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
	$msg =  '<div class="form-group">
	                <label class="control-label x120">置顶位置:</label>
					 <select id="sequence" name="sequence" style="width:200px;cursor: pointer;">
					    <option value="1">置顶第1位</option>
						<option value="2">置顶第2位</option>
						<option value="3">置顶第3位</option>
						<option value="4">置顶第4位</option>
						<option value="5">置顶第5位</option>
						<option value="6">置顶第6位</option>
						<option value="7">置顶第7位</option>
						<option value="8">置顶第8位</option>
						<option value="9">置顶第9位</option>
						<option value="10">置顶第10位</option>
						<option value="11">置顶第11位</option>
						<option value="12">置顶第12位</option>
						<option value="13">置顶第13位</option>
						<option value="14">置顶第14位</option>
						<option value="15">置顶第15位</option>
						<option value="16">置顶第16位</option>
						<option value="17">置顶第17位</option>
						<option value="18">置顶第18位</option>
						<option value="19">置顶第19位</option>
						<option value="20">置顶第20位</option>
						<option value="1000">置顶第1000位</option>
					 </select>
			 </div> ';
}

$smarty = new vtigerCRM_Smarty;
global $mod_strings;
global $app_strings;
global $app_list_strings;
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("MSG", $msg);
$smarty->assign("OKBUTTON", "确定");
$smarty->assign("RECORD",$_REQUEST['ids']);
$smarty->assign("SUBMODULE", "Mall_Products");
$smarty->assign("SUBACTION", "ModifySequence");

$smarty->display("MessageBox.tpl");

?>