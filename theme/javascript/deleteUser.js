function deleteUser(user)
{
	function remove(id) {
	var elem=document.getElementById(id);
    return elem.parentNode.removeChild(elem);
	}
	
	if(document.getElementById('erreur')) remove('erreur');
	
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function()
	{
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			if(document.getElementById('erreur')) remove('erreur');
			var mess = xhr.responseText; 
			if (mess == 'L\'utilisateur a été correctement supprimé.')
			{

					var head = document.getElementsByTagName("head")[0];
				
					var js = document.createElement("script");
					js.type = "text/javascript";
					js.text = 'setTimeout("window.location=\'accueil.php\'",1000);';
					head.appendChild(js);
					
					output = '<p class="center success">'+mess+'</p>';
					document.getElementById('main-panel').innerHTML=output;
				
			}
			else if(mess == 'Données non conformes.')
			{
				if(!document.getElementById('erreur'))
				{
					output = '<p class="center red" id="erreur">'+mess+'</p>';
					document.getElementById('main-panel').innerHTML=output;
				}
			}
			else
			{
				if(!document.getElementById('erreur'))
				{
					output = '<p class="center red" id="erreur">Une erreur est survenue : '+mess+'</p>';
					document.getElementById('main-panel').innerHTML=output;
				}
			}
		}
	};
	
	
	var formData = new FormData();
	
	formData.append('user', user);
	xhr.open("POST", "api/deleteUser.php", true);
	xhr.send(formData);
}