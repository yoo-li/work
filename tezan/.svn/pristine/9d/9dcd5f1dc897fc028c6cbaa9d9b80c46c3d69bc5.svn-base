{foreach name=agencysrows key=agencysid item=agencys from=$LISTENTRIES}
	<div class="panel-heading"><h3 class="panel-title">{$agencys.agencysname}</h3> </div>
	<table class="table table-bordered nowrap" style="border-width:0">
		<tr style="background-color:#EEEEEE;color:#013969;height: 30px;">
			<th style="text-align: center;width: 14%;">产品名称</th>
			<th style="text-align: center;width: 14%;">条形码</th>
			<th style="text-align: center;width: auto;">规格</th>
			<th style="text-align: center;width: auto;">单位</th>
			<th style="text-align: center;width: 14%;">生产厂商</th>
			<th style="text-align: center;width: auto;">助记码</th>
			<th style="text-align: center;width: auto;">注册证号</th>
			<th style="text-align: center;width: auto;">单价</th>
			<th style="text-align: center;width: auto;">数量</th>
			<th style="text-align: center;width: auto;">发货数量</th>
			<th style="text-align: center;width: auto;">验收数量</th>
			<th style="text-align: center;width: auto;">退回数量</th>
		</tr>
		{foreach name=productsrows key=recordid item=productrow from=$agencys.products}
			<tr>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.productname}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.barcode}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.guige}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.unit}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.factorys_name}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.memorycode}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.registercode}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.price}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.number}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.sendnumber}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.checknumber}</td>
				<td style="text-align: center;background-color: #EEEEEE;">{$productrow.returnnumber}</td>
			</tr>
		{/foreach}
	</table>

{/foreach}