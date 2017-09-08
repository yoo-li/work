<?php
if (isset($_REQUEST['record']) && $_REQUEST['record'] != "")
{
    $record = $_REQUEST['record'];
    $loadcontent = XN_Content::load($record, "mall_settings");
    $showcategory = $loadcontent->my->showcategory;
    $allowreturngoods = $loadcontent->my->allowreturngoods;
    $allowpayment = $loadcontent->my->allowpayment; 
    $commissionmode = $loadcontent->my->commissionmode; 
	$autodeliverrechargeablecard  = $loadcontent->my->autodeliverrechargeablecard;  
	$showuniquesale = $loadcontent->my->showuniquesale; // 资格商品展示 
	$reception = $loadcontent->my->reception; //签到商品
	$mylogistic = $loadcontent->my->mylogistic; //自有物流 
	$mylogisticname = $loadcontent->my->mylogisticname; // 自有物流名称
	
	
}

?>
<div layouth="100" class="pageFormContent">
	<div class="form-group" style="padding-top:10px;">
                <label class="control-label x150" style="font-weight: normal">商品分类:</label>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($showcategory == '1' ? "checked" : ""); ?> type="radio" name="showcategory"
                           id="showcategory_1" value="1" tabindex="2" style="cursor: pointer;margin-top: 5px;">
                    <label for="showcategory_1"
                           style="cursor: pointer;width:auto;padding: 0;">显示</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($showcategory == '0' ? "checked" : ""); ?> type="radio" name="showcategory" id="showcategory_2" value="0" tabindex="2"
                           style="cursor: pointer;margin-top: 5px;">
                    <label for="showcategory_2"
                           style="cursor: pointer;width:auto;padding: 0;">不显示</label>
                </span>
	</div>	
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">允许退货:</label>  
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($allowreturngoods == '1' ? "checked" : ""); ?> type="radio" name="allowreturngoods" id="allowreturngoods_1" value="1" tabindex="2"
                           style="cursor: pointer;margin-top: 5px;">
                    <label for="allowreturngoods_1" style="cursor: pointer;class="form-group"width:auto;padding: 0;">允许</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($allowreturngoods == '0' ? "checked" : ""); ?> type="radio" name="allowreturngoods" id="allowreturngoods_2" value="0" tabindex="2"
                           style="cursor: pointer;margin-top: 5px;">
                    <label for="allowreturngoods_2" style="cursor: pointer;class="form-group"width:auto;padding: 0;">不允许</label>
                </span>
	</div>	
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">分销佣金:</label>  
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($commissionmode == '1' ? "checked" : ""); ?> type="radio" name="commissionmode" id="commissionmode_1" value="1" tabindex="2"
                                                                                   style="cursor: pointer;margin-top: 5px;">
                    <label for="commissionmode_1"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">直接发放</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($commissionmode == '2' ? "checked" : ""); ?> type="radio" name="commissionmode" id="commissionmode_2" value="2" tabindex="2"
                                                                                   style="cursor: pointer;margin-top: 5px;">
                    <label for="commissionmode_2"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">确认收货7天后发放</label>
                </span>
	</div>
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">充值卡自动发货:</label>  
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($autodeliverrechargeablecard == '1' ? "checked" : ""); ?> type="radio" name="autodeliverrechargeablecard" id="autodeliverrechargeablecard_1" value="1" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="autodeliverrechargeablecard_1"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">支持</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($autodeliverrechargeablecard == '0' ? "checked" : ""); ?> type="radio" name="autodeliverrechargeablecard" id="autodeliverrechargeablecard_2" value="0" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="autodeliverrechargeablecard_2"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">不支持</label>
                </span>
	</div>
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">资格商品展示:</label> 
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($showuniquesale == '0' ? "checked" : ""); ?> type="radio" name="showuniquesale" id="showuniquesale_1" value="0" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="showuniquesale_1"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">购买后继续显示</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($showuniquesale == '1' ? "checked" : ""); ?> type="radio" name="showuniquesale" id="showuniquesale_2" value="1" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="showuniquesale_2"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">购买后不显示</label>
                </span> 
	</div>
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">签到商品:</label> 
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($reception == '0' ? "checked" : ""); ?> type="radio" name="reception" id="reception_1" value="0" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="reception_1"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">关闭</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($reception == '1' ? "checked" : ""); ?> type="radio" name="reception" id="reception_2" value="1" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="reception_2"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">开启</label>
                </span> 
	</div>	
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">自有物流:</label>  
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($mylogistic == '0' ? "checked" : ""); ?> type="radio" name="mylogistic" id="mylogistic_1" value="0" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="mylogistic_1"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">关闭</label>
                </span>
                <span style="padding-right: 8px;" class="left">
                    <input <?php echo($mylogistic == '1' ? "checked" : ""); ?> type="radio" name="mylogistic" id="mylogistic_2" value="1" tabindex="2"
                                                                                 style="cursor: pointer;margin-top: 5px;">
                    <label for="mylogistic_2"
                           style="cursor: pointer;class="form-group"width:auto;padding: 0;">开启</label>
                </span>
	</div>
	<div class="form-group">
                <label class="control-label x150" style="font-weight: normal">自有物流名称:</label> 
			 <input type="text" class="input input-large  textInput" value="<?php echo $mylogisticname; ?>" name="mylogisticname" tabindex="1" maxlength="20">
                
	</div> 
        </tbody>
    </table>
</div>