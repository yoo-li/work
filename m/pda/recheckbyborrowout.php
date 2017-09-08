<?php
	session_start();

	require_once (dirname(__FILE__) . "/../include/config.inc.php");
	require_once (dirname(__FILE__) . "/../include/config.common.php");
	require_once (dirname(__FILE__) . "/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
	$record     = $_POST['record'];
	$profileid = $_POST['profileid'];
	$supplierid = $_POST['supplierid'];

	$recheckordersid = 0;
	$loadContent = XN_Content::load($record,"ma_inventoryborrowout");
	$submit_type=$loadContent->my->submit_type;
	$submit_id=$loadContent->my->submit_id;
	$receipt_type=$loadContent->my->receipt_type;
	$receipt_id=$loadContent->my->receipt_id;
	$submit_supplier_info=XN_Content::load($submit_id,"ma_suppliers");
	$ma_borrowordersout=$loadContent->my->ma_borrowordersout;
	$ma_borrowordersin=$loadContent->my->ma_borrowordersin;
	$send_supplierid=$loadContent->my->send_supplierid;
	//发货仓库
	$ma_storagelistfrom=$loadContent->my->ma_storagelist;
	$from_storage_info=XN_Content::load($ma_storagelistfrom,"ma_storagelist");
	//发货区
	$tostoragelists=XN_Query::create("Content")
		->tag("ma_storagelist")
		->filter("type","eic","ma_storagelist")
		->filter("my.supplierid","=",$send_supplierid)
		->filter("my.storagetype","=","7")
		->filter("my.deleted","=","0")
		->end(1)
		->execute();
	$tostorage_info=$tostoragelists[0];
	$ma_storagelistto=$tostorage_info->id;

	$pickorders = XN_Query::create("Content")
		->tag("ma_pickorders")
		->filter("type", "eic", "ma_pickorders")
		->filter("my.ma_inventoryborrowout", "=", $record)
		->filter("my.delivery_status", "=", "1")
		->filter("my.recheck_status","=","0")
		->filter("my.deleted", "=", "0")
		->execute();
	$ma_pickorders=array();
	foreach($pickorders as $pickorder_info){
		$ma_pickorders[]=$pickorder_info->id;
	}
	$pickdetails=XN_Query::create("Content")
		->tag("ma_pickdetails")
		->filter("type","eic","ma_pickdetails")
		->filter("my.record","in",$ma_pickorders)
		->filter("my.deleted","=","0")
				->end(-1)
		->execute();

	$amountsubmitnumber=0;
	foreach($pickorders as $pickorder_info){
		$amountsubmitnumber+=$pickorder_info->my->submitnumber;
		$pickorder_info->my->recheck_status='1';
		$pickorder_info->save("ma_pickorders");

		$query=XN_Query::create("Content")
			->tag("ma_recheckordersborrow")
			->filter("type","eic","ma_recheckordersborrow")
			->filter("my.ma_borrowordersout","=",$ma_borrowordersout)
			->filter("my.deleted","=","0")
			->execute();
		if(count($query)){
			$recheck_order=$query[0];
			$recheck_order->my->send_supplierid=$loadContent->my->send_supplierid;
			$recheck_order->my->supplierid=$loadContent->my->receipt_id;
			$recheck_order->my->number+=$pickorder_info->my->submitnumber;
			$recheck_order->my->recheckorders_status="1";
			$recheck_order->my->delivery_status="1";
			$recheck_order->save("ma_recheckordersborrow");
			$recheckordersid=$recheck_order->id;
		}
		else
		{
			$recheck_order=XN_Content::create("ma_recheckordersborrow","",false);
			$recheck_order->my->send_supplierid=$loadContent->my->send_supplierid;
			$recheck_order->my->supplierid=$loadContent->my->receipt_id;
			$recheck_order->my->ma_borrowordersout=$loadContent->my->ma_borrowordersout;
			$recheck_order->my->ma_borrowordersin=$loadContent->my->ma_borrowordersin;
			$recheck_order->my->submit_type=$loadContent->my->submit_type;
			$recheck_order->my->submit_id=$loadContent->my->submit_id;
			$recheck_order->my->receipt_type=$loadContent->my->receipt_type;
			$recheck_order->my->receipt_id=$loadContent->my->receipt_id;
			$recheck_order->my->number=$pickorder_info->my->submitnumber;
			$recheck_order->my->check_user="";
					$recheck_order->my->check_number=0;
			$recheck_order->my->check_desc="";
			$recheck_order->my->delivery_status="1";
			$recheck_order->my->recheckorders_status="1";
			$recheck_order->my->submit_user=$profileid;
			$recheck_order->my->sendnumber=0;
			$recheck_order->my->memory_type=$loadContent->my->memory_type;
			$recheck_order->my->transport_type=$loadContent->my->transport_type;
			$recheck_order->my->tradetime=$loadContent->my->tradetime;
			$recheck_order->my->tradeaddress=$loadContent->my->tradeaddress;
			$recheck_order->my->deleted='0';
			$recheck_order->my->createnew='0';
			$recheck_order->save("ma_recheckordersborrow");
			$recheckordersid=$recheck_order->id;
		}

	}

	$certificateout=XN_Content::create("ma_instoragecertificateout","",false);
	$certificateout->my->send_supplierid=$loadContent->my->send_supplierid;
	$certificateout->my->supplierid=$supplierid;
	$certificateout->my->record= $loadContent->id;
	$certificateout->my->ma_pickorders= $ma_pickorders;
	$certificateout->my->ma_recheckorders= $recheckordersid;
	$certificateout->my->ma_borrowordersout=$loadContent->my->ma_borrowordersout;
	$certificateout->my->ma_inventoryborrowout=$record;
	$certificateout->my->certificate_type="borrowout";
	$certificateout->my->submit_type=$loadContent->my->receipt_type;
	$certificateout->my->submit_id=$loadContent->my->receipt_id;
	$certificateout->my->receipt_type=$loadContent->my->submit_type;
	$certificateout->my->receipt_id=$loadContent->my->submit_id;
	$certificateout->my->number=$loadContent->my->number;
	$certificateout->my->submitnumber=$amountsubmitnumber;
	$certificateout->my->recheck_status='1';
	$certificateout->my->ma_storagelist=$loadContent->my->ma_storagelist;
	$certificateout->my->tradetime=$loadContent->my->tradetime;
	$certificateout->my->tradeaddress=$loadContent->my->tradeaddress;
	$certificateout->my->deleted='0';
	$certificateout->my->createnew='0';
	$certificateout->save("ma_instoragecertificateout");


	$product_submitnumbers=array();
	$product_ids=array();
	foreach($pickdetails as $detail_info){
		$product_ids[]=$detail_info->my->ma_products;
		$product_submitnumbers[$detail_info->my->ma_products]+=$detail_info->my->submitnumber;
	}
	$borrowout_details=XN_Query::create("Content")
		->tag("ma_borrowoutdetails")
		->filter("type","eic","ma_borrowoutdetails")
		->filter("my.record","=",$record)
		->filter("my.deleted","=","0")
		->execute();
	$factorys_names=array();
	foreach($borrowout_details as $borrowout_detail){
		$borrowout_detail->my->submitnumber+=$product_submitnumbers[$borrowout_detail->my->ma_products];
		$factorys_names[$borrowout_detail->my->factorys]=$borrowout_detail->my->factorys_name;
		$borrowout_detail->save("ma_borrowoutdetails");
	}
	if($amountsubmitnumber+$loadContent->my->submitnumber>=$loadContent->my->number){
		$loadContent->my->pick_status='3';
	}
	else{
		$loadContent->my->pick_status='2';
	}
	$loadContent->my->submitnumber+=$amountsubmitnumber;
	$loadContent->my->recheck_status='1';
	$loadContent->save("ma_inventoryborrowout");

	$from_inventorycount_infos=array();$from_inventory_infos=array();
	$to_inventorycount_infos=array();$to_inventory_infos=array();

	foreach(array_chunk($product_ids,50) as $chunk_product_ids) {
		$from_inventorycounts = XN_Query::create("Content")
			->tag("ma_inventorycount")
			->filter("type", "eic", "ma_inventorycount")
			->filter("my.ma_storagelist", "=", $ma_storagelistfrom)
			->filter("my.ma_products", "in", $chunk_product_ids)
			->filter("my.supplierid", "=", $receipt_id)
			->filter("my.deleted", "=", "0")
			->end(-1)
			->execute();
		foreach ($from_inventorycounts as $inventorycount_info) {
			$from_inventorycount_infos[$inventorycount_info->my->ma_products] = $inventorycount_info;
		}
		$frominventorylists = XN_Query::create("Content")
			->tag("ma_inventorylist")
			->filter("type", "eic", "ma_inventorylist")
			->filter("my.ma_storagelist", "=", $ma_storagelistfrom)
			->filter("my.ma_products", "in", $chunk_product_ids)
			->filter("my.supplierid", "=", $receipt_id)
			->filter("my.deleted", "=", "0")
			->end(-1)
			->execute();
		foreach ($frominventorylists as $frominventory_info) {
			$from_inventory_infos[$frominventory_info->my->union_product_batch_id] = $frominventory_info;
		}

		$toinventorycounts = XN_Query::create("Content")
			->tag("ma_inventorycount")
			->filter("type", "eic", "ma_inventorycount")
			->filter("my.ma_storagelist", "=", $ma_storagelistto)
			->filter("my.ma_products", "in", $chunk_product_ids)
			->filter("my.supplierid", "=", $receipt_id)
			->filter("my.deleted", "=", "0")
			->end(-1)
			->execute();
		foreach ($toinventorycounts as $inventorycount_info) {
			$to_inventorycount_infos[$inventorycount_info->my->ma_products] = $inventorycount_info;
		}
		$toinventorylists = XN_Query::create("Content")
			->tag("ma_inventorylist")
			->filter("type", "eic", "ma_inventorylist")
			->filter("my.ma_storagelist", "=", $ma_storagelistto)
			->filter("my.ma_products", "in", $chunk_product_ids)
			->filter("my.supplierid", "=", $receipt_id)
			->filter("my.deleted", "=", "0")
			->end(-1)
			->execute();
		foreach ($toinventorylists as $toinventory_info) {
			$to_inventory_infos[$toinventory_info->my->union_product_batch_id] = $toinventory_info;
		}
	}
	$products=XN_Content::loadMany($product_ids,"ma_product");
	foreach($products as $product_info){
		$product_detail_infos[$product_info->id]=$product_info;
	}
	//实时库存修改
	foreach($product_submitnumbers as $ma_products=>$number){
		$product_info=$product_detail_infos[$ma_products];
		if(isset($from_inventorycount_infos[$ma_products]) && $from_inventorycount_infos[$ma_products]!=""){
			$inventorycount_info=$from_inventorycount_infos[$ma_products];
			$inventorycount_info->my->inventorynum-=$number;
			$inventorycount_info->save("ma_inventorycount");
		}
		else
		{
			$inventorycount_info=XN_Content::create("ma_inventorycount","",false);
			$inventorycount_info->my->supplierid=$receipt_id;
			$inventorycount_info->my->barcode=$product_info->my->barcode;
			$inventorycount_info->my->itemcode=$product_info->my->itemcode;
			$inventorycount_info->my->ma_products=$ma_products;
			$inventorycount_info->my->ma_products_no=$product_info->my->ma_products_no;
			$inventorycount_info->my->productname=$product_info->my->productname;
			$inventorycount_info->my->guige=$product_info->my->guige;
			$inventorycount_info->my->unit=$product_info->my->unit;
			$inventorycount_info->my->registercode=$product_info->my->registercode;
			$inventorycount_info->my->memorycode=$product_info->my->memorycode;
			$inventorycount_info->my->factorys=$product_info->my->ma_factorys;
			$inventorycount_info->my->factorys_name=$factorys_names[$product_info->my->ma_factorys];
			$inventorycount_info->my->ma_storagelist=$ma_storagelistfrom;
			$inventorycount_info->my->ma_storagelibs=$from_storage_info->my->ma_storagelibs;
			$inventorycount_info->my->ma_storageracks=$from_storage_info->my->ma_storageracks;
			$inventorycount_info->my->storage_name=$from_storage_info->my->storagename;
			$inventorycount_info->my->isauthorize=$from_storage_info->my->isauthorize;
			$inventorycount_info->my->inventorynum=-$number;
			$inventorycount_info->my->storagetype=$from_storage_info->my->storagetype;
			$inventorycount_info->my->deleted='0';
			$inventorycount_info->my->createnew='0';
			$inventorycount_info->save("ma_inventorycount");
		}
		if(isset($to_inventorycount_infos[$ma_products]) && $to_inventorycount_infos[$ma_products]!=""){
			$inventorycount_info=$to_inventorycount_infos[$ma_products];
			$inventorycount_info->my->inventorynum+=$number;
			$inventorycount_info->save("ma_inventorycount");
		}
		else
		{
			$inventorycount_info=XN_Content::create("ma_inventorycount","",false);
			$inventorycount_info->my->supplierid=$receipt_id;
			$inventorycount_info->my->barcode=$product_info->my->barcode;
			$inventorycount_info->my->itemcode=$product_info->my->itemcode;
			$inventorycount_info->my->ma_products=$ma_products;
			$inventorycount_info->my->ma_products_no=$product_info->my->ma_products_no;
			$inventorycount_info->my->productname=$product_info->my->productname;
			$inventorycount_info->my->guige=$product_info->my->guige;
			$inventorycount_info->my->unit=$product_info->my->unit;
			$inventorycount_info->my->registercode=$product_info->my->registercode;
			$inventorycount_info->my->memorycode=$product_info->my->memorycode;
			$inventorycount_info->my->factorys=$product_info->my->ma_factorys;
			$inventorycount_info->my->factorys_name=$factorys_names[$product_info->my->ma_factorys];
			$inventorycount_info->my->ma_storagelist=$ma_storagelistto;
			$inventorycount_info->my->ma_storagelibs=$tostorage_info->my->ma_storagelibs;
			$inventorycount_info->my->ma_storageracks=$tostorage_info->my->ma_storageracks;
			$inventorycount_info->my->storage_name=$tostorage_info->my->storagename;
			$inventorycount_info->my->isauthorize=$tostorage_info->my->isauthorize;
			$inventorycount_info->my->inventorynum=$number;
			$inventorycount_info->my->storagetype=$tostorage_info->my->storagetype;
			$inventorycount_info->my->deleted='0';
			$inventorycount_info->my->createnew='0';
			$inventorycount_info->save("ma_inventorycount");
		}
	}
	//库存详情修改
	$billwater_Datas=array();
	foreach($pickdetails as $detail_info){
		$ma_products = $detail_info->my->ma_products;
		$product_info=$product_detail_infos[$ma_products];
		$batch_infos=json_decode($detail_info->my->batch_info,true);
		foreach($batch_infos as $index=>$number_arr){
			$products_batch_no=$number_arr["products_batch_no"];
			$union_id=$ma_products.'_'.$products_batch_no;
			//出库减库存、写流水
			if(isset($from_inventory_infos[$union_id]) && $from_inventory_infos[$union_id]!=""){
				$frominventory_info=$from_inventory_infos[$union_id];
				$oldnumber=$frominventory_info->my->inventorynum;
				$newnumber=$frominventory_info->my->inventorynum-$number_arr["submitnumber"];
				$frominventory_info->my->inventorynum=$newnumber;
				$frominventory_info->save("ma_inventorylist");
			}
			else
			{
				$oldnumber=0;
				$newnumber=-intval($number_arr["submitnumber"]);
				$frominventory_info=XN_Content::create ( 'ma_inventorylist', '', false );
				$frominventory_info->my->supplierid=$receipt_id;
				$frominventory_info->my->barcode=$detail_info->my->barcode;
				$frominventory_info->my->itemcode=$detail_info->my->itemcode;
				$frominventory_info->my->products_batch_no=$products_batch_no;
				$frominventory_info->my->ma_products=$ma_products;
				$frominventory_info->my->union_product_batch_id=$union_id;
				$frominventory_info->my->ma_products_no=$product_info->my->ma_products_no;
				$frominventory_info->my->productname=$product_info->my->productname;
				$frominventory_info->my->ma_categorys=$product_info->my->ma_categorys;
				$frominventory_info->my->guige=$detail_info->my->guige;
				$frominventory_info->my->unit=$detail_info->my->unit;
				$frominventory_info->my->registercode=$detail_info->my->registercode;
				$frominventory_info->my->factorys=$detail_info->my->factorys;
				$frominventory_info->my->factorys_name=$detail_info->my->factorys_name;
				$frominventory_info->my->ma_storagelist=$ma_storagelistfrom;
				$frominventory_info->my->ma_storagelibs=$from_storage_info->my->ma_storagelibs;
				$frominventory_info->my->ma_storageracks=$from_storage_info->my->ma_storageracks;
				$frominventory_info->my->storage_name=$from_storage_info->my->storagename;
				$frominventory_info->my->isauthorize=$from_storage_info->my->isauthorize;
				$frominventory_info->my->fromsupplierid=$submit_id;
				$frominventory_info->my->fromsuppliername=$submit_supplier_info->my->suppliername;
				$frominventory_info->my->inventorynum=$newnumber;
				$frominventory_info->my->storagetype=$from_storage_info->my->storagetype;
				$frominventory_info->my->productdate=$number_arr['productdate'];
				$frominventory_info->my->validate=$number_arr['validate'];
				$frominventory_info->my->sterilizecode=$number_arr['sterilizecode'];
				$frominventory_info->my->sterilizedate=$number_arr['sterilizedate'];
				$frominventory_info->my->sterilizevalidate=$number_arr['sterilizevalidate'];
				$frominventory_info->my->deleted='0';
				$frominventory_info->my->createnew='0';
				$frominventory_info->save("ma_inventorylist");
			}
			$billwaterContent=XN_Content::create ( 'ma_inventorybillwaters', '', false );
			$billwaterContent->my->ma_borrowordersout=$ma_borrowordersout;
			$billwaterContent->my->ma_borrowordersin=$ma_borrowordersin;
			$billwaterContent->my->barcode=$detail_info->my->barcode;
			$billwaterContent->my->itemcode=$detail_info->my->itemcode;
			$billwaterContent->my->products_batch_no=$products_batch_no;
			$billwaterContent->my->ma_products=$detail_info->my->ma_products;
			$billwaterContent->my->ma_products_no=$detail_info->my->ma_products_no;
			$billwaterContent->my->productname=$detail_info->my->productname;
			$billwaterContent->my->factorys=$detail_info->my->factorys;
			$billwaterContent->my->factorys_name=$detail_info->my->factorys_name;
			$billwaterContent->my->guige=$detail_info->my->guige;
			$billwaterContent->my->unit=$detail_info->my->unit;
			$billwaterContent->my->registercode=$detail_info->my->registercode;
			$billwaterContent->my->ma_storagelist=$ma_storagelistfrom;
			$billwaterContent->my->ma_storagelibs=$from_storage_info->my->ma_storagelibs;
			$billwaterContent->my->ma_storageracks=$from_storage_info->my->ma_storageracks;
			$billwaterContent->my->ma_inventorylist=$frominventory_info->id;
			$billwaterContent->my->receipt_type=$submit_type;
			$billwaterContent->my->submit_type=$receipt_type;
			$billwaterContent->my->submit_id=$receipt_id;
			$billwaterContent->my->receipt_id=$submit_id;
			$billwaterContent->my->execute=$profileid;
			$billwaterContent->my->oldnumber=$oldnumber;
			$billwaterContent->my->inventorynum=-intval($number_arr["submitnumber"]);
			$billwaterContent->my->newnumber=$newnumber;
			$billwaterContent->my->ma_billwatertype='31';
			$billwaterContent->my->deleted='0';
			$billwaterContent->my->createnew='0';
			$billwater_Datas[]=$billwaterContent;

			if(isset($to_inventory_infos[$union_id]) && $to_inventory_infos[$union_id]!=''){
				$toinventory_info=$to_inventory_infos[$union_id];
				$oldnumber=$toinventory_info->my->inventorynum;
				$newnumber=$toinventory_info->my->inventorynum+$number_arr["submitnumber"];
				$toinventory_info->my->inventorynum=$newnumber;
				$toinventory_info->save("ma_inventorylist");
			}
			else
			{
				$oldnumber=0;
				$newnumber=intval($number_arr["submitnumber"]);
				$toinventory_info=XN_Content::create ( 'ma_inventorylist', '', false );
				$toinventory_info->my->supplierid=$receipt_id;
				$toinventory_info->my->barcode=$detail_info->my->barcode;
				$toinventory_info->my->itemcode=$detail_info->my->itemcode;
				$toinventory_info->my->products_batch_no=$products_batch_no;
				$toinventory_info->my->ma_products=$detail_info->my->ma_products;
				$toinventory_info->my->union_product_batch_id=$union_id;
				$toinventory_info->my->ma_products_no=$detail_info->my->ma_products_no;
				$toinventory_info->my->productname=$detail_info->my->productname;
				$toinventory_info->my->ma_categorys=$product_info->my->ma_categorys;
				$toinventory_info->my->factorys=$detail_info->my->factorys;
				$toinventory_info->my->guige=$detail_info->my->guige;
				$toinventory_info->my->unit=$detail_info->my->unit;
				$toinventory_info->my->registercode=$detail_info->my->registercode;
				$toinventory_info->my->factorys_name=$detail_info->my->factorys_name;
				$toinventory_info->my->ma_storagelist=$ma_storagelistto;
				$toinventory_info->my->ma_storagelibs=$tostorage_info->my->ma_storagelibs;
				$toinventory_info->my->ma_storageracks=$tostorage_info->my->ma_storageracks;
				$toinventory_info->my->storage_name=$tostorage_info->my->storagename;
				$toinventory_info->my->isauthorize=$tostorage_info->my->isauthorize;
				$toinventory_info->my->fromsupplierid=$submit_id;
				$toinventory_info->my->fromsuppliername=$submit_supplier_info->my->suppliername;
				$toinventory_info->my->inventorynum=$newnumber;
				$toinventory_info->my->storagetype=$tostorage_info->my->storagetype;
				$toinventory_info->my->productdate=$number_arr['productdate'];
				$toinventory_info->my->validate=$number_arr['validate'];
				$toinventory_info->my->sterilizecode=$number_arr['sterilizecode'];
				$toinventory_info->my->sterilizedate=$number_arr['sterilizedate'];
				$toinventory_info->my->sterilizevalidate=$number_arr['sterilizevalidate'];
				$toinventory_info->my->deleted='0';
				$toinventory_info->my->createnew='0';
				$toinventory_info->save("ma_inventorylist");
			}
			$billwaterContent=XN_Content::create ( 'ma_inventorybillwaters', '', false );
			$billwaterContent->my->ma_borrowordersout=$ma_borrowordersout;
			$billwaterContent->my->ma_borrowordersin=$ma_borrowordersin;
			$billwaterContent->my->barcode=$detail_info->my->barcode;
			$billwaterContent->my->itemcode=$detail_info->my->itemcode;
			$billwaterContent->my->products_batch_no=$products_batch_no;
			$billwaterContent->my->ma_products=$detail_info->my->ma_products;
			$billwaterContent->my->ma_products_no=$detail_info->my->ma_products_no;
			$billwaterContent->my->productname=$detail_info->my->productname;
			$billwaterContent->my->factorys=$detail_info->my->factorys;
			$billwaterContent->my->factorys_name=$detail_info->my->factorys_name;
			$billwaterContent->my->guige=$detail_info->my->guige;
			$billwaterContent->my->unit=$detail_info->my->unit;
			$billwaterContent->my->registercode=$detail_info->my->registercode;
			$billwaterContent->my->ma_storagelist=$ma_storagelistto;
			$billwaterContent->my->ma_storagelibs=$tostorage_info->my->ma_storagelibs;
			$billwaterContent->my->ma_storageracks=$tostorage_info->my->ma_storageracks;
			$billwaterContent->my->ma_inventorylist=$toinventory_info->id;
			$billwaterContent->my->receipt_type=$submit_type;
			$billwaterContent->my->submit_type=$receipt_type;
			$billwaterContent->my->submit_id=$receipt_id;
			$billwaterContent->my->receipt_id=$submit_id;
			$billwaterContent->my->execute=$profileid;
			$billwaterContent->my->oldnumber=$oldnumber;
			$billwaterContent->my->inventorynum="+".intval($number_arr["submitnumber"]);
			$billwaterContent->my->newnumber=$newnumber;
			$billwaterContent->my->ma_billwatertype='32';
			$billwaterContent->my->deleted='0';
			$billwaterContent->my->createnew='0';
			$billwater_Datas[]=$billwaterContent;
		}
	}
	foreach(array_chunk($billwater_Datas,50) as $child_billwater_Datas){
				XN_Content::batchsave($child_billwater_Datas,"ma_inventorybillwaters");
	}

	//自动修改拣货单状态
	$wcs_orders = XN_Query::create("Content")
		->tag("wcs_orders")
		->filter("type","eic","wcs_orders")
		->filter("my.ma_pickorders","in",$ma_pickorders)
		->filter("my.wcs_ordersstatus","!=","拣货完成")
		->filter("my.deleted","=","0")
		->end(-1)
		->execute();
	$pickinguserids=XN_Query::create("Content")
		->tag("wcs_pickingusers")
		->filter("type","eic","wcs_pickingusers")
		->filter('my.supplierid',"=",$supplierid)
		->filter("my.profileid","=",$profileid)
		->filter('my.status', '=', '0')
		->filter('my.approvalstatus', '=', '2')
		->filter("my.deleted","=","0")
		->end(-1)
		->execute();
	if(count($wcs_pickinguser_info)){
		$wcs_pickinguser_info=$pickinguserids[0]->id;
		$pickinguserid = $wcs_pickinguser_info->id;
		$jobnumber = $wcs_pickinguser_info->my->jobnumber;
		$scancode = $wcs_pickinguser_info->my->scancode;
		$tagledcolor = $wcs_pickinguser_info->my->tagledcolor;
		$pickingusername = $wcs_pickinguser_info->my->name;
		$wcs_pickinguser_info->my->wcspickstatus="0";
		$wcs_pickinguser_info->save("wcs_pickingusers,wcs_pickingusers_".$supplierid);
	}
	else{
		$pickinguserid="";
		$scancode="";
		$pickingusername ="";
	}

	foreach($wcs_orders as $wcs_order_info )
	{
		$storageid=$wcs_order_info->my->ma_storagelist;
		if($wcs_order_info->my->wcs_ordersstatus!="拣货完成"){
			if($wcs_order_info->my->wcs_ordersstatus!="正在拣货"){
				$pickdetails=XN_Query::create("Content")
					->tag("ma_pickdetails")
					->filter("type","eic","ma_pickdetails")
					->filter("my.record","=",$wcs_order_info->my->ma_pickorders)
					->filter("my.deleted","=","0")
					->end(-1)
					->execute();
				$picknumber=0;
				foreach($pickdetails as $pickdetail_info)
				{
					$productid = $pickdetail_info->my->ma_products;
					$productname = $pickdetail_info->my->productname;
					$number = $pickdetail_info->my->submitnumber;
					$product_barcode = $pickdetail_info->my->barcode;

					$wcs_warehouselocationsproducts = XN_Query::create("Content")->tag("wcs_warehouselocationsproducts")
						->filter("type","eic","wcs_warehouselocationsproducts")
						->filter("my.supplierid","=",$supplierid)
						->filter("my.productid","=",$productid)
						->filter("my.storeid","=",$storageid)
						->filter("my.deleted","=","0")
						->end(1)
						->execute();
					if (count($wcs_warehouselocationsproducts) > 0)
					{
						$picknumber+=$number;
						$wcs_warehouselocationsproduct_info = $wcs_warehouselocationsproducts[0];

						$warehouselocation_info = XN_Content::load($wcs_warehouselocationsproduct_info->my->record,"wcs_warehouselocations");
						$tagid = $warehouselocation_info->my->tagid;
						$warehouselocation = $warehouselocation_info->my->no;
						$barcode = $warehouselocation_info->my->barcode;
						$product_itemcode = $wcs_warehouselocationsproduct_info->my->itemcode;
						$tagledflicker = $warehouselocation_info->my->tagledflicker;
						$haslcdscreen = $warehouselocation_info->my->haslcdscreen;
						$controllerid = $warehouselocation_info->my->controllerid;
						$channelid = $warehouselocation_info->my->channelid;

						$orders_detail = XN_Content::create("wcs_orders_details", "", false);
						$orders_detail->my->supplierid=$supplierid;
						$orders_detail->my->record = $wcs_order_info->id;
						$orders_detail->my->productid = $productid;
						$orders_detail->my->productname = $productname;
						$orders_detail->my->number = $number;
						$orders_detail->my->picknumber = $number;
						$orders_detail->my->status = '2';
						$orders_detail->my->barcode = $product_barcode;
						$orders_detail->my->itemcode = $product_itemcode;
						$orders_detail->my->warehouselocationid = $warehouselocation_info->id;
						$orders_detail->my->tagid = $tagid;
						$orders_detail->my->scancode = $scancode;
						$orders_detail->my->warehouselocation = $warehouselocation_info->my->barcode;
						$orders_detail->my->deleted = '0';
						$orders_detail->save("wcs_orders_details,wcs_orders_details_".$supplierid);


						$wcs_tags = XN_Query::create("Content")->tag("wcs_tags")
							->filter("type","eic","wcs_tags")
							->filter("my.supplierid","=",$supplierid)
							->filter("my.tagid","=",$tagid)
							->filter("my.deleted","=","0")
							->end(1)
							->execute();
						if (count($wcs_tags) == 0)
						{
							$tag_info = XN_Content::create("wcs_tags", "", false);
							$tag_info->my->supplierid=$supplierid;
							$tag_info->my->tagid = $tagid;
							$tag_info->my->orderid = $wcs_order_info->id;
							$tag_info->my->status = '1';
							$tag_info->my->deleted = '0';
							$tag_info->my->controllerid = $controllerid;
							$tag_info->my->channelid = $channelid;
							$tag_info->save("wcs_tags,wcs_tags_".$supplierid);

							$showtag_info = XN_Content::create("wcs_showtags", "", false);
							$showtag_info->my->supplierid=$supplierid;
							$showtag_info->my->tagid = $tagid;
							$showtag_info->my->record = $tag_info->id;
							$showtag_info->my->orderid = $wcs_order_info->id;
							$showtag_info->my->pickinguserid = $wcs_pickinguser_info->id;

							$showtag_info->my->warehouselocation = $warehouselocation;
							$showtag_info->my->barcode = $barcode;
							$showtag_info->my->scancode = $scancode;
							$showtag_info->my->pickingusername = $pickingusername;
							$showtag_info->my->tagledflicker = $tagledflicker;
							$showtag_info->my->haslcdscreen = $haslcdscreen;
							$showtag_info->my->number = $number;

							$showtag_info->my->orders_detailid = $orders_detail->id;
							$showtag_info->my->warehouselocationid = $warehouselocation_info->id;
							$showtag_info->my->deleted = '0';
							$showtag_info->my->status = '1';
							$showtag_info->save("wcs_showtags,wcs_showtags_".$supplierid);
						}
						else
						{
							$tag_info = $wcs_tags[0];
							$tag_info->my->status = '1';
							$tag_info->my->controllerid = $controllerid;
							$tag_info->my->orderid = $wcs_order_info->id;
							$tag_info->my->channelid = $channelid;
							$tag_info->save("wcs_tags,wcs_tags_".$supplierid);

							$wcs_showtags= XN_Query::create("Content")->tag("wcs_showtags")
								->filter("type","eic","wcs_showtags")
								->filter("my.supplierid","=",$supplierid)
								->filter("my.tagid","=",$tagid)
								->filter("my.warehouselocation","=",$warehouselocation)
								->filter("my.scancode","=",$scancode)
								->filter("my.deleted","=","0")
								->end(1)
								->execute();
							if (count($wcs_showtags) == 0)
							{
								$showtag_info = XN_Content::create("wcs_showtags", "", false);
								$showtag_info->my->supplierid=$supplierid;
								$showtag_info->my->tagid = $tagid;
								$showtag_info->my->record = $tag_info->id;
								$showtag_info->my->orderid = $wcs_order_info->id;
								$showtag_info->my->pickinguserid = $wcs_pickinguser_info->id;

								$showtag_info->my->warehouselocation = $warehouselocation;
								$showtag_info->my->scancode = $scancode;
								$showtag_info->my->barcode = $barcode;
								$showtag_info->my->tagledflicker = $tagledflicker;
								$showtag_info->my->haslcdscreen = $haslcdscreen;
								$showtag_info->my->pickingusername = $pickingusername;
								$showtag_info->my->number = $number;

								$showtag_info->my->orders_detailid = $orders_detail->id;
								$showtag_info->my->warehouselocationid = $warehouselocation_info->id;
								$showtag_info->my->deleted = '0';
								$showtag_info->my->status = '1';
								$showtag_info->save("wcs_showtags,wcs_showtags_".$supplierid);
							}
							else
							{
								$showtag_info = $wcs_showtags[0];
								$status = $showtag_info->my->status;
								if ($status == "1")
								{
									$showtag_info->my->record = $tag_info->id;
									$showtag_info->my->orderid = $wcs_order_info->id;
									$showtag_info->my->pickinguserid = $wcs_pickinguser_info->id;

									$showtag_info->my->barcode = $barcode;
									$showtag_info->my->tagledflicker = $tagledflicker;
									$showtag_info->my->haslcdscreen = $haslcdscreen;
									$showtag_info->my->pickingusername = $pickingusername;
									$showtag_info->my->number = $number;

									$showtag_info->my->orders_detailid = $orders_detail->id;
									$showtag_info->my->warehouselocationid = $warehouselocation_info->id;
									$showtag_info->my->deleted = '0';
									$showtag_info->my->status = '1';
									$showtag_info->save("wcs_showtags,wcs_showtags_".$supplierid);
								}
								else
								{
									$oldnumber = $showtag_info->my->number;
									$showtag_info->my->number = intval($oldnumber) + intval($number);
									$old_orders_detailid = $showtag_info->my->orders_detailid;
									$showtag_info->my->barcode = $barcode;
									$showtag_info->my->orders_detailid = $old_orders_detailid.",".$orders_detail->id;
									$showtag_info->my->status = '1';
									$showtag_info->save("wcs_showtags,wcs_showtags_".$supplierid);
								}
							}
						}

					}
				}
			}
			else{
				$wcs_orderdetails = XN_Query::create("Content")->tag("wcs_orders_details")
					->filter("type","eic","wcs_orders_details")
					->filter("my.record","=",$wcs_order_info->id)
					->filter("my.deleted","=","0")
					->end(-1)
					->execute();
				foreach($wcs_orderdetails as $orderdetail){
					$orderdetail->my->picknumber=$orderdetail->my->number;
					$orderdetail->my->status="1";
					$orderdetail->save("wcs_orders_details");
				}

				$wcs_tags = XN_Query::create("Content")->tag("wcs_tags")
					->filter("type","eic","wcs_tags")
					->filter("my.supplierid","=",$supplierid)
					->filter("my.orderid","=",$wcs_order_info->id)
					->filter("my.status","=","0")
					->filter("my.deleted","=","0")
					->end(-1)
					->execute();
				foreach($wcs_tags as $wcs_tag_info)
				{
					$wcs_tag_info->my->status = "1";
					$wcs_tag_info->save("wcs_tags,wcs_tags_". $supplierid);
				}

				$wcs_showtags = XN_Query::create("Content")->tag("wcs_showtags")
					->filter("type","eic","wcs_showtags")
					->filter("my.supplierid","=",$supplierid)
					->filter("my.orderid","=",$wcs_order_info->id)
					->filter("my.status","=","0")
					->filter("my.deleted","=","0")
					->end(-1)
					->execute();
				foreach($wcs_showtags as $wcs_showtag_info)
				{
					$wcs_showtag_info->my->status = "1";
					$wcs_showtag_info->save("wcs_showtags,wcs_showtags_". $supplierid);
				}
			}
			$wcs_order_info->my->pickinguserid = $pickinguserid;
			$wcs_order_info->my->usenumber = $wcs_order_info->my->number;
			$wcs_order_info->my->picknumber = $wcs_order_info->my->number;
			$wcs_order_info->my->startdate = date("Y-m-d H:i");
			$wcs_order_info->my->enddate = date("Y-m-d H:i");
			$wcs_order_info->my->wcs_ordersstatus = "拣货完成";
			$wcs_order_info->my->finished = '1';
			$wcs_order_info->my->progress = '100%';
			$tag = "wcs_orders,wcs_orders_". $supplierid;
			$wcs_order_info->save($tag);
		}
	}

	echo '200';

