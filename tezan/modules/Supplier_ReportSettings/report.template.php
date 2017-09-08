<?php
	$reporttemplates = array(
		'0' => array(
			'reportid' => '1064943',
			'reportname' => '日期-订单数',
			'reportgroup' => '订单管理',
			'reporttype' => '商城报表',
			'modulestabid' => '3006',
			'x_axis' => 'published@monthday',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'1' => array(
			'reportid' => '1064944',
			'reportname' => '日期-金额',
			'reportgroup' => '订单管理',
			'reporttype' => '商城报表',
			'modulestabid' => '3006',
			'x_axis' => 'published@monthday',
			'y_axis' => 'orderstotal',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'2' => array(
			'reportid' => '1064945',
			'reportname' => '分类-商品数',
			'reportgroup' => '商品管理',
			'reporttype' => '商城报表',
			'modulestabid' => '3004',
			'x_axis' => 'categorys',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array()
		),
		'3' => array(
			'reportid' => '1064946',
			'reportname' => '品牌-商品数',
			'reportgroup' => '商品管理',
			'reporttype' => '商城报表',
			'modulestabid' => '3004',
			'x_axis' => 'brand',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array()
		),
		'4' => array(
			'reportid' => '1064947',
			'reportname' => '日期-数量',
			'reportgroup' => '订单管理',
			'reporttype' => 'TopN报表',
			'modulestabid' => '3006',
			'x_axis' => 'published@monthday',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'5' => array(
			'reportid' => '1064948',
			'reportname' => '日期-金额',
			'reportgroup' => '订单管理',
			'reporttype' => 'TopN报表',
			'modulestabid' => '3006',
			'x_axis' => 'published@monthday',
			'y_axis' => 'orderstotal',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'6' => array(
			'reportid' => '1064949',
			'reportname' => '数量',
			'reportgroup' => '订单管理',
			'reporttype' => '环比报表',
			'modulestabid' => '3006',
			'x_axis' => '',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'7' => array(
			'reportid' => '1064950',
			'reportname' => '金额',
			'reportgroup' => '订单管理',
			'reporttype' => '环比报表',
			'modulestabid' => '3006',
			'x_axis' => '',
			'y_axis' => 'orderstotal',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'8' => array(
			'reportid' => '1064951',
			'reportname' => '数量',
			'reportgroup' => '订单管理',
			'reporttype' => '同比报表',
			'modulestabid' => '3006',
			'x_axis' => '',
			'y_axis' => 'count',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'9' => array(
			'reportid' => '1064952',
			'reportname' => '金额',
			'reportgroup' => '订单管理',
			'reporttype' => '同比报表',
			'modulestabid' => '3006',
			'x_axis' => '',
			'y_axis' => 'orderstotal',
			'z_axis' => '',
			'filters' => array(),
			'querys' => array(
				'0' => array(
					'fieldname' => 'tradestatus',
					'logic' => '=',
					'queryvalue' => 'trade'
				)
			)
		),
		'10' => array(
			'reportid' => '1064953',
			'reportname' => '日期-数量-订单状态',
			'reportgroup' => '订单管理',
			'reporttype' => '商城报表',
			'modulestabid' => '3006',
			'x_axis' => 'published@monthday',
			'y_axis' => 'count',
			'z_axis' => 'order_status',
			'filters' => array(),
			'querys' => array()
		)
	);