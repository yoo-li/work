
function thisMovie(movieName) {
    if (navigator.appName.indexOf("Microsoft") != -1) 
	{
		/*if (navigator.userAgent.indexOf("MSIE 7.0") > 0)
		{
			return window[movieName];
		}  */      
		return document[movieName];
    } 
	else 
	{
        return document[movieName];
    }
}
 
function logistics_validate(form)
{	
	var message= thisMovie("ExpressFormDesigner").getdata();
	form['template_data'].value = message;
	return true;
}
