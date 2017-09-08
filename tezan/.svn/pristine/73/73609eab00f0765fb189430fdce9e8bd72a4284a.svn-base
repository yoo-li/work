<?php
//require_once ("ttwz/config.postage.php");
global $mod_strings,$app_strings,$theme,$currentModule,$current_user;

if(isset($_REQUEST['readonly']) && $_REQUEST['readonly'] !='') 
{
		$readonly = $_REQUEST['readonly'];
}

$panel =  strtolower(basename(__FILE__,".php"));	
 
require_once('modules/Mall_Orders/utils.php');

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') 
{
		$recordid = $_REQUEST['record'];
		$details = XN_Content::load($recordid,strtolower($currentModule),7);
		$orderid = $details->my->orderid;
		$profileid = $details->my->profileid;  
		if(isset($_REQUEST['conntype']) && $_REQUEST['conntype'] =='addnew') 
		{
			require_once('Smarty_setup.php');
			require_once('include/utils/utils.php');
			$smarty = new vtigerCRM_Smarty; 
			$steps = array("待处理","协商处理中","不退货","换货","已退货"); 
			$step .= '<option value=""></option>'; 
			foreach($steps as $step_info)
			{ 
				if($details->my->mall_returnedgoodsapplysstatus == "不退货" || 
				   $details->my->mall_returnedgoodsapplysstatus == "已退款" || 
				   $details->my->mall_returnedgoodsapplysstatus == "已退货" || 
				   $details->my->mall_returnedgoodsapplysstatus == "换货")
				{
				     $step .= '<option disabled value="'.$step_info.'">'.$step_info.'</option>'; 
				} 
				else
				{ 
    				 $step .= '<option value="'.$step_info.'">'.$step_info.'</option>';
				}
			}
			$step .= '<option disabled value="已退款">已退款</option>';
			$step .= '<option value="解释说明">解释说明</option>';
			$orders = XN_Content::load($details->my->orderid,'mall_orders',7); 
			$msg = '
				<input type="hidden" name="conntype" value="savedetails">
				<input type="hidden" name="mode" value="ajax">
				<div class="form-group">
					<label class="control-label x120">'.getTranslatedString('Author').':</label>
					<input type="text" disabled  value="'.$current_user->last_name.'">
				</div>
				<div class="form-group">
					<label class="control-label x120">'.getTranslatedString('Published').':</label>
					<input type="text" disabled  value="'.date("Y-m-d H:i:s").'">
				</div>
				<div class="form-group">
					<label class="control-label x120">'.getTranslatedString('Step').':</label>
					<select data-toggle="selectpicker" data-rule="required" id="step" class="required" name="step" style="width:134px;cursor: pointer;">'.$step.'</select>
				</div>
				<div class="form-group">
					<label class="control-label x120">*</font>'.getTranslatedString('Content').':</label>
					<textarea class="required"  data-rule="required" style="width:280px;height:70px;" name="content" id="content"></textarea>
				</div>
				</div>
			';
			$smarty->assign("MSG", $msg);
			$smarty->assign("SUBMODULE", $currentModule);
			$smarty->assign("SUBACTION", $_REQUEST['action']);
			// $smarty->assign("ONCLICK", '
// 					var step = $("#step").val();
// 					if(step == "已退货" || step == "已退款"){
// 						if(confirm("【"+step+"】无法撤销！确定要执行？")){
// 						   return true;
// 						}else{
// 						   return false;
// 						}
// 					}else{
// 						return true;
// 					}
// 				'); 
			$smarty->assign("OKBUTTON", "保存");
			$smarty->assign("CANCELBUTTON", "返回");
			$smarty->assign("RECORD", $recordid);
			$smarty->display('MessageBox.tpl');
			die();
		}
		if(isset($_REQUEST['conntype']) && $_REQUEST['conntype'] =='savedetails')
		 {
			if($details->my->mall_returnedgoodsapplysstatus == "不退货" || 
			   $details->my->mall_returnedgoodsapplysstatus == "已退款" || 
			   $details->my->mall_returnedgoodsapplysstatus == "已退货" || 
			   $details->my->mall_returnedgoodsapplysstatus == "换货")
			{
				  if($_REQUEST["step"] != "解释说明")
				  {
		  		        echo '{"statusCode":30,"message":"申请已['.$details->my->mall_returnedgoodsapplysstatus .']处理完毕，无法做其它处理！"}';
		  		        die();
				  }
			}
		   
			if($_REQUEST["step"] != "待处理" && 
			   $_REQUEST["step"] != "协商处理中" && 
			   $_REQUEST["step"] != "不退货" && 
			   $_REQUEST["step"] != "换货"){
				$reamount = XN_Query::create('YearContent_Count')->tag('mall_returnedgoodsapplys_products')
					->filter('type','eic','mall_returnedgoodsapplys_products')
					->filter('my.orderid','=',$details->my->orderid)
					->filter('my.deleted','=','0')
					->rollup('my.returnedgoodsquantity')
					->execute();
				foreach($reamount as $info)
				{
					if($info->my->returnedgoodsquantity <= '0')
					{
				        echo '{"statusCode":30,"message":"退货数量为0，无法退货流程"}';
				        die();
					}
				}
			}  
			$supplierid = $details->my->supplierid;  
			 
		    $newcontent = XN_Content::create('mall_returnedgoodsapplys_details','',false,7);					  
			$newcontent->my->deleted = '0';
			$newcontent->my->applyid = $recordid;
			$newcontent->my->step = $_REQUEST["step"]; 
			$newcontent->my->content = $_REQUEST["content"];
			$newcontent->my->profileid = XN_Profile::$VIEWER;  
			$newcontent->my->orderid = $details->my->orderid;  
			$newcontent->my->productid = $details->my->productid;  
			$newcontent->my->supplierid = $details->my->supplierid;   
			$newcontent->save("mall_returnedgoodsapplys_details,mall_returnedgoodsapplys_details_".$orderid.",mall_returnedgoodsapplys_details_".$supplierid.",mall_returnedgoodsapplys_details_".$profileid);
			
			$identity = getUserNameByProfile(XN_Profile::$VIEWER);
			
			$wxmsg = '您的退货请求,'.$identity.'处理为'.$_REQUEST["step"].','.$_REQUEST["content"];
			 
			
			$supplier_wxsettings = XN_Query::create ( 'MainContent' ) ->tag('supplier_wxsettings')
			    ->filter ( 'type', 'eic', 'supplier_wxsettings')
			    ->filter ( 'my.deleted', '=', '0' )
			    ->filter ( 'my.supplierid', '=' ,$supplierid)
				->end(1)
			    ->execute(); 
			if (count($supplier_wxsettings) > 0)
			{
			    $supplier_wxsetting_info = $supplier_wxsettings[0];
				$appid = $supplier_wxsetting_info->my->appid;
				require_once (XN_INCLUDE_PREFIX."/XN/Message.php"); 
				XN_Message::sendmessage($profileid,$wxmsg,$appid);   
			} 
			
			
			
			$details->my->lastdatetime = date('Y-m-d H:i:s');
			$details->my->operator = XN_Profile::$VIEWER;  
			
			if ($_REQUEST["step"] != "协商处理中" && $_REQUEST["step"] != "解释说明")  
			{
				$details->my->mall_returnedgoodsapplysstatus = $_REQUEST["step"];
			}  
			 
			$returnedgoodsapplys_products = XN_Query::create('YearContent_Count')->tag('mall_returnedgoodsapplys_products')
						->filter('type','eic','mall_returnedgoodsapplys_products')
						->filter('my.deleted','=','0')
						->filter('my.orderid', '=', $orderid)					
						->rollup('my.quantity') 
						->rollup('my.returnedgoodsquantity') 
						->rollup('my.returnedgoodsamount') 
						->begin(0)
						->end(-1)
						->execute();
			$returnedgoodsquantity = 0;
			$quantity = 0;
			$returnedgoodsamount = 0;
			if (count($returnedgoodsapplys_products) > 0)
			{
				$returnedgoodsapplys_product_info = $returnedgoodsapplys_products[0];
				$returnedgoodsquantity = intval($returnedgoodsapplys_product_info->my->returnedgoodsquantity);
				$quantity = intval($returnedgoodsapplys_product_info->my->quantity);
				$returnedgoodsamount = floatval($returnedgoodsapplys_product_info->my->returnedgoodsamount);
			} 
			$details->my->returnedgoodsquantity = $returnedgoodsquantity;
			$details->my->returnedgoodsamount = number_format($returnedgoodsamount,2,".","");  
			
			
			if ($quantity == $returnedgoodsquantity)
			{
				$allreturned = 'yes';
				$details->my->allreturned = 'yes';
			}
			else
			{
				$allreturned = 'no';
				$details->my->allreturned = 'no';
			} 
			
			if($_REQUEST["step"] == "不退货" || $_REQUEST["step"] == "换货")
			{
				$details->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$profileid.',mall_returnedgoodsapplys_'.$supplierid);
				$order_info = XN_Content::load($orderid,"mall_orders",7);
				$order_info->my->order_status = $order_info->my->old_order_status; 
				$order_info->my->submitreturnedgoodsdatetime = date('Y-m-d H:i:s');
				$order_info->my->returnedgoodsstatus = 'no';
				$order_info->my->aftersaleservicestatus = 'no';
				$order_info->my->needconfirmreceipt = 'yes';
			    $order_info->save('mall_orders,mall_orders_'.$orderid.',mall_orders_'.$profileid.',mall_orders_'.$supplierid);
				synchronous_settlementorders($orderid,$supplierid,0);
			}
			else if($_REQUEST["step"] == "已退货")
			{
				$details->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$profileid.',mall_returnedgoodsapplys_'.$supplierid);
				$order_info = XN_Content::load($orderid,"mall_orders",7);
				if ($allreturned == 'yes')
				{
					$order_info->my->order_status = "已退货";
					$order_info->my->submitreturnedgoodsdatetime = date('Y-m-d H:i:s');
					$order_info->my->returnedgoodsstatus = 'yes';
					$order_info->my->aftersaleservicestatus = 'no';
					$order_info->my->needconfirmreceipt = 'no';
				    $order_info->save('mall_orders,mall_orders_'.$orderid.',mall_orders_'.$profileid.',mall_orders_'.$supplierid);
					synchronous_settlementorders($orderid,$supplierid,1);
				}
				else
				{
					$order_info->my->order_status = $order_info->my->old_order_status; 
					$order_info->my->submitreturnedgoodsdatetime = date('Y-m-d H:i:s');
					$order_info->my->returnedgoodsstatus = 'yes';
					$order_info->my->aftersaleservicestatus = 'no';
					$order_info->my->needconfirmreceipt = 'yes';
				    $order_info->save('mall_orders,mall_orders_'.$orderid.',mall_orders_'.$profileid.',mall_orders_'.$supplierid);
					synchronous_settlementorders($orderid,$supplierid,2);
				}
				
				synchronous_returnedgoodsapplys_products($orderid);  
				inventory($orderid,$details->id,$allreturned);
			} 
			else
			{
				$details->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$profileid.',mall_returnedgoodsapplys_'.$supplierid);
 			} 
			echo '{	"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
			die();
		}
		if(isset($_REQUEST['conntype']) && $_REQUEST['conntype'] =='deleterow') {
			if(isset($_REQUEST["row"]) && $_REQUEST["row"] != ""){
				$rowid = $_REQUEST["row"];
			  	$loadcontent = 	XN_Content::load($rowid,"mall_returnedgoodsapplys_details"); 
				$orderid = $loadcontent->my->orderid;	
				$profileid = $loadcontent->my->profileid; 
			  	$step = $loadcontent->my->step; 
				if($step == "已退货" || $step == "已退款")
				{
			          echo '{"statusCode":30,"message":"已经退货退款的，不能撤销。"}';
				      die();
				}
				else
				{
					if($step == "不退货" ||  $step == "换货")
					{
						$applyid = $details->my->applyid;
						$returnedgoodsapply_info = XN_Content::load($applyid,"mall_returnedgoodsapplys");
						$returnedgoodsapply_info->my->mall_returnedgoodsapplysstatus = '待处理';
						$returnedgoodsapply_info->save('mall_returnedgoodsapplys,mall_returnedgoodsapplys_'.$orderid.',mall_returnedgoodsapplys_'.$profileid.',mall_returnedgoodsapplys_'.$supplierid);
				
					} 
				  	$loadcontent->my->deleted = '1';
					$loadcontent->save('mall_returnedgoodsapplys_details,mall_returnedgoodsapplys_details_'.$orderid.',mall_returnedgoodsapplys_details_'.$profileid.',mall_returnedgoodsapplys_details_'.$supplierid);
				} 
			}
			echo '{	"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
			die();
		}
		
		$html = '<table id="'.$panel.'_details_table" class="table table-bordered" width="100%" >
		<tbody>
		<tr>
		<th align="center" width="6%">'.getTranslatedString('Author').'</th>
		<th align="center" width="14%">'.getTranslatedString('Published').'</th>
		<th align="center" width="14%">'.getTranslatedString('Step').'</th>
		<th align="center">'.getTranslatedString('Content').'</th>
		<th align="center" style="width:5%">
			<a href="index.php?module='.$currentModule.'&action=ProcessDetails&record='.$recordid.'&readonly='.$readonly.'&conntype=addnew"   data-toggle="dialog" data-mask="true" data-width="540" data-height="310" data-fresh="false" data-title="增加明细">
				<i class="fa btn-default fa-plus-circle" style="cursor: pointer;font-size:1.3em;"></i>
			</a>
		</th>
		</tr>';

		$memos =   XN_Query::create ( 'YearContent' )->tag("mall_returnedgoodsapplys_details")
			->filter ( 'type', 'eic', 'mall_returnedgoodsapplys_details' )
			->filter ( 'my.deleted', '=', '0' )
			->filter ( 'my.applyid', '=', $recordid )
			->order('published',XN_Order::DESC)
			->execute ();
		if (count ( $memos ) > 0) 
		{
			$user_ids = array();
			foreach($memos as $memo_info)
			{
				$user_ids[] = $memo_info->my->profileid;
			}
			 
			$userlist = getOwnerProfileNameList($user_ids);
			 
			$auto_increment = 1;
			foreach($memos as $memo_info)
			{
				$profileid = $memo_info->my->profileid;
				$author = $userlist[$profileid];

				$time = strtotime($memo_info->createdDate);
				$published = date('Y-m-d H:i', $time);
				$html .= '<tr id="'.$panel.'_row_'.$auto_increment.'"><td style="text-align: center;" align="center" width="6%">'.$author.'</td><td align="center" style="text-align: center;" width="14%">'.$published.'</td><td align="center" style="text-align: center;" width="14%">'.$memo_info->my->step.'</td><td align="left">'.$memo_info->my->content.'</td>';
				$value =  strtotime(date('Y-m-d H:i:s')) - strtotime($memo_info->published);
				if ($value > 3600)//&& $memo_info->my->step != "退货中"
				{
					$html .= '<td align="center" style="text-align: center;">
						<a title="已经超过1小时" class="btn btn-gray"><i class="fa fa-minus-circle" style="cursor: pointer;font-size:1.3em;color:gray;"></i></a>
					</td>';
				}elseif($details->my->mall_returnedgoodsapplysstatus == "已退货" || 
				        $details->my->mall_returnedgoodsapplysstatus == "换货" || 
						$details->my->mall_returnedgoodsapplysstatus == "退货中" || 
						$details->my->mall_returnedgoodsapplysstatus == "不退货" || 
				        $details->my->mall_returnedgoodsapplysstatus == "已退款"){
				    $html .= '<td align="center" style="text-align: center;">
					<a title="退货或退款无法撤销，不能删除" class="btn btn-gray"><i class="fa fa-minus-circle" style="cursor: pointer;font-size:1.3em;color:gray;"></i></a>
					</td>';
				}
				else
				{
					 if (XN_Profile::$VIEWER  == $memo_info->contributorName)
					{
						$html .= '<td align="center" style="text-align: center;">
<a title="1小时内可以删除【已过'.round($value/60).'分钟】" class="btn btn-default" onclick="'.$panel.'_delete_row(\''.$auto_increment.'\',\''.$memo_info->id.'\')"><i class="fa fa-minus-circle" style="cursor: pointer;font-size:1.3em;"></i></a>
							</td>';
					}
					else
					{
						$html .= '<td align="center" style="text-align: center;"><img border="0" title="" src="/images/icons/nodelete.png"></td>';
					}
				}
				$html .= '</tr>';
				$auto_increment ++;	
			}
		}
		$html .= '</tbody></table>';
		
}

$script = '

function '.$panel.'_delete_row(cid,id){	
	var tableName = document.getElementById("'.$panel.'_details_table");
	var tbody=tableName.getElementsByTagName("tbody");
	var row = document.getElementById("'.$panel.'_row_"+cid);
	if(tbody!=null)
		tbody[0].removeChild(row);
	else
		tableName.removeChild(row);   

	var url = "module=Mall_ReturnedGoodsApplys&action=ProcessDetails&conntype=deleterow&record='.$record.'&row="+id;
	jQuery.post("index.php", url,
	function (data, textStatus)
	{				

	});	
}
';


echo '<script type="text/javascript" defer="defer">'.$script.'</script>
<div>'.$html.'</div>';

?>