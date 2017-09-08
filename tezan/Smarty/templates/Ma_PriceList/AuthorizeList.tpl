<div class="panel panel-default" style="margin:2px;">
	<div class="panel-heading">
		<h3 class="panel-title">授权详情
			<a style="float:right;cursor:pointer;text-decoration: none;font-size:17px;"  data-toggle="collapse" data-target="#dealwithlist_entries">
				<i class="fa btn-default fa-caret-square-o-up"></i>
				<i class="fa btn-default fa-caret-square-o-down"></i>
			</a>
		</h3>
	</div>
	<div style="padding:0;" class="panel-body bjui-doc">
		<div id="dealwithlist_entries" class="collapse in">
			<table class="table table-bordered nowrap" style="border-width:0">
				<tr>
					<td colspan="2" style="border-width: 0px;padding: 0px;">
						<table id="pricelistlist_table" class="table table-bordered nowrap" style="border-width:0">
							<tr style="background-color:#EEEEEE;color:#013969;height: 30px;">
								<th style="text-align: center;width: 14%;">产品编号</th>
								<th style="text-align: center;width: auto;">产品名称</th>
								<th style="text-align: center;width: 14%;">产品分类</th>
								<th style="text-align: center;width: 14%;">生产厂家</th>
								<th style="text-align: center;width: 14%;">销售方</th>
								<th style="text-align: center;width: 14%;">授权价格</th>
								<th style="text-align: center;width: 14%;">授权证书</th>
								<th style="text-align: center;width: 42px;">操作</th>
							</tr>
							{foreach name=productsrows item=productrow from=$LISTENTRIES}
							<tr>
								<td style="text-align: center;background-color: #EEEEEE;">
									<div style="position: absolute;z-index: 9999;"><span class="msg-box n-top" for="pricelist_products_{$smarty.foreach.productsrows.iteration}_id"></div>
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
										<input type="hidden" value="{$productrow.productid}" data-value="{$productrow.productid}" id="pricelist_products_{$smarty.foreach.productsrows.iteration}_id" name="pricelist_products_{$smarty.foreach.productsrows.iteration}.id" data-rule="required;">
										<input type="hidden" value="{$productrow.productname}" id="pricelist_products_{$smarty.foreach.productsrows.iteration}_name" name="pricelist_products_{$smarty.foreach.productsrows.iteration}.name">
										<input type="hidden" value="{$productrow.categoryid}" id="pricelist_products_{$smarty.foreach.productsrows.iteration}_category" name="pricelist_products_{$smarty.foreach.productsrows.iteration}.category">
										<input type="hidden" value="{$productrow.factoryid}" id="pricelist_products_{$smarty.foreach.productsrows.iteration}_factorys" name="pricelist_products_{$smarty.foreach.productsrows.iteration}.factorys">
										<input type="text" value="{$productrow.productno}" style="width: 100%;cursor:pointer;" name="pricelist_products_{$smarty.foreach.productsrows.iteration}.productsno" id="pricelist_products_{$smarty.foreach.productsrows.iteration}_productsno" readonly {if $READONLY neq 'true'}class="required"{else}disabled{/if} onclick="$(this).parent().find('a.bjui-lookup').trigger('click');"/>
										{if $READONLY neq 'true'}
										<a data-callback="pricelist_products_callback" class="bjui-lookup" data-toggle="lookupbtn" data-newurl=""
										   data-oldurl="index.php?module=Ma_PriceList&action=ProductsList&mode=0&exclude="
										   data-url="index.php?module=Ma_PriceList&action=ProductsList&mode=0&exclude={$PRODUCTSIDS}"
										   data-group="pricelist_products_{$smarty.foreach.productsrows.iteration}" data-maxable="false" data-title="选择产品"
										   href="javascript:;" style="height: 22px; line-height: 22px;"><i class="fa fa-search"></i>
										</a>
										{/if}
									</span>
								</td>
								<td id="pricelist_products_{$smarty.foreach.productsrows.iteration}_name_td" style="text-align: center;background-color: #EEEEEE;">{$productrow.productname}</td>
								<td id="pricelist_products_{$smarty.foreach.productsrows.iteration}_category_td" style="text-align: center;background-color: #EEEEEE;">{$productrow.categoryname}</td>
								<td id="pricelist_products_{$smarty.foreach.productsrows.iteration}_factory_td" style="text-align: center;background-color: #EEEEEE;">{$productrow.factoryname}</td>
								<td style="text-align: right;background-color: #EEEEEE;">
									<div style="position: absolute;z-index: 9999;"><span class="msg-box n-top" for="pricelist_agencys_{$smarty.foreach.productsrows.iteration}_id"></div>
									<span class="wrap_bjui_btn_box" style="position: relative; display: inline-block;width:100%;">
										<input type="hidden" value="{$productrow.agencysid}" data-value="{$productrow.agencysid}" id="pricelist_agencys_{$smarty.foreach.productsrows.iteration}_id" name="pricelist_agencys_{$smarty.foreach.productsrows.iteration}.id" data-rule="required;">
										<input type="text"  value="{$productrow.agencysname}" style="width: 100%;cursor:pointer;" name="pricelist_agencys_{$smarty.foreach.productsrows.iteration}.name" id="pricelist_agencys_{$smarty.foreach.productsrows.iteration}_name" readonly {if $READONLY neq 'true'}class="required"{else}disabled{/if} onclick="$(this).parent().find('a.bjui-lookup').trigger('click');"/>
										{if $READONLY neq 'true'}
										<a data-callback="pricelist_agencys_callback" class="bjui-lookup" data-toggle="lookupbtn" data-newurl=""
										   data-oldurl="index.php?module=Ma_Agencys&action=Popup&popuptype=Ma_PriceList&mode=0&exclude="
										   data-url="index.php?module=Ma_Agencys&action=Popup&popuptype=Ma_PriceList&mode=0&exclude={$productrow.agencysid}"
										   data-group="pricelist_agencys_{$smarty.foreach.productsrows.iteration}" data-maxable="false" data-title="选择经营企业"
										   href="javascript:;" style="height: 22px; line-height: 22px;"><i class="fa fa-search"></i>
										</a>
										{/if}
									</span>
								</td>
								<td style="text-align: center;background-color: #EEEEEE;">
									<div style="position: absolute;z-index: 9999;"><span class="msg-box n-top" for="pricelist_price_{$smarty.foreach.productsrows.iteration}"></div>
									<input id="pricelist_price_{$smarty.foreach.productsrows.iteration}" name="pricelist_price_{$smarty.foreach.productsrows.iteration}" type="text" style="left: 0; width: 90%;text-align: center;" data-rule="required;number;" {if $READONLY neq 'true'}class="required"{else}disabled{/if} value="{$productrow.price}" data-value="{$productrow.price}">
									<span  style="padding:0px 2px;margin-left:-3px;z-index:-1;">元</span>
								</td>
								<td style="text-align: center;background-color: #EEEEEE;">
									<div style="position: absolute;z-index: 9999;"><span class="msg-box n-top" for="pricelist_certificate_{$smarty.foreach.productsrows.iteration}_plupload_required"></div>
									<div id="pricelist_certificate_{$smarty.foreach.productsrows.iteration}_plupload_div" style="width: 100%;overflow: hidden;"></div>
									<script type="text/javascript"  defer="defer">
										inituploadfile('{$ID}','{$productrow.certificate}','pricelist_certificate_{$smarty.foreach.productsrows.iteration}','{$READONLY}');
									</script>
								</td>
								<td style="text-align: center;width: 42px;{if $READONLY eq 'true'}background-color: #EEEEEE;{/if}">
									{if $READONLY neq 'true'}
									<button class="btn btn-red" data-icon="times" onclick="removeproducts(this);" type="button"></button>
									{/if}
								</td>
							</tr>
							{/foreach}
						</table>
					</td>
				</tr>
				{if $READONLY neq 'true'}
					<tr>
						<td style="background-color: #EEEEEE;width: auto;">
							<input type="hidden" value="{$LISTENTRIES|@count}" name="pricelisttotlerows" id="pricelisttotlerows"/>
						</td>
						<td style="text-align: center;width: 43px;">
							<button id="addnewpricelistrowbtn" class="btn btn-green" data-icon="plus" onclick="addnewpricelistrow();" type="button"></button>
						</td>
					</tr>
				{/if}
			</table>
		</div>
	</div>
</div>