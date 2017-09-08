{if $HASAPPROVALS eq 'true' && $APPROVALID neq ''}
<div class="panel panel-default" style="margin:2px;">
    <div class="panel-heading"><h3 class="panel-title">{'LBL_APPROVALS'|@getTranslatedString}<a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#approval_form_div"><i class="fa btn-default fa-caret-square-o-up"></i><i class="fa btn-default fa-caret-square-o-down"></i></a> </h3></div>
    <div style="padding:0;" class="panel-body bjui-doc">
		<div id="approval_form_div" class="collapse in">
				{if $APPROVALDIALOG}
					{$APPROVALDIALOG}
				{/if}
		         <div class="form-group" style="margin: 20px 0 20px; ">
			            <label class="control-label x100">{$APP.LBL_APPROVALS_HIGHER_OPINION}:</label>
						<input type="radio" name="reply" id="reply_agree" value="Agree" data-toggle="icheck" data-label="{$APP.LBL_AGREE}" checked>
						<input type="radio" name="reply" id="reply_disagree" value="Disagree" data-toggle="icheck" data-label="{$APP.LBL_DISAGREE}">
 		          </div>
 		          <div class="form-group" style="margin: 20px 0 20px; ">
 			            <label class="control-label x100">{$APP.LBL_APPROVALS_HIGHER_REPLAY}:</label>
 						<textarea class="detailedViewTextBox textInput" id="reply_text" style="width:80%;"></textarea>
 		          </div>
 		          <div class="form-group" style="margin: 20px 0 20px; ">
 			            <label class="control-label x100">&nbsp;</label>
						<a type="button" class="btn btn-orange" data-icon="save" onclick="submit_approvals('{$MODULE}','{$APPROVALID}')" >{$APP.LBL_APPROVALS_SAVE_BUTTON_TITLE}</a>
  		          </div> 
		</div>
    </div>
</div>  
<script language="JavaScript">


function submit_approvals(module,recordid)
{ldelim}
	var reply_text = $('#reply_text').val();
	var reply = $("input[name='reply']:checked").val();
	if(reply == undefined)
	{ldelim}		
		alertMsg.error(alert_arr.APPROVALS_CAN_BE_SELECT);
		return false;
	{rdelim}
	var details="";
	$("[name='details']:checked").each(function(){ldelim}if (details==""){ldelim} details=$(this).val(); {rdelim}else{ldelim} details+=","+$(this).val();{rdelim}{rdelim});
 	
	$(this).alertmsg('confirm', "保存审批后，将无法撤销审批，\n您是否确定保存审批？", {ldelim}
		     displayMode:'slide', displayPosition:'middlecenter', okName:'确定保存', cancelName:'取消', title:'审批',
		     okCall: function()
			 {ldelim}
	 			var url =  'index.php?module=Approvals&action=saveApprove&record='+recordid+'&formodule='+module+ '&reply=' + reply + '&details=' + details + '&reply_text=' + reply_text;
				$(this).bjuiajax("doAjax", {ldelim}url:url,loadingmask:true{rdelim});
			 {rdelim}
	    {rdelim}); 
		
{rdelim}
</script>
{/if}

