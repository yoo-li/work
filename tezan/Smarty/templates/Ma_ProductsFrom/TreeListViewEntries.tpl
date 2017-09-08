<div id="refresh_tree_listview">
    <div class="bjui-pageContent tableContent tree-left-box" style="width:30%;">
        {$ZTREEDATA}
    </div>
    <div id="refresh_listview_entries" class="bjui-pageContent tableContent" style="left: 30%;width:70%;">
        <div class="bjui-pageContent tableContent" style="bottom: 30px;overflow: hidden;">
            <div class="panel panel-default" style="float:left;width:60%;height:auto;overflow-y:scroll; ">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a href="#agencys_form_div" data-toggle="collapse">
                            <i class="fa fa-book"></i><span> 经营企业</span>
                            <b>
                                <i class="fa btn-default fa-caret-square-o-up"></i>
                                <i class="fa btn-default fa-caret-square-o-down"></i>
                            </b>
                        </a>
                    </h3>
                </div>
                <div style="padding:0;" class="panel-body bjui-doc">
                    <div id="agencys_form_div" class="collapse in">
                    </div>
                </div>
            </div>
            <div class="panel panel-default" style="float:left;width:40%;height:auto;overflow-y:scroll; ">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a href="#hospitals_form_div" data-toggle="collapse">
                            <i class="fa fa-book"></i><span> 医疗机构</span>
                            <b>
                                <i class="fa btn-default fa-caret-square-o-up"></i>
                                <i class="fa btn-default fa-caret-square-o-down"></i>
                            </b>
                        </a>
                    </h3>
                </div>
                <div style="padding:0;" class="panel-body bjui-doc">
                    <div id="hospitals_form_div" class="collapse in">

                    </div>
                </div>
            </div>
        </div>
        <div class="bjui-pageFooter" style="height: 30px;">
        </div>
    </div>
</div>
