<?php
    global $currentModule, $supplierusertype, $supplierid;
    if (isset($_REQUEST['record']) && $_REQUEST['record'] != '')
    {
        $readonly    = $_REQUEST['readonly'];
        $record      = $_REQUEST['record'];
        $loadContent = XN_Content::load($record, $currentModule);
        if ($loadContent->my->approvalstatus == "" || $loadContent->my->approvalstatus == '0' ||$loadContent->author == XN_Profile::$VIEWER)
        {
            $readonly = "false";
        }
        else
        {
            $readonly = "true";
        }
        $table_index  = $record;
        $index        = 0;
        $query1       = XN_Query::create("Content")
            ->tag("ma_inventorywarndetails")
            ->filter("type", "eic", "ma_inventorywarndetails")
            ->filter("my.record", "=", $record)
            ->filter("my.deleted", "=", "0")
            ->end(-1);
        $list_result1 = $query1->execute();
        if (count($list_result1) > 0)
        {
            foreach ($list_result1 as $info)
            {
                $ma_inventorycount = XN_Query::create("Content_Count")
                    ->tag("ma_inventorycount")
                    ->filter("type", "eic", "ma_inventorycount")
                    ->filter("my.ma_products", "=", $info->my->ma_products)
                    ->filter("my.supplierid", "=", $loadContent->my->supplierid)
                    ->filter("my.storagetype", "in", ["1", "2", "3"])
                    ->filter("my.deleted", "=", "0")
                    ->rollup("my.inventorynum")
                    ->end(-1)
                    ->execute();
                if (count($ma_inventorycount) > 0)
                {
                    $ma_inventorycount_info                               = $ma_inventorycount[0];
                    $inventorys[$info->my->ma_products] = $ma_inventorycount_info->my->inventorynum;
                }
            }
        }
        echo '
    <style>
        .small-width{width:100%;}
        .middle-width{width:100%;}
        .long-width{width:100%;}
        .select_row{position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);}
    </style>
    <input type="hidden" id="cur_index"  value="0">
    <table id="datagrid" data-width="100%" data-height="500" class="table table-bordered" style="width: 100%;">
    <tr tr-index="0" style="height:25px;">
        <th width="30" align="center"  class="datagrid-linenumber-td">No.</th>
        <th width="100" align="center" class="single-row">产品名称</th>
        <th width="100" align="center" class="single-row">产品编码</th>
        <th width="100" align="center" class="single-row">产品条码</th>
        <th width="100" align="center" class="single-row">生产企业</th>
        <th width="80" align="center" class="single-row">规格</th>
        <th width="60" align="center" class="single-row">单位</th>
        <th width="80" align="center" class="single-row">当前库存</th>
        <th width="80" align="center" class="single-row">最大库存</th>
        <th width="80" align="center" class="single-row">最小库存</th>
        <th width="80" align="center" class="single-row">操作</th>';
        echo '</tr>';
        if (count($list_result1) > 0)
        {
            foreach ($list_result1 as $info)
            {
                $index++;
                if ($inventorys[$info->my->ma_products] == '')
                {
                    $inventorys[$info->my->ma_products] = 0;
                }
                echo '<tr tr-index="'.$index.'">
                 <td class="datagrid-linenumber-td" align="center">'.$index.'</td>
                <td align="center" class="datagrid-edit-td">
                 	<input type="hidden" name="ma_products['.$index.']" id="ma_products_'.$index.'" readonly="readonly" value="'.$info->my->ma_products.'" class="form-control middle-width">
                    <span>'.$info->my->productname.'</span>
                </td>
                <td align="center" class="datagrid-edit-td">
                <span>'.$info->my->barcode.'</span>
                </td>
                 <td align="center" class="datagrid-edit-td">
                  <span>'.$info->my->itemcode.'</span>
                </td>
                 <td align="center" class="datagrid-edit-td">
                 <span>'.$info->my->factorys_name.'</span>
                </td>
                <td align="center" class="datagrid-edit-td">
                <span>'.$info->my->guige.'</span>
                </td>
                <td align="center" class="datagrid-edit-td">
                <span>'.$info->my->unit.'</span>
                </td>
                <td align="center" class="datagrid-edit-td">
                    <input type="text" name="inventorynum['.$index.']" value="'.$inventorys[$info->my->ma_products].'" readonly="" class="form-control small-width">
                </td>
                <td align="center" class="datagrid-edit-td">';
                if ($readonly == "false")
                {
                    echo '<input type="text" name="maximum['.$index.']" value="'.$info->my->maximum.'" data-rule="required;change_maximum;" data-rule-change_maximum="change_maximum" class="form-control small-width"></td>
					</td>
 				<td align="center" class="datagrid-edit-td">
 				<input type="text" name="minimum['.$index.']" value="'.$info->my->minimum.'" data-rule="required;changeminimum"  data-rule-changeminimum="change_minimum" class="form-control small-width"></td>
 				 </td>
 				  <td align="center" class="datagrid-edit-td">
 				 <button type="button" onclick="remove_row(this);" class="btn btn-red" data-icon="times"><i class="fa fa-times"></i></button>
					</td>';
                }
                else
                {
                    echo '<input type="text" name="maximum['.$index.']" value="'.$info->my->maximum.'" readonly="" class="form-control small-width"></td>
					</td>
					<td align="center" class="datagrid-edit-td">
					<input type="text" name="minimum['.$index.']" value="'.$info->my->minimum.'" readonly="" class="form-control small-width"></td>
					</td>';
                }
                echo '</tr>';
            }
        }
        if ($readonly == "false")
        {
            echo '<tr id="add_tr">
        <td align="center" colspan="10"></td>
        <td align="center">
            <button type="button" onclick="addrow(this);" class="btn btn-red" data-icon="plus">
                <i class="fa fa-plus"></i>
            </button>
        </td>
    </tr>';
        }
        echo '</table>';
        echo '
         <script type="text/javascript">
              function remove_row(obj){
            $(obj).parent().parent().remove();
			$("#add_tr").css("display","");
        }
        function addrow(obj){
             var url="index.php?module=Ma_Products&action=Popup&popuptype=ma_inventorywarn&exclude=";
            var index=parseInt($("#datagrid").find("tr:last").prev().attr("tr-index"),10)+1;
            var html="<tr tr-index=\'"+index+"\' class=\'datagrid-add-tr datagrid-edit-tr nice-validator n-red datagrid-hover\' novalidate=\'novalidate\'>"+
                "<td class=\'datagrid-linenumber-td\' align=\'center\'>"+index+"</td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'>"+
                    "<span class=\'wrap_bjui_btn_box\' style=\'position: relative; display: inline-block;width:100%;\'>"+
                        "<input type=\'hidden\' name=\'ma_products["+index+"]\' id=\'ma_products_"+index+"\' value=\'\' >"+
                        "<input type=\'hidden\' id=\'ma_products_no_"+index+"\' value=\'\' >"+
                        "<input type=\'text\' id=\'productname_"+index+"\' data-rule=\'required;\' class=\'form-control required middle-width\'>"+
                        "<a onclick=\'ma_products_no_clickthishref("+index+",this);\' data-callback=\'ma_products_no_callback\' id=\'ma_products_no_"+index+"_lookup\' class=\'bjui-lookup\' data-toggle=\'lookupbtn\' data-newurl=\'\'"+
                        "data-oldurl=\'"+url+"\'"+
                        "data-url=\'"+url+"\' data-width=\'800\' data-height=\'500\' "+
                        "data-group=\'ma_products_no_"+index+"\' data-maxable=\'false\' data-title=\'选择\' href=\'javascript:;\'"+
                        "style=\'right:9px;height: 22px; line-height: 22px;\'>"+
                            "<i class=\'fa fa-search\'></i>"+
                        "</a>"+
                    "</span>"+
                "</td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'barcode_"+index+"\'>&nbsp;</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'itemcode_"+index+"\'>&nbsp;</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'factorys_name_"+index+"\'>&nbsp;</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'guige_"+index+"\'>&nbsp;</span></td>"+
                "<td align=\'center\' class=\'datagrid-edit-td\'><span id=\'unit_"+index+"\'>&nbsp;</span></td>"+
				 "<td align=\'center\' class=\'datagrid-edit-td\'><input type=\'text\' name=\'inventorynum["+index+"]\' id=\'inventorynum_"+index+"\' readonly=\'\' ></td>"+
				"<td align=\'center\' class=\'datagrid-edit-td\'><input type=\'text\' name=\'maximum["+index+"]\' id=\'maximum_"+index+"\'  data-rule=\'required;change_maximum;\' data-rule-change_maximum=\'change_maximum\' value=\'\' ></td>"+
				"<td align=\'center\' class=\'datagrid-edit-td\'><input type=\'text\' name=\'minimum["+index+"]\'  id=\'minimum_"+index+"\' data-rule=\'required;changeminimum\'  data-rule-changeminimum=\'change_minimum\' value=\'\' ></td>"+
                "<td align=\'center\'>"+
                    "<button type=\'button\' onclick=\'remove_row(this);\' class=\'btn btn-red\' data-icon=\'times\'><i class=\'fa fa-times\'></i></button>"+
                "</td>"+
            "</tr>";
            $(html).insertBefore($(obj).parent().parent());
        }
        function ma_products_no_clickthishref(index,obj){
            $("#cur_index").val(index);
        }
        function ma_products_no_callback(grid,args){
            var url="index.php?module=Ma_InventoryWarn&action=config.func&mode=getproductinfo&record="+args.id+"&supplierid="+$("#supplierid_id").val();
            var index=parseInt($("#cur_index").val(),10);
            jQuery("#ma_products_"+index).val(args.id);
            jQuery("#ma_products_no_"+index).val(args.name);
            jQuery.post(url,"",function(data){
                eval("var json="+data);
               if(json.msg=="300"){
                     $(this).alertmsg(\'warn\',\'该产品已存在警戒库存!\');
                     return ;
               }else{
                jQuery("#productname_"+index).val(json.productname);
                jQuery("#barcode_"+index).html(json.barcode);
                 jQuery("#itemcode_"+index).html(json.itemcode);
                jQuery("#factorys_name_"+index).html(json.factorys_name);
                jQuery("#guige_"+index).html(json.guige);
                jQuery("#unit_"+index).html(json.unit);
                jQuery("#inventorynum_"+index).val(json.inventorynum);
               }
            })
        }
        function change_maximum(obj){
                var maximum=parseInt($(obj).val(),10);
                if(maximum<=0){
                     obj.value=1;
                 $(this).alertmsg(\'warn\',\'输入数量有误,请重新输入!\');
                 return ;
                }
            }
             function change_minimum(obj){
                var minimum=parseInt($(obj).val(),10);
                var maximum=parseInt($(obj).parent().prev().find("input").val(),10);
                if(minimum>=maximum ||minimum<0){
                    obj.value=0;
                    $(this).alertmsg(\'warn\',\'输入数量有误,请重新输入!\');
                    return ;
                }
            }
        </script>';
        if ($readonly != "true")
        {
            echo '<script>$.CurrentNavtab.find("#savebutton").each(function(k,e){e.removeAttribute("disabled");});</script>';
        }
    }
?>