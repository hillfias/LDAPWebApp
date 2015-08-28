function getAddAdminPage(group)
{	
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function()
	{
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			
			var mydata=eval("("+xhr.responseText+")"); //retrieve result as an JavaScript object
			
			
			
			var head = document.getElementsByTagName("head")[0];
			
			var js = document.createElement("script");
			js.type = "text/javascript";
			js.src = "theme/javascript/checkAllCheckbox.js";

			head.appendChild(js);
			
			var js2 = document.createElement("script");
			js2.type = "text/javascript";
			js2.src = "theme/javascript/addAdmin.js";

			head.appendChild(js2);

			var output='';
			
			output+= '<h3 class="center">Ajouter un ou plusiseurs administrateur(s) au groupe "'+group+'"</h3>';
			output+= '<form action="#" name="form" class="spe" onsubmit="addAdmin(\''+group+'\'); return false;">';


			output+= '<label for="adgr">Ajouter un ou plusiseurs administrateur(s) au groupe "'+group+'"</label>';
			output+= '<a onclick="javascript:checkAll(\'form\', true);" href="javascript:void();">tout cocher</a> | '; 
			output+= '<a onclick="javascript:checkAll(\'form\', false);" href="javascript:void();">tout décocher</a>';
			output+= '<br />';
			var output2 = "";
			for (var i=0; i<mydata.length; i++)
			{
				if(mydata[i].isAdmin == "false")
				output2+='<label for="'+mydata[i].pseudo+'">Cliquer pour cocher l\'utilisateur \''+mydata[i].forname +' '+mydata[i].lastname+'\'</label><input type="checkbox" name="'+mydata[i].pseudo+'" id="'+mydata[i].pseudo+'" /><br />';
			}
			if(output2.length > 0) output += output2+'<input type="submit" value="Envoyer" onclick=""/></form>';
			else output = '<h3 class="center">Ajouter un ou plusiseurs administrateur(s) au groupe "'+group+'"</h3><p class="red center">Il n\'y a plus d\'administrateurs à ajouter à ce groupe.</p>';
			
			document.getElementById('main-panel').innerHTML=output;
		   
		}
	};
	
	xhr.open("POST", "api/getUsersForGroup.php", true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send("attributes=jpegphotoSTOPgivennameSTOPsnSTOPcn&group=" + group);
}