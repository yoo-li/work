
<div id="bjui-hnav">
    <div id="bjui-hnav-navbar-box">
        <ul id="bjui-hnav-navbar">
            <li class="active"><a href="javascript:;" data-toggle="slidebar"><i class="fa-iconfont icon-application"></i> 应用 </a>
                <div class="items hide" data-noinit="true">
					{assign var=did value=1}
                    <ul id="bjui-hnav-tree0" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{ldelim}callback:{ldelim}beforeExpand:MainMenu_ztree_beforeexpand{rdelim}{rdelim}" data-faicon="iconfont icon-application" data-tit="应用">
						{foreach name=tabname key=maintabs item=detail from=$HEADERS}
							{if $maintabs neq 'Analytics'}
								{assign var=lowermaintabs value=$maintabs|@strtolower}
								{assign var=newmaintabs value=' '|@str_replace:'_':$lowermaintabs}
								<!--一级菜单-->
								<li data-id="{$did}" data-pid="0" {if $smarty.foreach.tabname.iteration == 1}data-open="true"{/if} data-faicon="iconfont icon-{$newmaintabs}" data-faicon-close="iconfont icon-{$newmaintabs}">{$APP[$maintabs]}</li>
								<!--二级菜单-->
								{assign var=pid value=$did}
								{assign var=did value=$did+1}
								{foreach name=subtab  key=assembly item=module from=$detail}
									{if is_array($module) }
										<li data-id="{$did}" data-pid="{$pid}" data-faicon="iconfont icon-{$assembly|@strtolower}" {if $smarty.foreach.subtab.iteration == 1}data-open="true"{/if} data-faicon-close="iconfont icon-{$assembly|@strtolower}">{$APP[$assembly]}</li>
										{assign var=spid value=$did}
										{foreach name=subsubtab  item=submodule from=$module}
											{assign var="label" value=$HEADERLABELS.submodule}
											{if $APP.$label}
												{assign var="modulelabel" value=$APP.$label}
											{else}
												{assign var="modulelabel" value=$APP.$submodule}
											{/if}
											<!--三级菜单-->
											{assign var=did value=$did+1}
											<li data-id="{$did}" data-pid="{$spid}" data-url="index.php?module={$submodule}&action=index&parenttab={$maintabs}" data-fresh="true" data-tabid="{$submodule}" data-faicon="iconfont icon-{$submodule|@strtolower}">{$modulelabel}</li>
											{assign var="shortcuts" value=$SHORTCUTS.$submodule}
											{if $shortcuts}  
												{foreach key=shortcut item=action from=$shortcuts} 
													{assign var=did value=$did+1}
												    <li data-id="{$did}" data-pid="{$spid}" data-url="index.php?module={$submodule}&action={$action}&parenttab={$maintabs}" data-fresh="true" data-tabid="{$submodule}" data-faicon="iconfont icon-{$shortcut|@strtolower}">{$APP[$shortcut]}</li>
												 {/foreach}
											{/if}
										{/foreach}
									{else}
										{assign var="label" value=$HEADERLABELS.$module}
										{if $APP.$label}
											{assign var="modulelabel" value=$APP.$label}
										{else}
											{assign var="modulelabel" value=$APP.$module}
										{/if}
										{assign var=did value=$did+1}
										<li data-id="{$did}" data-pid="{$pid}" data-url="index.php?module={$module}&action=index&parenttab={$maintabs}" data-fresh="true" data-tabid="{$module}" data-faicon="iconfont icon-{$module|@strtolower}">{$modulelabel}</li>
										{assign var="shortcuts" value=$SHORTCUTS.$module}
										{if $shortcuts}  
											{foreach key=shortcut item=action from=$shortcuts} 
												{assign var=did value=$did+1}
											    <li data-id="{$did}" data-pid="{$pid}" data-url="index.php?module={$module}&action={$action}&parenttab={$maintabs}" data-fresh="true" data-tabid="{$submodule}" data-faicon="iconfont icon-{$shortcut|@strtolower}">{$APP[$shortcut]}</li>
											 {/foreach}
										{/if}
									{/if}									
								{/foreach}
							{/if}
						{/foreach}
                    </ul>
					<!--增加一个一级菜单(报表)-->

					{if $HASREPORT eq 'true'}
					<ul id="bjui-hnav-tree1" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{ldelim}callback:{ldelim}beforeExpand:MainMenu_ztree_beforeexpand{rdelim}{rdelim}" data-expand-all="false" data-faicon="iconfont icon-group-reports" data-tit="{$APP.Analytics}">
						{foreach name=tabname key=maintabs item=detail from=$HEADERS}
							{if $maintabs eq 'Analytics'}
								<!--二级菜单-->
								{assign var=pid value=$did}
								{assign var=did value=$did+1}
								{foreach name=subtab  key=assembly item=module from=$detail}
									{if $assembly eq 'TopN报表'}
										{assign var=menuicon value='ReportsTopN'}
									{elseif $assembly eq '环比报表'}
										{assign var=menuicon value='ReportsLinkRelative'}
									{elseif $assembly eq '同比报表'}
										{assign var=menuicon value='ReportsSameRelative'}
									{elseif $assembly eq '综合报表'}
										{assign var=menuicon value='ReportsIntegrated'}
									{else}
										{assign var=menuicon value='Reports'}
									{/if}
									<li data-id="{$did}" data-pid="{$pid}" {if $smarty.foreach.subtab.iteration == 1}data-open="true"{/if} data-faicon="iconfont icon-{$menuicon|@strtolower}" data-faicon-close="iconfont icon-{$menuicon|@strtolower}">{$assembly}</li>
									{assign var=spid value=$did}
									{foreach name=subsubtab  item=submodule key=submodulename from=$module}
										<!--三级菜单-->
										{assign var=did value=$did+1}
										{if is_array($submodule) }
											<li data-id="{$did}" data-pid="{$spid}" {if $smarty.foreach.subsubtab.iteration == 1}data-open="true"{/if} data-faicon="iconfont icon-reportitem" data-faicon-close="iconfont icon-reportitem">{$submodulename}</li>
											{assign var=sspid value=$did}
											{foreach name=subsubsubtab  item=subsubmodulename key=subsubmoduleid from=$submodule}
												{assign var=did value=$did+1}
												<li data-id="{$did}" data-pid="{$sspid}" data-url="index.php?module={$menuicon}&action=index&reportid={$subsubmoduleid}&parenttab={$maintabs}" data-fresh="true" data-tabid="{$menuicon}" data-faicon="iconfont icon-reportitem">{$subsubmodulename}</li>
											{/foreach}
										{else}
											<li data-id="{$did}" data-pid="{$pid}" data-url="index.php?module={$menuicon}&action=index&reportid={$submodule}&parenttab={$maintabs}" data-fresh="true" data-tabid="{$menuicon}" data-faicon="iconfont icon-reportitem">{$submodulename}</li>
										{/if}
									{/foreach}
								{/foreach}
							{/if}
						{/foreach}
					</ul>
					{/if}

					<!--增加一个一级菜单（系统设置）-->
					{if $IS_ADMIN eq 1}
						<ul id="bjui-hnav-tree2" class="ztree ztree_main" data-toggle="ztree" data-on-click="MainMenuClick" data-setting="{ldelim}callback:{ldelim}beforeExpand:MainMenu_ztree_beforeexpand{rdelim}{rdelim}" data-faicon="iconfont icon-settings" data-tit="{$APP.Settings}">
							{foreach name=blockname key=blockid item=details from=$MENUS}
								{assign var=lbl_blockid value=LBL_$blockid}
								{assign var=blocklabel value=$lbl_blockid|@getTranslatedString:'Settings'}
								<!--一级菜单-->
	                                <li data-id="{$did}" data-pid="0" {if $smarty.foreach.blockname.iteration == 1}data-open="true"{/if} data-faicon="iconfont icon-{$lbl_blockid|@strtolower}" data-faicon-close="iconfont icon-{$lbl_blockid|@strtolower}">{$blocklabel}</li>
								<!--二级菜单-->
								{assign var=pid value=$did}
								{assign var=did value=$did+1}
								{foreach key=menuid item=data from=$details}
									{assign var=lbl_menuid value=LBL_$menuid}
									{assign var=label value=$lbl_menuid|@getTranslatedString:'Settings'}
									{assign var=did value=$did+1}
									<li data-id="{$did}" data-pid="{$pid}" data-url="{$data.link}" data-fresh="true" data-tabid="{$data.module}" data-faicon="iconfont icon-{$lbl_menuid|@strtolower}">{$label}</li>
								{/foreach}
							{/foreach}
						</ul>
					{/if}
				</div>
            </li>
        </ul>
    </div>
</div>
