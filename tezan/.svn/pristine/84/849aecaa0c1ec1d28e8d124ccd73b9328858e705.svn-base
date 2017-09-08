
<?php
require_once('modules/Mall_Categorys/utils.php');
global  $currentModule, $current_user,$supplierid,$supplierusertype;
if(isset($_SESSION['supplierid']) && $_SESSION['supplierid'] !='')
{
	$supplierid = $_SESSION['supplierid'];
	$supplierusertype = $_SESSION['supplierusertype'];
}
else
{
	$supplier_users = XN_Query::create ( 'Content' ) ->tag('supplier_users')
		->filter ( 'type', 'eic', 'supplier_users')
		->filter ( 'my.deleted', '=', '0' )
		->filter ( 'my.profileid', '=' ,XN_Profile::$VIEWER)
		->execute();
	if (count($supplier_users) > 0)
	{
		$supplier_users_info = $supplier_users[0];
		$supplierid = $supplier_users_info->my->supplierid;
		$supplierusertype = $supplier_users_info->my->supplierusertype;
		$_SESSION['supplierid'] = $supplierid;
		$_SESSION['supplierusertype'] = $supplierusertype;
	}
	else
	{
		echo '没有商家supplierid';
		die();
	}
}



/*


for($i=0;$i<100;$i++)
{ 
	$mall_categorys = XN_Query::create ( 'Content' )
	 	->filter('type','eic','mall_categorys') 
		->begin(0)
		->end(100)
 	    ->execute();  
	if (count($mall_categorys) > 0)
	{
		XN_Content::delete($mall_categorys,'mall_categorys,mall_categorys_'.$supplierid); 
	}
	else
	{
		break;
	} 
}*/


$category_one_level_configs = array(
	array('name' => '您的分系',
		'categoryicon' => '/images/categorys/shoujishuma.jpg',
		'children' => array(),
	),

);
$category_one_level_configs = array(
	array('name' => '您的分系',
		'categoryicon' => '/images/categorys/shoujishuma.jpg',
		'children' => array(),
	),

);

$category_configs = array(
array('name' => '手机数码',
      'categoryicon' => '/images/categorys/shoujishuma.jpg',
      'children' => array(
			array('name' => '手机','categoryicon' => '/images/categorys/shoujishuma/shouji.jpg'),
		    array('name' => '相机摄像','categoryicon' => '/images/categorys/shoujishuma/xiangjishexiang.jpg'),
		    array('name' => '手机配件','categoryicon' => '/images/categorys/shoujishuma/shoujipeijian.jpg'), 
		    array('name' => '数码配件','categoryicon' => '/images/categorys/shoujishuma/shumapeijian.jpg'), 
		    array('name' => '平板电脑','categoryicon' => '/images/categorys/shoujishuma/pingbandiannao.jpg'), 
		    array('name' => '笔记本','categoryicon' => '/images/categorys/shoujishuma/bijiben.jpg'), 
		    array('name' => '电脑硬件','categoryicon' => '/images/categorys/shoujishuma/diannaoyingjian.jpg'), 
		    array('name' => '台式机','categoryicon' => '/images/categorys/shoujishuma/taishiji.jpg'), 
		   ),
      ),
array('name' => '护肤用品',
      'categoryicon' => '/images/categorys/hufuyongpin.jpg',
      'children' => array(
			array('name' => '护肤用品','categoryicon' => '/images/categorys/hufuyongpin/hufuyongpin.jpg'),
		    array('name' => '美甲','categoryicon' => '/images/categorys/hufuyongpin/meijia.jpg'), 
		    array('name' => '美容用品','categoryicon' => '/images/categorys/hufuyongpin/meirongyongpin.jpg'), 
		    array('name' => '护理保健','categoryicon' => '/images/categorys/hufuyongpin/hulibaojian.jpg'), 
		    array('name' => '男士护肤','categoryicon' => '/images/categorys/hufuyongpin/nanshihufu.jpg'), 
		    array('name' => '彩妆用品','categoryicon' => '/images/categorys/hufuyongpin/caizhuangyongpin.jpg'),
		    array('name' => '美发产品','categoryicon' => '/images/categorys/hufuyongpin/meifachanpin.jpg'),
			 ), 
      ),
array('name' => '服装内衣',
      'categoryicon' => '/images/categorys/fuzhuangnayi.jpg',
      'children' => array(
			array('name' => '女士上衣','categoryicon' => '/images/categorys/fuzhuangnayi/nvshishangyi.jpg'), 
		    array('name' => '女士裤装','categoryicon' => '/images/categorys/fuzhuangnayi/nvshikuzhuang.jpg'), 
		    array('name' => '女士内衣','categoryicon' => '/images/categorys/fuzhuangnayi/nvshinayi.jpg'), 
		    array('name' => '职业女装','categoryicon' => '/images/categorys/fuzhuangnayi/zhiyenvzhuang.jpg'), 
		    array('name' => '商务男装','categoryicon' => '/images/categorys/fuzhuangnayi/shangwunanzhuang.jpg'), 
		    array('name' => '应季男装','categoryicon' => '/images/categorys/fuzhuangnayi/yingjinanzhuang.jpg'),
		    array('name' => '男士裤装','categoryicon' => '/images/categorys/fuzhuangnayi/nanshikuzhuang.jpg'),
			array('name' => '男士内衣','categoryicon' => '/images/categorys/fuzhuangnayi/nanshinayi.jpg'),
			 ),
      ), 
array('name' => '母婴用品',
      'categoryicon' => '/images/categorys/muyingyongpin.jpg',
      'children' => array(
			array('name' => '婴幼食品','categoryicon' => '/images/categorys/muyingyongpin/yingyoushipin.jpg'), 
		    array('name' => '婴幼用品','categoryicon' => '/images/categorys/muyingyongpin/yingyouyongpin.jpg'), 
		    array('name' => '早教玩具','categoryicon' => '/images/categorys/muyingyongpin/zaojiaowanju.jpg'), 
		    array('name' => '婴童服装','categoryicon' => '/images/categorys/muyingyongpin/yingtongfuzhuang.jpg'), 
		    array('name' => '童鞋配饰','categoryicon' => '/images/categorys/muyingyongpin/tongxiepeishi.jpg'), 
		    array('name' => '孕妇新妈','categoryicon' => '/images/categorys/muyingyongpin/yunfuxinma.jpg'), 
			 ),
      ),
array('name' => '美食特产',
      'categoryicon' => '/images/categorys/meishitechan.jpg',
      'children' => array(
			array('name' => '巧克力','categoryicon' => '/images/categorys/meishitechan/qiaokeli.jpg'), 
		    array('name' => '休闲零食','categoryicon' => '/images/categorys/meishitechan/xiuxianlingshi.jpg'), 
		    array('name' => '营养保健','categoryicon' => '/images/categorys/meishitechan/yingyangbaojian.jpg'), 
		    array('name' => '参茸滋补','categoryicon' => '/images/categorys/meishitechan/canrongzibu.jpg'), 
		    array('name' => '茶叶','categoryicon' => '/images/categorys/meishitechan/chaye.jpg'),
		    array('name' => '全球美食','categoryicon' => '/images/categorys/meishitechan/quanqiumeishi.jpg'), 
		    array('name' => '干果坚果','categoryicon' => '/images/categorys/meishitechan/ganguojianguo.jpg'), 
		    array('name' => '粮油米面','categoryicon' => '/images/categorys/meishitechan/liangyoumimian.jpg'),
			 ), 
      ),
array('name' => '日用百货',
      'categoryicon' => '/images/categorys/riyongbaihuo.jpg',
      'children' => array(
			array('name' => '毛绒玩具','categoryicon' => '/images/categorys/riyongbaihuo/maorongwanju.jpg'), 
		    array('name' => '杯子水具','categoryicon' => '/images/categorys/riyongbaihuo/beizishuiju.jpg'), 
		    array('name' => '烹饪餐具','categoryicon' => '/images/categorys/riyongbaihuo/pengrencanju.jpg'), 
		    array('name' => '烘焙烧烤','categoryicon' => '/images/categorys/riyongbaihuo/hongbeishaokao.jpg'), 
		    array('name' => '居家用品','categoryicon' => '/images/categorys/riyongbaihuo/jujiayongpin.jpg'), 
		    array('name' => '家务清洁','categoryicon' => '/images/categorys/riyongbaihuo/jiawuqingjie.jpg'), 
		    array('name' => '储物收纳','categoryicon' => '/images/categorys/riyongbaihuo/chuwushouna.jpg'), 
		    array('name' => '烟酒具','categoryicon' => '/images/categorys/riyongbaihuo/yanjiuju.jpg'), 
			array('name' => '卫浴日化','categoryicon' => '/images/categorys/riyongbaihuo/weiyurihua.jpg'),
			array('name' => '成人用品','categoryicon' => '/images/categorys/riyongbaihuo/chengrenyongpin.jpg'),
			 ),
       ),  
array('name' => '家电办公',
      'categoryicon' => '/images/categorys/jiadianbangong.jpg',
      'children' => array(
			array('name' => '大家电','categoryicon' => '/images/categorys/jiadianbangong/dajiadian.jpg'), 
		    array('name' => '生活电器','categoryicon' => '/images/categorys/jiadianbangong/shenghuodianqi.jpg'), 
		    array('name' => '影音电器','categoryicon' => '/images/categorys/jiadianbangong/yingyindianqi.jpg'), 
		    array('name' => '办公文具','categoryicon' => '/images/categorys/jiadianbangong/bangongwenju.jpg'), 
		    array('name' => '厨房电器','categoryicon' => '/images/categorys/jiadianbangong/chufangdianqi.jpg'),  
			 ),
      ),  
array('name' => '家纺居家',
      'categoryicon' => '/images/categorys/jiafangjujia.jpg',
      'children' => array(
			array('name' => '客厅家俱','categoryicon' => '/images/categorys/jiafangjujia/ketingjiaju.jpg'),
		    array('name' => '工艺饰品','categoryicon' => '/images/categorys/jiafangjujia/gongyishipin.jpg'), 
		    array('name' => '床上用品','categoryicon' => '/images/categorys/jiafangjujia/chuangshangyongpin.jpg'), 
		    array('name' => '居家布艺','categoryicon' => '/images/categorys/jiafangjujia/jujiabuyi.jpg'), 
		    array('name' => '卧室家俱','categoryicon' => '/images/categorys/jiafangjujia/woshijiaju.jpg'),  
			 ),
       ), 
array('name' => '鞋包配饰',
      'categoryicon' => '/images/categorys/xiebaopeishi.jpg',
      'children' => array(
			array('name' => '女鞋','categoryicon' => '/images/categorys/xiebaopeishi/nvxie.jpg'), 
		    array('name' => '潮流女包','categoryicon' => '/images/categorys/chaoliunvbao/chaoliunvbao.jpg'), 
		    array('name' => '女式配件','categoryicon' => '/images/categorys/xiebaopeishi/nvshipeijian.jpg'),
		    array('name' => '男鞋','categoryicon' => '/images/categorys/xiebaopeishi/nanxie.jpg'),
		    array('name' => '男包','categoryicon' => '/images/categorys/xiebaopeishi/nanbao.jpg'),
		    array('name' => '男士配件','categoryicon' => '/images/categorys/xiebaopeishi/nanshipeijian.jpg'), 
		    array('name' => '旅行箱包','categoryicon' => '/images/categorys/xiebaopeishi/lvxingxiangbao.jpg'), 
			 ), 
      ),  
array('name' => '运动户外',
      'categoryicon' => '/images/categorys/yundonghuwai.jpg',
      'children' => array(
			array('name' => '运动鞋','categoryicon' => '/images/categorys/yundonghuwai/yundongxie.jpg'), 
		    array('name' => '运动休闲服','categoryicon' => '/images/categorys/yundonghuwai/yundongxiuxianfu.jpg'), 
		    array('name' => '户外用品','categoryicon' => '/images/categorys/yundonghuwai/chuangshangyongpin.jpg'), 
		    array('name' => '健身用品','categoryicon' => '/images/categorys/yundonghuwai/jianshenyongpin.jpg'),
		    array('name' => '运动包配','categoryicon' => '/images/categorys/yundonghuwai/yundongbaopei.jpg'), 
			 ),
      ),  
array('name' => '珠宝手表',
      'categoryicon' => '/images/categorys/zhubaoshoubiao.jpg',
      'children' => array(
			array('name' => '珠宝饰品','categoryicon' => '/images/categorys/zhubaoshoubiao/zhubaoshipin.jpg'), 
		    array('name' => '流行饰品','categoryicon' => '/images/categorys/zhubaoshoubiao/liuxingshipin.jpg'), 
		    array('name' => '眼镜','categoryicon' => '/images/categorys/zhubaoshoubiao/yanjing.jpg'), 
		    array('name' => '手表','categoryicon' => '/images/categorys/zhubaoshoubiao/shoubiao.jpg'),  
			 ),  
	  ),  
);

$categorys = XN_Query::create('Content')
	->tag('mall_categorys')
	->filter('type', 'eic', 'mall_categorys')
	//->filter ( 'my.supplierid', '=', $supplierid )
	->filter ( 'my.pid',"<>","")
	->filter('my.deleted', '=', '0')
	->end(-1)
	->execute();
if (count($categorys) == 0)
{
	if (count($categorys) == 0)
	{
		$mainsequence = 100;
		foreach($category_configs as  $category_info)
		{
			$mainname = $category_info['name'];
			$categoryicon = $category_info['categoryicon'];
			$newcontent = XN_Content::create('mall_categorys','',false);
			$newcontent->my->deleted = '0';
			$newcontent->my->sequence = $mainsequence;
			$newcontent->my->categoryname = $mainname;
			$newcontent->my->categoryicon = $categoryicon;
			$newcontent->my->supplierid = 0;
			$newcontent->my->pid = '0';
			$newcontent->save('mall_categorys,mall_categorys_'.$supplierid);
			$childsequence = 100;
			$pid = $newcontent->id;
			$mainsequence += 1;
			$childcategory = $category_info['children'];
			foreach($childcategory as $childcategory_info)
			{
				$name = $childcategory_info['name'];
				$categoryicon = $childcategory_info['categoryicon'];
				$newcontent = XN_Content::create('mall_categorys','',false);
				$newcontent->my->deleted = '0';
				$newcontent->my->sequence = $childsequence;
				$newcontent->my->categoryname = $name;
				$newcontent->my->categoryicon = $categoryicon;
				$newcontent->my->businesseid = $businesseid;
				$newcontent->my->supplierid = 0;
				$newcontent->my->pid = $pid;
				$newcontent->save('mall_categorys,mall_categorys_'.$supplierid);
				$childsequence += 1;
			}
		}
	}
	getCategoryStructure(null, null, true);
}
if (isset($_REQUEST['loadtree']) && $_REQUEST['loadtree'] == "true")
{
	echo getCategoryTree();
	die();
}
global $currentModule, $current_user;
global $app_strings, $mod_strings;
require_once('modules/'.$currentModule.'/'.$currentModule.'.php');
require_once('Smarty_setup.php');
$smarty = new vtigerCRM_Smarty;

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE", $currentModule);
$smarty->assign("MODULENAME", "商品分类管理");
if($supplierid != ""){
	$smarty->assign("CUSTOMCATEGORYTREE", "1");
}
$smarty->display('TezanCategorys/CategorysManager.tpl');


function getCategoryTree()
{
	global $current_user, $supplierusertype,$supplierid;
	$hrarray         = array ();
	$customcategorys = null;
	$canCustom       = false;
	/**
	 * 获取自定义分类树
	 */
	if ($supplierid=="0" || $supplierid=="")
	{
		getCustomCategorys("0", $hrarray);
	}
	else
	{
		getCustomCategorys($supplierid, $hrarray);
	}

	$roleout = '';
	createGenericCategoryTree($roleout, $hrarray, null, null, false, true);
	$ztree = '<ul id="categorymanager-ztree" class="ztree"
                    data-setting="{callback:{beforeExpand:CategoryManager_OnBeforeExpand}}"
                    data-on-click="CategoryManager_onClick"
					data-toggle="ztree"
					';
	if ($supplierid != "")
	{
		$ztree .= '
					data-add-hover-dom = "CategoryManager_addHoverDom"
					data-remove-hover-dom = "CategoryManager_removeHoverDom"
					data-before-drop = "CategoryManager_beforeDrop"
					data-on-drop = "CategoryManager_onDrop"
					data-edit-enable = "true"
					data-on-node-created = "CategoryManager_onNodeCreated"
					data-on-collapse = "CategoryManager_CollapseTreeNode"
					data-on-expand = "CategoryManager_ExpandTreeNode"
			';
	}
	elseif ($canCustom)
	{
		$ztree .= '
				data-add-hover-dom = "CustomCategoryManager_addHoverDom"
				data-remove-hover-dom = "CustomCategoryManager_removeHoverDom"
				';

	}
	$ztree .= 'data-expand-all="false">'.$roleout.'</ul>';
	return $ztree;
}

function getCustomCategorys($reguseid, &$hrarray)
{
	$customcategorys = XN_Query::create('Content')
		->tag('mall_categorys')
		->filter('type', 'eic', 'mall_categorys')
		->filter('my.deleted', '=', '0')
		->filter('my.pid', '=', '0')
		->filter('my.supplierid', '=', $reguseid)
		->execute();
	if (is_null($customcategorys) || count($customcategorys) <= 0)
	{
		$supplier     = XN_Content::load($reguseid, "suppliers");
		$suppliername = $supplier->my->suppliername;
		$newcontent   = XN_Content::create("mall_categorys", "", false);
		$newcontent->my->deleted = '0';
		$newcontent->my->pid = '0';
		$newcontent->my->supplierid = $reguseid;
		$newcontent->my->categoryname = $suppliername;
		$newcontent->my->sequence = '1';
		$newcontent->save('mall_categorys,mall_categorys_'.$reguseid);
	}
	$customcategorys = XN_Query::create('Content')
		->tag('mall_categorys')
		->filter('type', 'eic', 'mall_categorys')
		->filter('my.deleted', '=', '0')
		->filter('my.pid', '<>', '')
		->filter('my.supplierid', '=', $reguseid)
		->order('my.sequence', XN_Order::ASC_NUMBER)
		->end(-1)
		->execute();

	if (isset($customcategorys) && count($customcategorys) > 0)
	{
		foreach ($customcategorys as $customcategory)
		{
			$hrarray[$customcategory->id] = array (
				'key'      => $customcategory->id,
				'name'     => $customcategory->my->categoryname,
				"categoryicon"=>$customcategory->my->categoryicon,
				'sequence' => $customcategory->my->sequence,
				'value'    => $customcategory->my->pid == '' ? 'root' : $customcategory->id,
				'parentid' => $customcategory->my->pid);
		}
	}
}

?>
 
