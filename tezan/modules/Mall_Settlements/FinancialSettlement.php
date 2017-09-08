<?php
global $currentModule, $supplierid;
if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
{

    if (isset($_REQUEST['type']) && $_REQUEST['type'] == "submit")
    {
        if (isset($_REQUEST['actualvendormoney']) && $_REQUEST['actualvendormoney'] != "")
        {
            $record = $_REQUEST['record'];
            $actualvendormoney = $_REQUEST['actualvendormoney'];

            $loadcontent = XN_Content::load($record, strtolower($currentModule),7);
			$status = strtolower($currentModule).'status';
			$loadcontent->my->$status = 'Settlement';
			$loadcontent->my->actualvendormoney = number_format($actualvendormoney, 2, ".", "");
			$loadcontent->my->accounting = XN_Profile::$VIEWER;
			$loadcontent->my->settlementdate = date("Y-m-d H:i"); 
			$loadcontent->my->vendorsettlementstatus = '2'; 
			$loadcontent->save("mall_settlements,mall_settlements_".$supplierid);  
			
			
		    $mall_settlementorders = XN_Query::create("YearContent")->tag("mall_settlementorders_".$supplierid)
		        ->filter("type","eic","mall_settlementorders")
		        ->filter("my.vendorsettlementid","=",$record)
				->filter("my.deleted","=",'0')
		        ->end(-1)
		        ->execute();
		    foreach($mall_settlementorders as $mall_settlementorder_info){
		        $mall_settlementorder_info->my->mall_settlementordersstatus = 'Settlement';
				$mall_settlementorder_info->my->vendorsettlementstatus = '3';
		        $mall_settlementorder_info->save("mall_settlementorders,mall_settlementorders_".$supplierid);
		    }
        }

        echo '{"statusCode":"200","message":null,"tabid":"edit","closeCurrent":true,"forward":null}';
        die();
    }
    else
    {

        $record = $_REQUEST['record'];
		$loadcontent = XN_Content::load($record,'mall_settlements_'.$supplierid,7);  
		$actualvendormoney = $loadcontent->my->actualvendormoney; 
		
		$msg= '<div class="form-group" style="width:98%;margin:3px 0px;float:left;">
					<label class="control-label x150">结算总额:</label>
					<input class="number textInput required" type="text" value="' . $actualvendormoney . '" name="actualvendormoney" tabindex="16" style="width:200px" maxlength="100" >
					<span class="left" style="padding:0 5px 0 5px">元</span>
			</div>
			';

		require_once('Smarty_setup.php');
		require_once('include/utils/utils.php');

		$smarty = new vtigerCRM_Smarty;

		$smarty->assign("MODULE",$currentModule);
		$smarty->assign("APP",$app_strings);
		$smarty->assign("MOD", $mod_strings);

		$smarty->assign("MSG", $msg);
		$smarty->assign("SUBMODULE", $currentModule);
		$smarty->assign("SUBACTION", 'FinancialSettlement'); 
		$smarty->assign("OKBUTTON", '确定结算');
	    $smarty->assign("CANCELBUTTON", getTranslatedString('LBL_CANCEL_BUTTON_LABEL'));
	    $smarty->assign("RECORD", $record); 

		$smarty->display('MessageBox.tpl');
        die();
    }
}


?>
