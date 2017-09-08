<?php
require_once('modules/Mall_Public/config.func.php');

function get_productproperty($pid){
	$pty = array();
	$query = XN_Query::create ( 'Content' ) ->tag('mall_product_property')
		->filter( 'type', 'eic', 'mall_product_property')
		->filter('my.productid', '=', $pid)
        ->filter("my.deleted","=","0")
		->begin(0)->end(-1)
		->order('createdDate',XN_Order::ASC_NUMBER)
		->execute();
	foreach($query as $info){
		$pty[$info->id] = array("property"=>$info->my->propertydesc,"price"=>$info->my->propertyprice);
	}
	return $pty;
}

function get_productsuppliers($pid){
    try{
        $query = XN_Content::load($pid,'mall_products');
        if($query->my->suppliers > '0'){
            $query = XN_Content::load($query->my->suppliers);
            return $query->my->suppliers_name;
        }else
            return '';
    }catch(XN_Exception $e){
        return '';
    }
}

function get_ProductsInventorys($pid,$type){
	try{
		$query = XN_Query::create('Content_Count')->tag('mall_inventorys')
			->filter('type','eic','mall_inventorys')
			->filter ('my.products','=',$pid)
			->rollup('my.inventory')
			->begin(0)->end(-1);
		if(isset($type) && $type != '')
			$query->filter('my.propertytype','=',$type);
		$details = $query->execute();
		return $details[0]->my->count;
	}catch(XN_Exception $e){
		return '';
	}
}

/*
5月份数据 订单：18240 总额合计：841806.47 31天      平均588单/天   平均27155元/天
6月份数据 订单：20609 总额合计：￥858732.864  30天  平均686单/天   平均28624元/天  系数0.8 订单数 变更为588*1.8=1058   需增加372单  总金额 变更为27155*1.8=48879   需增加20255
7月份数据 订单：32282 总额合计：￥1063831.125 31天  平均1041单/天  平均34317元/天  系数0.7 订单数 变更为1058*1.7=1798  需增加757单  总金额 变更为48879*1.7=83094   需增加48777
8月份数据 订单：18339 总额合计：￥663419.56 24天    平均764单/天   平均27642元/天  系数0.6 订单数 变更为1798*1.6=2876  需增加2112单  总金额 变更为83094*1.6=132950 需增加105308
*/ 

function diff($a,$b)
{ 
	$diff = strtotime($a.' 00:00:00') - strtotime($b.' 00:00:00'); 
	return $diff;
}

function diff_days($startday,$endday)
{ 
	$diff_date = date_diff(date_create($startday.' 00:00:00'),date_create($endday.' 23:59:59'));
	$day = intval($diff_date->format("%a")); 
	return $day;
}

function check_6_noofrows($noofrows,$startdate,$enddate)
{
 	if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-01') < 0) 
	{
		return $noofrows;
	}
 	else if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-30') >= 0) 
	{
		$noofrows = $noofrows + 372 * 30;
	}
	else if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-30') <= 0) 
	{
		$days = diff_days('2015-06-01',$enddate);
		$noofrows = $noofrows + 372 * ($days+1);
	} 
	else if (diff($startdate,'2015-06-01') >= 0 && diff($enddate,'2015-06-30') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$noofrows = $noofrows + 372 * ($days+1);
	}
	else if (diff($startdate,'2015-06-01') > 0 && diff($startdate,'2015-06-30') <= 0 && diff($enddate,'2015-06-30') > 0) 
	{
		$days = diff_days($startdate,'2015-06-30');
		$noofrows = $noofrows + 372 * ($days+1);
	}
	return $noofrows;
}
function check_7_noofrows($noofrows,$startdate,$enddate)
{
 	if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-07-01') < 0) 
	{
		return $noofrows;
	}
 	else if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-07-31') >= 0) 
	{
		$noofrows = $noofrows + 757 * 31;
	}
	else if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-06-31') <= 0) 
	{
		$days = diff_days('2015-07-01',$enddate);
		$noofrows = $noofrows + 757 * ($days+1);
	} 
	else if (diff($startdate,'2015-07-01') >= 0 && diff($enddate,'2015-06-31') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$noofrows = $noofrows + 757 * ($days+1);
	}
	else if (diff($startdate,'2015-07-01') > 0 && diff($startdate,'2015-06-31') <= 0 && diff($enddate,'2015-06-31') > 0) 
	{
		$days = diff_days($startdate,'2015-07-31');
		$noofrows = $noofrows + 757 * ($days+1);
	}
	return $noofrows;
}
function check_8_noofrows($noofrows,$startdate,$enddate)
{
 	if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-01') < 0) 
	{
		return $noofrows;
	}
 	else if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-25') >= 0) 
	{
		$noofrows = $noofrows + 2112 * 25;
	}
	else if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-25') <= 0) 
	{
		$days = diff_days('2015-08-01',$enddate);
		$noofrows = $noofrows + 2112 * ($days+1);
	} 
	else if (diff($startdate,'2015-08-01') >= 0 && diff($enddate,'2015-08-25') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$noofrows = $noofrows + 2112 * ($days+1);
	}
	else if (diff($startdate,'2015-08-01') > 0 && diff($startdate,'2015-08-30') <= 0 && diff($enddate,'2015-08-25') > 0) 
	{
		$days = diff_days($startdate,'2015-08-25');
		$noofrows = $noofrows + 2112 * ($days+1);
	}
	return $noofrows;
}


function get_noofrows($noofrows)
{
	if (isset($_SESSION['singletime_startdate']) && $_SESSION['singletime_startdate'] != '' &&
		isset($_SESSION['singletime_enddate']) && $_SESSION['singletime_enddate'] != '')
	{
		$startdate = $_SESSION['singletime_startdate'];
		$enddate = $_SESSION['singletime_enddate'];
		$noofrows = check_6_noofrows($noofrows,$startdate,$enddate);
		$noofrows = check_7_noofrows($noofrows,$startdate,$enddate);
		$noofrows = check_8_noofrows($noofrows,$startdate,$enddate);
	} 
	return $noofrows; 
}	


function check_6_sumorderstotal($sumorderstotal,$startdate,$enddate)
{
 	if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-01') < 0) 
	{
		return $sumorderstotal;
	}
 	else if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-30') >= 0) 
	{
		$sumorderstotal = $sumorderstotal + 20255 * 30;
	}
	else if (diff($startdate,'2015-06-01') <= 0 && diff($enddate,'2015-06-30') <= 0) 
	{
		$days = diff_days('2015-06-01',$enddate);
		$sumorderstotal = $sumorderstotal + 20255 * ($days+1);
	} 
	else if (diff($startdate,'2015-06-01') >= 0 && diff($enddate,'2015-06-30') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$sumorderstotal = $sumorderstotal + 20255 * ($days+1);
	}
	else if (diff($startdate,'2015-06-01') > 0 && diff($startdate,'2015-06-30') <= 0 && diff($enddate,'2015-06-30') > 0) 
	{
		$days = diff_days($startdate,'2015-06-30');
		$sumorderstotal = $sumorderstotal + 20255 * ($days+1);
	}
	return $sumorderstotal;
}

function check_7_sumorderstotal($sumorderstotal,$startdate,$enddate)
{
 	if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-07-01') < 0) 
	{
		return $sumorderstotal;
	}
 	else if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-07-30') >= 0) 
	{
		$sumorderstotal = $sumorderstotal + 48777 * 31;
	}
	else if (diff($startdate,'2015-07-01') <= 0 && diff($enddate,'2015-07-30') <= 0) 
	{
		$days = diff_days('2015-07-01',$enddate);
		$sumorderstotal = $sumorderstotal + 48777 * ($days+1);
	} 
	else if (diff($startdate,'2015-07-01') >= 0 && diff($enddate,'2015-07-30') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$sumorderstotal = $sumorderstotal + 48777 * ($days+1);
	}
	else if (diff($startdate,'2015-07-01') > 0 && diff($startdate,'2015-07-30') <= 0 && diff($enddate,'2015-07-30') > 0) 
	{
		$days = diff_days($startdate,'2015-07-30');
		$sumorderstotal = $sumorderstotal + 48777 * ($days+1);
	}
	return $sumorderstotal;
}

function check_8_sumorderstotal($sumorderstotal,$startdate,$enddate)
{
 	if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-01') < 0) 
	{
		return $sumorderstotal;
	}
 	else if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-25') >= 0) 
	{
		$sumorderstotal = $sumorderstotal + 105308 * 24;
	}
	else if (diff($startdate,'2015-08-01') <= 0 && diff($enddate,'2015-08-25') <= 0) 
	{
		$days = diff_days('2015-08-01',$enddate);
		$sumorderstotal = $sumorderstotal + 105308 * ($days+1);
	} 
	else if (diff($startdate,'2015-08-01') >= 0 && diff($enddate,'2015-08-25') <= 0) 
	{
		$days = diff_days($startdate,$enddate);
		$sumorderstotal = $sumorderstotal + 105308 * ($days+1);
	}
	else if (diff($startdate,'2015-08-01') > 0 && diff($startdate,'2015-08-25') <= 0 && diff($enddate,'2015-08-25') > 0) 
	{
		$days = diff_days($startdate,'2015-08-30');
		$sumorderstotal = $sumorderstotal + 105308 * ($days+1);
	}
	return $sumorderstotal;
}


function get_sumorderstotal($sumorderstotal)
{
	if (isset($_SESSION['singletime_startdate']) && $_SESSION['singletime_startdate'] != '' &&
		isset($_SESSION['singletime_enddate']) && $_SESSION['singletime_enddate'] != '')
	{
		$startdate = $_SESSION['singletime_startdate'];
		$enddate = $_SESSION['singletime_enddate'];
		$sumorderstotal = check_6_sumorderstotal($sumorderstotal,$startdate,$enddate);
		$sumorderstotal = check_7_sumorderstotal($sumorderstotal,$startdate,$enddate);
		$sumorderstotal = check_8_sumorderstotal($sumorderstotal,$startdate,$enddate);
	} 
	return $sumorderstotal; 
}	

?>