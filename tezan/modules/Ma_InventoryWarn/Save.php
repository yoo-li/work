<?php
	require_once('modules/Users/Users.php');
	require_once('include/utils/UserInfoUtil.php');
	Fast_Finish_Start(true);
	global $currentModule, $user_type, $user_type_id, $supplierusertype, $supplierid;
	$focus = CRMEntity::getInstance($currentModule);
	setObjectValuesFromRequest($focus);
	$focus->column_fields['ma_inventorywarnstatus'] = "Saved";
	$focus->column_fields['approvalstatus']         = "0";
	$focus->column_fields['supplierid']             = $supplierid;
	$focus->column_fields['isenabled']              = $_REQUEST['isenabled'];
	$focus->column_fields['name']              = $_REQUEST['name'];
	$focus->column_fields['execute']              = XN_Profile::$VIEWER;
	$query = XN_Query::create("Content")->tag("ma_inventorywarndetails")
		->filter("type", "eic", "ma_inventorywarndetails")
		->filter("my.record", "=", $record)
		->filter("my.deleted", "=", "0")
		->end(-1)
		->execute();
	if (count($query) > 0)
	{
		XN_Content::delete($query, "ma_inventorywarndetails");
	}
	try
	{
		$product_infos = [];
		foreach (array_chunk($_REQUEST['ma_products'], 50) as $chunk_ids)
		{
			$infos = XN_Content::loadMany($chunk_ids, "ma_products");
			foreach ($infos as $info)
			{
				$product_infos[$info->id] = $info;
			}
		}
		foreach ($_REQUEST['ma_products'] as $index => $val)
		{
			$ma_products_info               = $product_infos[$val];
			$pickdetail                     = XN_Content::create("ma_inventorywarndetails", "", false);
			$pickdetail->my->record         = $focus->id;
			$pickdetail->my->ma_products    = $ma_products_info->id;
			$pickdetail->my->supplierid     = $supplierid;
			$pickdetail->my->ma_products_no = $ma_products_info->my->ma_products_no;
			$pickdetail->my->productname    = $ma_products_info->my->productname;
			$pickdetail->my->ma_factorys    = $ma_products_info->my->ma_factorys;
			$pickdetail->my->factorys_name  = $ma_products_info->my->factorys_name;
			$pickdetail->my->barcode        = $ma_products_info->my->barcode;
			$pickdetail->my->itemcode       = $ma_products_info->my->itemcode;
			$pickdetail->my->unit           = $ma_products_info->my->unit;
			$pickdetail->my->guige          = $ma_products_info->my->guige;
			$pickdetail->my->deleted        = '0';
			$pickdetail->my->maximum        = $_REQUEST['maximum'][$index];
			$pickdetail->my->minimum        = $_REQUEST['minimum'][$index];
			$SaveConn[]                     = $pickdetail;
		}
		if (count($SaveConn) > 0)
		{
			foreach (array_chunk($SaveConn, 50) as $chunk)
			{
				XN_Content::batchsave($SaveConn, "ma_inventorywarndetails");
			}
		}
		$focus->saveentity($currentModule);
	}
	catch (XN_Exception $e)
	{
		Fast_Finish_End('{"statusCode":"300","message":"'.$e->getMessage().'"}', true);
	}
	Fast_Finish_End('{"statusCode":200,"message":"保存成功!","tabid":"'.$currentModule.'","forward":"index.php?module='.$currentModule.'&action=EditView&record='.$focus->id.'"}', true);