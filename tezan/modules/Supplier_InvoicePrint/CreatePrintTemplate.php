<?php
	if(isset($_REQUEST["type"]) && $_REQUEST["type"] == "save"){
		if (isset($_REQUEST['supplier_invoiceprint_tabid']) && $_REQUEST['supplier_invoiceprint_tabid'] != "" && isset($_REQUEST['InvoicePrintname']) && $_REQUEST['InvoicePrintname'] != "")
		{
			try{
				$invoiceprint_template = '
					<table align="center" border="0" cellspacing="0" height="50" style="font-family: Arial; font-size: 10pt" width="90%">
						<tbody>
							<tr>
								<td><span key="{UNITLOGO}">【单位LOGO】</span>
									&nbsp;</td>
								<td align="right" valign="bottom" width="50%">
									<span key="{UNITNAME}">【单位名称】</span><br />
									地址:<span key="{UNITADDR}">【单位地址】</span><br />
									电话:<span key="{UNITPHONE}">【单位电话】</span> <br />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<hr size="1" style="margin-top: 3px; color: #b0b0b0" />
								</td>
							</tr>
							<tr>
								<td colspan="2" height="50" style="font-family: 黑体; font-size: 18pt">
									<p align="center"><span key="{INVOICEPRINTNAME}">【单据打印名称】</span></p>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<table border="1" bordercolordark="#ffffff" bordercolorlight="#b0b0b0" cellpadding="0" cellspacing="0" style="width: 100%; font-family: Arial; font-size: 10pt">
										<tbody>
											<tr>
												<td align="right" height="25" width="65"><span>字段标签</span></td>
												<td>【字段内容】</td>
												<td align="right" width="65"> <span>字段标签</span></td>
												<td>【字段内容】</td>
											</tr>
											<tr>
												<td align="right" height="25">备注</td>
												<td colspan="3">&nbsp;</td>
											</tr>
										</tbody>
									</table>
									<br>
								</td>
							</tr>
							<table align="center" border="0" cellspacing="0" height="50" style="font-family: Arial; font-size: 10pt" width="90%">
								<tbody>
									<tr>
										<td style="text-align: center;" width="50%">&nbsp;</td>
										<td style="text-align: right;">
											<span>操作员</span>：</td>
										<td>
											<span key="{CURRENTVIEWER}">【当前操作员】 </span></td>
										<td style="text-align: right;">
											<span>打印日期</span>：</td>
										<td>
											<span key="{CURRENTDATE}">【当前日期】</span></td>
									</tr>
								</tbody>
							</table>
						</tbody>
					</table>
				';

				$supplier_invoiceprint_tabid = $_REQUEST['supplier_invoiceprint_tabid'];
				$module_name = getModule($supplier_invoiceprint_tabid);

				$newcontent = XN_Content::create('supplier_invoiceprint','',false);
				$newcontent->my->deleted = '0';
				$newcontent->save('supplier_invoiceprint');
				require_once('modules/Supplier_InvoicePrint/Supplier_InvoicePrint.php');
				$focus = CRMEntity::getInstance('Supplier_InvoicePrint');
				$focus->id = $newcontent->id;
				$data = array();
				$data['module_name'] = $module_name;
				$data['supplier_invoiceprint_tabid'] = $supplier_invoiceprint_tabid;
				$data['invoiceprintname'] = $_REQUEST['InvoicePrintname'];
				$pregprintdata = preg_replace('/<span key="\{INVOICEPRINTNAME\}">(.*)<\/span>/iUs', '<span key="{INVOICEPRINTNAME}">'.$_REQUEST['InvoicePrintname'].'</span>', $invoiceprint_template);

				$data['template_editor'] = $pregprintdata;
				global $supplierid;
				$focus->column_fields['supplierid'] = $supplierid;
				$data['status'] = '0';
				$data['supplierid'] = $supplierid;

				foreach($data as $fieldname => $value)
				{
					$focus->column_fields[$fieldname] =  $value;
				}
				$focus->save('Supplier_InvoicePrint');

				echo '{"statusCode":200,"tabid":"'.$currentModule.'","closeCurrent":"true"}';
			}catch(XN_Exception $e){
				echo '{"statusCode":"300","message":"'.$e->getMessage().'"}';
			}
		}else{
			echo '{"statusCode":"300","message":"参数错误"}';
		}
		die();
	}


	require_once "modules/PickList/PickListUtils.php";
	$options = getAssignedPicklistValues('supplier_invoiceprint_tabid');

	$option = "";
	foreach($options as $key => $value)
	{
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}

	echo '
		<div class="bjui-pageContent" style="overflow: hidden;">
			<form id="RoleManagerPagerForm" method="post" action="/index.php" data-toggle="validate" data-validator-option="{focusCleanup:true,timely:false}" data-alertmsg="false">
				<input type="hidden" id="module" name="module" value="Supplier_InvoicePrint">
				<input type="hidden" id="action" name="action" value="CreatePrintTemplate">
				<input type="hidden" id="type" name="type" value="save">
				<div class="form-group">
					<label class="control-label x120" for="supplier_invoiceprint_tabid">模块：</label>
					<select id="supplier_invoiceprint_tabid" name="supplier_invoiceprint_tabid" data-width="200" data-toggle="selectpicker" class="required" data-rule="required;">
						<option value="">==选择模块==</option>
					'.$option.'
					</select>
				</div>

				<div class="form-group">
					<label class="control-label x120" for="InvoicePrintname">单据打印名称：</label>
					<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;">
						<input id="InvoicePrintname" class="required form-control" type="text" style="padding-right: 15px; width: 200px;" value="" name="InvoicePrintname" tabindex="1" size="20" maxlength="40" data-rule="required;">
					</span>
				</div>
			</form>
		</div>
		<div class="bjui-pageFooter">
			<ul>
				<li><button type="button" class="btn-close" data-icon="close">关闭</button></li>
				<li><button type="submit" class="btn-green" data-icon="save"">保存</button></li>
			</ul>
		</div>
	';
