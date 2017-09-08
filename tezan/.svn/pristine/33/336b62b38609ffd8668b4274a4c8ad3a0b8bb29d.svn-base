<?php


/*
$ma_paymentlist = XN_Query::create ( 'Content' ) ->tag("ma_paymentlist")
	->filter ( 'type', 'eic', 'ma_paymentlist')
 	->filter ( 'my.deleted', '=', '0' )
	->end(-1)
	->execute();
foreach($ma_paymentlist as $ma_paymentlist_info)
{
	$sid = $ma_paymentlist_info->my->supplierid;
	if (!isset($sid) || $sid == "")
	{
		 $paymentid = $ma_paymentlist_info->my->paymentid;
		 $ma_paymentlist_info->my->supplierid = $paymentid;
		 $ma_paymentlist_info->save("ma_paymentlist,ma_paymentlist_".$paymentid);
	}
}

$ma_receiptlist = XN_Query::create ( 'Content' ) ->tag("ma_receiptlist")
	->filter ( 'type', 'eic', 'ma_receiptlist')
 	->filter ( 'my.deleted', '=', '0' )
	->end(-1)
	->execute();
foreach($ma_receiptlist as $ma_receiptlist_info)
{
	$sid = $ma_receiptlist_info->my->supplierid;
	if (!isset($sid) || $sid == "")
	{
		 $paymentid = $ma_receiptlist_info->my->paymentid;
		 $ma_receiptlist_info->my->supplierid = $paymentid;
		 $ma_receiptlist_info->save("ma_receiptlist,ma_receiptlist_".$paymentid);
	}
}
*/

function get_payment_receipt_data($startdate, $enddate)
{
	global $supplierid;
	$query = XN_Query::create ( 'Content_Count' ) ->tag("ma_paymentlist")
		->filter ( 'type', 'eic', 'ma_paymentlist')
	 	->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.supplierid', '=', $supplierid ) 
		->rollup('my.amount')
		->group('my.receiptid')  
		->begin(0)
		->end(-1);
	
	if (isset($startdate) && $startdate != "" &&
		isset($enddate) && $enddate != "")
	{
		$query->filter('published','>=',$startdate." 00:00:00")
			  ->filter('published','<=',$enddate." 23:59:59"); 
	}
	
	$ma_paymentlist = $query->execute();
	
	$payment_receipt = array();	
	foreach($ma_paymentlist as $ma_paymentlist_info)
	{
		 $amount = $ma_paymentlist_info->my->amount;
		 $receiptid = $ma_paymentlist_info->my->receiptid; 
		 $payment_receipt[$receiptid]['payment'] = $amount;
		 $payment_receipt[$receiptid]['receipt'] = '0';
	}
	$query = XN_Query::create ( 'Content_Count' ) ->tag("ma_receiptlist")
		->filter ( 'type', 'eic', 'ma_receiptlist')
	 	->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.supplierid', '=', $supplierid ) 
		->rollup('my.amount')
		->group('my.paymentid')  
		->begin(0)
		->end(-1);
	if (isset($startdate) && $startdate != "" &&
		isset($enddate) && $enddate != "")
	{
		$query->filter('published','>=',$startdate." 00:00:00")
			  ->filter('published','<=',$enddate." 23:59:59"); 
	}
	$ma_receiptlist = $query->execute();
	foreach($ma_receiptlist as $ma_receiptlist_info)
	{
		 $amount = $ma_receiptlist_info->my->amount;
		 $paymentid= $ma_receiptlist_info->my->paymentid; 
		 if (isset($payment_receipt[$paymentid]))
		 {
		 	 $payment_receipt[$receiptid]['receipt'] = $amount;
		 }
		 else
		 {
			 $payment_receipt[$receiptid]['payment'] = '0';
		 	 $payment_receipt[$receiptid]['receipt'] = $amount;
		 } 
	}
	return $payment_receipt;
}


	
global $supplierid;

global $currentModule;
require_once('Smarty_setup.php'); 
require_once('include/utils/DataSearch.php');
require_once('modules/CustomView/CustomView.php');

global $app_strings,$mod_strings,$current_language;
$current_module_strings = return_module_language($current_language, $currentModule);


$smarty = new vtigerCRM_Smarty;

if($_REQUEST['errormsg'] != '')
{
        $errormsg = $_REQUEST['errormsg'];
        $smarty->assign("ERROR",$errormsg);
}else
{
        $smarty->assign("ERROR","");
}
if($_REQUEST['numPerPage'] != '' && $_REQUEST['numPerPage'] != $_SESSION['numPerPage'])
{
	$numperpage = $_REQUEST['numPerPage'];
	$_SESSION['numPerPage'] = $numperpage;
} 
else if(isset($_SESSION['numPerPage']) && $_SESSION['numPerPage'] != "")
{
	$numperpage = $_SESSION['numPerPage'];
}
else
{
	$numperpage = 50;
}
$smarty->assign("NUMPERPAGE", $numperpage);

$upperModule = strtoupper($currentModule);


//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>

if($_REQUEST['_order'] != '' && $_REQUEST['_order'] != $_SESSION[$upperModule.'_ORDER_BY'])
{
	$order_by = $_REQUEST['_order'];
	$_SESSION[$upperModule.'_ORDER_BY'] = $order_by;
} 
else if(isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
{
	$order_by = $_SESSION[$upperModule.'_ORDER_BY'];
}
else
{
	$order_by = "published";
}
////////////////////////////////
if($_REQUEST['_sort'] != '' && $_REQUEST['_sort'] != $_SESSION[$upperModule.'_SORT_ORDER'])
{
	$sorder= $_REQUEST['_sort'];
	$_SESSION[$upperModule.'_SORT_ORDER'] = $sorder;
} 
else if(isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
{
	$sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
}
else
{
	$sorder = "DESC";
}


//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>


$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>

global $supplierid;
  


if (isset($_REQUEST['reportsintegrated_published_thistype']) && 
	$_REQUEST['reportsintegrated_published_thistype'] != "all" &&
	isset($_REQUEST['published_enddate']) &&
	isset($_REQUEST['published_startdate']))
{
	$_SESSION['PUBLISHED_THISTYPE']= $_REQUEST['reportsintegrated_published_thistype'];
	$_SESSION['PUBLISHED_STARTDATE'] = $_REQUEST['published_startdate'];
	$_SESSION['PUBLISHED_ENDDATE'] = $_REQUEST['published_enddate']; 
}

if (isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '' &&
	isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '')
{
	$published_enddate = $_REQUEST['published_enddate'];
	$published_startdate = $_REQUEST['published_startdate']; 
}  
elseif (isset($_SESSION['PUBLISHED_STARTDATE']) && $_SESSION['PUBLISHED_STARTDATE'] != '' && 
	    isset($_SESSION['PUBLISHED_ENDDATE']) && $_SESSION['PUBLISHED_ENDDATE'] != '' && 
		$_REQUEST['reportsintegrated_published_thistype'] != "all" )
{ 
	$published_startdate = $_SESSION['PUBLISHED_STARTDATE']; 
	$published_enddate = $_SESSION['PUBLISHED_ENDDATE'];   
} 
else
{ 
	$published_startdate = ''; 
	$published_enddate = ''; 
} 
 
 
$smarty->assign("PAGENUM", "");

$payment_receipt = get_payment_receipt_data($published_startdate, $published_enddate);

$this_year_startdate = date("Y")."-01-01"; 
$this_year_enddate = date("Y")."-12-31"; 

$this_year_payment_receipt = get_payment_receipt_data($this_year_startdate, $this_year_enddate);


 
foreach($this_year_payment_receipt as $supplierid => $payment_receipt_info)
{
	 if (isset($payment_receipt[$supplierid]))
	 {
		 $payment_receipt[$supplierid]['thisyear_payment'] = $payment_receipt_info['payment'];
	 	 $payment_receipt[$supplierid]['thisyear_receipt'] = $payment_receipt_info['receipt'];
	 }
	 else
	 {
		 $payment_receipt[$supplierid]['thisyear_payment'] = $payment_receipt_info['payment'];
	 	 $payment_receipt[$supplierid]['thisyear_receipt'] = $payment_receipt_info['receipt'];
		 $payment_receipt[$supplierid]['payment'] = 0;
	 	 $payment_receipt[$supplierid]['receipt'] = 0;
	 }
} 
  
$noofrows = count($payment_receipt);

$smarty->assign('NOOFROWS',$noofrows);

$list_entries = array();

$list_entries['supplierid'] = array('label' => '科目名称','sort'=> false,'width' => 30,'align' => "center" );
$list_entries['rmb'] = array('label' => '币别','sort'=> false,'width' => 10,'align' => "center" );
$list_entries['payment'] = array('label' => '本期借方发生额','sort'=> false,'width' => 15,'align' => "center" );
$list_entries['receipt'] = array('label' => '本期贷方发生额','sort'=> false,'width' => 15,'align' => "center" ); 
$list_entries['thisyear_payment'] = array('label' => '本年借方累计','sort'=> false,'width' => 15,'align' => "center" );
$list_entries['thisyear_receipt'] = array('label' => '本年贷方累计','sort'=> false,'width' => 15,'align' => "center" ); 

$smarty->assign("LISTHEADER",$list_entries); 

function getStdOutput($list_result, $list_entries)
{
	$supplierids = array_keys($list_result); 
	$supplier_names = array(); 
	$ma_suppliers = XN_Content::loadMany($supplierids,"ma_suppliers");
	 
	foreach($ma_suppliers as $ma_supplier_info)
	{
		$supplier_names[$ma_supplier_info->id] = $ma_supplier_info->my->suppliername;
	}  
	
	$return_data = array();
	foreach($list_result as $supplierid => $info)
	{
		$standCustFld = array();
		foreach(array_keys($list_entries) as $field)
		{
			if ($field == "supplierid")
			{
				$standCustFld[]= $supplier_names[$supplierid];
			}
			else if ($field == "rmb")
			{
				$standCustFld[]= '人民币';
			} 
			else if ($field == "payment" || $field == "receipt" || $field == "thisyear_payment" || $field == "thisyear_receipt")
			{
				$standCustFld[]= number_format($info[$field], 2, ".", "");
			} 
			else
			{
				$standCustFld[]= $info[$field];
			}
			
		}
		$return_data[$supplierid]=$standCustFld;
	}
	return $return_data;
}

$smarty->assign("LISTENTITY",getStdOutput($payment_receipt, $list_entries));



$searchpanel = array();
if (isset($_REQUEST['reportsintegrated_published_thistype']))
{
	$thistype = $_REQUEST['reportsintegrated_published_thistype']; 
}
else if ( isset($_SESSION['PUBLISHED_THISTYPE']) && $_SESSION['PUBLISHED_THISTYPE'] != '' )
{
	$thistype = $_SESSION['PUBLISHED_THISTYPE'];  
}
else
{
	$thistype = "";  
} 

 

$searchpanel['操作日期'] = '<a href="javascript:;" id="reportsintegrated_published_all" for="reportsintegrated_published_period" '.(($thistype == 'all'?'class="over"':'')).' title="全部">全部</a>
						<a href="javascript:;" id="reportsintegrated_published_thisyear" for="reportsintegrated_published_period" '.(($thistype == 'thisyear'?'class="over"':'')).'  title="本年">本年</a>
						<a href="javascript:;" id="reportsintegrated_published_thisquater" for="reportsintegrated_published_period" '.(($thistype == 'thisquater'?'class="over"':'')).'  title="本季">本季</a>
						<a href="javascript:;" id="reportsintegrated_published_thismonth" for="reportsintegrated_published_period" '.(($thistype == 'thismonth'?'class="over"':'')).'  title="本月">本月</a>
						<a href="javascript:;" id="reportsintegrated_published_recently" for="reportsintegrated_published_period" '.(($thistype == 'recently'?'class="over"':'')).' title="最近">最近</a>
						<input type="text" name="published_startdate" id="reportsintegrated_published_startdate" value="'.$published_startdate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
						-
						<input type="text" name="published_enddate" id="reportsintegrated_published_enddate" value="'.$published_enddate.'" readonly data-toggle="datepicker" data-rule="date" size="11">
						<input value="'.$thistype.'" type="hidden" id="reportsintegrated_published_thistype" name="reportsintegrated_published_thistype" />';
 


$smarty->assign('SEARCHPANEL',$searchpanel);

$listview_check_button = array();

$smarty->assign("LISTVIEW_CHECK_BUTTON", $listview_check_button);
$smarty->assign("ACTION", "AccountSummary");
$smarty->display("Settings/ListTabView.tpl");

?>

