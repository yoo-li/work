<?php


global  $supplierid;

$products_query = XN_Query::create('Content_Count')->tag('mall_products')
    ->filter('type','eic','mall_products')
    ->filter('my.deleted','=','0');

$products_query->filter ( 'my.supplierid','=',$supplierid);
 
$products=$products_query->rollup()
    ->group('my.categorys')
    ->begin(0)->end(-1)
    ->execute();
$pr = array();
foreach ($products as $info){
    $pr[$info->my->categorys] = $info->my->count;
}

$categorys_query = XN_Query::create ( 'Content' )->tag('mall_categorys')
	->filter ( 'type', 'eic', 'mall_categorys');
$categorys_query->filter ( 'my.supplierid','=',$supplierid);
$categorys=$categorys_query->filter ( 'my.deleted', '=', 0)
	->order("my.sequence",XN_Order::ASC_NUMBER)
	->end(-1)
	->execute ();
$categoryArr = array();
$nums=array();
foreach($categorys as $category_info)
{
    $parentid = $category_info->my->pid;
    $nums[$parentid]['num']+=$pr[$category_info->id];
}

foreach($categorys as $category_info)
{
	 $parentid = $category_info->my->pid;
	 $name = $category_info->my->categoryname;
 	 if($nums[$category_info->id]['num'] != '')
 	     $name .= " [".$nums[$category_info->id]['num']."]";
	 if($pr[$category_info->id] != "")
	     $name .= " [".$pr[$category_info->id]."]";
	 $categoryArr[] = array('id' => $category_info->id,
								'pId' => $parentid,
								'isParent'=>false,
								'name' => $name,
								't'=> '',
								'open' => false,
								'sequence' => $category_info->my->sequence,
								);

}
echo json_encode($categoryArr);

?>