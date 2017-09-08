<table class="table table-bordered nowrap" style="border-width:0">
	<tr style="background-color:#EEEEEE;color:#013969;height: 30px;">
		<th style="text-align: center;width: 14%;">产品编号</th>
		<th style="text-align: center;width: auto;">产品名称</th>
		<th style="text-align: center;width: 14%;">产品分类</th>
		<th style="text-align: center;width: 14%;">生产厂家</th>
		<th style="text-align: center;width: 14%;">授权价格</th>
		<th style="text-align: center;width: 14%;">采购数量</th>
		{if $READONLY neq 'true'}
			<th style="text-align: center;width: 42px;">操作</th>
		{/if}
	</tr>
	{foreach name=productsrows key=recordid item=productrow from=$LISTENTRIES}
		<tr>
			<td style="text-align: center;background-color: #EEEEEE;">{$productrow.productno}</td>
			<td style="text-align: center;background-color: #EEEEEE;">{$productrow.productname}</td>
			<td style="text-align: center;background-color: #EEEEEE;">{$productrow.categoryname}</td>
			<td style="text-align: center;background-color: #EEEEEE;">{$productrow.factoryname}</td>
			<td style="text-align: center;background-color: #EEEEEE;">{$productrow.price}</td>
			<td id="productnumber_{$recordid}" style="text-align: center;background-color: #EEEEEE;">{$productrow.number}</td>
			{if $READONLY neq 'true'}
				<td style="text-align: center;width: 42px;">
					<button class="btn btn-green" data-icon="plus" onclick="ModifyProductQuantity('{$recordid}','add');" type="button"></button>
					<button class="btn btn-green" data-icon="minus" onclick="ModifyProductQuantity('{$recordid}','minus');" type="button"></button>
					<button class="btn btn-red" data-icon="times" onclick="delProduct(this,'{$recordid}');" type="button"></button>
				</td>
			{/if}
		</tr>
	{/foreach}
</table>