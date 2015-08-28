function getAddGroupPage()
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
			js2.src = "theme/javascript/newGroup.js";

			head.appendChild(js2);

			var output='';
			
			output+= '<h3 class="center">Ajouter un nouveau groupe</h3>';
			output+= '<form action="#" name="form" class="spe" onsubmit="newGroup(); return false;">';
			
			
			output+= '<label for="nom">Nom du groupe :*</label>';
			output+= '<input type="text" name="nom" id="nom" required/>';
			output+= '<br />';
			output+= '(Utiliser uniquement les lettres de l\'alphabets, sans accents)';
			output+= '<br />';

			output+= '<label for="adgr">Membre administrateur du groupe :*</label>';
			
			output+= '<select name="adgr[]" id="adgr">';
			for (var i=0; i<mydata.length; i++)
			{
				output+= '<option value="'+mydata[i].pseudo+'">'+mydata[i].forname+' '+mydata[i].lastname+'</option>';
			}
			output+= '</select>';
			output+= '<br />';
			output+= '<br />';
			
			
			
			
			output+= '<a href="#" onclick="newAdmin(); return false;" style="clear:both;">Ajouter un autre administrateur ?</a>';
			output+= '<br />';
			output+= '<br />';
			
			output+= 'Ajouter des membres au groupe : ';
			output+= '<a onclick="javascript:checkAll(\'form\', true);" href="javascript:void();">tout cocher</a> | '; 
			output+= '<a onclick="javascript:checkAll(\'form\', false);" href="javascript:void();">tout décocher</a>';
			output+= '<br />';
			
			for (var i=0; i<mydata.length; i++)
			{
				output+='<label for="'+mydata[i].pseudo+'">Cliquer pour cocher l\'utilisateur \''+mydata[i].forname +' '+mydata[i].lastname+'\'</label><input type="checkbox" name="'+mydata[i].pseudo+'" id="'+mydata[i].pseudo+'" /><br />';
			}
			
			
			output+= '<input type="submit" value="Envoyer" onclick=""/>';
			output+= '</form>';
			
			document.getElementById('main-panel').innerHTML=output;
		   
		}
	};
	
	xhr.open("POST", "api/getUsers.php", true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send("attributes=cnSTOPgivennameSTOPsn");
}
function newAdmin(){

	
	
	var referenceNode = document.getElementById("adgr");
	var sel = referenceNode.cloneNode(true);
	
	referenceNode.parentNode.insertBefore(sel, referenceNode.nextSibling);
	var div = document.createElement("div");
	div.setAttribute("id", "space");
	sel.parentNode.insertBefore(div, sel.nextSibling);

	}
