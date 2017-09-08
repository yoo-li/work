<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/2/18
 * Time: 下午12:44
 */
ini_set('memory_limit','2048M');
set_time_limit(0);

session_start();

$loopcallbacks = XN_Query::create ( 'MainContent' )
    ->tag ( 'loopcallback' )
    ->filter ( 'type', 'eic', 'loopcallback' )
    ->filter ( 'my.deleted', '=', '0' )
    ->filter ( 'my.url', '=', '/plugins/task/storagecost.php' )
    ->execute ();

if (count($loopcallbacks) == 0)
{
    if (strpos($_SERVER["SERVER_SOFTWARE"],"nginx") !==false)
    {
        $domain=$_SERVER['HTTP_HOST'];
        $web_root = $domain;
    }
    else
    {
        $domain=$_SERVER['SERVER_NAME'];
        $web_root = $domain.':'.$_SERVER['SERVER_PORT'];
    }

    $newcontent = XN_Content::create('loopcallback','',false,4);
    $newcontent->my->deleted = 0;
    $newcontent->my->url = '/plugins/task/storagecost.php';
    $newcontent->my->sleep = '86400';
    $newcontent->my->webroot = $web_root;
    $newcontent->my->status = 'Active';
    $newcontent->save('loopcallback');
}

//定时统计货主的仓库中某个产品的数量*平均价,总价值,表名:ma_storagecost

try{
//采购订单入库(包含正产采购订单和借领采购订单)
    $inputdetails=XN_Query::create("Content")
        ->tag("ma_inputdetail")
        ->filter("type","eic","ma_inputdetail")
        ->filter("my.instorestatus","=","1")
        ->filter("my.ma_purchaseorders",">","0")
        ->filter(XN_Filter::all(XN_Filter("updated",">",date("Y-m-d",strtotime("-1 day"))." 00:00:00"),XN_Filter("updated","<=",date("Y-m-d")." 00:00:00")))
        ->filter("my.deleted","=","0")
        ->end(-1)
        ->execute();

    if(count($inputdetails)){
        $purchase_prices=array();
        $purchaseorder_ids=array();
        $purchasein_counts=array();
        foreach($inputdetails as $detail_info){
            $ma_purchaseorders=  $detail_info->my->record;
            $purchaseorder_ids[]=$ma_purchaseorders;
        }
        foreach(array_chunk($purchaseorder_ids,30) as $chunk_ids){
            $purchasedetails=XN_Query::create("Content")
                ->tag("ma_purchasedetails")
                ->filter("type","eic","ma_purchasedetails")
                ->filter("my.record","in",$chunk_ids)
                ->filter("my.deleted","=","0")
                ->end(-1)
                ->execute();
            if(count($purchasedetails)){
                foreach($purchasedetails as $detail_info){
                    $purchase_prices[$detail_info->my->record][$detail_info->my->ma_products]=$detail_info->my->price;
                }
            }
        }

        foreach($inputdetails as $detail_info){
            $record=$detail_info->my->record;
            $putinContent=XN_Content::load($record,"ma_inventoryputin");
            $putin_storagelist=$putinContent->my->ma_storagelist;
            $supplierid=$putinContent->my->submit_id;
            $price=$purchase_prices[$detail_info->my->ma_purchaseorders][$detail_info->my->ma_products];
            $number=$detail_info->my->checknumber;
            $costcount_query=XN_Query::create("Content")
                ->tag("ma_storagecost")
                ->filter("type","eic","ma_storagecost")
                ->filter("my.ma_storagelist","=",$putin_storagelist)
                ->filter("my.supplierid","=",$supplierid)
                ->filter("my.ma_products","=",$detail_info->my->ma_products)
                ->filter("my.deleted","=","0")
                ->end(-1)
                ->execute();
            if(count($costcount_query)){
                $cost_info=$costcount_query[0];
                $old_cost=$cost_info->my->cost;
                $new_number=$cost_info->my->number + $number;
                $new_cost=$old_cost+$price*$number;
                $new_price=ceil($new_cost*100/$new_number)/100;
                $cost_info->my->number  = $new_number;
                $cost_info->my->price  = $new_price;
                $cost_info->my->cost  = $new_cost;
                $cost_info->save('ma_storagecost');
            }
            else
            {
                $cost_info = XN_Content::create('ma_storagecost', '', false);
                $cost_info->my->createnew    = '0';
                $cost_info->my->deleted      = '0';
                $cost_info->my->supplierid    = $supplierid;
                $cost_info->my->ma_storagelist  = $putin_storagelist;
                $cost_info->my->ma_products  = $detail_info->my->ma_products;
                $cost_info->my->number  = $number;
                $cost_info->my->price  = $price;
                $cost_info->my->cost  = $price*$number;
                $cost_info->my->last_date     = date("Y-m-d",strtotime("-1 day"));
                $cost_info->save('ma_storagecost');
            }
        }
    }


//销后退回入库
    $inputdetails=XN_Query::create("Content")
        ->tag("ma_inputdetail")
        ->filter("type","eic","ma_inputdetail")
        ->filter("my.instorestatus","=","1")
        ->filter("my.ma_returnordersin",">","0")
        ->filter(XN_Filter::all(XN_Filter("updated",">",date("Y-m-d",strtotime("-1 day"))." 00:00:00"),XN_Filter("updated","<=",date("Y-m-d")." 00:00:00")))
        ->filter("my.deleted","=","0")
        ->end(-1)
        ->execute();

    if(count($inputdetails)){
        $return_prices=array();
        $returnin_order_ids=array();
        $returnin_counts=array();
        foreach($inputdetails as $detail_info){
            $returnordersin=  $detail_info->my->ma_returnordersin;
            $returnin_order_ids[]=$returnordersin;
        }
        foreach(array_chunk($returnin_order_ids,30) as $chunk_ids){
            $returndetails=XN_Query::create("Content")
                ->tag("ma_returndetails")
                ->filter("type","eic","ma_returndetails")
                ->filter("my.record","in",$chunk_ids)
                ->filter("my.deleted","=","0")
                ->end(-1)
                ->execute();
            if(count($returndetails)){
                foreach($returndetails as $detail_info){
                    $return_prices[$detail_info->my->record][$detail_info->my->ma_products]=$detail_info->my->price;
                }
            }
        }

        foreach($inputdetails as $detail_info){
            $record=$detail_info->my->record;
            $returninContent=XN_Content::load($record,"ma_inventoryreturnin");
            $returnin_storagelist=$returninContent->my->ma_storagelist;
            $supplierid=$returninContent->my->submit_id;
            $price=$return_prices[$detail_info->my->ma_purchaseorders][$detail_info->my->ma_products];
            $number=$detail_info->my->checknumber;
            $costcount_query=XN_Query::create("Content")
                ->tag("ma_storagecost")
                ->filter("type","eic","ma_storagecost")
                ->filter("my.ma_storagelist","=",$returnin_storagelist)
                ->filter("my.supplierid","=",$supplierid)
                ->filter("my.ma_products","=",$detail_info->my->ma_products)
                ->filter("my.deleted","=","0")
                ->end(-1)
                ->execute();
            if(count($costcount_query)){
                $cost_info=$costcount_query[0];
                $old_cost=$cost_info->my->cost;
                $new_number=$cost_info->my->number + $number;
                $new_cost=$old_cost+$price*$number;
                $new_price=ceil($new_cost*100/$new_number)/100;
                $cost_info->my->number  = $new_number;
                $cost_info->my->price  = $new_price;
                $cost_info->my->cost  = $new_cost;
                $cost_info->save('ma_storagecost');
            }
            else
            {
                $cost_info = XN_Content::create('ma_storagecost', '', false);
                $cost_info->my->createnew    = '0';
                $cost_info->my->deleted      = '0';
                $cost_info->my->supplierid    = $supplierid;
                $cost_info->my->ma_storagelist  = $returnin_storagelist;
                $cost_info->my->ma_products  = $detail_info->my->ma_products;
                $cost_info->my->number  = $number;
                $cost_info->my->price  = $price;
                $cost_info->my->cost  = $price*$number;
                $cost_info->my->last_date     = date("Y-m-d",strtotime("-1 day"));
                $cost_info->save('ma_storagecost');
            }
        }
    }

//库存初始化入库
    $storageinits=XN_Query::create("Content")
        ->tag("ma_storageinit")
        ->filter("type","eic","ma_storageinit")
        ->filter("my.ma_storageinitstatus","=","Agree")
        ->filter(XN_Filter::all(XN_Filter("my.submitapprovalreplydatetime",">",date("Y-m-d",strtotime("-1 day"))." 00:00:00"),XN_Filter("my.submitapprovalreplydatetime","<=",date("Y-m-d")." 00:00:00")))
        ->filter("my.deleted","=","0")
        ->end(-1)
        ->execute();

    if(count($storageinits)){
        foreach($storageinits as $info){
            $ma_storagelist=$info->my->ma_storagelist;
            $supplierid=$info->my->supplierid;
            $details=XN_Query::create("Content")
                ->tag("ma_pickdetails")
                ->filter("type","=","ma_pickdetails")
                ->filter("my.record","=",$info->id)
                ->filter("my.deleted","=","0")
                ->execute();
            foreach($details as $detail_info){
                $price=0;
                $number=$detail_info->my->sendnumber;
                $costcount_query=XN_Query::create("Content")
                    ->tag("ma_storagecost")
                    ->filter("type","eic","ma_storagecost")
                    ->filter("my.ma_storagelist","=",$ma_storagelist)
                    ->filter("my.supplierid","=",$supplierid)
                    ->filter("my.ma_products","=",$detail_info->my->ma_products)
                    ->filter("my.deleted","=","0")
                    ->end(-1)
                    ->execute();
                if(count($costcount_query)){
                    $cost_info=$costcount_query[0];
                    $old_cost=$cost_info->my->cost;
                    $new_number=$cost_info->my->number + $number;
                    $new_cost=$old_cost+$price*$number;
                    $new_price=ceil($new_cost*100/$new_number)/100;
                    $cost_info->my->number  = $new_number;
                    $cost_info->my->price  = $new_price;
                    $cost_info->my->cost  = $new_cost;
                    $cost_info->save('ma_storagecost');
                }
                else
                {
                    $cost_info = XN_Content::create('ma_storagecost', '', false);
                    $cost_info->my->createnew    = '0';
                    $cost_info->my->deleted      = '0';
                    $cost_info->my->supplierid    = $supplierid;
                    $cost_info->my->ma_storagelist  = $ma_storagelist;
                    $cost_info->my->ma_products  = $detail_info->my->ma_products;
                    $cost_info->my->number  = $number;
                    $cost_info->my->price  = $price;
                    $cost_info->my->cost  = $price*$number;
                    $cost_info->my->last_date     = date("Y-m-d",strtotime("-1 day"));
                    $cost_info->save('ma_storagecost');
                }
            }
        }
    }
}
catch(XN_Exception $e){
    echo $e->getMessage();
}
echo 'ok!';

?>

