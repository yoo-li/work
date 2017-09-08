<?php
    session_start();
    require_once(dirname(__FILE__)."/../include/config.inc.php");
    require_once(dirname(__FILE__)."/../include/config.common.php");
    require_once(dirname(__FILE__)."/../include/utils.php");
//	$_SERVER["HTTP_X_NING_LOCAL_API_HOST_PORT"]="124.232.138.107:8000";
//	XN_REST::$LOCAL_API_HOST_PORT = $_SERVER['HTTP_X_NING_LOCAL_API_HOST_PORT'];
    $record            = $_REQUEST['record'];
    $mybarcodes        = $_REQUEST['mybarcodes'];
    $takepartin        = $_REQUEST['takepartin'];
    $profileid         = $_POST['profileid'];
    $ma_checkordersid  = $_POST['ma_checkordersid'];
    $temp              = json_decode($mybarcodes, true);
//    $instorage_info    = XN_Content::load($record, "ma_instoragecheck");
//    $ma_saleorders     = $instorage_info->my->ma_saleorders;
//    $ma_incheckstorage = $instorage_info->my->ma_incheckstorage;
    foreach ($temp as $detail_str)
    {
        $barcode      = $detail_str['barcode'];
        $number       = $detail_str['number'];
        $refusenumber = $detail_str['refusenumber'];
        if (substr($barcode, 0, 3) == "WZD")
        {
            $pieces = explode("_", $barcode);
            $myproducts_batch_no = $pieces[2];
            $myitemcode          = $pieces[1];
        }else if (substr($barcode, 0, 3) == "YLT")
        {
            $myproducts_batch_no = substr($barcode, 29);
            $myitemcode          = substr($barcode, 3, 16);
        }
        else if (substr($barcode, 0, 3) == "ATH")
        {
            $myproducts_batch_no = substr($barcode, 26);
            $myitemcode          = substr($barcode, 3, 13);
        }else if(substr($barcode, 0,3)=="BCL"){
            $myproducts_batch_no=substr($barcode, 37);
            $myitemcode=substr($barcode, 6,13);
        }else if(substr($barcode, 0,3)=="RTK"){
            $myproducts_batch_no=substr($barcode, 35);
            $myitemcode=substr($barcode, 6,17);
        }
        else
        {
            $myproducts_batch_no = substr($barcode, 26);
            $myitemcode          = substr($barcode, 3, 12);
        }
    }
    $check_details = XN_Query::create("Content")
        ->tag("ma_checkdetails")
        ->filter("type", "eic", "ma_checkdetails")
        ->filter("my.record", "=", $ma_checkordersid)
        ->filter("my.instoragenumber", ">", "0")
        ->filter(XN_Filter::any(XN_Filter('my.barcode', '=', $myitemcode), XN_Filter('my.itemcode', '=', $myitemcode)))
        ->filter("my.deleted", "=", "0")
        ->execute();
    $SaveConn      = [];
    foreach ($check_details as $key => $info)
    {
        $oldbatch_infos = json_decode($info->my->batch_info, true);
        foreach ($oldbatch_infos as $key => $binfo)
        {
            if ($myproducts_batch_no === $binfo["products_batch_no"])
            {

                if ($takepartin === "1")
                {
                    if(isset($binfo["add_checknumber"])){
                        $number+=intval($binfo["add_checknumber"]);
                    }
                    $oldbatch_infos[$key]["add_checknumber"]  = intval($number);
                    $oldbatch_infos[$key]["add_refusenumber"] = intval($oldbatch_infos[$key]["ing_instoragenumber"])-intval($number);
                    $oldbatch_infos[$key]["scancode"]  = "1";
                    break;
                }
                else
                {
                    if ($number > $oldbatch_infos[$key]["instoragenumber"])
                    {
                        $number       = intval($oldbatch_infos[$key]["instoragenumber"]);
                        $refusenumber = 0;
                    }else{
                        $number+=intval($oldbatch_infos[$key]["checknumber"]);
                        $refusenumber=intval($oldbatch_infos[$key]["instoragenumber"])-intval($number);
                    }
                    $oldbatch_infos[$key]["checknumber"]  = $number;
                    $oldbatch_infos[$key]["refusenumber"] = $refusenumber;
                    $oldbatch_infos[$key]["scancode"]  = "1";
                    break;
                }
            }
        }
        $info->my->batch_info = json_encode($oldbatch_infos);
        $SaveConn[]           = $info;
    }
    if (count($SaveConn) > 0)
    {
        XN_Content::batchsave($SaveConn, "ma_checkdetails");
    }
//    $loadcontent              = XN_Content::load($record, "ma_instoragecheck");
//    $loadcontent->my->execute = $profileid;
//    $loadcontent->save("ma_instoragecheck");
//    echo '200';


