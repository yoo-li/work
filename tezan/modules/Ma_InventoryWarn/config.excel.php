<?php
	/**
	 * 字段定义说明
	 * 主Key为数据存放的表名
	 * type: reference类型为关联字段,picklist为数据字典字段,profile为用户字段,text为文本字段,digital为数字字段
	 * refield : 获取关联数据中的字段名
	 * source : 为type提供数据源.为空时为普通数据类型
	 * filter : 为source提供自定义查询条件,可多个,可空项.格式:array("field"=>"my.productid","logic"=>"","value"=>"")
	 * onlyone : 为导入数据时使用,及唯一标示
	 */
	$exceltemplate = array(
		"ma_inventorywarndetails" => array (
			"title"       => "警戒库存详情批量导入",
			"fixedcolumn" => "0",
			"readrow"     => 3,
			"fields"      => array (
				array ("field" => "barcode", "label" => "产品编码", "width" => "20", "type" => "text"),
				array ("field" => "itemcode", "label" => "产品条码", "width" => "20", "type" => "text"),
				array ("field" => "maximum", "label" => "最大库存", "width" => "20", "type" => "digital"),
				array ("field" => "minimum", "label" => "最小库存", "width" => "20", "type" => "digital"),
			),
		),
	);