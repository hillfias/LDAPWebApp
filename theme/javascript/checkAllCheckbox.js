// <![CDATA[
	function checkAll(formname, checktoggle)
	{
	  var checkboxes = new Array(); 
	  checkboxes = document[formname].getElementsByTagName('input');
	 
	  for (var i=0; i<checkboxes.length; i++)  {
		if (checkboxes[i].type == 'checkbox')   {
		  checkboxes[i].checked = checktoggle;
		}
	  }
	}
	// ]]>