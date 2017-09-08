<?php
/**
 * Created by PhpStorm.
 * User: xingyun
 * Date: 2017/6/15
 * Time: 17:51
 */
require_once (dirname(__FILE__) . "/../include/config.inc.php");

$id = $_POST['id_now'];
try{
    $loadcontent = XN_Query::create ( 'Content' )
        ->tag('mall_officialauthorizeevents')
        ->filter ( 'type', 'eic', 'mall_officialauthorizeevents')
        ->filter ( 'id', '=',$id)
        ->execute();
    $status = $loadcontent[0]->my->status;
    if ($status == 0) {
        foreach ($loadcontent as $info) {
        $info->my->mall_officialauthorizeeventsstatus = 'Submit';
//            $info->my->mall_officialauthorizeeventsstatus = 'JustCreated';
//            $info->my->endtime = date('Y年m月d日h时i分s秒', time());
        $info->save("mall_officialauthorizeevents");
        }
        echo "上线成功";
        die;
    }else{
        echo "已经上线";
        die;
    }
}catch(Exception $e) {
    print $e->getMessage();
    exit();
}


