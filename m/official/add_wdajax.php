<?php
/**
 * Created by PhpStorm.
 * User: xingyun
 * Date: 2017/6/21
 * Time: 11:20
 */
$id = $_POST['id_now'];
$loadcontent = XN_Query::create ( 'Content' )
    ->tag('Mall_OfficialAuthorizeEvents')
    ->filter ( 'type', 'eic', 'Mall_OfficialAuthorizeEvents')
    ->filter ( 'id', '=',$id)
    ->execute();
if ($loadcontent[0]->my->status == 0) {
    foreach ($loadcontent as $info) {
        $info->my->status = 1;
//            $info->my->endtime = date('Y年m月d日h时i分s秒', time());
        $info->save("Mall_OfficialAuthorizeEvents");
    }
    echo "上线成功";
    die;
}else{
    echo "已经上线";
    die;
}

