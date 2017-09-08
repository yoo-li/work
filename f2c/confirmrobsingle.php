<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lihongfei
 * Date: 15-2-2
 * Time: 上午10:41
 * To change this template use File | Settings | File Templates.
 */
require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/util.php");
session_start();
$profileid = $_SESSION['profileid'];

$record=$_REQUEST['record'];

// 根据 活动ID 和商品ID 查询

$activity_product=XN_Content::load($record,'Mall_RobSingles_details');
$productid = $activity_product->my->productid;
$salesactivityid = $activity_product->my->salesactivityid;
$amount=$activity_product->my->activitynumber;
$stime=$activity_product->my->begindate;
$etime=$activity_product->my->enddate;

if($stime<=date("Y-m-d H:i:s") && $etime>=date("Y-m-d H:i:s") ){
        try{
            $rob_value=XN_MemCache::get($record);
        }
        catch(XN_Exception $e){
            $rob_value=$activity_product->my->productid.'_'.($activity_product->my->activitynumber-$activity_product->my->robnumber).'_'.date("Y-m-d H:i:s",strtotime($activity_product->my->begindate)).'_'.date("Y-m-d H:i:s",strtotime($activity_product->my->enddate));
            XN_MemCache::put($rob_value,$record);
        }
        $rob_info=explode("_",$rob_value);
        if($rob_info[1]>0){
            $rob_info[1]-=1;
            XN_MemCache::put(implode("_",$rob_info),$record);

            $robproduct_query=XN_Query::create("Content_Count")
                ->tag("robproducts")
                ->filter("type","eic","robproducts")
                ->filter("my.activity_product_id","=",$record)
                ->filter("my.profileid","=",$profileid)
                ->rollup();
            $robproduct_query->execute();
            $count=$robproduct_query->getTotalCount();
            if(!$count){
                //写抢购纪录
                $content=XN_Content::create("robproducts","",false);
                $content->my->profileid=$profileid;
                $content->my->productid=$rob_info[0];
                $content->my->supplierid=$activity_product->my->supplierid;
                $content->my->deleted='0';
                $content->my->price=$activity_product->my->rob_price;
                $content->my->singletime=date("Y-m-d H:is:s");
                //$content->my->sn=$result['sn'];
                $content->my->paymenttime="";
                $content->my->robpaymentstatus="未支付";
                $content->my->createnew="0";
                $content->my->activityid=$salesactivityid;
                $content->my->activity_product_id=$record;
                $content->save("robproducts,robproducts_".$profileid);
                //纪录已抢到数量
                $count_robnum=$activity_product->my->robnumber+1;
                $activity_product->my->robnumber=$count_robnum;
                $activity_product->save("Mall_RobSingles_details");
                //修改可抢状态为已抢完
                if($count_robnum>=$activity_product->my->num){
                    $activity_product->my->robstatus='2';
                    $activity_product->save("activity_product");
                }
                echo '{"status":"1","robproductsid":"'.$content->id.'","num":"3","msg":"抢购成功！"}';
                die();
            }
            else
            {
                echo '{"status":"1","robproductsid":"'.$content->id.'","num":"3","msg":"抢购成功！"}';
                die();
            }

        }
        else{
            echo '{"status":"0","msg":"亲，已经抢完了，下次早点来哦！"}';
            die();
        }
}else{
    echo '{"status":"0","msg":"亲，活动还没开始哦！"}';
    die();
}



