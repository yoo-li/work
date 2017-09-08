<style>
	{literal}
	.cart-p{
		width:50%;
		float:right;
		height:25px;
		line-height:25px;
		padding-top:5px;
		padding-left:90px;
	}
	.cart-class{
		cursor:pointer;
		color:2B8CD0;
		float: right;
		width:20px;height:20px;
		line-height:20px;
		margin-right:10px;
		z-index:1000;
	}
	{/literal}
</style>

<div class="bjui-pageContent">
	{foreach item=productinfo key=record from=$products}
		<div id="{$record}" style="display: block; width: 240px; height: 175px; position: relative; float: left; margin: 2px 3px; border: 1px solid rgb(205, 205, 205); z-index: 1;">
			<div style="position: relative;height: 30px;background-color: rgb(43, 140, 208);">
				<div style="height: 30px;float: left;">
					<label style="line-height: 30px;color: white;margin-left: 10px;font-weight:normal;">{$productinfo.productname}</label>
				</div>
			</div>
			<div style="position: relative;width: 50%;float: left;height: 120px;">
				<div style="position: relative;width: 100%;float: left;height: 90px;">
					<a rel="edit" target="navTab" href="index.php?module=Ma_Products&action=EditView&record={$productinfo.productid}" title="查看产品信息" data-toggle="navtab" data-fresh="true" data-id="edit" data-title="产品信息">
						<img class="lazy img-responsive" src="{$productinfo.productlogo}" style="width:100%;line-height: 100px;">
					</a>
				</div >
				<p style="font-size: 12px;color: #16669e;font-weight:normal;float:left;height: 30px;">批号:{$productinfo.products_batch_no}</p>
			</div>

			<div style="position: relative;width: 1px;height: 100px;float: left;margin: 10px 0px;background-color: rgb(205, 205, 205);">
			</div>
			<div style="position: relative;width: 49.5%;float: right;height: 120px;padding-left: 3px;">
				<label style="padding-top:2px;line-height: 45px;width: 100%;text-align: left;font-size: 20px;">
					<p style="font-size: 12px;color: #16669e;font-weight:normal;float:left;">厂家:{$productinfo.factorys_name}</p>
					<p style="font-size: 12px;color: #16669e;font-weight:normal;float:left;width:100%;height:21px;overflow:hidden;">规格:{$productinfo.guige}</p>
					<p style="font-size: 12px;color: #16669e;font-weight:normal;float:left;width:100%;height:21px;overflow: hidden;">型号:{$productinfo.unit}</p>
				</label>
			</div>
			<div style="height: 25px;background-color: rgb(205, 205, 205);margin-top: 120px;">
				<p style="width:50%;float:left;height:20px;line-height:20px;padding-top:5px;padding-left:10px;">剩余<span id="onsale_number_{$record}" class="red" style="font-size: 16px;">{$productinfo.number}</span>{$productinfo.unit}</p>
				{if $isplatagency neq '1' and $isonsalesupplier eq '1'}
					<p class="cart-p">
						<i onclick="addShoppingcarts(this,'{$record}');" id="add_button_{$record}" class="fa fa-iconfont icon-ma_shoppingcarts cart-class"></i>
					</p>
				{/if}
			</div>
		</div>
	{/foreach}
</div>