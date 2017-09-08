<div class="bjui-pageContent">
{foreach item=wsdudata key=wsdudata_id from=$WSDUDATA}
	<div id="{$wsdudata_id}" style="display: block; width: 240px; height: 200px; position: relative; float: left; margin: 2px 3px; border: 1px solid rgb(205, 205, 205); z-index: 1;">
		<div style="position: relative;height: 30px;background-color: rgb(43, 140, 208)">
			<div style="height: 30px;float: left;">
				<label style="line-height: 30px;color: white;margin-left: 10px;font-weight:normal;">{$wsdudata.name}</label>
			</div>
			<div style="float: right;">
				<a data-title="温湿度曲线图" title="温湿度曲线图" href="index.php?module=Ma_StorageHumiture&action=HumitureReport&equipname={$wsdudata.name}&equip_sn={$wsdudata.equipsn}&storage={$wsdudata.storage}"
				   target="navtab" data-toggle="navtab"
				   rel="humiture" data-id="humiture" data-fresh="true"
				   style="float:right;cursor:pointer;text-decoration: none;font-size:17px;margin-top: 6px;margin-right: 10px;">
					<i class="fa fa-iconfont icon-reportitem" style="color: white;"></i>
				</a>
			</div>
		</div>
		<div style="position: relative;width: 49.5%;float: left;height: 140px;">
			<i class="fa fa-iconfont icon-wendu" style="margin-top:10px;margin-left:20px;font-size: 80px;"></i>
			<label style="line-height: 45px;width: 100%;text-align: center;font-size: 20px;">
				<span style="font-size: 20px;color: {if $wsdudata.wenduover eq '1'}#a82b25{else}#16669e{/if};">{$wsdudata.wendu}</span>
				<span style="font-size: 12px;color: rgb(205, 205, 205);font-weight:normal;">℃</span>
			</label>
		</div>
		<div style="position: relative;width: 1px;height: 100px;float: left;margin: 20px 0px;background-color: rgb(205, 205, 205);">
		</div>
		<div style="position: relative;width: 50%;float: right;height: 140px;">
			<i class="fa fa-iconfont icon-shidu" style="margin-top:10px;margin-left:20px;font-size: 80px;"></i>
			<label style="line-height: 45px;width: 100%;text-align: center;font-size: 20px;">
				<span style="font-size: 20px;color: {if $wsdudata.shiduover eq '1'}#a82b25{else}#16669e{/if};">{$wsdudata.shidu}</span>
				<span style="font-size: 12px;color: rgb(205, 205, 205);font-weight:normal;">%RH</span>
			</label>
		</div>
		<div style="height: 30px;background-color: rgb(205, 205, 205);margin-top: 138px;">
			<label style="line-height: 30px;margin-left: 10px;font-weight:normal;">{$wsdudata.time}</label>
		</div>
	</div>
{/foreach}
</div>