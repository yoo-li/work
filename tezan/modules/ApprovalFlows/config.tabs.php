<?php
//添加对应的表tabid=>"tabname"即可以在审批流程中配置对这个表的审批流程
        $all_entity_tabs_array =
            array(
                202 => 'MakeBudget',
                203 => 'Loan',
                204 => 'Reimbursement',
                205 => 'ReceiveCash',
                206 => 'AddBudget',
                207 => 'SpecialProject', 
                320 => 'Suppliers',
				403 => 'SupplierCorrect', 
                2004 => 'Supplier_Shops',
                4001 => 'Ma_Products',
                4003 => 'Ma_Rejects',
                4004 => 'Ma_Factorys',
                4005 => 'Ma_Agencys',
              	4006 => 'Ma_Hospitals',
                4081 => 'Ma_RegisterCodes',
				4002 => 'Ma_PriceList',
                4016 => "Ma_DeliveryContract",
                4192 => "Ma_OnSaleSuppliers",
                4193 => "Ma_OnSaleProducts",
				5004 => 'Vehicle_Apply',

            );
			
            try{
                global $global_session; 
$tabdata  = $global_session['tabdata']; 
                $all_tabs_array = $tabdata['all_entity_tabs_array'];
				$all_entity_tabs_array = array_intersect($all_entity_tabs_array,$all_tabs_array);
            }
			catch(XN_Exception $e){}
?>