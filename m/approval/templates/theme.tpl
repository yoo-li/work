{if $supplier_info.navigationbarcolor neq ''}
	<style>
	<!-- 
	   header.mui-bar {ldelim}background-color: {$supplier_info.navigationbarcolor}; {rdelim}
	   header .mui-title, header a {ldelim} color: {$supplier_info.navigationtextcolor}; {rdelim}
	   .mui-bar-tab .mui-tab-item.mui-active {ldelim} color: {$supplier_info.tabbariconselectcolor}; {rdelim}
	   .mui-grid-view.mui-grid-9 .mui-media {ldelim} color: {$supplier_info.navigationbarcolor}; {rdelim}
	   .menuicon {ldelim} color: {$supplier_info.navigationbarcolor}; {rdelim}
	   .mui-searchbar {ldelim} background-color: {$supplier_info.navigationbarcolor}; {rdelim} 
	   .tishi {ldelim} color: {$supplier_info.navigationbarcolor}; {rdelim}
	   h5.show-content {ldelim} background: {$supplier_info.navigationbarcolor}; color: {$supplier_info.navigationtextcolor};{rdelim}
	   .mui-segmented-control-negative.mui-segmented-control-inverted .mui-control-item.mui-active {ldelim} color: {$supplier_info.navigationbarcolor};  border-bottom: 2px solid {$supplier_info.navigationbarcolor};{rdelim}
	   .button-color {ldelim}  color: {$supplier_info.buttoncolor};  {rdelim} 
	   .mui-table-view input[type='radio']:checked:before,.mui-radio input[type='radio']:checked:before, .mui-checkbox input[type='checkbox']:checked:before {ldelim}  color: {$supplier_info.buttoncolor};  {rdelim} 
	    
		{if $supplier_info.navigationbarcolor eq $supplier_info.buttoncolor }
		 	.special-button-color {ldelim}  color: #fff;  {rdelim} 
		{else}
		 	.special-button-color {ldelim}  color: {$supplier_info.buttoncolor};  {rdelim} 
		{/if} 
	-->
	</style>
{/if}