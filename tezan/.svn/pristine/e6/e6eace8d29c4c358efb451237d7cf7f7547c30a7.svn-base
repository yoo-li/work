<?php
/**
 * 审核选中的写字楼 
 */
$i = 0;
if(isset($_REQUEST['ids']) && $_REQUEST['ids'] != '')
{
    $ids = $_REQUEST['ids'];
	$orders = XN_Content::loadMany(explode(',',$ids),"mall_orders");
	foreach($orders as $order_info)
	{
		if ($order_info->my->ordersstatus == "JustCreated")
		{
			$order_info->my->ordersstatus = "Accepted";
			$order_info->my->tradetime = date("Y-m-d H:i");
			$order_info->save('mall_orders');
            $i++;
		}		
	}
}
	ShowMessage("成功确认了 $i 个订单！");
    exit();