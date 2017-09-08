<?php
	if(isset($_REQUEST["ids"]) && $_REQUEST["ids"] != ""){
		$reids = $_REQUEST["ids"];
		if(is_string($reids) && (!(strpos($reids, ',') === false) || !(strpos($reids, ';') === false))){
			if (!(strpos($reids, ',') === false))
				$reids = explode(',', $reids);
			elseif (!(strpos($reids, ';') === false))
				$reids = explode(';', $reids);
		}
		if (isset($reids) && !is_array($reids))
			$reids = array ($reids);
		if (isset($reids) && count($reids) > 0)
		{
			$currentModule = $_REQUEST["module"];
			require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
			require_once('modules/CustomView/CustomView.php');
			global $app_strings, $mod_strings, $current_language;
			$current_module_strings = return_module_language($current_language, $currentModule);
			$focus                  = CRMEntity::getInstance($currentModule);
			$focus->initSortbyField($currentModule);
			$upperModule = strtoupper($currentModule);
			if (isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
			{
				$order_by = $_SESSION[$upperModule.'_ORDER_BY'];
			}
			else
			{
				$order_by = $focus->getOrderBy();
			}
			if (isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
			{
				$sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
			}
			else
			{
				$sorder = $focus->getOrderBy();
			}
			$oCustomView = new CustomView($currentModule);
			$viewid      = $oCustomView->getViewId($currentModule);
			global $current_user;
			$queryGenerator = new QueryGenerator($currentModule, $current_user);
			if ($viewid != "0")
			{
				$queryGenerator->initForCustomViewById($viewid);
			}
			else
			{
				$queryGenerator->initForDefaultCustomView();
			}
			if (isset($focus->datatype) && $focus->datatype == "7")
			{
				$query  = XN_Query::create('YearContent')->tag($focus->table_name)
								  ->filter('type', 'eic', $focus->table_name)
								  ->filter('my.deleted', '=', '0')
								  ->filter('id', 'in', $reids);
			}
			else
			{	$query  = XN_Query::create('Content')->tag($focus->table_name)
							  ->filter('type', 'eic', $focus->table_name)
							  ->filter('my.deleted', '=', '0')
							  ->filter('id', 'in', $reids);
				
			}
			 

			$query_order_by = $order_by;
			if (isset($order_by) && $order_by != '' && strncmp($order_by, 'my.', 3) != 0 && $order_by != 'updateDate' && $order_by != 'createdDate' && $order_by != 'published' && $order_by != 'updated' && $order_by != 'author' && $order_by != 'title')
			{
				$query_order_by = "my.".$order_by;
			}
			if (strtolower($sorder) == 'desc')
			{
				if (isset($focus->sortby_number_fields) && in_array($order_by, $focus->sortby_number_fields))
				{
					$query->order($query_order_by, XN_Order::DESC_NUMBER);
				}
				else
				{
					$query->order($query_order_by, XN_Order::DESC);
				}
			}
			else
			{
				if (isset($focus->sortby_number_fields) && in_array($order_by, $focus->sortby_number_fields))
				{
					$query->order($query_order_by, XN_Order::ASC_NUMBER);
				}
				else
				{
					$query->order($query_order_by, XN_Order::ASC);
				}
			}
			$query->begin(0);
			$query->end(-1);
			$list_result      = $query->execute();
			$controller       = new ListViewController($current_user, $queryGenerator);

			$changeArray['hideFields']=array("ma_deliveryorders","ma_returnordersout","ma_inventoryreturnout");
			if (isset($changeArray) && is_array($changeArray))
			{
				$listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by, $changeArray);
			}
			else
			{
				$listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by);
			}
			$listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array);
			foreach($listview_entries as $index=>$entry_info){
				if($entry_info['ma_deliveryorders']!="--"){
					$listview_entries[$index]['ma_purchaseorders']=$entry_info['ma_deliveryorders'];
				}
				if($entry_info['ma_returnordersout']!="--"){
					$listview_entries[$index]['ma_purchaseorders']=$entry_info['ma_returnordersout'];
				}
				if($entry_info['ma_inventoryreturnout']!="--"){
					$listview_entries[$index]['ma_inventoryputin']=$entry_info['ma_inventoryreturnout'];
				}
				unset($listview_entries[$index]["ma_deliveryorders"]);
				unset($listview_entries[$index]["ma_returnordersout"]);
				unset($listview_entries[$index]["ma_inventoryreturnin"]);
			}


			require_once('include/PHPExcel/PHPExcel.php');
			require_once('include/PHPExcel/PHPExcel/IOFactory.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setTitle(getTranslatedString($currentModule, $currentModule));
			$objPHPExcel->getActiveSheet()->getProtection()->setPassword('tezan');
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setAutoFilter(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setDeleteColumns(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setDeleteRows(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setFormatColumns(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setFormatRows(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setInsertColumns(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setInsertHyperlinks(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setObjects(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setPivotTables(true);
			$objPHPExcel->getActiveSheet()->getProtection()->setScenarios(true);
			$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
			$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
			$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(30);
			$objPHPExcel->getActiveSheet()->getCell('A1')->setValue(getTranslatedString($currentModule, $currentModule));
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);        // 加粗
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);            // 字体大小
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, count($listview_header) - 2, 1);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 2, 1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 2, 1)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
			$objPHPExcel->getActiveSheet()->getCell('A2')->setValue("导出时间:".date("Y-m-d H:i")."        导出人:".getUserName($current_user->id));
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 2, count($listview_header) - 2, 2);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 2, 2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 2, 2)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
			$i = 0;
			foreach ($listview_header as $fieldname => $listview_header_info)
			{
				if($fieldname == 'oper') continue;
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setWidth(20);
				$label = $listview_header_info['label'];
				$label = str_replace("&nbsp;", "", $label);
				preg_match('/>([^<]+)</U', $label, $tmp);
				if (isset($tmp[1]))
					$label = $tmp[1];
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getFill()->getStartColor()->setARGB('00F2F2F2');
				$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, 3)->setValue(getTranslatedString($label));
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 2)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, 3)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$i++;
			}
			$j = 4;
			function removeEmoji($text) 
			{ 
			    $clean_text = ""; 
			    // Match Emoticons
			    $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
			    $clean_text = preg_replace($regexEmoticons, '', $text);

			    // Match Miscellaneous Symbols and Pictographs
			    $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
			    $clean_text = preg_replace($regexSymbols, '', $clean_text);

			    // Match Transport And Map Symbols
			    $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
			    $clean_text = preg_replace($regexTransport, '', $clean_text);

			    // Match Miscellaneous Symbols
			    $regexMisc = '/[\x{2600}-\x{26FF}]/u';
			    $clean_text = preg_replace($regexMisc, '', $clean_text);

			    // Match Dingbats
			    $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
			    $clean_text = preg_replace($regexDingbats, '', $clean_text);

			    return $clean_text;
			}
			foreach ($listview_entries as $key => $row)
			{
				$i = 0;
				foreach ($listview_header as $fieldname => $fieldlabel)
				{
					if($fieldname == 'oper') continue;
					$label = $row[$fieldname];
					if(!isset($label)) $label = "";
					if (strpos($label, "<br>"))
					{
						$tmp   = explode('<br>', $label);
						$label = "";
						foreach ($tmp as $tv)
						{
							if ($label == "")
								$label .= getTranslatedString($tv, $currentModule);
							else
								$label .= "\r\n".getTranslatedString($tv, $currentModule);
						}
						$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setWrapText(true);
					}
					else
					{
						preg_match('/>([^<]+)</U', $label, $tmp);
						if (count($tmp) == 0 && strpos($label, "</"))
						{
							$label = "";
						}
						elseif (isset($tmp[1]))
							$label = $tmp[1];
					}  
					$label = removeEmoji($label); 
					
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->setValueExplicit(getTranslatedString($label, $currentModule),PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$i++;
				}
				$objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(30);
				$j++;
			}
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			ob_clean();
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition:inline;filename="'.nl2br(decode_html(getTranslatedString($currentModule, $currentModule))).'.xls"');
			header("Content-Transfer-Encoding: binary");
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Pragma: no-cache");
			$objWriter->save('php://output');
		}
	}