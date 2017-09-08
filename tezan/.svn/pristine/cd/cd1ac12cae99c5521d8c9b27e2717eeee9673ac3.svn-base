<?php
    global $currentModule;
    require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
    require_once('Smarty_setup.php');
    require_once('include/utils/DataSearch.php');
    require_once('modules/CustomView/CustomView.php');
    global $app_strings, $mod_strings, $current_language;
    $current_module_strings = return_module_language($current_language, $currentModule);
    $focus = CRMEntity::getInstance($currentModule);
    $focus->initSortbyField($currentModule);
    $upperModule = strtoupper($currentModule);
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
    if (isset($_SESSION[$upperModule.'_ORDER_BY']) && $_SESSION[$upperModule.'_ORDER_BY'] != "")
    {
        $order_by = $_SESSION[$upperModule.'_ORDER_BY'];
    }
    else
    {
        $order_by = $focus->getOrderBy();
    }
////////////////////////////////
    if (isset($_SESSION[$upperModule.'_SORT_ORDER']) && $_SESSION[$upperModule.'_SORT_ORDER'] != "")
    {
        $sorder = $_SESSION[$upperModule.'_SORT_ORDER'];
    }
    else
    {
        $sorder = $focus->getOrderBy();
    }
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
//<<<<cutomview>>>>>>>
    $oCustomView = new CustomView($currentModule);
    $viewid      = $oCustomView->getViewId($currentModule);
//<<<<<customview>>>>>
//Retreive the list from Database
//<<<<<<<<<customview>>>>>>>>>
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
//<<<<<<<<customview>>>>>>>>>
    $search = new DataSearch($currentModule, $queryGenerator, $focus->special_search_fields);
    $query = XN_Query::create('Content')->tag($focus->table_name)
        ->filter('type', 'eic', $focus->table_name)
        ->filter('my.deleted', '=', '0');
    foreach ($search->searchfields as $searchfield)
    {
        if ($searchfield == "published")
        {
            if (isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
            {
                $query->filter('published', '>=', $_REQUEST['published_startdate'].' 00:00:00')
                    ->filter('published', '<=', $_REQUEST['published_enddate'].' 23:59:59');
            }
        }
        elseif ($searchfield == "author")
        {
            if (isset($_REQUEST['author']) && $_REQUEST['author'] != '')
            {
                $author = $_REQUEST['author'];
                $query->filter('author', 'in', explode(';', $author));
            }
        }
        elseif ($searchfield == "user_role")
        {
            if (isset($_REQUEST['user_role']) && $_REQUEST['user_role'] != '')
            {
                $user_role = $_REQUEST['user_role'];
                $query->filter('my.user_role', 'in', explode(';', $user_role));
            }
        }
        elseif (is_array($searchfield))
        {
            if ($searchfield[0] == "input")
            {
                $input = $_REQUEST['search_input'];
                if (isset($input) && $input != "")
                {
                    $fields    = $searchfield[1];
                    $fieldlist = explode(",", $fields);
                    $fieldlist = array_unique($fieldlist);
                    if (count($fieldlist) == 1)
                    {
                        if ($fieldlist[0] == "title")
                        {
                            $query->filter('title', 'like', $input);
                        }
                        else
                        {
                            $query->filter('my.'.$fieldlist[0], 'like', $input);
                        }
                    }
                    elseif (count($fieldlist) == 2)
                    {
                        if ($fieldlist[0] == "title")
                        {
                            $fieldlist1 = "title";
                        }
                        else
                        {
                            $fieldlist1 = "my.".$fieldlist[0];
                        }
                        if ($fieldlist[1] == "title")
                        {
                            $fieldlist2 = "title";
                        }
                        else
                        {
                            $fieldlist2 = "my.".$fieldlist[1];
                        }
                        $query1 = XN_Filter($fieldlist1, 'like', $input);
                        $query2 = XN_Filter($fieldlist2, 'like', $input);
                        $query->filter(XN_Filter::any($query1, $query2));
                    }
                }
            }
            elseif ($searchfield[0] == "calendar")
            {
                if ($searchfield[1] == "published")
                {
                    if (isset($_REQUEST['published_startdate']) && $_REQUEST['published_startdate'] != '' && isset($_REQUEST['published_enddate']) && $_REQUEST['published_enddate'] != '')
                    {
                        $query->filter('published', '>=', $_REQUEST['published_startdate'].' 00:00:00')
                            ->filter('published', '<=', $_REQUEST['published_enddate'].' 23:59:59');
                    }
                }
                else
                {
                    if (isset($_REQUEST[$searchfield[1].'_startdate']) && $_REQUEST[$searchfield[1].'_startdate'] != '' && isset($_REQUEST[$searchfield[1].'_enddate']) && $_REQUEST[$searchfield[1].'_enddate'] != '')
                    {
                        $query->filter('my.'.$searchfield[1], '>=', $_REQUEST[$searchfield[1].'_startdate'].' 00:00:00')
                            ->filter('my.'.$searchfield[1], '<=', $_REQUEST[$searchfield[1].'_enddate'].' 23:59:59');
                    }
                }
            }
        }
        else
        {
            if (isset($_REQUEST[$searchfield]) && $_REQUEST[$searchfield] != '')
            {
                $query->filter('my.'.$searchfield, '=', $_REQUEST[$searchfield]);
            }
            elseif (isset($_REQUEST['search_'.$searchfield]) && $_REQUEST['search_'.$searchfield] != '')
            {
                $query->filter('my.'.$searchfield, '=', $_REQUEST['search_'.$searchfield]);
            }
        }
    }
    if (in_array($currentModule, array ("TakeCashs")))
    {
        if (!check_authorize('tezanadmin') && !is_admin($current_user))
        {
            $permission = listviewpermission($currentModule, $search);
            if (isset($permission))
            {
                $query->filter($permission);
            }
        }
    }
    else
    {
        $permission = listviewpermission($currentModule, $search);
        if (isset($permission))
            $query->filter($permission);
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
    $list_result = $query->execute();
    $noofrows = $query->getTotalCount();
    $controller       = new ListViewController($current_user, $queryGenerator);
    $listview_header  = $controller->getListViewHeader($focus, $currentModule, "", $sorder, $order_by);
    $listview_entries = $controller->getListViewEntries($focus, $currentModule, $list_result, $navigation_array);
    ob_clean();
    if (count($listview_entries) < 100)
    {
        require_once('include/PHPExcel/PHPExcel.php');
        require_once('include/PHPExcel/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle(getTranslatedString($currentModule, $currentModule));
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getCell('A1')->setValue(getTranslatedString($currentModule, $currentModule));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);        // 加粗
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);            // 字体大小
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('SIMSUN');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, count($listview_header) - 1, 1);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 1, 1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1, count($listview_header) - 1, 1)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
        $objPHPExcel->getActiveSheet()->getCell('A2')->setValue("导出时间:".date("Y-m-d H:i")."        导出人:".getUserName($current_user->id));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->mergeCellsByColumnAndRow(0, 2, count($listview_header) - 1, 2);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 1, 2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 2, count($listview_header) - 1, 2)->getFill()->getStartColor()->setARGB('00F2F2F2');            // 底纹
        //for($i=0;$i<count($listview_header);$i++){
        $i = 0;
        foreach ($listview_header as $listview_header_info)
        {
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
        foreach ($listview_entries as $key => $row)
        {
            $i = 0;
            foreach ($listview_header as $fieldname => $fieldlabel)
            {
                $label = $row[$fieldname];
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
                $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($i, $j)->setValue(getTranslatedString($label, $currentModule));
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Pragma: no-cache");
        $objWriter->save('php://output');
    }
    else
    {
        $html = '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:"Microsoft Yahei",Tahoma,"Simsun";color:#0D0D0D;}</style><table width="100%" cellspacing="0" border="0" align="center" style="font-family: Arial; font-size: 10pt">
	    <tbody>
	        <tr>
	            <td valign="top" align="center" colspan="4" rowspan="1">
	                <strong><span style="font-family: 黑体;font-size: 20px;">'.getTranslatedString($currentModule, $currentModule).'</span></strong>
	            </td>
	        </tr>		
	        <tr>          
		    <td width="30%" valign="top" align="left" colspan="1" rowspan="1" style="word-break: break-all;">               
	            </td>
	            <td width="39%" valign="top" align="center" colspan="2" rowspan="1">导出时间:'.date("Y-m-d H:i").'        导出人:'.getUserName($current_user->id).'</td>
	            <td width="30%" valign="top" align="right" colspan="1" rowspan="1" style="word-break: break-all;"></td>
	        </tr>
	        <tr>
	            <td width="99%" valign="top" align="center" colspan="4">
	                <table width="100%" cellspacing="0" cellpadding="0" border="1" style="font-family: Arial; font-size: 10pt;" bordercolorlight="#b0b0b0" bordercolordark="#ffffff">
	                    <tbody>
	                        <tr>';
        $i    = 0;
        foreach ($listview_header as $listview_header_info)
        {
            $label = $listview_header_info['label'];
            $label = str_replace("&nbsp;", "", $label);
            preg_match('/>([^<]+)</U', $label, $tmp);
            if (isset($tmp[1]))
                $label = $tmp[1];
            $html .= '<td valign="middle" height="25" align="center" style="word-break: break-all;">'.getTranslatedString($label).'</td>'."\r\n";
            $i++;
        }
        $html .= ' </tr>';
        $j = 4;
        foreach ($listview_entries as $key => $row)
        {
            $html .= ' </tr>';
            $i = 0;
            foreach ($listview_header as $fieldname => $fieldlabel)
            {
                $label = $row[$fieldname];
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
                    //$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$j)->getAlignment()->setWrapText(true);
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
                if ($label == "")
                    $label = "&nbsp;";
                if (is_numeric($label))
                    $label = "&nbsp;".$label;
                $html .= '<td valign="middle" height="25" align="center" style="word-break: break-all;">'.getTranslatedString($label, $currentModule).'</td>'."\r\n";
                $i++;
            }
            $j++;
            $html .= ' </tr>';
        }
        $html .= '</tbody>
	                </table>
	            </td>			 
	        </tr>
	    </tbody>
	</table> 
	</div></body></html>';
        /*header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Expires: 0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$currentModule.'.xlsx"');//getTranslatedString($currentModule,$currentModule)
        header("Content-Transfer-Encoding: binary");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Pragma: no-cache");*/
        header("Content-Type:   application/vns.ms-excel");
        header("Content-Disposition:   attachment;   filename=".$currentModule.".xls");
        header("Pragma:   no-cache");
        header("Expires:   0");
        echo $html;
    }
?>