<?php
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
global $currentModule; 
/*
$suppliers=XN_Query::create("Content")
    ->tag("suppliers")
    ->filter("type","=","suppliers")
    ->filter("my.pers","=",XN_Profile::$VIEWER)
    ->filter("my.suppliersstatus","=","Agree")
    ->filter("my.deleted","=","0")
    ->end(1)
    ->execute();
if(count($suppliers)){
    echo '
    <script>
        $(this).navtab("closeTab","Mall_SmkUsers");
        $(this).navtab({id:"edit", url:"index.php?module=Mall_SmkUsers&action=EditView", title:"商家中心",fresh:false,mask:true});
    </script>
    ';
}else{
 */
    include ('modules/'.$currentModule.'/ListView.php');
//}


?>
