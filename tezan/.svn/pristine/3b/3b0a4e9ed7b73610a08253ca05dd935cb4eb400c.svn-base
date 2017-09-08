<?php
    /*********************************************************************************
     * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
     * ("License"); You may not use this file except in compliance with the
     * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
     * Software distributed under the License is distributed on an  "AS IS"  basis,
     * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
     * the specific language governing rights and limitations under the License.
     * The Original Code is:  SugarCRM Open Source
     * The Initial Developer of the Original Code is SugarCRM, Inc.
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
     * All Rights Reserved.
     * Contributor(s): ______________________________________.
     ********************************************************************************/
    /*********************************************************************************
     * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Users/Save.php,v 1.14 2005/03/17 06:37:39 rank Exp $
     * Description:  TODO: To be written.
     * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
     * All Rights Reserved.
     * Contributor(s): ______________________________________..
     ********************************************************************************/
    ini_set('memory_limit', '2048M');
    set_time_limit(0);
    session_start();
    $warn_date_configs = [];
    try
    {
        $warn_date_configs = XN_MemCache::get("warn_date_configs");
    }
    catch (XN_Exception $e)
    {
        $query = XN_Query::create("Content")
            ->tag("ma_settings")
            ->filter("type", "eic", "ma_settings")
            ->filter("my.deleted", "=", "0")
            ->end(1)
            ->execute();
        if (count($query))
        {
            foreach ($query as $info)
            {
                $warn_date_configs = [
                    "ma_factorys"     => $info->my->factoryaualificationwarningtime,
                    "ma_agencys"      => $info->my->agencyaualificationwarningtime,
                    "ma_hospitals"    => $info->my->hospitalaualificationwarningtime,
                    "ma_products"     => $info->my->productaualificationwarningtime,
                    "productvalidate" => $info->my->productvalidatewarningtime,
                ];
            }
        }
        else
        {
            $warn_date_configs = [
                "ma_factorys"     => 90,
                "ma_agencys"      => 90,
                "ma_hospitals"    => 90,
                "ma_products"     => 90,
                "productvalidate" => 180
            ];
        }
        XN_MemCache::put($warn_date_configs, "warn_date_configs");
    }
    $loopcallbacks = XN_Query::create('MainContent')
        ->tag('loopcallback')
        ->filter('type', 'eic', 'loopcallback')
        ->filter('my.deleted', '=', '0')
        ->filter('my.url', '=', '/plugins/task/checkwarn.php')
        ->execute();
    if (count($loopcallbacks) == 0)
    {
        if (strpos($_SERVER["SERVER_SOFTWARE"], "nginx") !== false)
        {
            $domain   = $_SERVER['HTTP_HOST'];
            $web_root = $domain;
        }
        else
        {
            $domain   = $_SERVER['SERVER_NAME'];
            $web_root = $domain.':'.$_SERVER['SERVER_PORT'];
        }
        $newcontent              = XN_Content::create('loopcallback', '', false, 4);
        $newcontent->my->deleted = 0;
        $newcontent->my->url     = '/plugins/task/checkwarn.php';
        $newcontent->my->sleep   = '86400';
        $newcontent->my->webroot = $web_root;
        $newcontent->my->status  = 'Active';
        $newcontent->save('loopcallback');
    }
    try
    {
        //警戒库存
        $clearquery = XN_Query::create("Content")
            ->tag("ma_checkinventorywarns")
            ->filter("type", "eic", "ma_checkinventorywarns")
            ->filter("my.deleted", "=", "0")
            ->end(-1)
            ->execute();
        if(count($clearquery)>0){
            XN_Content::delete($clearquery, "ma_checkinventorywarns");
        }
        $inventorywarn = XN_Query::create('Content')
            ->tag('ma_inventorywarn')
            ->filter('type', 'eic', 'ma_inventorywarn')
            ->filter('my.approvalstatus', '=', '2')
            ->filter('my.deleted', '=', '0')
            ->end(-1)
            ->execute();
        if (count($inventorywarn) > 0)
        {
            foreach ($inventorywarn as $inventorywarn_info)
            {
                $inventorywarnarr[] = $inventorywarn_info->id;
            }
            foreach (array_chunk($inventorywarnarr, 50) as $chunk)
            {
                $inventorywarndetails = XN_Query::create('Content')
                    ->tag('ma_inventorywarndetails')
                    ->filter('type', 'eic', 'ma_inventorywarndetails')
                    ->filter('my.record', 'in', $chunk)
                    ->filter('my.deleted', '=', '0')
                    ->end(-1)
                    ->execute();
                foreach ($inventorywarndetails as $inventorywarndetails_info)
                {
                    $inventorywarndetailsarr[$inventorywarndetails_info->my->supplierid][$inventorywarndetails_info->my->ma_products]  = $inventorywarndetails_info;
                    $productsarr[$inventorywarndetails_info->my->supplierid][] = $inventorywarndetails_info->my->ma_products;
                }
            }
            foreach ($productsarr as  $author_supplierid =>$products)
            {
                foreach (array_chunk($products, 50) as $chunk)
                {
                    $newquery = XN_Query::create("Content")
                        ->tag("ma_inventorycount")
                        ->filter("type", "eic", "ma_inventorycount")
                        ->filter("my.ma_products", "in", $chunk)
                        ->filter("my.supplierid", "=", $author_supplierid)
                        ->filter("my.storagetype", "in", ["1", "2", "3"])
                        ->filter("my.deleted", "=", "0")
                        ->end(-1)
                        ->execute();
                    foreach ($newquery as $newquery_info)
                    {
                            $numarr[$author_supplierid][$newquery_info->my->ma_products] =intval($numarr[$author_supplierid][$newquery_info->my->ma_products])+intval($newquery_info->my->inventorynum);
                    }
                }
            }
            foreach ($inventorywarndetailsarr as  $index=>$item)
            {
                foreach ($item as  $key=>$sid)
                {
                    if(intval($sid->my->maximum)<intval($numarr[$index][$key])){
                        $checkwarnsquery = XN_Query::create("Content")
                            ->tag("ma_checkinventorywarns")
                            ->filter("type", "eic", "ma_checkinventorywarns")
                            ->filter("my.ma_products", "=", $sid->my->ma_products)
                            ->filter("my.supplierid", "=", $sid->my->supplierid)
                            ->filter("my.module_type", "=", "1")
                            ->filter("my.deleted", "=", "0")
                            ->end(1)
                            ->execute();
                        if(count($checkwarnsquery)<1){
                            $newcontent                                 = XN_Content::create('ma_checkinventorywarns', '', false);
                            $newcontent->my->createnew                  = '0';
                            $newcontent->my->deleted                    = '0';
                            $newcontent->my->module_type                = '1';
                            $newcontent->my->barcode                    = $sid->my->barcode;
                            $newcontent->my->info_name                  = $sid->my->productname;
                            $newcontent->my->ma_products                = $sid->my->ma_products;
                            $newcontent->my->relation_id                = $sid->id;
                            $newcontent->my->supplierid                 = $sid->my->supplierid;
                            $newcontent->my->warn_msg                   = '产品库存'.intval($numarr[$index][$key]).'超过最大库存'.intval($sid->my->maximum);
                            $newcontent->save('ma_checkinventorywarns');
                        }
                    }
                    if(intval($sid->my->minimum)>intval($numarr[$index][$key])){
                        $checkwarnsquery = XN_Query::create("Content")
                            ->tag("ma_checkinventorywarns")
                            ->filter("type", "eic", "ma_checkinventorywarns")
                            ->filter("my.ma_products", "=", $sid->my->ma_products)
                            ->filter("my.supplierid", "=", $sid->my->supplierid)
                            ->filter("my.module_type", "=", "2")
                            ->filter("my.deleted", "=", "0")
                            ->end(1)
                            ->execute();
                        if(count($checkwarnsquery)<1){
                            $newcontent                                 = XN_Content::create('ma_checkinventorywarns', '', false);
                            $newcontent->my->createnew                  = '0';
                            $newcontent->my->deleted                    = '0';
                            $newcontent->my->module_type                = '2';
                            $newcontent->my->barcode                    = $sid->my->barcode;
                            $newcontent->my->info_name                  = $sid->my->productname;
                            $newcontent->my->ma_products                = $sid->my->ma_products;
                            $newcontent->my->relation_id                = $sid->id;
                            $newcontent->my->supplierid                 = $sid->my->supplierid;
                            $newcontent->my->warn_msg                   = '产品库存'.intval($numarr[$index][$key]).'低于最小库存'.$sid->my->minimum;
                            $newcontent->save('ma_checkinventorywarns');
                        }
                    }
                }
            }
        }
        //近效期预警  ischeckwarn=1为近效期ischeckwarn=2为过期
        $vali_date            = date("Y-m-d", strtotime("+".$warn_date_configs["productvalidate"]." day"));
        $currdate             = date("Y-m-d");
        $productvalidatesinfo = XN_Query::create('Content')
            ->tag('ma_inventorylist')
            ->filter('type', 'eic', 'ma_inventorylist')
            ->filter('my.validate', '<', $vali_date)
            ->filter('my.validate', '>=', $currdate)
            ->filter('my.validate', '!=', "")
            ->filter("my.storagetype", "in", ["1", "2", "3"])
            ->filter('my.inventorynum', '>', '0')
            ->filter('my.deleted', '=', '0')
            ->end(-1)
            ->execute();
        if (count($productvalidatesinfo) > 0)
        {
            foreach ($productvalidatesinfo as $productvalidatesinfo_info)
            {
                $temp = $productvalidatesinfo_info->my->ischeckwarn;
                if (!isset($temp) || ($temp != '1' && $temp != '2'))
                {
                    $supplier_info = XN_Content::load($productvalidatesinfo_info->my->supplierid, "ma_suppliers");
                    if ($supplier_info->my->suppliertype == "ma_agencys")
                    {
                        $productvalidatesinfo_info->my->ischeckwarn = '1';
                        $newcontent                                 = XN_Content::create('ma_checkwarns', '', false);
                        $newcontent->my->createnew                  = '0';
                        $newcontent->my->deleted                    = '0';
                        $newcontent->my->module_type                = 'productvalidate';
                        $newcontent->my->barcode                    = $productvalidatesinfo_info->my->barcode;
                        $newcontent->my->info_name                  = $productvalidatesinfo_info->my->productname;
                        $newcontent->my->products_batch_no          = $productvalidatesinfo_info->my->products_batch_no;
                        $newcontent->my->relation_id                = $productvalidatesinfo_info->id;
                        $newcontent->my->supplierid                 = $productvalidatesinfo_info->my->supplierid;
                        $newcontent->my->warn_msg                   = '产品有效期预警';
                        $newcontent->my->modifystatus               = '4';
                        $newcontent->my->end_date                   = $productvalidatesinfo_info->my->validate;
                        $newcontent->save('ma_checkwarns');
                    }
                }
            }
            XN_Content::batchsave($productvalidatesinfo, "ma_inventorylist");
        }
        //如果出售完的则修改预警状态
        $issaleinfo = XN_Query::create('Content')
            ->tag('ma_inventorylist')
            ->filter('type', 'eic', 'ma_inventorylist')
            ->filter("my.storagetype", "in", ["1", "2", "3"])
            ->filter('my.ischeckwarn', '=', '1')
            ->filter('my.inventorynum', '<=', '0')
            ->filter('my.deleted', '=', '0')
            ->end(-1)
            ->execute();
        if (count($issaleinfo) > 0)
        {
            foreach ($issaleinfo as $issaleinfo_info)
            {
                $arr[]                            = $issaleinfo_info->id;
                $issaleinfo_info->my->ischeckwarn = '0';
                $issaleinfo_info->save("ma_inventorylist");
            }
        }
        if (count($arr) > 0)
        {
            foreach (array_chunk($arr, 50) as $chunk)
            {
                $checkwarns = XN_Query::create('Content')
                    ->tag('ma_checkwarns')
                    ->filter('type', 'eic', 'ma_checkwarns')
                    ->filter('my.relation_id', 'in', $chunk)
                    ->filter('my.deleted', '=', '0')
                    ->end(-1)
                    ->order("published", XN_Order::DESC)
                    ->execute();
                foreach ($checkwarns as $checkwarnsinfo)
                {
                    $checkwarnsinfo->my->modifystatus = 5;
                    $checkwarnsinfo->save("ma_checkwarns");
                }
            }
        }
        //过期的批号生成不合格品登记
        $badproductsinfo = XN_Query::create('Content')
            ->tag('ma_inventorylist')
            ->filter('type', 'eic', 'ma_inventorylist')
            ->filter('my.validate', '<', $currdate)
            ->filter('my.validate', '!=', "")
            ->filter("my.storagetype", "in", ["1", "2", "3"])
            ->filter('my.inventorynum', '>', '0')
            ->filter('my.deleted', '=', '0')
            ->end(-1)
            ->execute();
        if (count($badproductsinfo) > 0)
        {
            foreach ($badproductsinfo as $badproductsinfo_info)
            {
                $temp = $badproductsinfo_info->my->ischeckwarn;
                if (!isset($temp))
                {
                    $supplier_info = XN_Content::load($badproductsinfo_info->my->supplierid, "ma_suppliers");
                    if ($supplier_info->my->suppliertype == "ma_agencys")
                    {
                        $badproductsinfo_info->my->ischeckwarn = '2';
                        $newcontent                            = XN_Content::create('ma_checkwarns', '', false);
                        $newcontent->my->createnew             = '0';
                        $newcontent->my->deleted               = '0';
                        $newcontent->my->module_type           = 'productvalidate';
                        $newcontent->my->barcode               = $badproductsinfo_info->my->barcode;
                        $newcontent->my->info_name             = $badproductsinfo_info->my->productname;
                        $newcontent->my->products_batch_no     = $badproductsinfo_info->my->products_batch_no;
                        $newcontent->my->relation_id           = $badproductsinfo_info->id;
                        $newcontent->my->supplierid            = $badproductsinfo_info->my->supplierid;
                        $newcontent->my->warn_msg              = '产品过期，请到不合格品登记处理';
                        $newcontent->my->modifystatus          = '6';
                        $newcontent->my->end_date              = $badproductsinfo_info->my->validate;
                        $newcontent->save('ma_checkwarns');
                    }
                }
                else if ($temp == '1')
                {
                    $details = XN_Query::create('Content')
                        ->tag('ma_checkwarns')
                        ->filter('type', 'eic', 'ma_checkwarns')
                        ->filter('my.relation_id', '=', $badproductsinfo_info->id)
                        ->filter('my.products_batch_no', '=', $badproductsinfo_info->my->products_batch_no)
                        ->filter('my.supplierid', '=', $badproductsinfo_info->my->supplierid)
                        ->filter('my.modifystatus', '=', '4')
                        ->filter('my.deleted', '=', '0')
                        ->end(-1)
                        ->order("published", XN_Order::DESC)
                        ->execute();
                    if (count($details) > 0)
                    {
                        foreach ($details as $details_info)
                        {
                            $badproductsinfo_info->my->ischeckwarn = '2';
                            $details_info->my->modifystatus        = 6;
                            $details_info->my->warn_msg            = '产品过期，请到不合格品登记处理';
                            $details_info->save("ma_checkwarns");
                        }
                    }
                }
            }
            XN_Content::batchsave($badproductsinfo, "ma_inventorylist");
        }
        $product_date = date("Y-m-d 00:00:00", strtotime("+".$warn_date_configs["ma_products"]." day"));
        $products     = XN_Query::create('Content_Count')
            ->tag('ma_products')
            ->filter('type', 'eic', 'ma_products')
            ->filter('my.register_end_date', '<', $product_date)
            ->filter('my.ma_productsstatus', '=', 'Agree')
            ->filter('my.certificatemodify_status', '!=', '1')
            ->rollup()
            ->end(-1);
        $products->execute();
        $productsinfo_count = $products->getTotalCount();
        for ($a = 0; $a < $productsinfo_count; $a += 200)
        {
            $productsinfo = XN_Query::create('Content')
                ->tag('ma_products')
                ->filter('type', 'eic', 'ma_products')
                ->filter('my.certificate_end_date', '<', $product_date)
                ->filter('my.ma_productsstatus', '=', 'Agree')
                ->filter('my.certificatemodify_status', '!=', '1')
                ->begin($a)
                ->end($a + 200)
                ->order("published", XN_Order::DESC)
                ->execute();
            if (count($productsinfo) > 0)
            {
                foreach ($productsinfo as $productsinfo_info)
                {
                    $id                                              = $productsinfo_info->id;
                    $productsinfo_info->my->certificatemodify_status = '1';
                    $firstchecks                                     = XN_Query::create("Content")
                        ->tag("ma_firstchecks")
                        ->filter("type", "eic", "ma_firstchecks")
                        ->filter("my.ma_products", "=", $productsinfo_info->id)
                        ->filter("my.ma_firstchecksstatus", "=", "Agree")
                        ->filter("my.deleted", "=", "0")
                        ->end(-1)
                        ->execute();
                    if (count($firstchecks))
                    {
                        foreach ($firstchecks as $check_info)
                        {
                            $newcontent                   = XN_Content::create('ma_checkwarns', '', false);
                            $newcontent->my->createnew    = '0';
                            $newcontent->my->deleted      = '0';
                            $newcontent->my->module_type  = 'ma_products';
                            $newcontent->my->info_name    = $productsinfo_info->my->productname;
                            $newcontent->my->relation_id  = $id;
                            $newcontent->my->supplierid   = $check_info->my->supplierid;
                            $newcontent->my->warn_msg     = '注册证号预警';
                            $newcontent->my->modifystatus = '1';
                            $newcontent->my->end_date     = $productsinfo_info->my->register_end_date;
                            $newcontent->save('ma_checkwarns');
                        }
                    }
                    else
                    {
                        $ma_factorys                 = $productsinfo_info->my->ma_factorys;
                        $factory_info                = XN_Content::load($ma_factorys, "ma_factorys");
                        $newcontent                  = XN_Content::create('ma_checkwarns', '', false);
                        $newcontent->my->createnew   = '0';
                        $newcontent->my->deleted     = '0';
                        $newcontent->my->module_type = 'ma_products';
                        $newcontent->my->info_name   = $productsinfo_info->my->productname;
                        $newcontent->my->relation_id = $id;
                        if ($factory_info->my->relation_id != "")
                        {
                            $newcontent->my->supplierid = $factory_info->my->supplierid;
                        }
                        else
                        {
                            $newcontent->my->supplierid = 'admin';
                        }
                        $newcontent->my->warn_msg     = '注册证号预警';
                        $newcontent->my->modifystatus = '1';
                        $newcontent->my->end_date     = $productsinfo_info->my->register_end_date;
                        $newcontent->save('ma_checkwarns');
                    }
                }
                XN_Content::batchsave($productsinfo, "ma_products");
            }
        }
        $factory_date = date("Y-m-d 00:00:00", strtotime("+".$warn_date_configs["ma_factorys"]." day"));
        $factorys     = XN_Query::create('Content_Count')
            ->tag('ma_factorys')
            ->filter('type', 'eic', 'ma_factorys')
            ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<', $factory_date), XN_Filter('my.productlicence_end_date', '<', $factory_date)))
            ->filter('my.ma_factorysstatus', '=', 'Agree')
            ->filter('my.certificatemodify_status', '!=', '1')
            ->rollup()
            ->end(-1);
        $factorys->execute();
        $factorys_count = $factorys->getTotalCount();
        for ($a = 0; $a < $factorys_count; $a += 200)
        {
            $factorysinfo = XN_Query::create('Content')
                ->tag('ma_factorys')
                ->filter('type', 'eic', 'ma_factorys')
                ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<', $factory_date), XN_Filter('my.productlicence_end_date', '<', $factory_date)))
                ->filter('my.ma_factorysstatus', '=', 'Agree')
                ->filter('my.certificatemodify_status', '!=', '1')
                ->begin($a)
                ->end($a + 200)
                ->order("published", XN_Order::DESC)
                ->execute();
            if (count($factorysinfo) > 0)
            {
                foreach ($factorysinfo as $factorysinfo_info)
                {
                    $id                          = $factorysinfo_info->id;
                    $newcontent                  = XN_Content::create('ma_checkwarns', '', false);
                    $newcontent->my->createnew   = '0';
                    $newcontent->my->deleted     = '0';
                    $newcontent->my->module_type = 'ma_factorys';
                    $newcontent->my->info_name   = $factorysinfo_info->my->factorys_name;
                    $newcontent->my->relation_id = $id;
                    if ($factorysinfo_info->my->relation_id !== "")
                    {
                        $newcontent->my->supplierid = $factorysinfo_info->my->supplierid;
                    }
                    else
                    {
                        $newcontent->my->supplierid = "admin";
                    }
                    if ($factorysinfo_info->my->bussinesslicense != "" && $factorysinfo_info->my->bussinesslicense_end_date < $factory_date)
                    {
                        $newcontent->my->warn_msg = '营业执照预警';
                        $newcontent->my->end_date = $factorysinfo_info->my->bussinesslicense_end_date;
                    }
                    else if ($factorysinfo_info->my->productlicence != "" && $factorysinfo_info->my->productlicence_end_date < $factory_date)
                    {
                        $newcontent->my->warn_msg = '生产许可证预警';
                        $newcontent->my->end_date = $factorysinfo_info->my->productlicence_end_date;
                    }
                    $newcontent->my->modifystatus = '1';
                    $newcontent->save('ma_checkwarns');
                    $factorysinfo_info->my->certificatemodify_status = '1';
                }
                XN_Content::batchsave($factorysinfo, "ma_factorys");
            }
        }
        $agency_date = date("Y-m-d 00:00:00", strtotime("+".$warn_date_configs["ma_agencys"]." day"));
        $agencys     = XN_Query::create('Content_Count')
            ->tag('ma_agencys')
            ->filter('type', 'eic', 'ma_agencys')
            ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<', $agency_date)))
            ->filter('my.ma_agencysstatus', '=', 'Agree')
            ->filter('my.certificatemodify_status', '!=', '1')
            ->rollup()
            ->end(-1);
        $agencys->execute();
        $agencys_count = $agencys->getTotalCount();
        for ($a = 0; $a < $agencys_count; $a += 200)
        {
            $agencysinfo = XN_Query::create('Content')
                ->tag('ma_agencys')
                ->filter('type', 'eic', 'ma_agencys')
                ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<', $agency_date)))
                ->filter('my.ma_agencysstatus', '=', 'Agree')
                ->filter('my.certificatemodify_status', '!=', '1')
                ->begin($a)
                ->end($a + 200)
                ->order("published", XN_Order::DESC)
                ->execute();
            if (count($agencysinfo) > 0)
            {
                foreach ($agencysinfo as $agencysinfo_info)
                {
                    $id                          = $agencysinfo_info->id;
                    $newcontent                  = XN_Content::create('ma_checkwarns', '', false);
                    $newcontent->my->createnew   = '0';
                    $newcontent->my->deleted     = '0';
                    $newcontent->my->module_type = 'ma_agencys';
                    $newcontent->my->info_name   = $agencysinfo_info->my->agencys_name;
                    $newcontent->my->relation_id = $id;
                    if ($agencysinfo_info->my->relation_id !== "")
                    {
                        $newcontent->my->supplierid = $agencysinfo_info->my->supplierid;
                    }
                    else
                    {
                        $newcontent->my->supplierid = "admin";
                    }
                    if ($agencysinfo_info->my->bussinesslicense_end_date < $agency_date)
                    {
                        $newcontent->my->warn_msg = '营业执照预警';
                        $newcontent->my->end_date = $agencysinfo_info->my->bussinesslicense_end_date;
                    }
                    $newcontent->my->modifystatus = '1';
                    $newcontent->save('ma_checkwarns');
                    $agencysinfo_info->my->certificatemodify_status = '1';
                }
                XN_Content::batchsave($agencysinfo, "ma_agencys");
            }
        }
        $ma_suppliers = XN_Query::create('Content')
            ->filter('type', 'eic', 'ma_suppliers')
            ->filter('my.deleted', '=', '0')
            ->filter('my.iscertificatepass', '=', '1')
            ->filter('my.suppliertype', '=', 'ma_agencys')
            ->end(-1)
            ->execute();
        foreach ($ma_suppliers as $ma_supplier_info)
        {
            $relation_id = $ma_supplier_info->my->relation_id;
            $loadContent = XN_Content::load($relation_id, "ma_agencys");
            if ($loadContent->my->bussinesslicense_end_date > date("Y-m-d") && $loadContent->my->productlicence_end_date > date("Y-m-d"))
            {
                $ma_supplier_info->my->iscertificatepass = '0';
                $ma_supplier_info->save('ma_suppliers');
            }
        }
        //预期未付款的商家付完款之前不能进行新的采购销售
        $un_frozenlists = XN_Query::create("Content")
            ->tag("ma_frozensuppliers")
            ->filter("type", "eic", "ma_frozensuppliers")
            ->filter("my.frozenstatus", "=", '0')
            ->filter("my.deleted", "=", "0")
            ->end(-1)
            ->execute();
        XN_Content::delete($un_frozenlists, "ma_frozensuppliers");
        $lastpay_date      = date("Y-m-d");
        $prev_lastpay_date = date("Y-m-d", strtotime("-5 day"));
        $paymentlists      = XN_Query::create("Content")
            ->tag("ma_dividepayments")
            ->filter("type", "eic", "ma_dividepayments")
            ->filter("my.real_remain", ">", '0')
            //->filter("my.prepay_date",">=",$prev_lastpay_date)
            ->filter("my.prepay_date", "<=", $lastpay_date)
            ->filter("my.deleted", "=", "0")
            ->end(-1)
            ->execute();
        if (count($paymentlists))
        {
            $suppliers = [];
            foreach ($paymentlists as $payment_info)
            {
                $suppliers[$payment_info->my->receiptid][] = $payment_info->my->paymentid;
            }
            foreach ($suppliers as $receiptid => $paymentids)
            {
                $frozenlists          = XN_Query::create("Content")
                    ->tag("ma_frozensuppliers")
                    ->filter("type", "eic", "ma_frozensuppliers")
                    ->filter("my.frozenstatus", "=", '1')
                    ->filter("my.receiptid", "=", $receiptid)
                    ->filter("my.paymentid", "in", $paymentids)
                    ->filter("my.deleted", "=", "0")
                    ->end(-1)
                    ->execute();
                $has_frozen_suppliers = [];
                foreach ($frozenlists as $frozen_info)
                {
                    $has_frozen_suppliers[] = $frozen_info->my->paymentid;
                }
                $no_frozen_suppliers   = array_diff($paymentids, $has_frozen_suppliers);
                $suppliers[$receiptid] = $no_frozen_suppliers;
            }
            $Datas = [];
            foreach ($suppliers as $receiptid => $paymentids)
            {
                foreach ($paymentids as $paymentid)
                {
                    $frozenContent                   = XN_Content::create("ma_frozensuppliers", "", false);
                    $frozenContent->my->supplierid   = $receiptid;
                    $frozenContent->my->receiptid    = $receiptid;
                    $frozenContent->my->paymentid    = $paymentid;
                    $frozenContent->my->frozenstatus = '1';
                    $frozenContent->my->deleted      = '0';
                    $frozenContent->my->createnew    = '0';
                    $Datas[]                         = $frozenContent;
                }
            }
            XN_Content::batchsave($Datas, "ma_frozensuppliers");
        }
        //资质过期的商家,冻结不能再进行所有的新增操作;
        $agency_query = XN_Query::create("Content")
            ->tag("ma_suppliers")
            ->filter("type", "eic", "ma_suppliers")
            ->filter("my.iscertificatepass", "=", "0")
            ->filter("my.suppliertype", "=", "ma_agencys")
            ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<=', date("Y-m-d")), XN_Filter('my.productlicence_end_date', '<=', date("Y-m-d"))))
            ->end(-1)
            ->execute();
        if (count($agency_query))
        {
            foreach ($agency_query as $info)
            {
                $info->my->iscertificatepass = '1';
            }
            XN_Content::batchsave($agency_query, "ma_suppliers");
        }
        $factory_query = XN_Query::create("Content")
            ->tag("ma_suppliers")
            ->filter("type", "eic", "ma_suppliers")
            ->filter("my.iscertificatepass", "=", "0")
            ->filter("my.suppliertype", "=", "ma_factorys")
            ->filter(XN_Filter::any(XN_Filter('my.bussinesslicense_end_date', '<=', date("Y-m-d")), XN_Filter('my.productlicence_end_date', '<=', date("Y-m-d"))))
            ->end(-1)
            ->execute();
        if (count($factory_query))
        {
            foreach ($factory_query as $info)
            {
                $info->my->iscertificatepass = '1';
            }
            XN_Content::batchsave($factory_query, "ma_suppliers");
        }
        $deliverycontracts = XN_Query::create("Content")
            ->tag("ma_deliverycontract")
            ->filter("type", "eic", "ma_deliverycontract")
            ->filter("my.ispass", "=", "0")
            ->filter('my.end_date', '<=', date("Y-m-d"))
            ->end(-1)
            ->execute();
        if (count($deliverycontracts))
        {
            foreach ($deliverycontracts as $info)
            {
                $info->my->ispass                           = '1';
                $submit_id                                  = $info->my->submit_id;
                $submit_type                                = $info->my->submit_type;
                $submit_supplier_info                       = XN_Content::load($submit_id, "ma_suppliers");
                $submit_relation_info                       = XN_Content::load($submit_supplier_info->my->relation_id, $submit_type);
                $submit_supplier_info->my->authorize_status = "3";
                $submit_relation_info->my->authorize_status = "3";
                $submit_supplier_info->save("ma_suppliers");
                $submit_relation_info->save($submit_type);
            }
            XN_Content::batchsave($deliverycontracts, "ma_deliverycontract");
        }
    }
    catch (XN_Exception $e)
    {
    }
    echo 'ok';
?>

