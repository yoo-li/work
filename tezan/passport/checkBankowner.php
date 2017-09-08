<?php
if(isset($_REQUEST['r_bankowner']) && $_REQUEST['r_bankowner']!=""){
    $bankowner=$_REQUEST["r_bankowner"];
    try{
        $suppliers = XN_Query::create ( 'Content' )
            ->tag ( 'suppliers' )
            ->filter ( 'type', 'eic', 'suppliers' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.suppliers_type','=','0')
            ->filter ( 'my.accountname', '=', $bankowner )
            ->filter ("my.suppliersstatus","!=","Disagree")
            ->end(1)
            ->execute();

        if(count($suppliers) ){
            echo '{"error":"开户名已占用"}';
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


?>