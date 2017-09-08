<?php
//include ('modules/Public/massdelete.php');
try{
    $binds = $_REQUEST['ids'];
    $developer = $_REQUEST['developer'];
    $binds = str_replace(";",",",$binds);
    $binds = explode(",",trim($binds,','));
    array_unique($binds);
    if(count($binds)){
        $query=XN_Content::loadMany($binds,"announcements");
        foreach($query as $info){
            $info->my->deleted="1";
        }
        XN_Content::batchsave($query,"announcements");
    }
    echo '{"statusCode":200,"message":"删除成功","tabid":"'.$module.'"}';
    die();
}
catch(XN_Exception $e){
    echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
    die();
}

?>
