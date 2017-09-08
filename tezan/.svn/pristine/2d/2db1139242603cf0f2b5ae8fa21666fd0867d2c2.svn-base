<?php
$filter=$_REQUEST['filter'];
$products = XN_Query::create('Content_Count')->tag('products')
    ->filter('type','eic','products')
    ->filter('my.deleted','=','0')
    ->rollup()
    ->group('my.categorys')
    ->begin(0)->end(-1)
    ->execute();
$pr = array();
foreach ($products as $info){
    $pr[$info->my->categorys] = $info->my->count;
}

$categorys = XN_Query::create ( 'Content' )->tag('categorys')
    ->filter ( 'type', 'eic', 'categorys')
    ->filter ( 'my.deleted', '=', 0)
    ->order("my.sequence",XN_Order::ASC_NUMBER)
    ->end(-1)
    ->execute ();
$categoryArr = array();
foreach($categorys as $category_info)
{
    $parentid = $category_info->my->pid;
    $name = $category_info->my->categoryname;
    $nodes = GetCategory($category_info->id);
    $all = "";
    foreach ($nodes as $item){
        $all = intval($all) + intval($pr[$item]);
    }
    if($all != '')
        $name .= " [".$all."]";
    if($pr[$category_info->id] != "")
        $name .= " [".$pr[$category_info->id]."]";
    $categoryArr[] = array(
        'id' => $category_info->id,
        'pId' => $parentid,
        'isParent'=>false,
        'name' => $name,
        't'=> '',
        'open' => false,
        'sequence' => $category_info->my->sequence,
        'url'=>'index.php?module=Products&action=CategoryPopup&categorys='.$category_info->id."&filter=".$filter,
    );
}
echo json_encode($categoryArr);

function GetCategory($pid){
    $categorys = XN_Query::create ( 'Content' )->tag('categorys')
        ->filter ( 'type', 'eic', 'categorys')
        ->filter ( 'my.deleted', '=', 0)
        ->filter ( 'my.pid', '=', $pid)
        ->order("my.sequence",XN_Order::ASC_NUMBER)
        ->end(-1)
        ->execute();
//     $categoryOption[] = $pid;
    $categoryOption = array();
    foreach ($categorys as $info){
        $categoryOption[] = $info->id;
        $categoryOption = array_merge($categoryOption,GetCategory($info->id));
    }
    return $categoryOption;
}

?>