<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
global $currentModule,$supplierid,$readonly,$current_user;
require_once('modules/Users/Users.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/'.$currentModule.'/config.func.php');


$record=$_REQUEST['record'];

 
if(isset($_REQUEST['property_type_list']) && $_REQUEST['property_type_list'] != '')
{
	$proplist = $_REQUEST['property_type_list'];
	$proplist = json_decode($proplist,true);
	$propArray = array();
    $index=1;
    foreach($proplist as $pro => $value)
	{
        if($value == '1')
		{
            if(isset($_REQUEST[$pro.'_list']) && $_REQUEST[$pro.'_list'] != '')
			{
                $rows = explode(',', $_REQUEST[$pro.'_list']);
                $rows = array_filter($rows);
                $index*=count($rows);
				$propertylist = array();
                foreach($rows as $row)
				{
                    if(isset($_REQUEST["propertydesc_".$pro."_".$row]) && $_REQUEST["propertydesc_".$pro."_".$row] != "")
					{
                        $propertydesc_str=str_replace("\\\\t","",trim($_REQUEST["propertydesc_".$pro."_".$row]));
                        $propertydesc_str=str_replace("\\","",$propertydesc_str);
                        $propertydesc_str=str_replace("/","-",$propertydesc_str);
                        $propertylist[] = $propertydesc_str;
                    }
                }
				if (count($propertylist) != count(array_unique($propertylist)))
				{
					echo '{"statusCode":"300","message":"在商品属性【'.$pro.'】中检测到了重复的属性,请重新定义属性。"}';
					die();
				} 
            }
        }
    }
}
 

$focus = CRMEntity::getInstance($currentModule);
$parameters=serialize($_REQUEST['parameters']);
$_REQUEST['parameters']=$parameters;

setObjectValuesFromRequest($focus);
if($focus->column_fields['supplierid'] == '' && $focus->mode == "create")
{
    $focus->column_fields['supplierid'] = $supplierid;
	$focus->column_fields['distributionstatus'] = '0';
	
}
 
$focus->tag=strtolower($currentModule)."_".$supplierid;

function raw_json_encode($input) {
	return preg_replace_callback(
	    '/\\\\u([0-9a-zA-Z]{4})/',
	 	create_function('$matches', 'return mb_convert_encoding(pack("H*",$matches[1]),"UTF-8","UTF-16");'),
	    /**
	    function ($matches) {
	    	return mb_convert_encoding(pack('H*',$matches[1]),'UTF-8','UTF-16');
	    },
	    **/
	    json_encode($input)
	);
}
 
$loadcontent = XN_Content::load($focus->id,"mall_productlibs");
$approvalstatus = $loadcontent->my->approvalstatus;
if($approvalstatus != '2' )
{
	$propertys=XN_Query::create ( 'Content' )
	    ->tag("mall_propertys")
	    ->filter ( 'type', 'eic', 'mall_propertys' )
	    ->filter ( 'my.productid', '=', $record)
	    ->begin(0)->end(-1)
	    ->execute ();
	if(count($propertys)){
	    XN_Content::delete($propertys,"mall_propertys");
	}
	$product_propertys=XN_Query::create ( 'Content' )
	    ->tag("mall_product_property")
	    ->filter ( 'type', 'eic', 'mall_product_property' )
	    ->filter ( 'my.productid', '=', $record)
	    ->begin(0)->end(-1)
	    ->execute ();
	if(count($propertys)){
	    XN_Content::delete($product_propertys,"mall_product_property");
	}

	//删掉商品属性里面废弃的图片暂时没做
 
	 
	$focus->column_fields["product_guige"]=str_replace("\\","",trim($_REQUEST["product_guige"]));
	$focus->column_fields["simple_desc"]=str_replace("\\","",trim($_REQUEST["simple_desc"]));

	if($focus->readOnly != 'true'){
		if($_REQUEST["postage"] == ""){
			$focus->column_fields['postage'] = '0.00';
		}
		if($_REQUEST["mergepostage"] == ""){
			$focus->column_fields['mergepostage'] = '0';
		}
	    $product_propertys=array();
	    $property_ids=array();
		if(isset($_REQUEST['property_type_list']) && $_REQUEST['property_type_list'] != ''){
			$proplist = $_REQUEST['property_type_list'];
			$proplist = json_decode($proplist,true);
			$propArray = array();
	        $index=1;
	        foreach($proplist as $pro => $value){
	            if($value == '1'){
	                if(isset($_REQUEST[$pro.'_list']) && $_REQUEST[$pro.'_list'] != ''){
	                    $rows = explode(',', $_REQUEST[$pro.'_list']);
	                    $rows = array_filter($rows);
	                    $index*=count($rows);
	                    foreach($rows as $row){
	                        if(isset($_REQUEST["propertydesc_".$pro."_".$row]) && $_REQUEST["propertydesc_".$pro."_".$row] != ""){
	                            $propertydesc_str=str_replace("\\\\t","",trim($_REQUEST["propertydesc_".$pro."_".$row]));
	                            $propertydesc_str=str_replace("\\","",$propertydesc_str);
	                            $propertydesc_str=str_replace("/","-",$propertydesc_str);
	                            $property=XN_Content::create("mall_propertys","",false);
	                            $property->my->productid=$_REQUEST['record'];
	                            $property->my->property_type=$pro;
	                            $property->my->property_value=$propertydesc_str;
	                            $property->my->deleted='0';
	                            $property->my->status='0';
	                            $property->my->sequence=$row;
	                            $property->save("mall_propertys");
	                            $property_ids[$propertydesc_str]=$property->id;
	                            $propArray[$pro][$property->id] = $propertydesc_str;
	                        }
	                    }
	                }
	            }
	        }
	        $shop_price_arr=array();
	        $market_price_arr=array();
	        $count_inventory=0;
	        for($i=1;$i<=$index;$i++){
	            if(isset($_REQUEST['complexpice_desc_'.$i]) && $_REQUEST['complexpice_desc_'.$i]!=''){
	                $shop_price_arr[]=$_REQUEST['complexpice_shop_'.$i];
	                $market_price_arr[]=$_REQUEST['complexpice_market_'.$i];
	                $count_inventory+=$_REQUEST['complexpice_inventorys_'.$i];
	                $complexpice_desc=str_replace("\\\\t","",trim($_REQUEST['complexpice_desc_'.$i]));
	                $complexpice_desc=str_replace("\\","",$complexpice_desc);
	                $complexpice_desc=str_replace("/","-",$complexpice_desc);

	                $property_lists=explode("~^~",$complexpice_desc);
	                $property_records=array();
	                foreach($property_lists as $desc){
	                    $property_records[] = $property_ids[$desc];
	                }
	                //$property_records=substr($property_records,0,-1);
				
					$complexpice_desc = str_replace("~^~"," ",$complexpice_desc);

	                $product_propertys[]=array(
	                    "propertyids"=>$property_records,
	                    "propertydesc"=>$complexpice_desc,
	                    "barcode"=>$_REQUEST['barcode_'.$i],
	                    "taobao_sku_id"=>$_REQUEST['taobao_sku_id_'.$i],
	                    "imgurl"=>$_REQUEST['complexpice_img_'.$i],
	                    "market"=>$_REQUEST['complexpice_market_'.$i],
	                    "shop"=>$_REQUEST['complexpice_shop_'.$i],
	                    "inventorys"=>$_REQUEST['complexpice_inventorys_'.$i],
	                    "recommend"=>$_REQUEST['complexpice_recommend_'.$i]
	                );
	            }
	        }
	        if(count($shop_price_arr)>0 && min($shop_price_arr)>0 && max($shop_price_arr)>$_REQUEST['shop_price']){
	            $focus->column_fields['shop_price']=max($shop_price_arr);
	        }
	        if(count($market_price_arr)>0 && min($market_price_arr)>0 && max($market_price_arr)>$_REQUEST['market_price']){
	            $focus->column_fields['market_price']=max($market_price_arr);
	        }
	        if($count_inventory){
	            $focus->column_fields['inventory']=$count_inventory;
	        }
			if(count($propArray)>0){
				//$focus->column_fields['property_type'] = json_encode($propArray);
				$focus->column_fields['property_type'] = raw_json_encode($propArray);
	            $focus->column_fields['myproperty_type'] = raw_json_encode($propArray);
			}else{
	            if(isset($_REQUEST['property_type']) && $_REQUEST['property_type']!=""){
	                $request_property_type=(array)$_REQUEST['property_type'];
	                foreach($request_property_type as $key){
	                    if(isset($_REQUEST["property_type_".$key]) &&$_REQUEST["property_type_".$key]!=''){
	                        $propArray[$key]=(array)$_REQUEST["property_type_".$key];
	                    }
	                }
	            }
	            if(count($propArray)>0){
	                $focus->column_fields['property_type'] = raw_json_encode($propArray);
	                $focus->column_fields['myproperty_type'] = raw_json_encode($propArray);
	            }else{
	                $focus->column_fields['property_type'] = " ";
	                $focus->column_fields['myproperty_type'] = " ";
	            }
			}
	            //如果有新建属性的话，创建
	        if(count($propArray)){
	            if(count($product_propertys)){
	                $savedata = array();
	                foreach($product_propertys as $property_arr_info){
	                    $details = XN_Content::create('mall_product_property',"",false);
	                    $details->my->status="0";
	                    $details->my->productid = $_REQUEST['record'];
	                    $details->my->taobao_sku_id = $property_arr_info['taobao_sku_id'];
	                    $details->my->barcode = $property_arr_info['barcode'];
	                    $details->my->propertyids=$property_arr_info['propertyids'];
	                    $details->my->propertydesc = $property_arr_info['propertydesc'];
	                    $details->my->market = $property_arr_info['market'];
	                    $details->my->imgurl = $property_arr_info['imgurl'];
	                    $propertyimgs[]=$property_arr_info['imgurl'];
	                    $details->my->shop = $property_arr_info['shop'];
	                    $details->my->inventorys = $property_arr_info['inventorys'];
	                    $details->my->deleted='0';
	                    if(isset($property_arr_info['recommend']) && $property_arr_info['recommend'] == "on")
	                        $details->my->recommend = '1';
	                    else
	                        $details->my->recommend = '0';
	                    $savedata[] = $details;
	                }
	                $attachments=XN_Query::create("Content")
	                    ->tag("attachments")
	                    ->filter("type","eic","attachments")
	                    ->filter("my.record","=",$record)
	                    ->filter("my.category",'=','propertyimg')
	                    ->filter("my.deleted","=","0")
	                    ->order("my.sequence",XN_Order::ASC_NUMBER)
	                    ->end(-1)
	                    ->execute();
	                array_unique($propertyimgs);
	                foreach($attachments as $attachment_info){
	                    $path = $attachment_info->my->path;
	                    $savefile  = $attachment_info->my->savefile;
	                    $img = $path.((strrpos($path,'/') == strlen($path) -1 )?'':'/').$savefile;
	                    if(!in_array($img,$propertyimgs)){
	                        {
	                            $imgfile=$_SERVER['DOCUMENT_ROOT'].$img;
	                            if (@file_exists($imgfile) && is_writeable($imgfile)){
	                                if(@unlink($imgfile)){
	                                    XN_Content::delete($attachment_info,"attachments");
	                                }else{
	                                    echo '{"statusCode":"300","message":"删除'.$imgfile.'无用图片失败"}';
	                                    die();
	                                }
	                            }else{
	                                echo '{"statusCode":"300","message":"文件不存在或者无权限操作"}';
	                                die();
	                            }
	                        }
	                    }
	                }
	                if(count($savedata)>0)XN_Content::batchsave($savedata,"mall_product_property");
	            }
	            else{
	                echo '{"statusCode":"300","message":"填写了商品属性名称，就必须点击[创建价格列表]创建商品属性"}';die();
	            }
	        }

		}
	}

	if($focus->column_fields[strtolower($currentModule). 'status'] == '' || $focus->mode == "create")
	{
		$focus->column_fields[strtolower($currentModule). 'status'] = 'Saved';
	    $focus->column_fields['approvalstatus'] = '0';
	    $focus->column_fields['status'] = '0';
	    $focus->column_fields['salevolume'] = '0'; 
		$focus->column_fields['sequence'] = '1000';
	}

	$focus->column_fields["datafrom"] = '后台';

	if($focus->column_fields['memberrate'] == '' && $focus->mode == "create")
	{
		$focus->column_fields['memberrate'] = '2'; 
	
	} 


	$mall_productpropertys=XN_Query::create ( 'Content' )
		    ->tag('mall_product_property')
		    ->filter( 'type', 'eic', 'mall_product_property')
		    ->filter('my.productid', '=', $_REQUEST['record'])
		    ->filter('my.deleted','=','0')
			->order('my.shop',XN_Order::ASC_NUMBER)
		    ->begin(0)
		    ->end(1)
		    ->execute();

	if (count($mall_productpropertys) > 0)
	{
		$mall_productproperty_info = $mall_productpropertys[0];
		$shop = $mall_productproperty_info->my->shop;
		if ($focus->column_fields['shop_price'] != $shop)
		{
		    $focus->column_fields['shop_price'] = $shop; 
		}
	}
}
else
{
	$focus->column_fields['property_type'] = $loadcontent->my->property_type;
    $focus->column_fields['myproperty_type'] = $loadcontent->my->myproperty_type; 
	$focus->column_fields['approvalstatus'] = '0';
}


 
try { 

    $focus->saveentity($currentModule);
} 
catch (XN_Exception $e) 
{
	echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
	die;
}

//echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';

echo '{"statusCode":"200","message":null,"tabid":null,"callbackType":"forward","forward":"/index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}';

?>






