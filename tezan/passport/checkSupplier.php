<?php
if(isset($_REQUEST['r_username']) && $_REQUEST['r_username']!=""){
    $username=$_REQUEST["r_username"];
    try{
        $suppliers = XN_Query::create ( 'Content' )
            ->tag ( 'suppliers' )
            ->filter ( 'type', 'eic', 'suppliers' )
            ->filter ( 'my.deleted', '=', '0' )
            ->filter ( 'my.suppliers_name', '=', $username )
            ->filter ("my.suppliersstatus","!=","Disagree")
            ->end(1)
            ->execute();

        $users= XN_Query::create ( 'Content' )
            ->tag("users")
            ->filter("type",'eic',"users")
            ->filter ( 'my.deleted', '=', '0' )
            ->filter("my.user_name","=",$username)
            ->end(1)
            ->execute();
        $givenname=XN_Filter("givenname",'=',$username);
        $realname =XN_Filter("realname ",'=',$username);
        $profiles=XN_Query::create("Profile")
             ->tag("profile")
             ->filter(XN_Filter::any($givenname,$realname))
             ->end(1)
             ->execute();
        if(count($suppliers) || count($users) ||count($profiles)){
            echo '{"error":"用户名已占用"}';
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