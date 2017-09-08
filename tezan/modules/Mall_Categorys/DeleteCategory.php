<?php


if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && isset($_REQUEST['type']) && $_REQUEST['type'] == 'submit')
{
    if(isset($_REQUEST['categoryshift']) && $_REQUEST['categoryshift'] != '' ){
		global  $supplierid,$supplierusertype;
		$record = $_REQUEST['record'];
		$categoryArray = GetCategory($record,0,'');
		$deltree[] = $record;
		foreach($categoryArray as $key=>$value){
		    $deltree[] = str_replace('"',"",$key);
		}
		$query = XN_Query::create('Content')->tag('mall_products')
		  ->filter('type','eic','mall_products')
		  ->filter('my.categorys','in',$deltree)
		  ->execute();
		foreach ($query as $info){
		    $info->my->categorys = $_REQUEST['categoryshift'];
		}
		XN_Content::batchsave($query,"mall_products");
		try{
		    $loadcontent = XN_Content::loadMany($deltree,'mall_categorys');
		    foreach ($loadcontent as $info){
		        $info->my->deleted = "1";
		        $info->save("mall_categorys,mall_categorys_".$supplierid);
		    }
			XN_MemCache::delete("Mall_CategoryStructureProductsCount");
		}catch(XN_Exception $ex){
		    echo '{"statusCode":300,"message":"删除分类出错！"}';
		    die();
		}
		XN_MemCache::delete("supplier_" . $supplierid);
		echo '{	"statusCode":"200","message":"删除成功！相关数据已转移至指定分类！","tabid":"Mall_Categorys","closeCurrent":true,"forward":null}';
		die();
    }else{
        echo '{"statusCode":300,"message":"指定的分类转移无效！"}';
        die();
    }
}
elseif(isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{
		$record = $_REQUEST['record'];

		$loadcontent = XN_Content::load($record,'mall_categorys');
		$parent = $loadcontent->my->pid;
		$categoryname = $loadcontent->my->categoryname;
		
		$categoryArray = GetCategory(0,0,$record);
		$categoryOption = '<option value=""></option>';
		foreach ($categoryArray as $key => $value){
		  $categoryOption .= '<option value='.$key.'>'.$value.'</option>';
		}
		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');

		global  $currentModule;
		$smarty = new vtigerCRM_Smarty;
/*
		$msg .=  '<div class="form-group">
						<label class="control-label x120">栏目名称:</label>
						<div>'.$categoryname.'</div>
				 </div>
				<div class="form-group">
						<label class="control-label x120">排序:</label>
						<div>'.$sequence.'</div>
				 </div>';
*/
		$msg =  '<div class="form-group">
                <label class="control-label x120">分类名称:</label>
				<input id="categoryname" name="categoryname" type="text" readonly value="'.$categoryname.'" class="input readonly required">
            </div>';
		
		$msg .= '<div class="form-group">
                <label class="control-label x120">分类转移:</label>
				<select id="categoryshift" name="categoryshift" class="required" style="cursor: pointer;width:135px;">'.$categoryOption.'</select>
            </div> ';
		

		$smarty->assign("APP", $app_strings);
		$smarty->assign("RECORD", $record);
		$smarty->assign("CMOD", $mod_strings);
		$smarty->assign("MSG", $msg);
		$smarty->assign("SUBMODULE", "Mall_Categorys");
		$smarty->assign("OKBUTTON", "确定删除");
		$smarty->assign("SUBACTION", "DeleteCategory");

		$smarty->display("MessageBox.tpl");
}

function GetCategory($pid,$depth,$exclude){
    $excludes = explode(',', $exclude);
	global  $supplierid;
    $categorys = XN_Query::create ( 'Content' )
		->tag('mall_categorys')
    	->filter ( 'type', 'eic', 'mall_categorys')
    	->filter ( 'my.deleted', '=', 0)
    	->filter ( 'my.supplierid', '=', $supplierid)
    	->filter ( 'my.pid', '=', $pid)
    	->order("my.sequence",XN_Order::ASC_NUMBER)
    	->end(-1)
    	->execute();
    $categoryOption = array();
    $Prefix = "";
    if($depth>0){
        $Prefix = "　┣━";
        for($i=2;$i<=$depth;$i++){
            $Prefix .= "━";
        }
    }
    foreach ($categorys as $info){
        if(!in_array($info->id,$excludes)){
            $categoryOption['"'.$info->id.'"'] = $Prefix . $info->my->categoryname;
            $categoryOption = array_merge($categoryOption,GetCategory($info->id,$depth+1,$exclude));
        }
    }
    return $categoryOption;
}

?>