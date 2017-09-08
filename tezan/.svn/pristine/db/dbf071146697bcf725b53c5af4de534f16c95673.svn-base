<?php
	global $currentModule;
	if(!isset($_REQUEST['areanmae']) || $_REQUEST['areanmae'] == ""){
		echo '
		<style>
			span.error{
				left:auto;
				width:auto;
			}
		</style>
		<form method="post" action="index.php" onsubmit="return validateCallback(this, dialogAjaxDone)">
			<input type="hidden" value="Shares" name="module">
			<input type="hidden" value="AreaStatistics" name="action">
			<div class="pageFormContent" style="overflow: auto;border-style: none;">
				<table class="edit-form-container" border="0" cellspacing="0" cellpadding="0">
					<tr class="edit-form-tr" style="height:60px;">
						<td class="edit-form-tdlabel mandatory">统计日期：</td>
						<td class="edit-form-tdinfo" colspan="3">
							<span>
								<input id="sharedate" class="date textInput readonly" type="text" readonly="true" datefmt="yyyy-MM-dd" name="sharedate" value="" style="float:left;width:75px">
								<a class="inputDateButton" href="javascript:;">选择</a>
							</span>
						</td>
					</tr>
					<tr class="edit-form-tr" style="height:60px;">
						<td class="edit-form-tdlabel mandatory">城市名称：</td>
						<td class="edit-form-tdinfo" colspan="3">
							<input id="areanmae" class="input input-large required textInput" type="text" value="" name="areanmae" tabindex="1" maxlength="18" >
						</td>
					</tr>
				</table>
			</div>
			<div class="formBar">
				<ul>
					<li><div class="button"><div class="buttonContent"><button type="submit">统计</button></div></div></li>
					<li><div class="button"><div class="buttonContent"><button class="close" type="button">取消</button></div></div></li>
				</ul>
			</div>
		</form>
		';
		die();
	}else{
		$readids = array();
		$noofrows = -1;
		do{
			$query = XN_Query::create ( 'Profile' )
				->filter('type','=','wxuser')
				->filter('city','like',$_REQUEST['areanmae'])
				->begin(count($readids))->end(count($readids)+500);
			$list_result = $query->execute();
			if($noofrows < 0)
				$noofrows = $query->getTotalCount();
			foreach($list_result as $info){
				$readids[] = $info->screenName;
			}
		} while (count($readids) < $noofrows);
		$share = 0;
		foreach (array_chunk($readids,200,true) as $subids){
			if(count($subids) > 0){
				$statistics = XN_Query::create ( 'Content_Count' )
				    ->filter ( 'type', 'eic', strtolower($currentModule))
				    ->filter ( 'my.deleted', '=', '0' )
					->filter ( 'my.profileid','in',$subids)
					->begin(0)->end(-1)
				    ->rollup();
				if(isset($_REQUEST["sharedate"]) && $_REQUEST["sharedate"] != "")
					$statistics->filter ( 'my.sharedate','=',$_REQUEST["sharedate"]);
				else
					$statistics->filter ( 'my.sharedate','=',date('Y-m-d'));
				$list_result = $statistics->execute();
				$share += intval($statistics->getTotalCount());
			}
		}
		if(isset($_REQUEST["sharedate"]) && $_REQUEST["sharedate"] != "")
			if($_REQUEST["sharedate"] == date('Y-m-d'))
				$params=array('area'=>'[ '.$_REQUEST['areanmae'].' ] 今日的分享总次数','count'=>$share);
			else
				$params=array('area'=>'[ '.$_REQUEST['areanmae'].' ]在 '.$_REQUEST["sharedate"].' 的分享总次数','count'=>$share);
		else
			$params=array('area'=>'[ '.$_REQUEST['areanmae'].' ] 今日的分享总次数','count'=>$share);
		echo'{"statusCode":"200","message":"","tabid":"","callbackType":"closeDialog","params":'.json_encode($params).',"forward":null}';
	}
?>