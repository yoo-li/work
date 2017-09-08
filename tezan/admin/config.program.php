<?php

	if ($_SERVER["SERVER_ADDR"] == "117.41.237.48")
	{
		$programs = array (
			"MaPlatform" => array (
				"label"     => "智博医疗器械云平台",
				"status"    => "1",
				"tabid"     => array (
					"4000", "4001", "4002", "4003", "4004", "4005", "4006", "4007", "4008", "4009",
					"4010", "4011", "4012", "4013", "4014", "4015", "4016", "4017", "4018", "4019",
					"4020", "4021", "4022", "4023", "4024", "4025", "4026", "4027", "4028", "4029",
					"4030", "4031", "4032", "4033", "4034", "4035", "4036", "4037", "4038", "4039",
					"4040", "4041", "4042", "4043", "4044", "4045", "4046", "4047", "4048", "4049",
					"4050", "4051", "4052", "4053", "4054", "4055", "4056", "4057", "4058", "4059",
					"4060", "4061", "4062", "4063", "4064", "4065", "4066", "4067", "4068", "4069",
					"4070", "4071", "4072", "4073", "4074", "4075", "4076", "4077", "4078", "4079",
					"4080", "4081", "4082", "4083", "4084", "4085", "4086", "4087", "4088", "4089",
					"4090", "4091", "4092", "4093", "4094", "4095", "4096", "4097", "4098", "4099",
					"4100", "4101", "4102", "4103", "4104", "4105", "4106", "4107", "4108", "4109",
					"4110", "4111", "4112", "4113", "4114", "4115", "4116", "4117", "4118", "4119",
					"4120", "4121", "4122", "4123", "4124", "4125", "4126", "4127", "4128", "4129",
					"4130", "4131", "4132", "4133", "4134", "4135", "4136", "4137", "4138", "4139",
					"4141", "4141", "4142", "4143", "4144", "4145", "4146", "4147", "4148", "4149",
					"4150", "4151", "4152", "4153", "4154", "4155", "4156", "4157", "4158", "4159",
					"4160", "4161", "4162", "4163", "4164", "4165", "4166", "4167", "4168", "4169",
					"4170", "4171", "4172", "4173", "4174", "4175", "4176", "4177", "4178", "4179",
					"4180", "4181", "4182", "4183", "4184", "4185", "4186", "4187", "4188", "4189",
					"4190", "4191", "4192", "4193", "4194", "4195", "4196", "4197", "4198", "4199",
					"4200","4201","4202",
				),
				"parenttab" => array ("Ma_Products Manage", "Ma_Certificate Manage", "Ma_Orders Manage", "Ma_Authorize Manage", "Ma_Storege Mange", "Ma_InStorageCheck Manage", "Ma_RecheckOrders Manage", "Ma_Storage Logistics", "Ma_Rejects Manage", "Ma_AfterSaleService", "Ma_Employee Manage", "Ma_Financial Manage", "Ma_Banks Manage", "Ma_Government Manage", "Ma_Setting Manage"),
				"authorize" => array (
					"MaPlatformAdmin" => "LBL_MAPLATFORMADMIN",
				),
			),
			"reports"    => array (
				"label"     => "大数据分析平台",
				"status"    => "1",
				"tabid"     => array ("147", "148", "149", "150", "151"),
				"parenttab" => array ("Analytics"),
			),
		);
	}
	else
	{
		if (XN_Application::$CURRENT_URL == "vehicle")
		{
			$programs = array (
				"vehicle" => array (
					"label"     => "车辆管理系统",
					"status"    => "1",
					"tabid"     => array ("5000", "5001", "5002", "5003", "5004", "5005", "5006", "5007", "5008", "5009", "5010", "5011", "5012", "5013"),
					"parenttab" => array ("VehicleManagement"),
					"authorize" => array (
						"vehiclemanger"          => "LBL_VEHICLEMANGER",
						"vehicleschedule"        => "LBL_VEHICLESCHEDULE",
						"editvehicleactivity"    => "LBL_EDITVEHICLEACTIVITY",
						"vehicle_insurance"      => "LBL_VEHICLEINSURANCE",
						"vehicle_maintenance"    => "LBL_VEHICLEMAINTENANCE",
						"vehicle_violaterecord"  => "LBL_VIOLATERECORD",
						"vehicle_accidentrecord" => "LBL_ACCIDENTRECORD",
						"vehicle_refuelrecord"   => "LBL_REFUELRECORD",
						"attendance"             => "LBL_ATTENDANCE",
					),
				),
			);
		}
		else
		{
			$programs = array (
				"sop"      => array (
					"label"     => "办公运维管理系统",
					"status"    => "1",
					"tabid"     => array ("5000", "5001", "5002", "5003", "5004", "5005", "5006", "5007", "5008", "5009",
										  "5010", "5011", "5012", "5013", "5014", "5015", "5016", "5017", "5008", "5019",
										  "5020", "5021", "5022", "5023", "5024", "5025", "5026", "5027", "5028", "5029",
										  "5050", "5051", "5052", "5053", "5054", "5055", "5056", "5057", "5058", "5059",
									      "5060", "5061", "5062", "5063", "5064", "5065", "5066", "5067", "5068", "5069",
									  	  "5070", "5071", "5072", "5073", "5074", "5075", "5076", "5077", "5078", "5079",
								  		  "5080", "5081", "5082", "5083", "5084", "5085", "5086", "5087", "5088", "5089",
							  			  "5090", "5091", "5092", "5093", "5094", "5095", "5096", "5097", "5098", "5099",),
					"parenttab" => array ("Sop Platfrom", "Sop Platfrom Log", "Sop Setting", "Sop Sub Platfrom"),
					"authorize" => array (),
				),
				"dc"       => array (
					"label"     => "爱源装饰装修平台",
					"status"    => "1",
					"tabid"     => array ("6000", "6001", "6002", "6003", "6004", "6005", "6006", "6007", "6008", "6009",
										  "6010", "6011", "6012", "6013", "6014", "6015", "6016", "6017", "6008", "6019",
										  "6020", "6021", "6022", "6023", "6024", "6025", "6026", "6027", "6028", "6029",
										  "6030", "6031", "6032", "6033", "6034", "6035", "6036", "6037", "6038", "6039",
										  "6040", "6041", "6042", "6043", "6044", "6045", "6046", "6047", "6048", "6049",),
					"parenttab" => array ("DC Base Platfrom", "DC Website Platfrom", "DC Platfrom", "DC Platfrom Log", "DC Project Log"),
					"authorize" => array (),
				),
				"platform" => array (
					"label"     => "特赞平台",
					"status"    => "1",
					"tabid"     => array ("152", "153", "154", "320", "348", "321", "322", "323", "324", "325", "326", "327", "328", "329", "330",
										  "331", "332", "333", "334", "335", "336", "337", "338", "339", "340", "341", "342", "343", "344", "345",
										  "346", "347", "400", "401", "402", "403", "404", "405", "406", "408", "409", "410", "411", "412", "413",
										  "414", "415", "416", "417", "418", "419", "420", "421", "422", "423", "424", "425", "426", "427", "428",
										  "429", "430", "431", "432", "433", "434", "435", "436", "437", "438", "439", "440", "441", "442", "443",
										  "444", "445", "446", "447", "448", "449", "450", "451", "452", "453", "454", "455", "456", "457", "458",
										  "459", "460", "461", "462", "463", "464", "465", "466", "467", "468", "469", "470", "472", "473", "474",
										  "475", "476", "477", "478", "479", "480", "481", "482", "483", "484", "485", "486", "487", "488", "489",
										  "490", "491", "492", "493", "494", "495", "496", "497", "498", "499", "501", "502", "503", "504", "505",
										  "506", "507", "508", "509", "510", "511", "512", "513", "514", "515", "516", "517", "518", "519", "520",
										  "521", "522", "523", "524", "525", "526", "527"),
					"parenttab" => array ("Tezan Platfrom", "Tezan Platfrom Log", "WeiXin Platform", "Pushs and Messages"),
					"authorize" => array (),
				),

				"SupplierPlatform" => array (
					"label"     => "特赞电子商务平台",
					"status"    => "1",
					"tabid"     => array (
						"1800", "1801", "1802", "1803", "1804", "1805", "1806", "1807", "1808", "1809",
						"1810", "1811", "1812", "1813", "1814", "1815", "1816", "1817", "1808", "1819",
						"1820", "1821", "1822", "1823", "1824", "1825", "1826", "1827", "1828", "1829",
						"1970", "1971", "1972", "1973", "1974", "1975", "1976", "1977", "1978", "1979",
						"1980", "1981", "1982", "1983", "1984", "1985", "1986", "1987", "1998", "1989",
						"1990", "1991", "1992", "1993", "1994", "1995", "1996", "1997", "1998", "1999",
						"2000", "2001", "2002", "2003", "2004", "2005", "2006", "2007", "2008", "2009",
						"2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019",
						"2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027", "2028", "2029",
						"2030", "2031", "2032", "2033", "2034", "2035", "2036", "2037", "2038", "2039",
						"2040", "2041", "2042", "2043", "2044", "2045", "2046", "2047", "2048", "2049",
						"2050", "2051", "2052", "2053", "2054", "2055", "2056", "2057", "2058", "2059",
						"2060", "2061", "2062", "2063", "2064", "2065", "2066", "2067", "2068", "2069",
						"2070", "2071", "2072", "2073", "2074", "2075", "2076", "2077", "2078", "2079",
						"2080", "2081", "2082", "2083", "2084", "2085", "2086", "2087", "2088", "2089",

						"3001", "3002", "3003", "3004", "3005", "3006", "3007", "3008", "3009", "3010",
						"3011", "3012", "3013", "3014", "3015", "3016", "3017", "3018", "3019", "3020",
						"3021", "3022", "3023", "3024", "3025", "3026", "3027", "3028", "3029", "3030",
						"3031", "3032", "3033", "3034", "3035", "3036", "3037", "3038", "3039", "3040",
						"3041", "3042", "3043", "3044", "3045", "3046", "3047", "3048", "3049", "3050",
						"3051", "3052", "3053", "3054", "3055", "3056", "3057", "3058", "3059", "3060",

						"3101", "3102", "3103", "3104", "3105", "3106", "3107", "3108", "3109", "3110",
						"3111", "3112", "3113", "3114", "3115", "3116", "3117", "3118", "3119", "3120",
                        "3121", "3122", "3123", "3124", "3125", "3126", "3127", "3128", "3129", "3130",

                        "3131","3132","3133","3134","3135","3136","3137",'3138','3139','3140','3141',
					),
					"parenttab" => array ("Supplier Style", "Tezan Micro Mall", "Tezan Micro Mall Log", "Micro Mall", "Micro Mall Log", "Mall Vendors and Settlements", "Supplier WeiXin Platform",
										  "Local Style", "Local Style Log", "Local Style Storages", "Local Style Settings", "Mall Logistics", "Supplier Setting"),
					"authorize" => array (
						"tezanadmin"    => "LBL_TEZANADMIN",
						"manageproflie" => "LBL_MANAGEPROFILE",
					),
				),
				"MaPlatform"       => array (
					"label"     => "医疗器械云平台",
					"status"    => "1",
					"tabid"     => array (
						"4000", "4001", "4002", "4003", "4004", "4005", "4006", "4007", "4008", "4009",
						"4010", "4011", "4012", "4013", "4014", "4015", "4016", "4017", "4018", "4019",
						"4020", "4021", "4022", "4023", "4024", "4025", "4026", "4027", "4028", "4029",
						"4030", "4031", "4032", "4033", "4034", "4035", "4036", "4037", "4038", "4039",
						"4040", "4041", "4042", "4043", "4044", "4045", "4046", "4047", "4048", "4049",
						"4050", "4051", "4052", "4053", "4054", "4055", "4056", "4057", "4058", "4059",
						"4060", "4061", "4062", "4063", "4064", "4065", "4066", "4067", "4068", "4069",
						"4070", "4071", "4072", "4073", "4074", "4075", "4076", "4077", "4078", "4079",
						"4080", "4081", "4082", "4083", "4084", "4085", "4086", "4087", "4088", "4089",
						"4090", "4091", "4092", "4093", "4094", "4095", "4096", "4097", "4098", "4099",
						"4100", "4101", "4102", "4103", "4104", "4105", "4106", "4107", "4108", "4109",
						"4110", "4111", "4112", "4113", "4114", "4115", "4116", "4117", "4118", "4119",
						"4120", "4121", "4122", "4123", "4124", "4125", "4126", "4127", "4128", "4129",
						"4130", "4131", "4132", "4133", "4134", "4135", "4136", "4137", "4138", "4139",
						"4141", "4141", "4142", "4143", "4144", "4145", "4146", "4147", "4148", "4149",
						"4150", "4151", "4152", "4153", "4154", "4155", "4156", "4157", "4158", "4159",
						"4160", "4161", "4162", "4163", "4164", "4165", "4166", "4167", "4168", "4169",
						"4170", "4171", "4172", "4173", "4174", "4175", "4176", "4177", "4178", "4179",
						"4180", "4181", "4182", "4183", "4184", "4185", "4186", "4187", "4188", "4189",
						"4190", "4191", "4192", "4193", "4194", "4195", "4196", "4197", "4198", "4199",
						"4200","4201","4202",
					),
					"parenttab" => array ("Ma_Products Manage", "Ma_PriceStrategy Manage", "Ma_Certificate Manage", "Ma_Orders Manage", "Ma_Storege Mange", "Ma_Quality Manage", "Ma_CRM Manage", "Ma_Financial Manage", "Ma_Banks Manage", "Ma_Government Manage", "Ma_Logistics Manage", "Ma_Setting Manage"),
					"authorize" => array (
						"MaPlatformAdmin" => "LBL_MAPLATFORMADMIN",
					),
				),
				"reports"          => array (
					"label"     => "大数据分析平台",
					"status"    => "1",
					"tabid"     => array ("147", "148", "149", "150", "151"),
					"parenttab" => array ("Analytics"),
				),
				"vehicle"          => array (
					"label"     => "车辆管理系统",
					"status"    => "1",
					"tabid"     => array ("5000", "5001", "5002", "5003", "5004", "5005", "5006", "5007", "5008", "5009", "5010", "5011", "5012", "5013"),
					"parenttab" => array ("VehicleManagement"),
					"authorize" => array (
						"vehiclemanger"          => "LBL_VEHICLEMANGER",
						"vehicleschedule"        => "LBL_VEHICLESCHEDULE",
						"editvehicleactivity"    => "LBL_EDITVEHICLEACTIVITY",
						"vehicle_insurance"      => "LBL_VEHICLEINSURANCE",
						"vehicle_maintenance"    => "LBL_VEHICLEMAINTENANCE",
						"vehicle_violaterecord"  => "LBL_VIOLATERECORD",
						"vehicle_accidentrecord" => "LBL_ACCIDENTRECORD",
						"vehicle_refuelrecord"   => "LBL_REFUELRECORD",
						"attendance"             => "LBL_ATTENDANCE",
					),
				),
				"Rush Platform"    => array (
					"label"     => "抢单系统",
					"status"    => "1",
					"tabid"     => array (
						"6000", "6001", "6002", "6003", "6004", "6005", "6006", "6007",
					),
					"parenttab" => array (
						"Rush Management",
					),
				),
				"Letter Platform" => array(
					"label"     => "书信",
					"status"    => "1",
					"tabid"     => array (
						"7000", "7001", "7002",
					),
					"parenttab" => array (
						"Letter Management",
					),
				),
                "DevPlatform" => array (
                    "label"     => "易车行分时租赁系统",
                    "status"    => "1",
                    "tabid"     => array ("7000","7001","7002","7003","7004","7005","7006","7007","7008","7009","7010","7011"),
                    "parenttab" => array ("Dev Equipments", "Dev Users", "Dev Orders","Dev Logs"),
                    "authorize" => array (),
                ),
			);
		}

	}