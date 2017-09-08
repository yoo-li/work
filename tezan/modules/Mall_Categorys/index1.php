 
<?php

global  $supplierid,$supplierusertype;

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
/*	  
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
);*/
 

$categorys = XN_Query::create ( 'Content' )
		   ->tag ( 'mall_categorys' )
		   ->filter ( 'type', 'eic', 'mall_categorys' )
		   ->filter ( 'my.supplierid', '=', $supplierid )
		   ->filter ( 'my.deleted', '=', '0' )
		   ->end(1)
		   ->execute ();

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
				$newcontent->my->supplierid = $supplierid;
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
					$newcontent->my->supplierid = $supplierid;
					$newcontent->my->pid = $pid;
					$newcontent->save('mall_categorys,mall_categorys_'.$supplierid);
					$childsequence += 1;
				}
		}
}

 
$html = '
<link rel="stylesheet" href="/Public/css/zTreeStyle/zTreeStyle.css" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.ztree.core-3.1.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.ztree.exedit-3.1.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.ztree.excheck-3.1.min.js"></script>
<script type="text/javascript" src="/modules/Mall_Categorys/Mall_Categorys.js"></script>

<script>
	hint_arr={
		       LBL_CATEGORY_NAME_EMPTY:"分类名称不能为空",
		       MISSING_CATEGORY_NOT_EMPTY:"{$MOD.MISSING_CATEGORY_NOT_EMPTY}",
		       MISSING_CATEGORY_MOVE_NODE:"{$MOD.MISSING_CATEGORY_MOVE_NODE}",
		       MISSING_CATEGORY_MOVE_NOT_CHILD:"{$MOD.MISSING_CATEGORY_MOVE_NOT_CHILD}",
		       LBL_SAVE_BUTTON_LABEL:"保存",
		       LBL_CANCEL_BUTTON_LABEL:"取消",
		       LBL_DELETE_TREEID:"{$MOD.LBL_DELETE_TREEID}",		      
		       LBL_CURRENT_NODE:"{$MOD.LBL_CURRENT_NODE}",
		       LBL_NEW_BUTTON_LABEL:"新建",
		       LBL_EDIT_BUTTON_LABEL:"编辑",
		       LBL_DELETE_BUTTON_LABEL:"删除"
		};
function addcategorys(){
	var ajaxurl = "index.php?module=Mall_Categorys&action=EditView&pid=0";	
	jQuery.pdialog.open(ajaxurl,"CreateCategory","新建分类",{width:700,height:380,mask:true});
}




</script>
	<h2 class="contentTitle">商品分类管理<div style="float:right;padding-top:2px;">';
	
	
	
if ($supplierusertype=='boss'){
	$html .='<div class="button" ><div class="buttonContent"><button onclick="addcategorys();">新建顶级分类</button></div></div><div style="float:left;">&nbsp;&nbsp;&nbsp;</div>';
}
$html .= '</h2>
<div class="pageContent">
	<div class="pageFormContent" layoutH="0">	
			<div id="CategoryRoleTreeFull" >
					  <ul id="categorys_tree" class="ztree" style=""></ul>
					  <div style="height:30px">&nbsp;</div>
			</div>
	</div>
	
</div>

';
if ($supplierusertype == "boss"){
    $html .= '
<script language="javascript" type="text/javascript">
	loadCmsCategoryTree();						
</script>
';
}else{
	$html .= '
<script language="javascript" type="text/javascript">
	loadCategoryTree();						
</script>
	';
}

echo $html; 
	

?>
 
