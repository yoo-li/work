<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//    $loadcontent=XN_Content::load('6391916',"ma_inputdetail");
//    $loadcontent->my->instoragenumber="70";
//    $loadcontent->my->checknumber="70";
//    $loadcontent->my->sendnumber="70";
//    $loadcontent->save("ma_inputdetail");
//
//    $loadcontent=XN_Content::load('6391960',"ma_inputdetail");
//    $loadcontent->my->instoragenumber="10";
//    $loadcontent->my->checknumber="10";
//    $loadcontent->my->sendnumber="10";
//    $loadcontent->save("ma_inputdetail");
//
//    $loadcontent=XN_Content::load('6285012',"ma_saledetails");
//    $loadcontent->my->instoragenumber="10";
//    $loadcontent->my->checknumber="10";
//    $loadcontent->my->sendnumber="10";
//    $loadcontent->save("ma_saledetails");
//
//    $loadcontent=XN_Content::load('6380739',"ma_checkdetails");
//    $loadcontent->my->rechecknumber="70";
//    $loadcontent->my->submitnumber="70";
//    $loadcontent->my->instoragenumber="70";
//    $loadcontent->my->checknumber="70";
//    $loadcontent->my->sendnumber="70";
//    $loadcontent->save("ma_checkdetails");
//
//    $loadcontent=XN_Content::load('6285052',"ma_saledetails");
//    $loadcontent->my->instoragenumber="70";
//    $loadcontent->my->checknumber="70";
//    $loadcontent->my->sendnumber="70";
//    $loadcontent->save("ma_saledetails");
//
    $saledetails = XN_Query::create("Content")->tag("ma_inputdetail")
        ->filter('type', 'eic', 'ma_inputdetail')
        ->filter('my.deleted', '=', '0')
        ->filter('id', '=', '6391960')
        ->end(-1)
        ->execute();
    if (count($saledetails))
    {
        foreach ($saledetails as $info)
        {
            $oldbatch_infos               = json_decode($info->my->batch_info, true);
            $oldbatch_infos["1407202091"] = array(
                "products_batch_no" => "1407202091",
                "productdate"       => "2014-09-01",
                "validate"          => "",
                "sterilizecode"     => "",
                "sterilizedate"     => "",
                "sterilizevalidate" => "",
                "instoragenumber"   => 1,
                "checknumber"      => 1,
                "refusenumber"     => 0,
                "sendnumber"        => 1,
                "number"        => 0,
            );

            $oldbatch_infos["1407202093"] = array(
                "products_batch_no" => "1407202093",
                "productdate"       => "2014-09-01",
                "validate"          => "",
                "sterilizecode"     => "",
                "sterilizedate"     => "",
                "sterilizevalidate" => "",
                "instoragenumber"   => 1,
                "checknumber"      => 1,
                "refusenumber"     => 0,
                "sendnumber"        => 1,
                "number"        => 0,
            );
            $info->my->batch_info         = json_encode($oldbatch_infos);
            $info->save("ma_inputdetail");
        }
    }

//    $loadcontent=XN_Content::load('6285090',"ma_incheckstorage");
//    $loadcontent->my->instoragenumber="2145";
//    $loadcontent->my->checknumber="2145";
//    $loadcontent->my->sendnumber="2145";
//    $loadcontent->save("ma_incheckstorage");
//
//    $loadcontent=XN_Content::load('6336331',"ma_instoragecheck");
//    $loadcontent->my->instoragenumber="2145";
//    $loadcontent->my->checknumber="2145";
//    $loadcontent->my->sendnumber="2145";
//    $loadcontent->save("ma_instoragecheck");

?>