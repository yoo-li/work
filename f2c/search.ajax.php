<?php


session_start();

require_once (dirname(__FILE__) . "/config.inc.php");
require_once (dirname(__FILE__) . "/config.common.php");
require_once (dirname(__FILE__) . "/util.php");

global $loginprofileid;

//获取到ajax传递过来的值
$int1          =   (int)$_POST['num1'];
$int2          =   (int)$_POST['num2'];
$categoryid    =   (int)$_POST['categoryid'];
$page          =   (int)$_POST['page'];


if(isset($_SESSION['profileid']) && $_SESSION['profileid'] !='')
{

    $loginprofileid = $_SESSION['profileid'];
//    var_dump($loginprofileid);die;   4eq2yr6x03a
}
elseif(isset($_SESSION['accessprofileid']) && $_SESSION['accessprofileid'] !='')
{
    $loginprofileid = $_SESSION['accessprofileid'];
}
else
{
    $loginprofileid = "anonymous";
}

if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
    $supplierid = $_SESSION['supplierid'];
//    var_dump($supplierid);die;    12352
}
else
{
    echo '{"code":201,"msg":"没有店铺ID!"}';
    die();
}


if(isset($_REQUEST['page']) && $_REQUEST['page'] !='')
{
    $page = $_REQUEST['page'];
//    var_dump($page);die;  2
}
else
{
    echo '{"code":201,"data":[]}';
    die();
}
    //空
if(isset($_REQUEST['keywords']) && $_REQUEST['keywords'] !='')
{
    $keywords = $_REQUEST['keywords'];
}
else
{

    $keywords = '';
}
if(isset($_REQUEST['categoryid']) && $_REQUEST['categoryid'] !='')
{
//        var_dump(11111);die;
    $categoryid = $_REQUEST['categoryid'];
}
else
{
    $categoryid = '';
}

if(isset($_REQUEST['sort']) && $_REQUEST['sort'] !='')
{

    $sort = $_REQUEST['sort'];
//    var_dump($sort);die;    desc
}
if(isset($_REQUEST['order']) && $_REQUEST['order'] !='')
{
//    var_dump(33333333);die;
    $order = $_REQUEST['order'];
}

//var_dump($categoryid);die;
try{
    $products = mall_products($keywords,$categoryid,$page,$supplierid,$order,$sort);
//    echo 11112221111;
    if (count($products) > 0)
    {
        echo '{"code":200,"data":'.json_encode($products).'}';
        die();
    }
}
catch(XN_Exception $e)
{

}
echo '{"code":202,"data":[]}'; 
die(); 

//$categoryid = 202172;
//$categoryid = 158908;
//function  mall_products($keywords,$categoryid,$page,$supplierid,$order,$sort) {
function  mall_products($keywords,$categoryid,$page,$supplierid,$order,$sort) {
    global $APISERVERADDRESS;
    $begin = ($page - 1) * 100;
    $end = $page * 100;

    $supplier_info = get_supplier_info();
    // $uniquesales = array();
// 	if ($supplier_info['showuniquesale'] == '1')
// 	{
// 		global $loginprofileid;
// 		$mall_uniquesales = XN_Query::create ( 'Content' )->tag('mall_uniquesales_'.$loginprofileid)
// 					->filter ( 'type', 'eic', 'mall_uniquesales')
// 					->filter ( 'my.deleted', '=', '0')
// 					->filter ( 'my.profileid', '=', $loginprofileid)
// 					->end(-1)
// 					->execute ();
//
// 		foreach($mall_uniquesales as $mall_uniquesale_info)
// 		{
// 			$uniquesales[] = $mall_uniquesale_info->my->productid;
// 		}
// 	}
// 	if (count($uniquesales) > 0)
// 	{
// 		$query = XN_Query::create ( 'Content' )->tag('mall_products')
// 					->filter ( 'type', 'eic', 'mall_products')
// 					->filter ( 'my.hitshelf', '=', 'on')
// 					->filter ( 'my.supplierid', '=', $supplierid)
// 					->filter ( 'id', '!in', $uniquesales)
// 					->begin($begin)
// 					->end($end);
// 	}
// 	else
// 	{
// 		$query = XN_Query::create ( 'Content' )->tag('mall_products')
// 					->filter ( 'type', 'eic', 'mall_products')
// 					->filter ( 'my.hitshelf', '=', 'on')
// 					->filter ( 'my.supplierid', '=', $supplierid)
// 					->begin($begin)
// 					->end($end);
// 	}

    if (isset($keywords) && $keywords != "")
    {
        try{
            $newcontent = XN_Content::create('productkeywords', '',false,5)
                ->my->add('keyword',base64_encode($keywords))
                ->my->add('supplierid',$supplierid)
                ->my->add('begin',$begin)
                ->my->add('end',$end);
            // ->my->add('orderby',"shop_price") //sequence,praise,shop_price,categorys,salevolume
            //  ->my->add('sort',"DESC"); //DESC,ASC,DESC_NUMBER,ASC_NUMBER

            if (isset($categoryid) && $categoryid != "")
            {
                $mall_categorys = XN_Query::create ( 'Content' )->tag('mall_categorys')
                    ->filter ( 'type', 'eic', 'mall_categorys')
                    ->filter ( 'my.supplierid', '=', $supplierid)
                    ->filter ( 'my.pid', '=', $categoryid)
                    ->begin()
                    ->end(-1)
                    ->execute ();
                if (count($mall_categorys) > 0)
                {
                    $categorys = array();
                    $categorys[] = $categoryid;
                    foreach($mall_categorys as $mall_category_info)
                    {
                        $categorys[] = $mall_category_info->id;
                    }
                    $newcontent->my->add('categorys',$categorys);
                }
                else
                {
                    $newcontent->my->add('categorys',$categoryid);
                }
            }

            if ($order == "published")
            {
                $newcontent->my->add('orderby',"default"); //sequence,praise,shop_price,categorys,salevolume
                $newcontent->my->add('sort',"DESC"); //DESC,ASC,DESC_NUMBER,ASC_NUMBER
            }
            else if ($order == "price")
            {
                if ($sort == "desc")
                {
                    $newcontent->my->add('orderby',"shop_price");
                    $newcontent->my->add('sort',"DESC");
                }
                else
                {
                    $newcontent->my->add('orderby',"shop_price");
                    $newcontent->my->add('sort',"ASC");
                }
            }
            else if ($order == "salevalue")
            {
                if ($sort == "desc")
                {
                    $newcontent->my->add('orderby',"salevolume");
                    $newcontent->my->add('sort',"DESC");
                }
                else
                {
                    $newcontent->my->add('orderby',"salevolume");
                    $newcontent->my->add('sort',"ASC");
                }
            }
            else if ($order == "praise")
            {
                if ($sort == "desc")
                {
                    $newcontent->my->add('orderby',"praise");
                    $newcontent->my->add('sort',"DESC");
                }
                else
                {
                    $newcontent->my->add('orderby',"praise");
                    $newcontent->my->add('sort',"ASC");
                }
            }
            $mall_products = $newcontent->save("mall_products"); //存储缓存标签


        }
        catch(XN_Exception $e){
            $mall_products	= array();
        }
    }
    else
    {

        global $int1;
        global $int2;
        if($int1 != 0 & $int2 !=0){
//        var_dump(2222222222);die;
            //执行筛选的sql,如果值不为零，执行筛选
            $query = XN_Query::create ( 'Content' )->tag('mall_products')
                ->filter ( 'type', 'eic', 'mall_products')
                ->filter ( 'my.hitshelf', '=', 'on')
                ->filter ('my.shop_price ', '>',$int1)
                ->filter ('my.shop_price ', '<',$int2)
                ->filter ( 'my.supplierid', '=', $supplierid)
                ->begin($begin)
                ->end($end);

        }
        //当值为空的时候遍历所有的商品
        if($int1 == 0 & $int2 ==0){
//        var_dump(1111111111111);die;
            $query = XN_Query::create ( 'Content' )->tag('mall_products')
                ->filter ( 'type', 'eic', 'mall_products')
                ->filter ( 'my.hitshelf', '=', 'on')
                ->filter ( 'my.supplierid', '=', $supplierid)
                ->begin($begin)
                ->end($end);
        }




        if (isset($categoryid) && $categoryid != "")
        {
            $mall_categorys = XN_Query::create ( 'Content' )->tag('mall_categorys')
                ->filter ( 'type', 'eic', 'mall_categorys')
                ->filter ( 'my.supplierid', '=', $supplierid)
                ->filter ( 'my.pid', '=', $categoryid)
                ->begin()
                ->end(-1)
                ->execute ();
//            $json = json_encode($mall_categorys);
//            print_r($mall_categorys);die;
            if (count($mall_categorys) > 0)
            {
                $categorys = array();
                $categorys[] = $categoryid;
                foreach($mall_categorys as $mall_category_info)
                {
                    $categorys[] = $mall_category_info->id;
                }
                $query->filter ( 'my.categorys', 'in', $categorys);
            }
            else
            {
                $query->filter ( 'my.categorys', '=', $categoryid);
            }

        }
        if ($order == "published")
        {
            $query->order("published",XN_Order::DESC);
        }
        else if ($order == "price")
        {
            if ($sort == "desc")
            {
                $query->order("my.shop_price",XN_Order::DESC_NUMBER);
            }
            else
            {
                $query->order("my.shop_price",XN_Order::ASC_NUMBER);
            }
        }
        else if ($order == "salevalue")
        {
            if ($sort == "desc")
            {
                $query->order("my.salevolume",XN_Order::DESC_NUMBER);
            }
            else
            {
                $query->order("my.salevolume",XN_Order::ASC_NUMBER);
            }
        }
        else if ($order == "praise")
        {
            if ($sort == "desc")
            {
                $query->order("my.praise",XN_Order::DESC_NUMBER);
            }
            else
            {
                $query->order("my.praise",XN_Order::ASC_NUMBER);
            }
        }

        $mall_products	= $query->execute ();
    }



    $productids = array();
    if (count($mall_products) == 0)
    {
        return array();
    }


    $brandids=array();
    foreach($mall_products as $product_info)
    {
        $brandids[] = $product_info->my->brand;;
    }

    $brands=array();
    if(count($brandids) > 0)
    {
        $brand_contents = XN_Content::loadMany(array_unique($brandids),"mall_brands");
        foreach($brand_contents as $brand_info)
        {
            $brandid = $brand_info->id;
            $brands[$brandid]['brand_logo'] = $brand_info->my->brand_logo;
            $brands[$brandid]['brand_name'] = $brand_info->my->brand_name;
        }
    }
    $praise_productids = array();
    foreach($newproductids as $productid)
    {
        $praise_productids[] = "praises_".$productid;
    }
    $praisesconfig = XN_MemCache::getmany($praise_productids);

    $productinfos = array();

    $index = 0;
    foreach($mall_products as $product_info)
    {
        if($product_info->my->hitshelf=='on' && $product_info->my->deleted=='0')
        {
            $productlogo = $APISERVERADDRESS.$product_info->my->productlogo."?width=".$_SESSION['width'];
            $productid = $product_info->id;
            $brandid = $product_info->my->brand;
            $productinfos[$index]['productid'] = $productid;
            $productinfos[$index]['productlogo'] = $productlogo;
            $productinfos[$index]['keywords'] = $product_info->my->keywords;
            $productinfos[$index]['market_price'] = number_format($product_info->my->market_price,2,".","");
            $productinfos[$index]['shop_price'] = number_format($product_info->my->shop_price,2,".","");
            $productinfos[$index]['productname'] = $product_info->my->productname;
            $productinfos[$index]['description'] = $product_info->my->description;
            $productinfos[$index]['simple_desc'] = $product_info->my->simple_desc;
            $productinfos[$index]['product_weight'] = $product_info->my->product_weight;
            $productinfos[$index]['weight_unit'] = $product_info->my->weight_unit;
            $productinfos[$index]['brand'] = $product_info->my->brand;
            $productinfos[$index]['categorys'] = $product_info->my->categorys;
            $productinfos[$index]['supplierid'] = $product_info->my->supplierid;
            $productinfos[$index]['salevolume'] = $product_info->my->salevolume;
            $praise = intval($product_info->my->praise);
            if ($praise < 1) $praise = 1;
            $productinfos[$index]['praise'] = intval($product_info->my->praise);
            if (is_array($brands[$brandid]))
            {
//                var_dump(11111111111);die;
                $productinfos[$index]['brand_logo'] = $brands[$brandid]['brand_logo'];
                $productinfos[$index]['brand_name'] = $brands[$brandid]['brand_name'];
            }
            else
            {
                $productinfos[$index]['brand_logo'] = "/images/brand_logo.png";
                $productinfos[$index]['brand_name'] = "";
            }
            if (isset($praisesconfig["praises_".$productid]))
            {
                $productinfos[$index]['praise'] = $praisesconfig["praises_".$productid];
            }
            $index = $index + 1;
//            var_dump($index);die;
        }
    }

    return $productinfos;
}

?>