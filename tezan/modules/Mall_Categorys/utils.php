<?php

	/**
	 * 创建分类树结构,方便过滤没有商品的分类
	 * @param string $root      根节点ID
	 * @param bool   $isRefresh 是否刷新数据缓存
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getCategoryStructure($root = null, $categorys = null, $isRefresh = false)
	{
		$Structre = array ();
		if ($isRefresh === true)
		{
			XN_MemCache::delete("CategoryStructure");
		}
		try
		{
			if (!isset($root) || empty($root))
			{
				$Structre = XN_MemCache::get("CategoryStructure");
			}
			else
			{
				throw new XN_Exception("取子节点数据");
			}
		}
		catch (XN_Exception $e)
		{
			if (!isset($root) && empty($root))
			{
				$root = '0';
			}
			$Structre = getCategoryStructureFromDB($root);
			XN_MemCache::put($Structre, "CategoryStructure");
		}
		return $Structre;
	}

	/**
	 * 根据根结点获取子结点
	 * @param string $pid
	 * @param        $categorys
	 * @return Generator
	 */
	function getSubCategoryStructure($pid = '0', $categorys)
	{
		if (isset($categorys) && !empty($categorys))
		{
			foreach ($categorys as $index=>$category_info)
			{
				if ($category_info["pid"] != $pid)
				{
					unset($categorys[$index]);
				}
			}
		}
		return $categorys;
	}
	function getSubCategoryStructureYield($pid = '0', $categorys)
	{
		if (isset($categorys) && !empty($categorys))
		{
			foreach ($categorys as $index=>$category_info)
			{
				/*
				if ($category_info["pid"] == $pid)
				{
					yield $category_info;
				}
				*/
			}
		}
		return $categorys;
	}
	/**
	 * 从数据库获取分类结构
	 * @param string $pid
	 * @param null   $Categorysinfo
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getCategoryStructureFromDB($pid = '0', $Categorysinfo = null)
	{
		global $supplierid;
		if (!isset($Categorysinfo) || empty($Categorysinfo))
		{
			$categorys = XN_Query::create('Content')
				->tag('mall_categorys')
				->filter('type', 'eic', 'mall_categorys')
				->filter('my.supplierid',"=",$supplierid)
				->filter('my.deleted', '=', '0')
				->order("my.sequence", XN_Order::ASC_NUMBER)
				->end(-1)
				->execute();

			foreach ($categorys as $category_info)
			{
				$Categorysinfo[] = array (
					'xnid'     => $category_info->id,
					'name'     => $category_info->my->categoryname,
					'sequence' => $category_info->my->sequence,
					'icon'     => $category_info->my->categoryicon,
					'pid'      => $category_info->my->pid,
				);
			}
		}
		$Structre = array ();
		foreach (getSubCategoryStructure($pid, $Categorysinfo) as $item)
		{
			$Structre[$item["xnid"]] = array (
				'xnid'     => $item["xnid"],
				'name'     => $item["name"],
				'sequence' => $item["sequence"],
				'parent'   => $item["pid"],
				'icon'     => $item["icon"],
				'children' => getCategoryStructureFromDB($item["xnid"], $Categorysinfo),
			);
		}
		return $Structre;
	}

	/**
	 * 过滤无产品数据的分类
	 * @param array $categorystructure 分类结构数据指针
	 * @param array $products          分类产品数量
	 * @throws XN_IllegalArgumentException
	 */
	function getCategoryStructureByProduct(&$categorystructure = null, $products = null)
	{
		if (!isset($categorystructure) || empty($categorystructure))
			$categorystructure = getCategoryStructure();

		if (!isset($products) || empty($products))
		{
			$productsContent = XN_Query::create('Content_Count')->tag('mall_products')
									   ->filter('type', 'eic', 'mall_products')
									   ->filter('my.deleted', '=', '0')
									   ->rollup()
									   ->group('my.categorys')
									   ->begin(0)->end(-1)
									   ->execute();
			$products        = array ();
			foreach ($productsContent as $info)
			{
				$products[$info->my->subcategorys] = $info->my->count;
			}
		}

		foreach ($categorystructure as $categoryid => $children)
		{
			$childreninfo = $children["children"];
			if (array_key_exists($categoryid, $products))
			{
				if (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
				{
					getCategoryStructureByProduct($childreninfo, $products);
					if (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
					{
						$categorystructure[$categoryid]["children"] = $childreninfo;
					}
					else
					{
						unset($categorystructure[$categoryid]["children"]);
					}
				}
				else
				{
					unset($categorystructure[$categoryid]["children"]);
				}
				$categorystructure[$categoryid]["count"] = $products[$categoryid];
			}
			elseif (isset($childreninfo) && empty($childreninfo))
			{
				unset($categorystructure[$categoryid]);
			}
			else
			{
				if (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
				{
					getCategoryStructureByProduct($childreninfo, $products);
					if (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
					{
						$categorystructure[$categoryid]["children"] = $childreninfo;
					}
					else
					{
						unset($categorystructure[$categoryid]);
					}
				}
				else
				{
					unset($categorystructure[$categoryid]);
				}
			}
		}
	}

	/**
	 * 返回子分类数据
	 * @param null $categorystructure
	 * @param null $cid   父类XN_ID
	 * @param int  $level 获取子类级数,0为全部子类
	 * @return array
	 */
	function getSubCategoryID($level = 0, $cid = null, $categorystructure = null)
	{
		if (!isset($categorystructure) || !is_array($categorystructure))
		{
			$categorystructure = getCategoryStructure();
		}
		$pid = $cid;
		if (!isset($pid) || empty($pid))
		{
			$pid = '0';
		}
		$subCategoryInfo = array ();
		foreach ($categorystructure as $categoryid => $children)
		{
			$childreninfo = $children["children"];
			if ($children["parent"] == $pid)
			{
				$subCategoryInfo[strval($categoryid)]['xnid']     = $children["xnid"];
				$subCategoryInfo[strval($categoryid)]['name']     = $children["name"];
				$subCategoryInfo[strval($categoryid)]['sequence'] = $children["sequence"];
				$subCategoryInfo[strval($categoryid)]['parent']   = $children["parent"];
				$subCategoryInfo[strval($categoryid)]['icon']     = $children["icon"];
				if ($level == 0)
				{
					foreach ($childreninfo as $childid => $ch_info)
					{
						$subCategoryInfo[strval($childid)]['xnid']     = $ch_info["xnid"];
						$subCategoryInfo[strval($childid)]['name']     = $ch_info["name"];
						$subCategoryInfo[strval($childid)]['sequence'] = $ch_info["sequence"];
						$subCategoryInfo[strval($childid)]['parent']   = $ch_info["parent"];
						$subCategoryInfo[strval($childid)]['icon']     = $ch_info["icon"];
						if (isset($ch_info["children"]) && is_array($ch_info["children"]) && count($ch_info["children"]) > 0)
						{
							$subCategoryInfo += getSubCategoryID($level, strval($childid), $ch_info["children"]);
						}
					}
				}
				elseif ($level - 1 > 0)
				{
					foreach ($childreninfo as $childid => $ch_info)
					{
						$subCategoryInfo[strval($childid)]['xnid']     = $ch_info["xnid"];
						$subCategoryInfo[strval($childid)]['name']     = $ch_info["name"];
						$subCategoryInfo[strval($childid)]['sequence'] = $ch_info["sequence"];
						$subCategoryInfo[strval($childid)]['parent']   = $ch_info["parent"];
						$subCategoryInfo[strval($childid)]['icon']     = $ch_info["icon"];
						if ($level - 1 > 1)
						{
							if (isset($ch_info["children"]) && is_array($ch_info["children"]) && count($ch_info["children"]) > 0)
							{
								$subCategoryInfo += getSubCategoryID($level - 1, strval($childid), $ch_info["children"]);
							}
						}
					}
				}
			}
			elseif (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
			{
				$subCategoryInfo += getSubCategoryID($level, strval($pid), $childreninfo);
			}
		}
		return $subCategoryInfo;
	}

	function getParentCategoryID($cid, $categorystructure = null)
	{
		if (!isset($categorystructure) || !is_array($categorystructure))
		{
			$categorystructure = getCategoryStructure();
		}
		$parentids = array ();
		$isFind    = false;
		foreach ($categorystructure as $categoryid => $children)
		{
			$childreninfo = $children["children"];
			if ($categoryid == $cid)
			{
				$isFind = true;
				if ($children["parent"] != "" && $children["parent"] != "0" & $children["parent"] != "root")
				{
					$parentids += getParentCategoryID($children["parent"]);
					$parentids[] = $children["parent"];
				}
			}
			elseif (isset($childreninfo) && is_array($childreninfo) && count($childreninfo) > 0)
			{
				$parentids += getParentCategoryID($cid, $childreninfo);
			}
			if ($isFind)
				break;
		}
		return $parentids;
	}

	/**
	 * 获取有商品信息的分类树结构
	 * @param array $hrarray   传出的数据结构
	 * @param null  $rootlabel 创建总根节点的名称
	 * @param null  $categorys 包含商品信息的分类数据
	 */
	function getProductCategoryTree(&$hrarray, $rootlabel = null, $categorys = null)
	{
		if (empty($categorys))
		{
			try{
				$categorys = XN_MemCache::get("CategoryStructureProductsTree");
			}catch(XN_Exception $e){
				getCategoryStructureByProduct($categorys);
				XN_MemCache::put($categorys,"CategoryStructureProductsTree");
			}
		}
		if (count($categorys) > 0)
		{
			if (isset($rootlabel) && !empty($rootlabel))
			{
				$hrarray["root"] = array ('key'      => "root",
										  'name'     => $rootlabel,
										  'sequence' => "1",
										  'parentid' => "");
			}
			foreach ($categorys as $categorid => $category_info)
			{
				$pid = $category_info["parent"];
				if (!isset($pid) || $pid == '0')
				{
					$pid = '';
				}
				if (isset($rootlabel) && !empty($rootlabel) && $pid == '')
				{
					$pid = "root";
				}
				$hrarray[$categorid] = array ('key'      => $categorid,
											  'name'     => $category_info["name"],
											  'sequence' => $category_info["sequence"],
											  'parentid' => $pid);
				if (isset($category_info["children"]) && is_array($category_info["children"]) && count($category_info["children"]) > 0)
				{
					getProductCategoryTree($hrarray, null, $category_info["children"]);
				}
			}
		}
		else
		{
			$hrarray = $categorys;
		}
	}

	/**
	 * 获取分类信息
	 * @param $cid
	 * @return array
	 */
	function getCategoryInfo($cid)
	{
		$category_info = array ();
		try
		{
			$loadcontent               = XN_Content::load($cid, 'mall_categorys');
			$category_info["parent"]   = $loadcontent->my->pid;
			$category_info["name"]     = $loadcontent->my->categoryname;
			$category_info["sequence"] = $loadcontent->my->sequence;
			$category_info["icon"]     = $loadcontent->my->categoryicon;
			$category_info['connent']  = $loadcontent;
		}
		catch (XN_Exception $e)
		{
		}
		return $category_info;
	}

	/**
	 * 获取通用分类树结构信息
	 * @param null $rootlabel
	 * @return array
	 * @throws XN_IllegalArgumentException
	 */
	function getGenericCategoryTree($rootlabel = null)
	{
		global $supplierid;
		$hrarray   = array ();
		$categorys = XN_Query::create('Content')->tag('mall_categorys')
			->filter('type', 'eic', 'mall_categorys')
			->filter('my.deleted', '=', '0')
			->filter("my.pid","<>","")
			->filter("my.supplierid","=",$supplierid)
			->order("my.sequence", XN_Order::ASC_NUMBER)
			->end(-1)
			->execute();
		if ($categorys > 0)
		{
			if (isset($rootlabel) && !empty($rootlabel))
			{
				$hrarray["root"] = array ('key'      => "root",
										  'name'     => $rootlabel,
										  'value'    => "root",						
										  'sequence' => "1",
										  'parentid' => "");
			}
			foreach ($categorys as $category_info)
			{
				$pid = $category_info->my->pid;
				if (!isset($pid) || $pid == '0')
				{
					$pid = '';
				}
				if (isset($rootlabel) && !empty($rootlabel) && $pid == '')
				{
					$pid = "root";
				}
				$hrarray[$category_info->id] = array ('key'      => $category_info->id,
													  'name'     => $category_info->my->categoryname,
													  'value'    => $category_info->id,						
													  'sequence' => $category_info->my->sequence,
													  'parentid' => $pid);

			}
		}
		return $hrarray;
	}

	/**
	 * 创建常规的分类树HTML对像
	 * @param string $categoryNodes 输入输出结果
	 * @param array  $hrarray       由函数:getGenericCategoryTree创建的数据
	 * @param array  $selectNodes   默认选择的结点数据
	 * @param array  $excludeNodes  默认排除的结点数据,在树结构中将不显示出来
	 * @param bool   $rootBox       当树结构能进行选择时,是否可选择根结点
	 * @throws XN_IllegalArgumentException
	 */
	function createGenericCategoryTree(&$categoryNodes = "", $hrarray, $selectNodes = null, $excludeNodes = null, $rootBox = false, $statistics = false)
	{
		if (isset($excludeNodes) && $excludeNodes != "")
		{
			if (is_string($excludeNodes))
			{
				$excludeNodes = explode(';', $excludeNodes);
			}
		}
		$excludeNodes = findExcludeNodes($hrarray, $excludeNodes, true);
		if (isset($selectNodes) && $selectNodes != "")
		{
			if (is_string($selectNodes))
			{
				$selectNodes = explode(';', $selectNodes);
			}
		}
		if($statistics)
		{
			try{
				$pr = XN_MemCache::get("Mall_CategoryStructureProductsCount");
			}catch(XN_Exception $e){
				$products = XN_Query::create('Content_Count')->tag('mall_products')
									->filter('type', 'eic', 'mall_products')
									->filter('my.deleted', '=', '0')
									->rollup()
									->group('my.categorys')
									->begin(0)->end(-1)
									->execute();
				$pr       = array ();
				foreach ($products as $info)
				{
					$pr[$info->my->categorys] = $info->my->count;
				}
				$all = 0;
				foreach($pr as $key => $value){
					$all += intval($value);
					$parents = getParentCategoryID($key);
					foreach($parents as $parent){
						if(isset($pr[$parent])){
							$pr[$parent] = intval($pr[$parent]) + intval($value);
						}else{
							$pr[$parent] = $value;
						}
					}
				}
				XN_MemCache::put($pr,"Mall_CategoryStructureProductsCount");
			}
		}
		$index = 1;
		foreach ($hrarray as $category_info)
		{
			$label = $category_info["name"];
			$key   = $category_info["key"];

			if (isset($pr[$key]) && $pr[$key] != '')
			{
				$label .= " (".$pr[$key].")";
			}
			if (isset($excludeNodes) && is_array($excludeNodes) && count($excludeNodes) > 0 && in_array($key, $excludeNodes))
			{
				continue;
			}
			$categoryNodes .= '<li  data-id="'.$key.'"
							data-pid="'.$category_info["parentid"].'"
							data-faicon="gift"
							data-checkall="false"
							data-sequence="'.$category_info['sequence'].'"
							data-nodename="'.$category_info["name"].'"
			';
			if (isset($category_info["value"]) && !empty($category_info["value"]))
			{
				$categoryNodes .= 'data-value="'.$category_info["value"].'"';
			}
			else
			{
				$categoryNodes .= 'data-value="'.$key.'"';
			}
			if (isset($category_info["iscustom"]) && !empty($category_info["iscustom"]))
			{
				$categoryNodes .= 'data-iscustom="true"';
			}
			else
			{
				$categoryNodes .= 'data-iscustom="false"';
			}
			if ($index == 1)
			{
				$categoryNodes .= 'data-open="true"';
			}
			if ($category_info['key'] == "root")
			{
				$categoryNodes .= 'data-nocheck="true"';
			}
			elseif ((!isset($category_info['parentid']) || $category_info['parentid'] == "") && !$rootBox)
			{
				$categoryNodes .= 'data-nocheck="true"';
			}
			elseif ($category_info['parentid'] == "root" && !$rootBox)
			{
				$categoryNodes .= 'data-nocheck="true"';
			}
			elseif ($category_info['isbox'] == "false")
			{
				$categoryNodes .= 'data-nocheck="true"';
			}
			elseif (isset($selectNodes) && is_array($selectNodes) && count($selectNodes) > 0)
			{
				if ($category_info['value'] && in_array($category_info['value'], $selectNodes))
					$categoryNodes .= 'data-checked="true"';
				elseif (in_array($category_info['key'], $selectNodes))
				{
					$categoryNodes .= 'data-checked="true"';
				}
			}
			$categoryNodes .= '>'.$label.'</li>';
			$index++;
		}
	}
