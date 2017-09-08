<?php
    global $mod_strings, $app_strings, $theme, $currentModule, $current_user, $supplierid;
    require_once('include/utils/utils.php');
    require_once('include/utils/CommonUtils.php');
    require_once('include/utils/UserInfoUtil.php');

    if (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'view')
    {
        try
        {
            $print_template = getPrintData($record, $supplierid);
            require_once('Smarty_setup.php');
            $smarty = new vtigerCRM_Smarty;
            $smarty->assign("MODULE", $currentModule);
            $smarty->assign("APP", $app_strings);
            $smarty->assign("MOD", $mod_strings);
            $smarty->assign("INVOICEPRINTTEMPLATE", $invoiceprinttemplate);
            $smarty->assign("RECORD", $record);
            $smarty->assign("PRINTDATA", $print_template);
            $smarty->display('Ma_InvoicePrint/TemplatePrint.tpl');
        }
        catch (XN_Exception $e)
        {
            echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
            die();
        }
    }
    elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'word')
    {
        try
        {
            header("Content-Type:   application/msword");
            header("Content-Disposition:   attachment;   filename=".nl2br(decode_html(购货者档案)).".doc");
            header("Pragma:   no-cache");
            header("Expires:   0");
            echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:["Microsoft Yahei","Tahoma","Simsun"];color:#0D0D0D;}</style>';
            echo getPrintData($record, $supplierid);
            echo '</div></body></html>';
        }
        catch (XN_Exception $e)
        {
            echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
            die();
        }
    }
    elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'excel')
    {
        try
        {
            header("Content-Type:   application/vns.ms-excel");
            header("Content-Disposition:   attachment;   filename=".nl2br(decode_html(购货者档案)).".xls");
            header("Pragma:   no-cache");
            header("Expires:   0");
            echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:["Microsoft Yahei","Tahoma","Simsun"];color:#0D0D0D;}</style>';
            echo getPrintData($record, $supplierid);
            echo '</div></body></html>';
        }
        catch (XN_Exception $e)
        {
            echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
            die();
        }
    }
    elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'pdf')
    {
        try
        {
            header("Content-Type:   application/Octet-stream;");
            header("Content-Disposition:   attachment;   filename=".nl2br(decode_html(购货者档案)).".pdf");
            header("Pragma:   no-cache");
            header("Expires:   0");
            echo '<html><body><style>body,td,select,input{font-size:12px;font-family: Arial, Helvetica, sans-serif;}</style><div id="Div_View"><style type="text/css">body,tr,td{font:["Microsoft Yahei","Tahoma","Simsun"];color:#0D0D0D;}</style>';
            echo getPrintData($record, $supplierid);
            echo '</div></body></html>';
        }
        catch (XN_Exception $e)
        {
            echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
            die();
        }
    }
    elseif (isset($_REQUEST['oper']) && $_REQUEST['oper'] == 'print')
    {
    }
    function getPrintData($record, $supplierid)
    {
        global $current_user, $tablebody;
        try
        {
            $query = XN_Query::create ( 'Content' ) ->tag("ma_saleorders")
                ->filter ( 'type', 'eic', 'ma_saleorders')
                ->filter ( 'my.deleted', '=', '0' )
                ->filter ( 'my.sale_id', '=', $supplierid)
                ->order('published',XN_Order::DESC_NUMBER)
                ->end(-1)->execute();
            $receipt_ids = array();
            foreach($query as $info)
            {
                $receipt_ids[] = $info->my->purchase_id;
            }

            $contents = XN_Content::loadMany(array_unique($receipt_ids),"ma_suppliers");

            foreach($contents as $info)
            {
                $relationcontents = XN_Content::load($info->my->relation_id,$info->my->suppliertype);
                $tablebody=$tablebody.'<tr>
                        <td width="20%" align="center" class="single-row">'.$relationcontents->my->nickname.'</td>
                        <td width="15%" align="center" class="single-row">'.$relationcontents->my->ceo.'</td>
                        <td width="15%" align="center" class="single-row">'.$relationcontents->my->contact.'</td>
                        <td width="20%" align="center" class="single-row">'.$relationcontents->my->mobile.'</td>
                        <td width="15%" align="center" class="single-row">'.$relationcontents->my->registeraddress.'</td>
                        <td width="15%" align="center" class="single-row">'.$relationcontents->my->storageaddress.'</td>
                        </tr>';
            }
            $print_template = '<table align="center" border="0" cellspacing="0" height="50" style="font-family: Arial; font-size: 10pt" width="90%">
    <tbody>
        <tr class="firstRow">
            <td colspan="2" height="50" style="font-family: 黑体; font-size: 18pt">
                <p style="text-align:center;">
                    <span style="font-size: 24px; font-family: 微软雅黑">购货者档案</span>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 <style>
        .small-width{width:100%;}
        .middle-width{width:100%;}
        .big-width{width:100%;}
         table>tr>th{font-size:12px;padding:0px;text-align:center;}
        table>tr>td{font-size:8px;padding:0px;text-align:center;}
        .select_row{position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);}
    </style>
    <table data-width="100%" data-height="500" class="table table-bordered" style="width: 100%;">
    <tr tr-index="0" style="height:25px;">
        <th width="20%" align="center" class="single-row">购货者名称</th>
        <th width="15%" align="center" class="single-row">法人代表</th>
        <th width="15%" align="center" class="single-row">联系人</th>
        <th width="20%" align="center" class="single-row">联系人手机</th>
        <th width="15%" align="center" class="single-row">注册地址</th>
        <th width="15%" align="center" class="single-row">库房地址</th>
    </tr>
    '.$tablebody.'
</table>                    ';
        }
        catch (XN_Exception $e)
        {
            return "";
        }

        return $print_template;
    }

    function getFieldTypeByUitype($uitype)
    {
        if (empty($uitype) || $uitype == "")
        {
            return array ();
        }
        if (is_string($uitype))
        {
            $uitype = array ($uitype);
        }
        $tabsquery = XN_Query::create('Content')->tag('ws_fieldtypes')->end(-1)
            ->filter('type', 'eic', 'ws_fieldtypes')
            ->filter("my.uitype", 'in', $uitype)
            ->execute();
        $fieldtype = array ();
        foreach ($tabsquery as $item)
        {
            $fieldtype[$item->my->uitype] = $item->my->fieldtype;
        }

        return $fieldtype;
    }