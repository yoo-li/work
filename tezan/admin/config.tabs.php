<?php


$Config_ParentTabs = array(
    'My Home Page' =>
        array(
            'Calendar',
            'Announcements', 
            'ApprovalCenters'
        ),

	//SOP企业运维综合管理系统
    'Sop Platfrom' =>
        array(
			'Sop_WorkSops',  /*SOP列表*/
        ),
    'Sop Platfrom Log' =>
        array(
            'Sop_WorkNotices',  /*SOP通知*/
        ),
    'Sop Sub Platfrom' =>
        array(
			'Erp_Customers', /*客户*/
			'Erp_Contacts', /*联系人*/
			'Erp_ContractCategorys', /*合同分类*/
			'Erp_Contracts', /*合同管理*/
			'Erp_Budgets', /*年度预算*/ 
			'Erp_Reimbursements', /*报账管理*/
			'Erp_Loans', /*报账管理*/
			'Erp_Receivables', /*应收款*/
			'Erp_Payables', /*应付款*/
			'Erp_ReceivableRecords', /*应收记录*/
			'Erp_PayablesRecords', /*应付记录*/ 
			'Erp_ProjectResolves', /*项目分解*/
			'Erp_ProjectMaintains', /*项目维护*/
			'Erp_ProjectGanttCharts', /*项目甘特图*/ 
			'Erp_Artisans', /*技术人员*/
			'Erp_BillWaters', /*账单流水*/
			'Erp_WorkLogs', /*工作日志*/
			'Erp_Products', /*采购商品*/
			'Erp_Inventorys', /*商品库存*/
			'Erp_PurchaseOrders', /*采购订单*/  
        ),
		
	 
    'Sop Setting' =>
        array(
            'Sop_Categorys',   /*流程分类*/
            'Sop_Workflows', /*sop_workflowfields、*/ /*流程配置*/
			'Sop_Plugins', /*插件设置*/
			'Sop_DocNums', /*文号管理*/
			'Sop_DocTemplates', /*文档模板*/
		    'Sop_Settings', /*运维设置*/
        ),

    //爱源装饰装修平台
    'DC Base Platfrom' => /*基础数据*/
        array(
			'Dc_Designers',  /*设计师 6000*/
			'Dc_Supervisors',  /*项目监理 6001*/
			'Dc_Craftsmans',  /*工匠 6002*/
			'Dc_Proprietors',  /*业主 6003*/
			'Dc_Categorys',  /*风格 6004*/
        ),
    'DC Website Platfrom' =>  /*爱源门户管理*/
        array(
            'Dc_EffectImages',  /*效果图管理 6005*/
		    'Dc_CarouselImages',  /*门户轮播图栏目 6006*/
			'Dc_EdgeImages',  /*门户边图栏目 6007*/
			'Dc_DcEffectImages',  /*装修效果图栏目 6008*/
		    'Dc_ExperiencedCraftsmans',  /*名工巧匠栏目 6009*/
		    'Dc_DesignerStyles',  /*设计师风采栏目 6010*/
			'Dc_Cooperativepartners',  /*合作伙伴 6011*/
			'Dc_Cases',  /*设计师/项目监理案例 6012*/
			'Dc_Documents',  /*文档库管理 6013*/
        ),
    'DC Platfrom' => /*爱源运营管理*/
        array(
			'Dc_RebateSetting', /*返利设置 6014*/
			'Dc_Demands', /*装修需求管理 6015*/
			'Dc_DesignerCharts', /*设计管理 6016*/
			'Dc_Offers', /*报价管理 6017*/
			'Dc_Projects', /*合同管理 6018*/
			'Dc_ProjectChanges', /*合同变更单管理 6019*/
			'Dc_Settlements', /*结算管理 6020*/
			'Dc_SettlementChanges', /*结算变更单管理 6021*/
			'Dc_CashApplys', /*返利提现申请 6022*/
        ),
    'DC Platfrom Log' => /*爱源运营日志*/
        array(
            'Dc_RecommendedDemands',   /*需求推荐记录 6023*/
            'Dc_RebateLogs', /*返利记录 6024*/
			'Dc_Payments', /*支付交易记录 6025*/
			'Dc_Recommendeds', /*推荐记录 6026*/
			'Dc_DemandFeedbacks', /*需求反馈记录 6027*/
		    'Dc_Collections', /*收藏记录 6028*/
		    'Dc_InnerMails', /*站内信 6029*/
		    'Dc_BillApplys', /*发票申请记录 6030*/
			),
    'DC Project Log' => /*爱源项目日志*/
        array(
            'Dc_ProjectConstructions',   /*施工日志记录 6031*/
            'Dc_ProjectConfirms', /*施工确认单记录 6032*/
			'Dc_ProjectAppraises', /*施工评价记录 6033*/
			'Dc_ProjectCraftsmans', /*施工工匠管理 6034*/
			),


	//特赞基础平台
	'Tezan Platfrom'     =>
        array(
            'Suppliers',
            'SupplierCorrect',
            'Profile',
            'ProfileRank',
            'Logistics',
            'PotenitalSuppliers',
			'Friends',
			'Themes',
        ),
    'Tezan Platfrom Log' =>
        array(
            'Blacklists',
            'Smslog',
            'FrozenList',
            'WuliuRoute',
            'LastLoginLog',
            'Subscribes',
            'DeleteProfileLog',
            'WuliuLog',
            'WordDict',
        ),

    'Tezan Micro Mall'     =>
        array(
            'Tezan_Settings',
            'Tezan_Profile',
            'Tezan_Categorys',
            'Tezan_RecommendSuppliers',
            'Tezan_DistributionProducts',
            'Tezan_RobSingles',
            'Tezan_DistributionSalesActivitys',
            'Tezan_DistributionSettlements',
        ),
    'Tezan Micro Mall Log' =>
        array(
            'Tezan_DistributionOrders',
            'Tezan_Shares',
            'Tezan_Commissions',
            'Tezan_Payments',
            'Tezan_BillWaters',
            'Tezan_ConsumeLogs',
            'Tezan_Orders_Products',
            'Tezan_ShoppingCarts',
        ),
    'WeiXin Platform'      =>
        array(
            'WxSettings',
            'WxRoles',
            'WxServices',
            'WxChannels',
            'WxBroadcasts',
            'Locations',
        ),
    'Pushs and Messages'   =>
        array(
            'PushMsgBinds',
            'BaiduPushs',
            'Messages',
            'PushMessages',
            'AdMessages',
        ),
		/*
	'Invoicing'            =>
        array(
            'Erp_Customers',
            'Erp_Suppliers',
            'Erp_Products',
            'Erp_Categorys',
            'Erp_Agios',
            'Erp_Funds',
            'Erp_Storages',
            'Erp_Stocks',
            'Erp_Purchases',
            'Erp_Sales',
            'Erp_Inventorys',
            'Erp_Returnedgoods',
            'Erp_Receivables',
            'Erp_Payables',
            'Erp_Turnovers',
            'Erp_BillWaters',
            'Erp_Settlements'
        ),*/

    'Local Style'     =>
        array(
            'Local_Profile',
            'Local_Businesses',
            'Local_Districts',
            'Local_Streets',
            'Local_VipCards',
            'Local_Brands',
            'Local_Stalls',
            'Local_Products',
            'Local_PropertyCorrect',
            'Local_Orders',

            'Local_Categorys',
            'Local_ShopAd',
            'Local_ShopPackage',
            'Local_ReturnedGoodsApplys',
            'Local_Reimburses',
            'Local_SalesActivitys',
            'Local_Reserves',
            'Local_Couriers',
            'Local_DiningDesks',
            'Local_DiningDeskPrinters',
            'Local_Debts',
            'Local_Agios',
            'Local_Waiters',
            'Local_CashierItems',
            'Local_Cooks',
            'Local_Joke',
            'Local_Show'
        ),
    'Local Style Log' =>
        array(
            'Local_Payments',
            'Local_Shares',
            'Local_BillWaters',
            'Local_Commissions',
            'Local_ShoppingCarts',
            'Local_Usages',
            'Local_ConsumeLogs',
            'Local_Appraises',
            'Local_Cashiers',
            'Local_AntiCashiers',
            'Local_Shifts',
            'Local_DebtLogs',
            'Local_AgioLogs',
            'Local_RoundLogs',
            'Local_Orders_Products',
            'Local_DailyStatistics',
            'Local_DiningDeskLogs',
            'Local_PrintQueues'
        ),

    'Local Style Storages' =>
        array(
            'Local_Inventorys',
            'Local_StockinStorages',
            'Local_SalesOutStorages',
            'Local_Turnovers',
            'Local_DailyInventorys'
        ),
    'Local Style Settings' =>
        array(
            'Local_PushSet',
            'Local_ShopSet',
            'Local_Users',
        ),





    'VehicleManagement' =>
        array(
            'Vehicle_Activity',
            'Vehicle_Apply',
            'Vehicle_Attendance',
            'Vehicle_Driver',
            'Vehicle_Vehicle',
            'Vehicle_Query',
            'Vehicle_Quota',
            'Vehicle_AccidentRecord',
            'Vehicle_RefuelRecord',
            'Vehicle_Insurance',
            'Vehicle_Maintenance',
            'Vehicle_ViolateRecord',
            'Vehicle_DriverQuery'
        ),



    'Mall Official Management'  => //事务官管理
	        array(
				//'Mall_OfficialAuthorizeRelationships',  //授权人关系设置 3101
	            'Mall_OfficialAuthorizeEvents',  //授权事件  3102
				'Mall_OfficialAuthorizeEventModifys',  //授权事件变更  3126
				'Mall_OfficialAuthorizeDimensions',  //授权维度  3103
				'Mall_OfficialEnterpriseCurrencys',  //企业币设置 3104
				'Mall_OfficialEnterpriseCurrencysAuthorizes',  //企业币授权管理 3105
				/*'Mall_OfficialAuthorizeUsers',  //3107
				'Mall_OfficialQuotas', //3108
				'Mall_OfficialQuotasLogs',*/ //3109
				'Mall_OfficialOrders',     //审批流程 3110
				'Mall_OfficialApplys',     //企业申请记录 3122
				'Mall_OfficialTreats',     //宴请记录 3123
				'Mall_OfficialTreatObjects',     //宴请对象 3124
				'Mall_OfficialTreatPayments',     //宴请支付 3125
                'Mall_OfficialSettlements',     //事务官结算记录 3127

                'Mall_OfficialTastObjects',     //宴请测试 3128
            ),
    'Mall Official Log'  => //事务官日志
	        array(
				'Mall_OfficialEnterpriseCurrencyLogs', //企业币日志 3111
				'Mall_OfficialAuthorizeLogs', //授权金日志  3112
				'Mall_OfficialOpinions', //关注人记录  3113
				'Mall_OfficialPhotoLogs', //拍摄照片记录 3114
				'Mall_OfficialQrcodeLogs', //分享二维码加入企业记录  3115
				'Mall_OfficialFocusedLogs', //关注商家记录 3116
	        ),
    'Mall Official Platform'  => //事务官平台
	        array(
				'Mall_OfficialPromotionSettings', //推广信息设置  3117
				'Mall_OfficialRankSettings', //推广积分设置 3118
				'Mall_OfficialRankLog', //推广积分记录 3119
				'Mall_OfficialEnterprisePayments', //商户支付日志 3120
				'Mall_OfficialEnterpriseReceivables', //企业应收日志 3121
                'Mall_OfficialShiduBills', //史嘟通宝授权管理 3138
                'Mall_OfficialShiduOrders', //史嘟通宝消费审批 3139
                'Mall_OfficialShiduLogs'//史嘟通宝消费流水 3140
	        ),

    'Micro Mall'   =>
        array(
            'Mall_Ads',
            'Mall_Categorys',
            'Mall_Brands',
            'Mall_ProductLibs',
            'Mall_Products',
            'Mall_PropertyCorrect',
            'Mall_Orders',
			'Mall_GroupPurchaseOrders',
            'Mall_ReturnedGoodsApplys',
            'Mall_Reimburses',
            'Mall_SalesActivitys',
			'Mall_RobSingles',
			'Mall_GroupPurchases',
            'Mall_ParameterConfig',
            'Mall_Inventorys',
            'Mall_ShareDatas',
            'Mall_VipCards',
            'Mall_Appraises',
            'Mall_Settings',
            'Mall_RechargeableCards',
            'Mall_ReceptionProducts',
            'Mall_SmkRechargeableCards', //市民卡'3053
			'Mall_JdOrders', //京东订单 3054
            'Mall_SmkCardRecords', //商城卡绑定 3132
            'Mall_SmkUsers', //商城卡用户 3133
            'Mall_SmkConsumeLogs', //商城卡消费 3134
            'Mall_SmkReimburses', //商城卡退款 3135
            'Mall_SmkVipCards' //商城优惠券 3136

        ),
    'Micro Mall Log'               =>
        array(
            'Mall_Shares',
            'Mall_Payments',
            'Mall_PaymentFails',
            'Mall_BillWaters',
            'Mall_Commissions',
            'Mall_SearchLog',
            'Mall_MyCollections',
            'Mall_ShoppingCarts',
            'Mall_HitshelfLog',
            'Mall_Turnovers',
            'Mall_AdjustrateLog',
            'Mall_ConsumeLogs',
            'Mall_Usages',
            'Mall_Orders_Products',
			'Mall_RobProducts',
            'Mall_Bargains',
            'Mall_UniqueSales',
            'Mall_Receptions',
            'Mall_ReceptionRecords',
            'Mall_Finance' //财务报表

        ),
    'Mall Vendors and Settlements' =>
        array(
            'Mall_Vendors',
            'Mall_SettlementOrders',
            'Mall_Settlements',
            'Mall_VendorsAddress',//供应商地址管理
        ),
    'Mall Logistics'               =>
        array(
            'Mall_LogisticDrivers',
            'Mall_LogisticPoints',
            'Mall_LogisticPackages',
            'Mall_LogisticTrips',
            'Mall_LogisticBills',
            'Mall_LogisticRoutes',
        ),

    'Supplier Style' =>
        array(
            'Supplier_PhysicalStores',
            'Supplier_PhysicalStoreProfiles',
			'Supplier_PhysicalStoreAssistants',
            'Supplier_Profile',
   		 	'Supplier_AuthenticationProfiles',
            'Supplier_FrozenLists',
            'Supplier_Shops',
            'Supplier_Ads',
            'Supplier_Albums',
            'Supplier_News',
            'Supplier_Recharges',
            'Supplier_RechargeLogs',
            'Supplier_Chats',
            'Supplier_TakeCashs',
            'Supplier_RedEnvelopes',
        ),

    'Supplier WeiXin Platform' =>
        array(
            'Supplier_WxSettings',
            'Supplier_WxRoles',
            'Supplier_WxServices',
            'Supplier_WxChannels',
            'Supplier_WxScans',
            'Supplier_WxFirstMeets',
        ),
    "Supplier Setting"         => array(
        'Supplier_Users',
        "Supplier_Departments",
        'Supplier_AccessSetting',
        'Supplier_ApprovalFlows',
        "Supplier_Themes",
        "Supplier_Modules",
        'Supplier_Settings',
		'Supplier_AuthorizeManage',
        'Supplier_InvoicePrint',
        "Supplier_ReportSettings",
    ),


	//医疗器械管理系统
    'Ma_Products Manage'    =>   //产品管理
        array(
            'Ma_Categorys', //产品分类
            'Ma_ClinicalCategorys', //临床分类
            'Ma_Products',  //产品信息
            'Ma_ProductPackage', //产品套餐
            'Ma_RegisterCodes', //注册备案证
            'Ma_PriceList',  //产品授权

        ),
	'Ma_PriceStrategy Manage' => array(
		'Ma_PurchaseStrategy', //采购价格策略
		'Ma_SaleStrategy',		//销售价格策略
		'Ma_InventoryWarn',		//警戒库存
		'Ma_CheckInventoryWarns',  //警戒库存
	),
    'Ma_Certificate Manage' =>  //资质管理
        array(
            'Ma_Factorys', //生产厂商
            'Ma_Agencys', //经营企业
            'Ma_Hospitals', //医疗机构
            'Ma_FirstChecks', //首营产品
            'Ma_FirstChecksEnterprise',  //首营企业
			'Ma_PurchaserQualification',
            'Ma_CheckWarns',  //效期预警
			"Ma_SalesAuthorizations",     //销售人员授权书
			"Ma_PurchaseAuthorizations",     //采购收货人员授权书
        ),
	//特价商品
	'Ma_OnSale Manage'=>  //特价商品
		array(
			"Ma_OnSaleSuppliers",  //特价商品会员
			"Ma_OnSaleProducts",    //特价商品列表
			"Ma_OnSaleProductShow",    //特价商品展示区
			"Ma_OnSaleShoppingCarts_Details",   //医疗机构特价商品购物车详情
		),
   //合同订单（采购合同、采购订单、销售合同、销售订单、集中购销、购进退出、销后退回、借出单、借入单、采购记录、销售记录）
    'Ma_Orders Manage'      =>  //合同订单
        array(
            "Ma_PurchaseContract", //采购合同
            "Ma_SaleContract", //销售合同
            //'Ma_ShoppingCarts',
            'Ma_PurchaseOrders',  //采购订单
            'Ma_CentralizedPurchase', //集中采购
            'Ma_SaleOrders', //销售订单
            'Ma_CentralizedSale', //集中销售
            "Ma_BorrowOrdersOut", //借出单
            "Ma_BorrowOrdersIn",  //借入单
            "Ma_ReturnOrdersOut", //购进退出
            "Ma_ReturnOrdersIn", //销后退回
            "Ma_PurchaseLogs",   //采购记录
            "Ma_SaleLogs",		 //销售记录
			//集中采购，集中销售 是分两个模块做的
        ),
    'Ma_Authorize Manage'=>  //委托管理
        array(
            "Ma_DeliveryContract",  //委托协议
            "Ma_DeliveryOrders",    //委托订单
			"Ma_AuthoAllocateContract",   //委托调拨协议
			"Ma_StorageAuthorize",   //委托仓库
        ),
	  //仓库列表、仓库初始化、实时库存、库存流水、库间调拨、库存盘点、仓库温湿度、温湿度校准记录、库存养护检查管理、质量复检通知单、车辆管理、设施设备检查记录
     'Ma_Storage Manage'          =>  //仓储管理
		array(
			"Ma_StorageLibs",
			"Ma_StorageRacks",
            "Ma_StorageList",  //仓库列表
			"Ma_InventoryCount", //实时库存
			"Ma_InventoryList", //库存详情
            "Ma_StorageInit",  //仓库初始化
            "Ma_InventoryBillWaters", //库存流水
            "Ma_InventoryConfirm",  //库存盘点 4026
            "Ma_StorageAllocate",  //库间调拨 4025
			"Ma_InventoryMaintenance", //库存养护检查管理 4029
            'Ma_VehicleChecks',  //车辆管理 4040
			"Ma_DeviceVerifications",  //设施设备检查记录  4041
			//"Ma_ScatteredStorages",	//拆零拼箱库
			"Ma_QualityInspectionNotice",  //质量复检通知单
			"Ma_EquipmentCalibration",  //计量器具校验
        ),
	'Ma_Humiture Manage'          =>  //温湿度管理系统
	array(
	    "Ma_StorageHumiture",  //仓库温湿度
   		"Ma_HumitureVerifications",  //温湿度校准记录 4028
		"Ma_TempHumEquip",
		"Ma_TempHumeLogs",
    ),
	//采购待验入库、销后退回待验入库、借入待验入库、采购验收、销后退回验收、借入验收、验收记录、拒收报告单、入库凭证）
	"Ma_InStorageCheck Manage"      => //入库验收
		array(
            "Ma_InCheckStorage", // 采购待验入库 4111
            "Ma_InReturnCheckStorage", //销后退回待验入库  4112
			"Ma_BorrowInCheckStorage", //借入待验入库
			"Ma_BackInCheckStorage",
			"Ma_AuthoInCheckStorage",
			"Ma_RefuseInCheckStorage",
			"Ma_InStorageCheck",  //采购验收 4120
			"Ma_InReturnStorageCheck",  //销后退回验收
			"Ma_BorrowInStorageCheck",  //借入验收
			"Ma_BackInStorageCheck",
			"Ma_AuthoInStorageCheck",
			"Ma_RefuseInStorageCheck",
			"Ma_ReceiveLogs",
			'Ma_CheckLogs', //验收记录   4130
            "Ma_RejectionNotice", //拒收报告单 4140
			'Ma_InStorageCertificate', //入库凭证 4150
		),


	//采购入库、销售出库、销后退回入库、购进退出出库、借出出库、借入入库、出库记录、入库记录、物流信息、运输温湿度记录
    'Ma_Storage Logistics'      =>  //仓储物流
        array(
            "Ma_InventoryPutIn", //采购入库
            "Ma_InventorySaleOut", //销售出库
            "Ma_InventoryBorrowIn", //借入入库
            "Ma_InventoryBorrowOut", //借出出库
            "Ma_InventoryReturnIn", //销后退回入库
            "Ma_InventoryReturnOut", //购进退出出库
			"Ma_InventoryBackIn", //归还入库
			"Ma_InventoryAuthoIn", //归还入库
			"Ma_InventoryBackOut", //归还出库
			"Ma_InventoryAuthoOut",
			"Ma_InventoryRefuseIn",
			"Ma_InventoryRefuseOut",
            'Ma_InStorageCertificateOut', //出库凭证
			"Ma_InventoryOutLogs", //出库记录
            "Ma_InventoryLogs", //入库记录 4128
        ),

	//销售出库复核、购进退出复核、借出复核、复核记录、随货同行单
	"Ma_RecheckOrders Manage"      =>  //出库复核
		array(
			 "Ma_RecheckOrders", //销售出库复核 4110
			 "Ma_RecheckOrdersOut", //购进退出复核
			 "Ma_RecheckOrdersBorrow", //借出复核
			 "Ma_RecheckOrdersBack", //借入归还复核
			 "Ma_RecheckOrdersAutho", //借入归还复核
			 "Ma_RecheckOrdersRefuse",
			 "Ma_RecheckLogs", //复核记录 4120
			 "Ma_FollowGoods", //随货同行单 4140
		),

	'Ma_Traffic Manage'          =>  //运输管理系统
		array(
            "Ma_LogisticsRouting", //物流信息  4130
			"Ma_ColdchainTruck", //冷链运输车 4182
			"Ma_TrafficHumitures",  //运输温湿度记录
	    ),
	//不合格产品管理（公示不合格品、不合格品登记、不合格品召回、不合格品退货记录、不合格品销毁、销毁审批记录、销毁记录、不良事件报告）
    'Ma_Rejects Manage'     => //不合格产品管理
        array(
			'Ma_Rejects', //公示不合格品 4003
			"Ma_BadProducts", //不合格品登记 4010
			"Ma_Recalls", //不合格品召回 4020
			"Ma_BadReturnLogs", //不合格品退货记录 4030
			"Ma_DestroyApprovals", //不合格品审批 4040
			"Ma_DestroyApprovalLogs", //销毁审批记录 4050
			"Ma_DestroyProducts",//不合格品销毁
			"Ma_DestroyLogs", //销毁记录 4060
			"Ma_BadReponseReports", //不良事件报告  4070
        ),
    'WCS Picking System'     => //WCS 拣货系统
        array(
			'Wcs_Controllers', //控制器管理 4003
			"Wcs_WorkAreas", //作业区域管理 4010
			"Wcs_Channels", //通道管理 4020
			"Wcs_WarehouseLocations", //标签仓位管理 4030
			"Wcs_WarehouseLocationsProducts", //货位产品管理 4030
			"Wcs_PickingUsers", //拣货人员管理 4040
			"Wcs_Orders", //拣货订单 4050
			"Wcs_UserResults", //拣货信息 4050
			"Wcs_OrderMonitors", //标签监控 4050
			"Wcs_HardwareMonitors", //硬件监控 4050
        ),

	//售后服务（质量投诉、事故调查、处理报告）
    "Ma_AfterSaleService"  => array(
		"Ma_QualityComplaints",  //质量投诉
        'Ma_AccidentInvestigations', //事故调查,
        'Ma_AfterSaleServiceProcessingReports', //处理报告
    ),
	//员工健康档案、质验培训合格证、售后服务上岗证、培训评估记录、培训记录
    'Ma_Employee Manage'     => //人员管理
        array(
            	"Ma_EmployeeHealthArchives",  //员工健康档案
				'Ma_Workers', //质验培训合格证
			    "Ma_ServiceCertificates",  //售后服务上岗证
			    "Ma_TrainRecords",  //培训记录
			   	"Ma_TrainingEvaluations",  //培训评估记录
        ),
	//财务管理（收票管理、应付款、开票管理、应收款、付款记录、收款记录）
    'Ma_Financial Manage'   =>  //财务管理
        array(
            "Ma_PaymentList", //应付款
            "Ma_ReceiptList", //应收款
            "Ma_InvoiceManage", //开票管理
            "Ma_InvoiceTake", //收票管理
            "Ma_MergePayment", //付款记录
            "Ma_MergeReceipt" //收款记录
        ),
	//企业资格审查、应收应付审查、应收应付池、池融资管理、资金池、资金池流水、金融统计
    'Ma_Banks Manage'       =>  //金融平台
        array(
            "Ma_FundPool", // 资金池
            "Ma_FundBillWaters", //资金池流水
            "Ma_CertificateApproval", //企业资格审查
            "Ma_OrdersApproval", //应收应付审查
            "Ma_PoolFinancialApproval", //池融资管理
            "Ma_NoPaylist", //应收应付池
            "Ma_FinancialCount" //金融统计
        ),
	//政府监管（产品溯源、不合格产品监管）
    "Ma_Government Manage"  => array(  //政府监管
        "Ma_ProductsFrom", //产品溯源
        'Ma_RejectAnalysis', //不合格产品监管
    ),
	//用户管理、部门管理、角色权限、用户角色、打印设置、流程设置、报表设置
    "Ma_Setting Manage"     => array(   //配置管理
        "Ma_Suppliers",
        "Ma_Departments", //部门管理  4051
        'Ma_Staffs', //用户管理 4052
        'Ma_AccessSetting', //角色权限 4053
		'Ma_AuthorizeManage', //用户角色 4054
        'Ma_InvoicePrint', //打印设置 4055
        'Ma_ApprovalFlows', //流程设置 4077
        "Ma_ReportSettings", //报表设置 4091
    ),
	"Ma_Cms Manage"     => array(   //配置管理
		"Cms_Descrip",
		"Cms_Ads",
		'Cms_News',
		'Cms_Fagui',
		'Cms_RecommendProducts'
	),
	//抢单系统
	"Rush Management"	=> array(
		"Rush_Suppliers",
		"Rush_Hospitals",
		"Rush_Technician",
		"Rush_Orders",
		"Rush_Protocol",
		"Rush_Users",
		"Rush_Payables",
		"Rush_Receivables"
	),
	"Letter Management" => array(
		"Let_Template",
		"Let_Information",
		"Let_Payments",
	),

    //易车行
    "Dev Equipments" => array(
        "Dev_Equipments",
        "Dev_EquipmentControl",
        "Dev_Locations",
        "Dev_Setting",
        "Dev_Params",
        "Dev_OperLogs"
    ),
    "Dev Users" => array(
        "Dev_Usercerts",
        "Dev_PaymentLogs",
        "Dev_ReturnLogs"
    ),
    "Dev Orders" => array(
        "Dev_PreOrders",
        "Dev_Orders"
    ),
    "Dev Logs" => array(
        "Dev_WarnLogs",
        "Dev_Breakrules",
        "Det_QueryLogs"
    ),
);
