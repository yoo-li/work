<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-8-25
 * Time: 上午10:09
 * To change this template use File | Settings | File Templates.
 */
require_once('Smarty_setup.php');
require_once('include/utils/utils.php');

global  $supplierid,$currentModule;

if (isset($_REQUEST['record']) && $_REQUEST['record'] != "" &&
    isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
{
    try {
        $ids=$_REQUEST['record'];
        $list_ids=explode(",",$ids);
        $product_infos=XN_Content::loadMany($list_ids,"mall_products");
        $boolee=true;
        $aoolee=true;
        foreach($product_infos as $info){
            if($info->my->mall_productsstatus!='Agree'){
                $aoolee=false;
            }
            if($info->my->hitshelf=="off"){
                $boolee=false;
            }
        }
        if(!$boolee){
            echo '{"statusCode":"300","message":"'."只能选择【上架】状态的商品".'"}';
            die();
        }
        if(!$aoolee){
            echo '{"statusCode":"300","message":"只能选择【审批通过】的商品"}';
            die();
        }
		
		$saveobjs = array();

        foreach($product_infos as $info){
            $info->my->hitshelf="off";
            $info->save("mall_products,mall_products_".$supplierid);
            $newContent=XN_Content::create("mall_hitshelflog","",false,"7");
            $newContent->my->deleted="0";
            $newContent->my->supplierid=$supplierid;
            $newContent->my->products=$info->id;
            $newContent->my->handle_type='off';
            $newContent->my->handle_reason=$_REQUEST['handle_reason'];
            $newContent->my->profileid=XN_Profile::$VIEWER;
            $newContent->save("mall_hitshelflog,mall_hitshelflog_".$supplierid);
			
			 
			$newcontent  = XN_Content::create('mall_products_modify', '',false,2)	 
				  ->my->add('productid',$info->id) 
				  ->my->add('profileid',XN_Profile::$VIEWER)
				  ->my->add('module','mall_products')
				  ->my->add('action','productsmodify')
				  ->my->add('record',$info->id); 
			$saveobjs[] = $newcontent; 
        }
		try{
			if (count($saveobjs) > 0)
			{
				XN_Content::batchsave($saveobjs,"mall_products_modify");
			} 
		}
		catch(XN_Exception $e){}
		 

        echo '{"statusCode":"200","message":"下架成功！","tabid":"'.$module.'","closeCurrent":true,"forward":null}';
    }
    catch ( XN_Exception $e )
    {
        echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    }
    die();
}
else{
    $ids=$_REQUEST["ids"];
    $msg='<div class="form-group"><label style="text-align:right;width:70px;">备注：</label>
            <textarea name="handle_reason" class="required" rows="5" cols="37" ></textarea>
        </div>';
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
$smarty->assign("SUBACTION", "offshelf");

$smarty->display("MessageBox.tpl");
