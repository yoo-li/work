<?php


global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

require_once('include/utils/utils.php');
require_once('include/utils/UserInfoUtil.php');

  


$content = '<table width="100%" cellspacing="0" border="0" align="center" style="font-family: Arial; font-size: 10pt">
    <tbody>
        <tr>
            <td valign="top" align="center" colspan="4" rowspan="1">
                <p style="font-size: 20px;">
                    $suppliername
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" align="center" colspan="4" rowspan="1">
                <strong><span style="font-family: 黑体;font-size: 20px;">拣货对账单</span></strong>
            </td>
        </tr>		
        <tr>          
	        <td width="30%" valign="top" align="left" colspan="1" rowspan="1" style="word-break: break-all;">    
			$vendorname
            </td>
            <td width="39%" valign="top" align="center" colspan="2" rowspan="1">
              	 $currentdate
            </td>
            <td width="30%" valign="top" align="right" colspan="1" rowspan="1" style="word-break: break-all;">
			&nbsp;</td>
        </tr>
        <tr>
            <td width="99%" valign="top" align="center" colspan="4">
                <table width="100%" cellspacing="0" cellpadding="0" border="1" style="font-family: Arial; font-size: 10pt;" bordercolorlight="#b0b0b0" bordercolordark="#ffffff">
                    <tbody>
                        <tr>
                            <td width="10%" valign="middle" height="25" align="center" style="word-break: break-all;">
                                订单编号
                            </td>  
							<td width="10%" valign="middle" align="center" style="word-break: break-all;">
                                付款时间
                            </td> 
                            <td width="8%" style="word-break: break-all;" align="center" > 
                                购货人
                            </td>
                            <td width="8%" valign="middle" align="center" style="word-break: break-all;">
                                手机号码
                            </td> 
							<td width="30%" valign="middle" align="center" style="word-break: break-all;">
                                收货地址
                            </td>  
                        </tr>
						$printlogisticstatistics
                    </tbody>
                </table>
            </td>			 
        </tr>
		  <tr>          
	        <td width="30%" valign="top" align="left" colspan="1" rowspan="1" style="word-break: break-all;">    
			 订单数：$ordercount 单
            </td>
            <td width="39%" valign="top" align="center" colspan="2" rowspan="1">
              打印时间：$currentdate $currenttime
            </td>
            <td width="30%" valign="top" align="right" colspan="1" rowspan="1" style="word-break: break-all;">操作人：$author</td>
        </tr>
    </tbody>
</table>';

 
global  $supplierid;


$templates = array();
 
$templates['$currentdate'] = getNewDisplayDate();
$templates['$currenttime'] = date('h:i:s');
$templates['$author'] = getUserNameByProfile(XN_Profile::$VIEWER);

if(isset($_SESSION['vendorid']) && $_SESSION['vendorid'] != '')
{
    $vendorid = $_SESSION['vendorid'];
	$vendor_info = XN_Content::load($vendorid,"mall_vendors_".$supplierid);
    $templates['$vendorname'] = $vendor_info->my->vendorname;
}

 
$supplier_info = XN_Content::load($supplierid,"suppliers");
$templates['$suppliername'] = $supplier_info->my->suppliers_name;
 

$templates['$ordercount'] = 0;
$templates['$printlogisticstatistics'] = "";
 
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{
	$ids = $_REQUEST['ids'];
    $ids = str_replace(";",",",$ids);
    $ids = explode(",",trim($ids,','));
    array_unique($ids);
	if (count($ids) > 0)
	{
			$orders = array();
		    $mall_settlementorders = XN_Query::create('YearContent')->tag('mall_settlementorders_' . $supplierid)
			    ->filter('type', 'eic', 'mall_settlementorders')
			    ->filter('my.deleted', '=', '0') 
				->filter('my.deliverystatus', '=', '0') 
			    ->filter('my.supplierid', '=', $supplierid)     
			    ->filter('id', 'in', $ids) 
				->filter('my.vendorid', '=', $vendorid) 
			    ->end(-1)
				->execute();   
		   
		  	$orderids = array();
		  	if (count($mall_settlementorders) > 0)
		  	{
		  		foreach($mall_settlementorders as $mall_settlementorder_info)
		  		{
		  			$orderid = $mall_settlementorder_info->my->orderid;
		  			$orderids[] = $orderid;
		  		}
		  	} 
			$mall_orders = XN_Content::loadMany($orderids,"mall_orders_".$supplierid,7);
			$products = array();
			foreach($mall_orders as $mall_order_info)
			{
				$orderid = $mall_order_info->id;
				$orders[$orderid]["mall_orders_no"] = $mall_order_info->my->mall_orders_no;
				$orders[$orderid]["consignee"] = $mall_order_info->my->consignee;
				$orders[$orderid]["mobile"] = $mall_order_info->my->mobile;
				$orders[$orderid]["postage"] = $mall_order_info->my->postage;
				$orders[$orderid]["order_status"] = $mall_order_info->my->order_status;
				$orders[$orderid]["singletime"] = $mall_order_info->my->singletime;
				$orders[$orderid]["paymenttime"] = $mall_order_info->my->paymenttime;
				$deliverytime = $mall_order_info->my->deliverytime;
				$deliverytime = date("Y-m-d H:i",strtotime($deliverytime));
				$orders[$orderid]["deliverytime"] = $deliverytime;
				$orders[$orderid]["invoicenumber"] = $mall_order_info->my->invoicenumber;
				$orders[$orderid]["address"] = $mall_order_info->my->address;
				$bills = array();
			    foreach($mall_settlementorders as $mall_settlementorder_info)
				{
					if ($mall_settlementorder_info->my->orderid == $orderid)
					{
						$settlementorderid = $mall_settlementorder_info->id;
						$productid = $mall_settlementorder_info->my->productid;
						if (isset($products[$productid]) && $products[$productid] != "")
						{
							$productname = $products[$productid];
						}
						else
						{
							$product_info = XN_Content::load($productid,"mall_products_".$supplierid);
							$productname = $product_info->my->productname;
							$products[$productid] = $productname;
						}
						$bills[$settlementorderid]['productid'] = $mall_settlementorder_info->my->productid;
						$bills[$settlementorderid]['productname'] = $productname;
						$bills[$settlementorderid]['propertydesc'] = $mall_settlementorder_info->my->propertydesc;
						$bills[$settlementorderid]['shop_price'] = $mall_settlementorder_info->my->shop_price;
						$quantity = $mall_settlementorder_info->my->quantity;
						$returnedquantity = $mall_settlementorder_info->my->returnedquantity;
						$bills[$settlementorderid]['quantity'] = $mall_settlementorder_info->my->quantity;
						$bills[$settlementorderid]['returnedquantity'] = $mall_settlementorder_info->my->returnedquantity;
						$bills[$settlementorderid]['deliveryquantity'] = intval($quantity) - intval($returnedquantity);
						$bills[$settlementorderid]['totalmoney'] = $mall_settlementorder_info->my->totalmoney;
						$bills[$settlementorderid]['vendor_price'] = $mall_settlementorder_info->my->vendor_price;
					} 
				}
				$orders[$orderid]['bills'] = $bills;
			}
		  
	}
	 
	 
	$printlogisticstatistics = "";
	foreach($orders as $order_info)
	{
		$printlogisticstatistics .= '<tr><td align="center">'.$order_info['mall_orders_no'].'</td>';
		$printlogisticstatistics .= '<td align="left">'.$order_info['paymenttime'].'</td>';
		//$printlogisticstatistics .= '<td align="center">'.$order_info['invoicenumber'].'</td>';
		//$printlogisticstatistics .= '<td align="left">'.$order_info['deliverytime'].'</td>';
		$printlogisticstatistics .= '<td align="center">'.$order_info['consignee'].'</td>';
		$printlogisticstatistics .= '<td align="center">'.$order_info['mobile'].'</td>';
		$printlogisticstatistics .= '<td align="left">'.$order_info['address'].'</td>';
		$printlogisticstatistics .= '</tr>';
		//$printlogisticstatistics .= '<tr><td align="center" >商品列表</td><td colspan="6">&nbsp;</td></tr>';
		$bills = $order_info['bills']; 
		$pos = 1;
		foreach($bills as $bill_info)
		{ 
			$printlogisticstatistics .= '<tr>';
			if ($pos == 1)
			{
				$printlogisticstatistics .= '<td align="center" valign="middle" rowspan="'.count($bills).'">商品列表</td>';
			} 
			if (isset($bill_info['propertydesc']) && $bill_info['propertydesc'] != "")
			{
				$printlogisticstatistics .= '<td colspan="4" align="left">'.$bill_info['productname'].',【'.$bill_info['propertydesc'].'】发货数量'.$bill_info['deliveryquantity'].'件</td></tr>';
			}
			else
			{
				$printlogisticstatistics .= '<td colspan="4" align="left">'.$bill_info['productname'].',发货数量'.$bill_info['deliveryquantity'].'件</td></tr>';
			}
			$pos ++;
			 
		}
	}
	$templates['$ordercount'] = count($orders);
	$templates['$printlogisticstatistics'] = $printlogisticstatistics;
	//print_r($orders);
	//die();
}
  
 

foreach($templates as $key => $value )
{
	$content = str_replace($key,$value,$content); 
}
 
//str_replace($initmsg,"\n",'<br>');

$script = '
function print_export(mode)
{
		window.location="/index.php?module='.$currentModule.'&action=PrintSortingOrder&oper="+mode+"&ids='.$_REQUEST['ids'].'";

}


function print_out()
{
	window.open("/index.php?module='.$currentModule.'&action=PrintSortingOrder&oper=print&ids='.$_REQUEST['ids'].'");
	
}';


	  try {		
				
				 if (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'view' )
		         {
					
					 require_once('Smarty_setup.php');

					 $smarty = new vtigerCRM_Smarty;

					 $smarty->assign("MODULE",$currentModule);
					 $smarty->assign("APP",$app_strings);
					 $smarty->assign("MOD", $mod_strings);
					 $smarty->assign("CATEGORY",getParentTab());

					 $smarty->assign("INVOICEPRINTTEMPLATE", $invoiceprinttemplate);
					 $smarty->assign("TEMPLATENAME", $template);
					 $smarty->assign("PRINTMODULE", $printmodule);
					 $smarty->assign("SCRIPT", $script);
					 $smarty->assign("PRINTDATA", $content);
					 if(is_admin($current_user)) 
					 {
						 $smarty->assign("IS_ADMIN", 'true');
					 }

					
					
					 $smarty->display('PrintStatistics.tpl');
				 }
				 elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'word' )
				 {
					header("Content-Type:   application/msword");
					header("Content-Disposition:   attachment;   filename=export.doc");
					header("Pragma:   no-cache");       
					header("Expires:   0");		
					echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
					echo $content;
					echo '</div></body></html>';
				 }
				  elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'excel' )
				 {
					header("Content-Type:   application/vns.ms-excel");
					header("Content-Disposition:   attachment;   filename=export.xls");
					header("Pragma:   no-cache");       
					header("Expires:   0");		
					echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
					echo $content;
					echo '</div></body></html>';
				 }
				  elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'pdf' )
				 {
					header("Content-Type:   application/Octet-stream;");
					header("Content-Disposition:   attachment;   filename=export.pdf");
					header("Pragma:   no-cache");       
					header("Expires:   0");		
					echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
					echo $content;
					echo '</div></body></html>';
				 }
				 elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'print' )
				 {
					echo '<html><body>';

					echo '<script type="text/javascript" charset="utf-8">
	function pagesetup_null()      
    {      
		try      
		{   
			  var HKEY_Root,HKEY_Path,HKEY_Key;
			  HKEY_Root="HKEY_CURRENT_USER";
			  HKEY_Path="\\\\Software\\\\Microsoft\\\\Internet Explorer\\\\PageSetup\\\\";
			  var Wsh=new ActiveXObject("WScript.Shell");      
			  HKEY_Key="header";  
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");      
			  HKEY_Key="footer";   
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"");      
			  HKEY_Key="margin_bottom"; 
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.3");      
			  HKEY_Key="margin_left"; 
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.3");      
			  HKEY_Key="margin_right"; 
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.2");      
			  HKEY_Key="margin_top"; 
			  Wsh.RegWrite(HKEY_Root+HKEY_Path+HKEY_Key,"0.3");    
		}      
		catch(e)
		{      
			//alert("不允许ActiveX控件");      
		}   
	}
	function printpreview()
					{
						window.print();
						/*var OLECMDID = 7;
						var PROMPT = 1; // 2 DONTPROMPTUSER
						pagesetup_null();
						var WebBrowser = \'<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>\';
						document.body.insertAdjacentHTML(\'beforeEnd\', WebBrowser);
						WebBrowser1.ExecWB(OLECMDID, PROMPT);
						WebBrowser1.outerHTML = "";*/
						
					}

					setTimeout("printpreview();",500);
					</script>';

					echo '<style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style>';
					echo $content;
					echo '</div></body></html>';
					die();
				 }	
				 die();				 
		}
		catch ( XN_Exception $e ) 
		{
			echo $e->getMessage ();
			die();
		}


?>
