<?php


$config_picklist =  array (  	 			    
				'stagestatus' => array(
										array( 'label' => '百分比', 'fieldname' => 'percent', 'memo' => '%','type'=>'number','min'=>0,'max'=>100,'width'=>100,'default'=>0 ),
									),
				'projectstage' => array(
										array( 'label' => '项目阶段进度最小值', 'fieldname' => 'min', 'memo' => '%','type'=>'number','min'=>0,'max'=>100,'width'=>100,'default'=>0 ),
										array( 'label' => '项目阶段进度最大值', 'fieldname' => 'max', 'memo' => '%','type'=>'number','min'=>0,'max'=>100,'width'=>100,'default'=>100  ),
									),
				'reimbursement_type' => array(
										array( 'label' => '报销明细', 'fieldname' => 'details', 'memo' => '以;分隔','type'=>'textarea','width'=>300 ),
									),
					);



$config_profile_picklist =  array (  	 			    
				'StorageList' => array('personman'),	
				'AccountReceivable' => array('business_manager'),
				'AccountPayable' => array('business_manager'),
				'BillInManage' => array('business_manager'),
				'BillOutManage' => array('business_manager'),	
				'BorrowManage' => array('business_manager'),	
				'Charge' => array('business_manager'),	
					);

?>