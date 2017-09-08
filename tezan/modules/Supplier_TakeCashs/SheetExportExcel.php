<?php


global $currentModule;
if (isset($_REQUEST['ids']) && $_REQUEST['ids'] != "")
{	
	$ids = $_REQUEST['ids'];
	$ids = explode(",",trim($ids,','));
	array_unique($ids);
	$ids = array_filter($ids);
//	rsort($ids,SORT_NUMERIC);
	$list_result = XN_Query::create('Content')->tag(strtolower($currentModule))
		->filter ( 'type', 'eic', strtolower($currentModule) )
		->filter ( 'id', 'in', $ids)
// 		->order ('my.takecashsdatetime',XN_ORDER::DESC_NUMBER)
		->begin(0)->end(-1);
// 		->execute();
//    $list_result = XN_Content::loadMany($ids,strtolower($currentModule));
	$upperModule = strtoupper($currentModule);
	$order_by = 'takecashsdatetime';
	$sorder = 'ASC';
	if(isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
	{
		$order_by = $_SESSION[$upperModule.'_ORDER_BY'];
	}
	if(isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
	{
		$sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
	}
	$query_order_by = $order_by;
	if (isset($order_by) && $order_by != '' && strncmp($order_by,'my.',3)!=0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by!= 'title')
	{
		$query_order_by = "my.".$order_by;
	}
	
	if (strtolower($sorder) == 'desc'){
		$list_result->order($query_order_by,XN_Order::DESC);
	}
	else
	{
		$list_result->order($query_order_by,XN_Order::ASC);
	}
	$list_result = $list_result->execute();
	
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "statistics"){
		$Statistics = 0;
		foreach($list_result as $info){
			$Statistics += $info->my->amount;
		}
		echo '{"status":30,"statusCode":30,"message":"统计记录：'.count($list_result).'<br>统计结果：'.abs($Statistics).'","tabid":"","callbackType":"","forward":null}';
		die();
	}
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "rejectexplanation"){
		echo '
		<style>
			span.error{
				left:auto;
				width:auto;
			}
		</style>
		<form method="post" action="index.php" callback="jQuery(\'[id=progressBar]\').addClass(\'hidden\');" onsubmit="return validateCallback(this, dialogAjaxDone)">
			<input type="hidden" value="TakeCashs" name="module">
			<input type="hidden" value="SheetExportExcel" name="action">
			<input type="hidden" value="'.$_REQUEST['ids'].'" name="ids">
			<input type="hidden" value="reject" name="opr">
			<div class="pageFormContent" style="overflow: auto;border-style: none;">
				<table class="edit-form-container" border="0" cellspacing="0" cellpadding="0"><tr class="edit-form-tr">
					<td align="center">选择的记录将被驳回处理？</td>
				</tr></table>
			</div>
			<div class="formBar">
				<ul>
					<li><div class="button"><div class="buttonContent"><button type="submit" onclick="jQuery.pdialog.closeCurrent();jQuery(\'[id=progressBar]\').removeClass(\'hidden\');">确认驳回</button></div></div></li>
					<li><div class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
				</ul>
			</div>
		</form>
		';
		die();
	}
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "reject"){
		foreach($list_result as $info){
			if($info->my->takecashsstatus != "驳回申请"){
				$amount = preg_replace("/[^0-9\.]/i", "", $info->my->amount);
				$profileid = $info->my->profileid;
				$info->my->takecashsstatus = "驳回申请";
				$info->my->rejectdate = date('Y-m-d H:i');
				$info->my->execute = XN_Profile::$VIEWER;
				$info->save(strtolower($currentModule));
				
				$profile = XN_Profile::load($profileid,"id","profile_".$profile->screenName);
				$money = preg_replace("/[^0-9\.]/i", "", $profile->money);
				$newmoney = floatval($money)+floatval($amount);
				
				$profile->money = $newmoney; 
			    $profile->save("profile,profile_".$profile->screenName.",profile_".$profile->wxopenid);

                $newcontent = XN_Content::create('rejectlog','',false);
                $newcontent->my->deleted = '0';
                $newcontent->my->source_id=$info->id;
                $newcontent->my->profileid = $info->my->profileid;
                $newcontent->my->execute=XN_Profile::$VIEWER;
                $newcontent->my->opertype="驳回提现申请";
                $newcontent->my->source = '提现';
                $newcontent->my->money = $newmoney;
                $newcontent->my->amount = $amount;
                $newcontent->my->oldmoney = $money;
                $newcontent->save('rejectlog');

                $wxmsg = "您的提现申请已经驳回，具体情况请联系客服！";
				require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
				XN_WX::sendmessage($profileid,$wxmsg);
			}
		}
        $alipays=XN_Query::create("Content")
            ->tag("alipays")
            ->filter("type","eic","alipays")
            ->filter("my.alipays_from_id","in",$ids)
            ->filter("my.alipays_from_type","=","takecashs")
            ->filter("my.deleted","=","0")
            ->end(-1)
            ->execute();
        if(count($alipays)){
            foreach($alipays as $info){
                $info->my->status="驳回申请";
                $info->my->handledate=date("Y-m-d H:i");
                $info->my->handlereason="提现驳回申请";
                $alipay_info->my->execute=XN_profile::$VIEWER;
                $info->save("alipays");
            }
        }
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","closeCurrent":true,"forward":null}';
		die();
	}
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "rejectcheck" && isset($_REQUEST['rejecttoken']) && $_REQUEST['rejecttoken'] !=''){
        $rejecttoken = $_REQUEST['rejecttoken'];
        $guid = $_SESSION['rejecttoken'];
        if ($guid == $rejecttoken)
        {
            $_SESSION['rejecttoken']="";
            $check = true;
            foreach($list_result as $info){
                if($info->my->takecashsstatus != "" && $info->my->takecashsstatus != "待处理" && $info->my->takecashsstatus != "待审核" && $info->my->takecashsstatus != "处理中" && $info->my->takecashsstatus != "转账失败"){
                    $check = false;
                    break;
                }
            }
            if(!$check){
                echo '{"status":300,"statusCode":300,"message":"所选择的数据不符要求，只能选择【待处理】【处理中】【转账失败】状态的数据！请重新选择","tabid":"","callbackType":"","forward":null}';
                die();
            }else{
                $params=array('ids'=>$_REQUEST['ids']);
                echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":"applyReject","params":'.json_encode($params).',"forward":null}';
                die();
            }
        }
	}
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "cancelscrapped"){
		$check = true;
		$msg = "";
		foreach($list_result as $info){
			if($info->my->takecashsstatus != "驳回申请"){
				$check = false;
				$msg = "所选择的数据不符要求，只能选择【驳回申请】状态的数据！请重新选择";
				break;
			}else{
				$amount = preg_replace("/[^0-9\.]/i", "", $info->my->amount);
				$profileid = $info->my->profileid;
				$rejectdate = $info->my->rejectdate;
				if(strtotime(date('Y-m-d H:i')) - strtotime($rejectdate) > 3600){
					$check = false;
					$msg = "所选择的数据不符要求，只能选择【驳回申请】不超过1小时的数据！请重新选择";
					break;
				}
				$profile = XN_Profile::load($profileid,"id","profile");
				$money = preg_replace("/[^0-9\.]/i", "", $profile->money);
				$newmoney = floatval($money)-floatval($amount);
				if($newmoney < 0){
					$check = false;
					$msg = "所选择的数据不符要求，帐户余额不足！请重新选择";
					break;
				}
			}
		}
		if(!$check){
			echo '{"status":300,"statusCode":300,"message":"'.$msg.'","tabid":"","callbackType":"","forward":null}';
			die();
		}else{
			foreach($list_result as $info){
				if($info->my->takecashsstatus == "驳回申请"){
					$amount = preg_replace("/[^0-9\.]/i", "", $info->my->amount);
					$profileid = $info->my->profileid;
					$info->my->takecashsstatus = "处理中";
					$info->my->rejectdate = date('Y-m-d H:i');
					$info->my->execute = XN_Profile::$VIEWER;
					$info->save(strtolower($currentModule));
					
					$profile = XN_Profile::load($profileid,"id","profile");
					$money = preg_replace("/[^0-9\.]/i", "", $profile->money);
					$newmoney = floatval($money)-floatval($amount);
					$profile->money = $newmoney;
					
					$profile->save("profile,profile_".$profile->screenName.",profile_".$profile->wxopenid); 
				}
			}
            $alipays=XN_Query::create("Content")
                ->tag("alipays")
                ->filter("type","eic","alipays")
                ->filter("my.alipays_from_id","in",$ids)
                ->filter("my.alipays_from_type","=","takecashs")
                ->filter("my.deleted","=","0")
                ->end(-1)
                ->execute();
            if(count($alipays)){
                foreach($alipays as $info){
                    $info->my->status="待处理";
                    $info->my->handledate="";
                    $info->my->handlereason="";
                    $info->save("alipays");
                }
            }

			echo '{"statusCode":"200","message":"驳回已撤消，状态为【处理中】！","tabid":"","callbackType":"","forward":null}';
			die();
		}
	}

	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "checkstutas"){
		$check = true;
		foreach($list_result as $info){
			if($info->my->takecashsstatus != "" && $info->my->takecashsstatus != "待处理" && $info->my->takecashsstatus != "待审核" && $info->my->takecashsstatus != "处理中"){
				$check = false;
				break;
			}
		}
		if(!$check){
			echo '{"status":300,"statusCode":300,"message":"所选择的数据不符要求，只能选择【待处理】【处理中】状态的数据！请重新选择","tabid":"","callbackType":"","forward":null}';
			die();
		}else{
			foreach($list_result as $info){
				$info->my->takecashsstatus = '处理中';
			}
			foreach ( array_chunk($list_result,50,true) as $chunk_query){
				XN_Content::batchsave($chunk_query,strtolower($currentModule));
			}
			$params=array('ids'=>$_REQUEST['ids']);
			echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":"SheetExportExcel","params":'.json_encode($params).',"forward":null}';
			die();
		}
	}
    if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "changestutas"){
 		$check = true;
		foreach($list_result as $info){
			if($info->my->takecashsstatus != "处理中"){
				$check = false;
				break;
			}
		}
		if(!$check){
			echo '{"statusCode":"300","message":"所选择的数据不符要求，只能选择【处理中】状态的数据！请重新选择"}';
			die();
		}
        $alipays=XN_Query::create("Content")
            ->tag("alipays")
            ->filter("type","eic","alipays")
            ->filter("my.alipays_from_id","in",$ids)
            ->filter("my.alipays_from_type","=","takecashs")
            ->filter("my.deleted","=","0")
            ->end(-1)
            ->execute();
        $alipay_err='';
        $err_profile_ids=array();
        if(count($alipays)){
            foreach($alipays as $alipay_info){
                if($alipay_info->my->status!='待处理'){
                    $err_profile_ids[]=$alipay_info->my->profileid;
                }
            }
            if(count($err_profile_ids)){
                $alipay_err.=getGivenNamesByids($err_profile_ids);
                echo '{"statusCode":"300","message":"由于服务器宕机，支付宝转账的对应记录（'.$alipay_err.'）状态不统一，请认真审核后再操作！"}';
                die();
            }
        }
        foreach($list_result as $info){
        	if ($info->my->takecashsstatus == '处理中')
        	{
                $info->my->takecashsstatus = '处理完成';
	            $info->my->executedatetime = date("Y-m-d H:i"); 
	            $info->my->execute = XN_Profile::$VIEWER;
	            $amount = $info->my->amount;
	            $money = $info->my->newmoney;
	            $profileid= $info->my->profileid;

				$newcontent = XN_Content::create('billwaters','',false);					  
				$newcontent->my->deleted = '0';
				$newcontent->my->profileid = $profileid; 
				$newcontent->my->billwatertype = 'cash';
				$newcontent->my->sharedate = '-'; 
				$newcontent->my->submitdatetime = date("Y-m-d H:i"); 
				$newcontent->my->orderid = '';
				$newcontent->my->productid = '';
				$newcontent->my->takecashid = $info->id;
				$newcontent->my->royaltyrate = '';
				$newcontent->my->commissiontype = '';
				$newcontent->my->amount = $amount; 
				$newcontent->my->money = $money; 
				$newcontent->save('billwaters,billwaters_'.$profileid);
				/*$wxmsg = "您的提现申请，小赚已经处理完成，请注意查收！";
				require_once (XN_INCLUDE_PREFIX."/XN/Wx.php");
				XN_WX::sendmessage($profileid,$wxmsg);
				*/
			}
        }

        if(count($alipays)){
            foreach($alipays as $info){
                $info->my->status="已转账";
                $info->my->handledate=date("Y-m-d H:i");
                $info->my->handlereason="支付宝转账-提现完成";
                $info->save("alipays");
            }
        }

        foreach ( array_chunk($list_result,50,true) as $chunk_query){
            XN_Content::batchsave($chunk_query,strtolower($currentModule));
        }
        echo '{"statusCode":"200","message":null,"tabid":"","callbackType":"","forward":null}';
		die();
	}
    if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "canceltake"){
 		$check = true;
		foreach($list_result as $info){
			if($info->my->takecashsstatus != "处理完成" || (strtotime(now) - strtotime($info->my->executedatetime)) > 2 * 60 * 60){
				$check = false;
				break;
			}
		}
		if(!$check){
			echo '{"statusCode":"300","message":"所选择的数据不符要求，只能选择【处理完成】并且不超过2小时的数据！请重新选择"}';
			die();
		}

        foreach($list_result as $info){
        	if ($info->my->takecashsstatus == '处理完成')
        	{
	            $info->my->takecashsstatus = '处理中';
	            $info->my->executedatetime = ''; 
	            $info->my->execute = '';
				$newcontent = XN_Query::create('Content')->tag('billwaters')
					->filter ( 'type', 'eic', 'billwaters' )
					->filter ( 'my.deleted','=','0')
					->filter ( 'my.takecashid','=',$info->id)
					->execute();
				foreach($newcontent as $newinfo){
					$newinfo->my->deleted = '1';
					$infoprofileid = $newinfo->my->profileid;
					$newinfo->save('billwaters,billwaters_'.$infoprofileid);
				}
			}
        }
        $alipays=XN_Query::create("Content")
            ->tag("alipays")
            ->filter("type","eic","alipays")
            ->filter("my.alipays_from_id","in",$ids)
            ->filter("my.alipays_from_type","=","takecashs")
            ->filter("my.deleted","=","0")
            ->end(-1)
            ->execute();
        if(count($alipays)){
            foreach($alipays as $info){
                $info->my->status="待处理";
                $info->my->handledate="";
                $info->my->handlereason="";
                $info->save("alipays");
            }
        }
        foreach ( array_chunk($list_result,50,true) as $chunk_query){
            XN_Content::batchsave($chunk_query,strtolower($currentModule));
        }

        echo '{"statusCode":"200","message":null,"tabid":"","callbackType":"","forward":null}';
		die();
	}
	if(isset($_REQUEST['opr']) && $_REQUEST['opr'] == "all"){
		$params=array('ids'=>$_REQUEST['ids']);
		echo '{"statusCode":"200","message":null,"tabid":"'.$currentModule.'","callbackType":"SheetExportExcel","params":'.json_encode($params).',"forward":null}';
		die();
	}
	
	$focus = CRMEntity::getInstance($currentModule);
	
	$focus->initSortbyField($currentModule);
	//<<<<cutomview>>>>>>>
	$oCustomView = new CustomView($currentModule);
	$viewid = $oCustomView->getViewId($currentModule);
	
	//<<<<<customview>>>>>
	
	//Retreive the list from Database
	//<<<<<<<<<customview>>>>>>>>>
	global $current_user;
	$queryGenerator = new QueryGenerator($currentModule, $current_user);
	if ($viewid != "0") {
		$queryGenerator->initForCustomViewById($viewid);
	} else {
		$queryGenerator->initForDefaultCustomView();
	}
	//<<<<<<<<customview>>>>>>>>>
	$controller = new ListViewController("", $current_user, $queryGenerator);
	$listview_header = $controller->getListViewHeader($focus,$currentModule,"",$sorder,$order_by);
	$listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array);
	
	ob_clean();
	require_once ('include/PHPExcel/PHPExcel.php');
	require_once ('include/PHPExcel/PHPExcel/IOFactory.php');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle(getTranslatedString($currentModule,$currentModule));
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getCell('A1')->setValue(getTranslatedString($currentModule,$currentModule));
	
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);		// 加粗
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);			// 字体大小
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,1,count($listview_header)-1,1);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($listview_header)-1,1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,1,count($listview_header)-1,1)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
	$objPHPExcel->getActiveSheet()->getCell('A2')->setValue("导出时间:".date("Y-m-d H:i")."        导出人:".getUserName($current_user->id));
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0,2,count($listview_header)-1,2);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($listview_header)-1,2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0,2,count($listview_header)-1,2)->getFill()->getStartColor()->setARGB('00F2F2F2');			// 底纹
	$i=0;
	foreach ($listview_header as $listview_header_info){
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setWidth(20);
		$label = $listview_header_info['label'];
		$label = str_replace("&nbsp;", "", $label);
		preg_match('/>([^<]+)</U',$label,$tmp);
		if(isset($tmp[1]))
			$label = $tmp[1];
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getFill()->getStartColor()->setARGB('00F2F2F2');
		$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,3)->setValue(getTranslatedString($label));
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$i++;
	}
	$j=4;
	foreach($listview_entries as $key=>$row){
		//for($i=0;$i<count($listview_header);$i++){
        $i=0;
        foreach($listview_header as $fieldname=>$fieldlabel){
			$label = $row[$fieldname];
			if(strpos($label, "<br>")){
				$tmp = explode('<br>', $label);
				$label = "";
				foreach ($tmp as $tv){
					if($label == "")
						$label .= getTranslatedString($tv,$currentModule);
					else
						$label .= "\r\n".getTranslatedString($tv,$currentModule);
				}
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setWrapText(true);
			}else{
				preg_match('/>([^<]+)</U',$label,$tmp);
				if(count($tmp)==0 && strpos($label, "</")){
					$label = "";
				}elseif(isset($tmp[1]))
					$label = $tmp[1];
			}
			$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i,$j)->setValueExplicit(getTranslatedString($label,$currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $i++;
        }
		$j++;
	}

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
	header("Expires: 0");   
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header('Content-Disposition:inline;filename="'.$currentModule.'.xlsx"');//getTranslatedString($currentModule,$currentModule)
	header("Content-Transfer-Encoding: binary");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header("Pragma: no-cache");
	$objWriter->save('php://output');
}
//	echo '{"statusCode":"200","message":null,"tabid":"","callbackType":"","forward":null}';
?>