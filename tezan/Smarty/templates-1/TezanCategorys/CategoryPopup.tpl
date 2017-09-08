{if $MODE neq "ajax"}
<link rel="stylesheet" href="/Public/css/zTreeStyle/zTreeStyle.css" type="text/css" />
<div class="tabsContent">
    <div inited="600" style="display: block;">
        <!--左边菜单 -->
        <div layouth="8" style="float: left; display: block; overflow: auto; width: 150px; border: 1px solid rgb(204, 204, 204);background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;">
            <div class="accordionContent">
                {$CATEGORYTREE}
            </div>
        </div>
        <!--右边列表 -->
        <div id="jbsxBox" class="unitBox" style="margin-left:156px;">
            {/if}
            <!--搜索框块-->
            <div class="pageHeader">
                <form id="pagerForm" onsubmit="return divSearch(this, 'jbsxBox');" action="index.php" method="post">
                    <input type="hidden" name="module" value="{$MODULE}"/>
                    <input type="hidden" name="filter" value="{$FILTER}"/>
                    <input type="hidden" name="action" value="CategoryPopup"/>
                    <input type="hidden" name="popuptype" value="{$POPUPTYPE}"/>
                    <input type="hidden" name="exclude" value="{$EXCLUDE}"/>
                    <input type="hidden" name="categorys" value="{$categorys}">
                    <input type="hidden" name="mode" value="ajax">
                    <input type="hidden" name="pageNum" value="{$PAGENUM}"/>
                    <input type="hidden" name="numPerPage" value="{$NUMPERPAGE}"/>
                    <input type="hidden" name="_order" value="{$ORDER_BY}"/>
                    <input type="hidden" name="_sort" value="{$ORDER}"/>
                    <div class="searchBar">
                        <ul class="searchContent">
                            <li>
                                <label>关键词：</label>
                                <input type="text" name="search_text" value="{$SEARCH_TEXT}"/>
                            </li>
                            <li>
                                <label>字段：</label>
                                <select id="search_field" name ="search_field" >
                                    {html_options selected="$SEARCH_FIELD" options=$SEARCHLISTHEADER  }
                                </select>
                            </li>
                        </ul>
                        <div class="subBar">
                            <ul>
                                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>

            <div class="j-resizeGrid" style="border-left:1px #B8D0D6 solid;border-right:1px #B8D0D6 solid">
                <!--操作按钮列-->
                <!--
                <div class="panelBar">
                    <ul class="toolBar">
                        <li><a class="add" href="##" target="dialog" mask="true"><span>添加尿检检测</span></a></li>
                        <li><a class="delete" href="##" target="ajaxTodo" title="确定要删除吗?"><span>删除</span></a></li>
                        <li class=""><a class="edit" href="##" target="dialog" mask="true"><span>修改</span></a></li>
                        <li class="line">line</li>
                        <li class=""><a class="icon" href="##" target="dwzExport" title="实要导出这些记录吗?"><span></span></a></li>
                    </ul>
                </div>
                -->
                <!--数据块-->
                <table class="table layoutH" width="100%" targetType="dialog" layoutH="116">
                    <thead>
                    <tr>
                        {foreach name="listviewforeach" item=header key=key from=$LISTHEADER}
                            {if $header.sort eq 'true'}
                                {if $ORDER_BY eq $key}
                                    <th class="center {$ORDER}" width="{$header.width}%" orderField="{$key}" >{$header.label}</th>
                                {else}
                                    <th class="center" width="{$header.width}%" orderField="{$key}" >{$header.label}</th>
                                {/if}
                            {else}
                                <th class="center" width="{$header.width}%" >{$header.label}</th>
                            {/if}
                        {/foreach}
                    </tr>
                    </thead>
                    <tbody>
                    {foreach name="listviewentity" item=entity key=entity_id from=$LISTENTITY}
                        {assign var=worknotices value=$entity.worknotices}
                        <tr target="sid" rel="{$entity_id}" {if $worknotices eq 'UnRead'} style= "background:#DDDDD0"{/if} bgcolor={cycle values="#FFFFFF,#EEEEEE"} id="row_{$entity_id}">
                            {foreach item=data key=key from=$entity}
                                {if $key neq 'worknotices' || $key eq '0' }
                                    {foreach name="listviewforeach" item=header key=headkey from=$LISTHEADER}
                                        {if $smarty.foreach.listviewforeach.iteration eq $key+1 }
                                            <td class="listview {$header.align}" class="listview" >{$data}</td>
                                        {/if}
                                    {/foreach}
                                {/if}
                            {/foreach}
                        </tr>
                        {foreachelse}
                        <tr><td style="background-color:#efefef;height:220px;">
                                <div style="left:150px;width: 45%; position: relative;overflow:visible;">
                                    <table border="0" cellpadding="5" cellspacing="0" width="98%">
                                        <tr >
                                            <td rowspan="2" width="64" align="right"><img src="/images/denied.gif" height="64" width="64"></td>
                                            <td rowspan="2" width="3%" align="right">&nbsp;</td>
                                            <td nowrap="nowrap" width="90%" align="left">
                                                <span class="genHeaderSmall">{$APP.LBL_POPUPMESSSAGE}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td></tr>
                    {/foreach}
                    </tbody>
                </table>

                <!-- 分页条-->
                <div class="panelBar hover">
                    <div class="pages">
                        <span>显示</span>
                        <select class="combox" name="numPerPage" onchange="dwzPageBreak({ldelim}targetType:'dialog',rel:'jbsxBox',numPerPage:this.value{rdelim})">
                            <option value="10" {if $NUMPERPAGE eq '10'}selected{/if}>10</option>
                            <option value="20" {if $NUMPERPAGE eq '20'}selected{/if}>20</option>
                            <option value="50" {if $NUMPERPAGE eq '50'}selected{/if}>50</option>
                            <option value="100" {if $NUMPERPAGE eq '100'}selected{/if}>100</option>
                            <option value="200" {if $NUMPERPAGE eq '200'}selected{/if}>200</option>
                        </select>
                        <span>条，共{$NOOFROWS}条</span>
                    </div>
                    <div class="pagination" targetType="dialog" rel="jbsxBox" totalCount="{$NOOFROWS}" numPerPage="{$NUMPERPAGE}" pageNumShown="10" currentPage="{$PAGENUM}"></div>
                </div>
            </div>
            {if $MODE neq "ajax"}
        </div>
    </div>
</div>
{/if}
