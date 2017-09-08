function ckeditor_change_field(obj)
{
	var value  = $(obj).val();
	var text   = $(obj).find("option:selected").text();
	var editor = UE.getEditor('template_editor');
	editor.execCommand("insertHtml", "<span key='" + value + "'>【" + text + "】<span>");
	$(obj).selectpicker('val','');
	$(obj).selectpicker('render');
}

function ckeditor_addevent(){
	var editor = UE.getEditor('template_editor');
	editor.addListener("keydown",function(type,event){
		if(event.code == "Delete" || event.code == "Backspace")
		{
			var range = editor.selection.getRange();
			var span = UE.dom.domUtils.findParentByTagName( range.startContainer, ['span'], true );
			if(span && (/{*}/).test($(span).attr("key")))
			{
				event.preventDefault()
				$(span).remove();
			}
		}
		return false;
	});
}