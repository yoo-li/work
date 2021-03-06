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
XN_Profile::$VIEWER=$profileid;
$record=$_REQUEST['record'];

// 根据 活动ID 和商品ID 查询

$activity_product=XN_Content::load($record,'mall_robsingles_details');
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
            $robproducts=XN_Query::create("Content")
                ->tag("mall_robproducts")
                ->filter("type","eic","mall_robproducts")
                ->filter("my.activity_product_id","=",$record)
                ->filter("my.profileid","=",$profileid)
                ->filter("my.deleted",'=','0')
                ->execute();
            $content=$robproducts[0];
            $count=count($robproducts);
            if($count<=0){
                $rob_info[1]-=1;
                XN_MemCache::put(implode("_",$rob_info),$record);

                $activitynumber=intval($activity_product->my->activitynumber);
                if($activitynumber<=1){
                    $activity_product->my->robstatus='2';            //修改可抢状态为已抢完
                }
                $activity_product->my->activitynumber=$activitynumber-1;
                $activity_product->save("mall_robsingles_details");
                //写抢购纪录
                $content=XN_Content::create("mall_robproducts","",false);
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
                $content->save("mall_robproducts,mall_robproducts_".$profileid);
                echo '{"status":"1","robproductsid":"'.$content->id.'","num":"3","msg":"抢购成功，请您在30分钟之内支付！"}';
                die();
            }
            else
            {
                if($content->my->robpaymentstatus=='未支付'){
                    echo '{"status":"1","robproductsid":"'.$content->id.'","num":"3","msg":"抢购成功,请您在30分钟之内支付"}';
                    die();
                }
                else{
                    echo '{"status":"0","robproductsid":"'.$content->id.'","num":"3","msg":"亲，同一个宝贝只能抢一次哦！"}';
                    die();
                }
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



