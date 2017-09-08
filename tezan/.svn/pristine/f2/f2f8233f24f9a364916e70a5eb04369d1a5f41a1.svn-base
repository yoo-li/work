<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-6-8
 * Time: 下午1:34
 * To change this template use File | Settings | File Templates.
 * 删除已上传图片
 */
$recordid=$_REQUEST['record'];
$category=$_REQUEST['category'];
try{
    $supplieratachments = XN_Query::create('Content')
        ->tag("attachments")
        ->filter('type','=','attachments')
        ->filter("my.record",'=',$recordid)
        ->filter("my.category",'=',$category)
        ->end(1)
        ->execute();
    if(count($supplieratachments)){
        XN_Content::delete($supplieratachments,"attachments");
    }
    return true;
}
catch(XN_Exception $e){
    echo $e->getMessage();
    return false;
}

