<?php
try{
    $mall_smkcardrecord_info=XN_Content::load('791288','mall_smkcardrecords');
    $mall_smkcardrecord_info->my->account = 200;
    $mall_smkcardrecord_info->save("mall_smkcardrecords");
}
catch (XN_Exception $e){
    echo $e->getMessage();
    die();
}
echo 'ok!';
