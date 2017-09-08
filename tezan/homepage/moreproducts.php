<?php
/**
 * Created by PhpStorm.
 * User: wangzhenming
 * Date: 17/2/21
 * Time: 下午5:47
 */
session_start();

$ma_factorys = $_REQUEST['ma_factorys'];

$ma_clinicalcategorys = $_REQUEST['ma_clinicalcategorys'];

$cur_page=$_REQUEST['cur_page'];
$limit_start=$cur_page*12;
$limit_end=($cur_page+1)*12;
$product_query = XN_Query::create('Content')->tag('ma_products')
    ->filter('type', 'eic', 'ma_products')
    ->filter('my.deleted', '=', '0')
    ->filter("my.ma_productsstatus","=","Agree");
if(isset($_REQUEST['ma_factorys']) && $_REQUEST['ma_factorys']>0){
    $product_query->filter('my.ma_factorys', '=', $ma_factorys);
}
if(isset($_REQUEST['ma_clinicalcategorys']) && $_REQUEST['ma_clinicalcategorys']>0){
    $product_query->filter('my.clinicalcategory_pids', 'like', $ma_clinicalcategorys);
}
$products=$product_query->order("published", XN_Order::DESC)
    ->begin($limit_start)
    ->end($limit_end)
    ->execute();
$num_count=$product_query->getTotalCount();
$product_infos = array();
foreach ($products as $product_info)
{
    $productid=$product_info->id;
    $product_infos[$productid]['productname'] = $product_info->my->productname;
    $product_infos[$productid]['guige'] = $product_info->my->guige;
    if($product_info->my->productlogo!="" && file_exists($productlogo)){
        $productlogo=$product_info->my->productlogo;
    }
    else{
        $radom_num=rand(1,6);
        $productlogo="carousel-0".$radom_num.'.jpg';
    }
    $product_infos[$productid]['productlogo'] = $productlogo;
}


$html=$num_count.',';
foreach($product_infos as $productid=>$product_info){
    $html.='<li class="fadeInUp animated" data-animation="fadeInUp" data-animation-delay="200">
                <div class="portfolio-item">
                    <div class="portfolio-img">
                        <a href="productdetail.php?record='.$productid.'">
                            <img src="images/upload/'.$product_info['productlogo'].'" alt="">
                        </a>
                    </div>
                    <div class="portfolio-title">
                        <h2>
                            <a href="javascript:void(0);">'.$product_info['productname'].'</a>
                        </h2>
                    </div>
                </div>
            </li>';

}
echo $html;
