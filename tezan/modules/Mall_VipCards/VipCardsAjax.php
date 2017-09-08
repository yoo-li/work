<?php
/*
  ["module"]=> "Mall_VipCards",
  ["action"]=>"VipCardsAjax",
  ["id"]=>"440015;439938;379511",
  ["name"]=>"阳山水蜜桃;脑白金",
  ["ids"]=>"493805",
  ["_"]=>"1498610254364"
*/
$id = $_REQUEST['id'];
$id = explode(";",trim($id,';'));
$names = $_REQUEST['name'];
$names = explode(";",trim($names,';'));
$ids = $_REQUEST['ids'];
$Mall_SmkVipCardsProducts = XN_Query::create("Content")->tag("Mall_SmkVipCardsProducts")
                   ->filter("type","eic","Mall_SmkVipCardsProducts")
                   ->filter("my.vipcardsid","=",$ids)
                   ->end(-1)
                   ->execute();
XN_Content::delete($Mall_SmkVipCardsProducts,"Mall_SmkVipCardsProducts");

foreach ($id as $key => $value) {
    $Mall_SmkVipCardsProducts = XN_Content::create('Mall_SmkVipCardsProducts');
    $Mall_SmkVipCardsProducts->my->supplierid= '12352'; // 商家
    $Mall_SmkVipCardsProducts->my->deleted = 0; //删除
    $Mall_SmkVipCardsProducts->my->vipcardsid = $ids; //券ID
    $Mall_SmkVipCardsProducts->my->productid = $value; //商品ID
    $Mall_SmkVipCardsProducts->my->productname = $names[$key]; //商品名称
    $Mall_SmkVipCardsProducts->save('Mall_SmkVipCardsProducts');
}

echo 200;
