<?php
require_once('Smarty_setup.php');
global  $currentModule,$supplierid;


	if(isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
	{
		if(isset($_REQUEST['vendorid']) && $_REQUEST['vendorid'] != "")
		{
			try{
				$record = $_REQUEST['record'];
				$vendorid = $_REQUEST['vendorid'];

				$loadcontent = XN_Content::load($record,strtolower($currentModule));

				$mall_product_property = XN_Query::create("Content")->tag("mall_product_property")
					->filter("type","eic","mall_product_property")
					->filter("my.productid","=",$record)
					->filter("my.deleted","=",'0')
					->end(-1)
					->execute();
				if (count($mall_product_property) > 0)
				{
					foreach ($mall_product_property as $mall_product_property_info)
					{
						$propertyid = $mall_product_property_info->id;
						if ($vendorid == "0")
						{
							$mall_product_property_info->my->vendor_price = "";
							$mall_product_property_info->save("mall_product_property,mall_product_property_".$supplierid);

						}
						else
						{
							if(isset($_REQUEST['vendor_price_'.$propertyid]) && $_REQUEST['vendor_price_'.$propertyid] != "")
							{
								$vendor_price = $_REQUEST['vendor_price_'.$propertyid];
								$mall_product_property_info->my->vendor_price = number_format($vendor_price, 2, ".", "");
								$mall_product_property_info->save("mall_product_property,mall_product_property_".$supplierid);
							}
						}


					}
					if ($vendorid == "0")
					{
						$loadcontent->my->vendorid = "";
						$loadcontent->my->vendor_price = "";
						$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
					}
					else
					{
						$loadcontent->my->vendorid = $vendorid;
						$loadcontent->my->vendor_price = "";
						$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
					}

				}
				else
				{
					if ($vendorid == "0")
					{
						$loadcontent->my->vendorid = "";
						$loadcontent->my->vendor_price = "";
						$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
					}
					else
					{
						if(isset($_REQUEST['vendor_price']) && $_REQUEST['vendor_price'] != "")
						{
							$vendor_price = $_REQUEST['vendor_price'];
							$loadcontent->my->vendorid = $vendorid;
							$loadcontent->my->vendor_price = number_format($vendor_price, 2, ".", "");
							$loadcontent->save(strtolower($currentModule).",".strtolower($currentModule)."_".$supplierid);
						}
					}
				}
				$mall_inventorys = XN_Query::create('Content')->tag('mall_inventorys')
					->filter('type','eic','mall_inventorys')
					->filter('my.deleted','=','0')
					->filter('my.supplierid','=',$supplierid)
					->filter('my.productid','=',$record)
					->end(1)
					->execute();
				foreach($mall_inventorys as $mall_inventory_info)
				{
					if ($mall_inventory_info->my->vendorid != $vendorid)
					{
						$mall_inventory_info->my->vendorid = $vendorid;
						$mall_inventory_info->save("mall_inventorys,mall_inventorys_".$supplierid);
					}
				}
			}
			catch(XN_Exception $e){
				echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
				die();
			}
		}
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die();
	}
	else
	{
	    $binds = $_REQUEST['ids']; 
	    $binds = str_replace(";",",",$binds);
	    $binds = explode(",",trim($binds,','));
	    array_unique($binds);
	    array_unique($binds);
		if (count($binds) > 1)
		{
			require_once('Smarty_setup.php');
			require_once('include/utils/utils.php');
			$smarty = new vtigerCRM_Smarty;
			global $mod_strings;
			global $app_strings;
			global $app_list_strings;
			$smarty->assign("APP", $app_strings);
			$smarty->assign("CMOD", $mod_strings); 
		    $msg = '<div style="width:100%;text-align:center;"><br><br><font color="red" size="2">您只能选择单条记录进行修改供应商操作！</font></div>';  
			$smarty->assign("MSG", $msg);  
			$smarty->display("MessageBox.tpl");
			die();
		}
		$record = $_REQUEST['ids']; 
		$loadcontent =  XN_Content::load($record,strtolower($currentModule)."_".$supplierid); 
		$shop_price = $loadcontent->my->shop_price;
		$vendorid = $loadcontent->my->vendorid;
		$shop_price = number_format($shop_price, 2, ".", "");
		$vendors = getvendors();
		$vendoroption = '<option value="0">取消供应商</option>';
		foreach ($vendors as $key => $value)
		{
			if ($vendorid == $key)
			{
				$vendoroption .= '<option value='.$key.' selected>'.$value.'</option>';
			}
			else
			{
				$vendoroption .= '<option value='.$key.'>'.$value.'</option>';
			}

		}



		$msg= '
			<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
				<label class="control-label x150">供应商:</label>
				<select name="vendorid" style="width:150px;" class="form-control">'.$vendoroption.'</select>
			</div>
			';

		$mall_product_property = XN_Query::create("Content")->tag("mall_product_property")
			->filter("type","eic","mall_product_property")
			->filter("my.productid","=",$record)
			->filter("my.deleted","=",'0')
			->end(-1)
			->execute();
		if (count($mall_product_property) > 0)
		{
			foreach ($mall_product_property as $mall_product_property_info)
			{
				$propertyid = $mall_product_property_info->id;
				$shop = $mall_product_property_info->my->shop;
				$shop = number_format($shop, 2, ".", "");
				$vendor_price = $mall_product_property_info->my->vendor_price;
				if (isset($vendor_price) && $vendor_price != "")
				{
					$vendor_price = number_format($vendor_price, 2, ".", "");
				}
				else
				{
					$vendor_price = $shop;
				}

				$propertydesc = $mall_product_property_info->my->propertydesc;
				$msg.= '
					<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
						<label class="control-label x150">' . $propertydesc . '-结算价:</label>
						<input class="form-control required" type="text" data-rule="number;required;" value="' . $vendor_price . '" name="vendor_price_'.$propertyid.'" tabindex="16" style="width:150px" maxlength="100">元
					</div>
					';
			}
		}
		else
		{
			$vendor_price = $loadcontent->my->vendor_price;
			if (isset($vendor_price) && $vendor_price != "")
			{
				$vendor_price = number_format($vendor_price, 2, ".", "");
			}
			else
			{
				$vendor_price = number_format($shop_price, 2, ".", "");;
			}
			$msg.='<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
						<label class="control-label x150">结算价:</label>
						<input class="form-control required" type="text" data-rule="number;required;" value="' . $vendor_price . '" name="vendor_price" tabindex="16" style="width:150px" maxlength="100">元
					</div>
					';
		}


		$smarty = new vtigerCRM_Smarty;
		$smarty->assign("APP", $app_strings);
		$smarty->assign("CMOD", $mod_strings);
		$smarty->assign("MSG", $msg);
		$smarty->assign("OKBUTTON", "修改供应商");
		$smarty->assign("RECORD",$record);
		$smarty->assign("SUBMODULE", $currentModule);
		$smarty->assign("SUBACTION", $_REQUEST['action']);

		$smarty->display("MessageBox.tpl");
	}



function getvendors()
{
	global $supplierid;
    $vendors = array();
    $mall_vendors = XN_Query::create ( 'Content' )->tag('mall_vendors_'.$supplierid)
	    ->filter ( 'type', 'eic', 'mall_vendors')
	    ->filter ( 'my.supplierid',"=",$supplierid)
		->filter ( 'my.deleted', '=', '0')  
		->filter ( 'my.approvalstatus', '=', '2')  
	    ->filter ( 'my.status', '=', '0')  
	    ->end(-1)
	    ->execute(); 
    foreach ($mall_vendors as $info)
	{ 
        $vendors[$info->id] = $info->my->vendorname;  
    }
    return $vendors;
}

?>
