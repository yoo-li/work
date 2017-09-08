<style>
    {literal}
        .my-bjui-navtab { position:absolute;width:100%; left:0px;}
        .tabsPageHeaderMarginLeft{margin-left:20px;}
        .tabsPageHeaderMarginRight{margin-right:39px;}
		.tabcontainer td {line-height:30px;}
		.tabcontainer td i {}
		 
    {/literal}
</style>
<script type='text/javascript' src="/Public/js/my_bjui_navtab.js"></script>
<script type='text/javascript'>
    {literal}
    var prevBtn     = $(".my-bjui-navtab").find('.tabsLeft')
    var nextBtn     = $(".my-bjui-navtab").find('.tabsRight')
    var ul_contaimer= $(".my-bjui-navtab").find(".tabsPageHeaderContent")
    var maxIndex    = $(".my-bjui-navtab").find("ul.navtab-tab>li").length
    var iW=0;//所有选显卡的宽度之和
    $(".my-bjui-navtab").find("ul.navtab-tab>li").each(function() {
        iW += $(this).outerWidth(true)
    })
    function vtlib_toggleModule(module, enable_disable, type,formodule) {
        if(typeof(formodule) == 'undefined') formodule = '';
        if(typeof(type) == 'undefined') type = '';
        var postBody = "index.php?module=Settings&action=ModuleSwitch&module_name=" + encodeURIComponent(module) + "&enable_disable=" + enable_disable  + "&type=" + type + "&formodule="+formodule;
        //jQuery("#my-navtab-content").loadUrl(postBody);
		 $(this).bjuiajax("doLoad", {url:postBody, target:"#my-navtab-content",loadingmask:true});
    }

    {/literal}
</script>


<div class="pageFormContent">
    <div id="bjui-navtab" class="my-bjui-navtab tabsPage" style="left:0px;">
        <div class="tabsPageHeader">
            <div class="tabsPageHeaderContent">
                <ul class="navtab-tab nav nav-tabs">
				{assign var="modulelabel" value=$APP.$FORMMODULE}
                {foreach key=tabname item=tablabel from=$HEADERS} 
                    {if $APP[$tablabel] neq ''}
                    {if $APP[$tablabel] eq $modulelabel}
                        <li id="{$tabname}" data-url="" class="active">
                            <a href="index.php?module=Settings&action=ModuleSwitch&formodule={$tabname}" role="tab" data-toggle="ajaxtab" data-target="#my-navtab-content" data-reload="true">
                                <span>{$APP[$tablabel]}</span>
                            </a>
                        </li>
                    {else}
                        <li id="{$tabname}" data-url="">
                            <a href="index.php?module=Settings&action=ModuleSwitch&formodule={$tabname}" role="tab" data-toggle="ajaxtab" data-target="#my-navtab-content" data-reload="true">
                                <span>{$APP[$tablabel]}</span>
                            </a>
                        </li>
                    {/if}
                    {/if}
                {/foreach}
                </ul>
            </div>
            <div class="tabsLeft" style="display: none;" onclick="scrolltoleft()"><i class="fa fa-angle-double-left"></i></div>
            <div class="tabsRight" style="display: none;" onclick="scrolltoright()"><i class="fa fa-angle-double-right"></i></div>
            <div class="tabsMore" onclick='showMoreList()'><i class="fa fa-angle-double-down"></i></div>
        </div>

        <ul class="tabsMoreList" style="display: none;">
            {foreach key=tabname item=tablabel from=$HEADERS}
                {if $APP[$tablabel] neq ''}
                    <li data-id="{$tabname}" data-tabid="{$tabname}" data-url="index.php?module=Settings&action=ModuleSwitch&module_name={$tabname}&formodule={$tabname}">
                        <a onclick="switchtotab(this,'{$tabname}','index.php?module=Settings&action=ModuleSwitch&module_name={$tabname}&formodule={$tabname}')" data-tabid="{$tabname}" href="javascript:;" role="tab" data-toggle="ajaxtab" data-reload="true">
                            {$APP[$tablabel]}
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>

        <div  class="tab-content">
            <div id="my-navtab-content">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tabcontainer">
                    <tr>
                        <td>
                            <table border=0 cellspacing=5 cellpadding=5 width=100% style="border-spacing: 10px 10px;border-bottom:1px solid #bcb7a0; ">
                                <tr>
                                {assign var="modulelabel" value=$APP.$FORMMODULE}
                                    <td align=right width=150>{$modulelabel}</td>
                                    <td align=left width=50>
                                    {if $FORMMODULE_PRESENCE eq 0}
                                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$FORMMODULE}', 'main','1','{$FORMMODULE}');">
                                            <i class="fa fa-toggle-on"></i>
                                        </a>
                                        {else}
                                        <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$FORMMODULE}', 'main','0','{$FORMMODULE}');">
                                            <i class="fa fa-toggle-off"></i>
                                        </a>
                                    {/if}
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <table border=0 cellspacing=5 cellpadding=5 width=750 style="border-spacing: 10px 10px;">
                            {assign var="i" value=0}
                            {assign var="count" value=$TOGGLE_MODINFO|@count}
                            {foreach key=modulename item=modinfo from=$TOGGLE_MODINFO}
                                {if $modinfo.customized eq false}
                                    {assign var="modulelabel" value=$modulename}
                                    {assign var="modi" value=$i%4}
                                    {if $APP.$modulename}{assign var="modulelabel" value=$APP.$modulename}{/if}

                                    {if ($modi eq 0) }<tr>{/if}
                                    <td align=right width=150>{$modulelabel}</td>
                                    <td align=left>
                                        {if $modinfo.presence eq 0}
                                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$modulename}', '1','','{$FORMMODULE}');">
                                                <i class="fa fa-toggle-on"></i>
                                            </a>
                                            {else}
                                            <a href="javascript:void(0);" onclick="vtlib_toggleModule('{$modulename}', '0','','{$FORMMODULE}');">
                                                <i class="fa fa-toggle-off"></i>
                                            </a>
                                        {/if}
                                    </td>
                                    {if $modi eq 3 }</tr>{/if}
                                {/if}
                                {assign var="i" value=$i+1}
                            {/foreach}
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="bjui-pageFooter">
    <ul>
        <li><button type="button" class="btn-close" data-icon="close">关闭</button></li> 
    </ul>
</div>