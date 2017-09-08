<?php
if(isset($_REQUEST['r_phone']) && $_REQUEST['r_phone']!=""){
    $phone=$_REQUEST["r_phone"];
    try{
        $users= XN_Query::create ( 'Content' )
            ->tag("users")
            ->filter("type",'eic',"users")
            ->filter( 'my.deleted', '=', '0' )
            ->filter("my.user_name","=",$phone)
            ->end(1)
            ->execute();
        if(count($users)){
            echo '{"error":"手机号已占用"}';
            die();
        }
        $suppliers = XN_Query::create ( 'Content' )
            ->tag ( 'suppliers' )
            ->filter ( 'type', 'eic', 'suppliers' )
            ->filter ( 'my.createnew', '=', '0' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.mobile', '=', $phone )
            ->filter ("my.suppliersstatus","!=","Disagree")
            ->execute ();
        if(count($suppliers)){
            echo '{"error":"手机号已占用"}';
            die();
        }else{
            echo '{"ok":"Pass"}';
            die();
        }
    }
    catch(XN_Exception $e){
        echo '{"error":"服务器网络延迟,请稍后再试!"}';
        die();
    }

}