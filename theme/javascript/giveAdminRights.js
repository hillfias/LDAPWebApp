function giveAdminRights(username)
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
			if (mess == 'L\'admin a été correctement ajouté.')
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
					// sans aucun ID, attribut ou contenu
					var sp1 = document.createElement("p");

					// lui donne un attribut id appelé 'nouveauSpan'
					sp1.setAttribute("class", "red center");
					sp1.setAttribute("id", "erreur");

					// crée un peu de contenu pour cet élément.
					var sp1_content = document.createTextNode("Veuillez vérifier que les données soient bien conformes.");

					// ajoute ce contenu au nouvel élément
					sp1.appendChild(sp1_content);

					// Obtient une référence de l'élément devant lequel on veut insérer notre nouveau span
					var sp2 = document.querySelectorAll('form[name="form"]');

					// Obtient une référence du nœud parent
					var parentDiv = sp2[0].parentNode;

					// insère le nouvel élément dans le DOM avant sp2
					parentDiv.insertBefore(sp1, sp2[0]);
				}
				
			}
			else
			{
				if(!document.getElementById('erreur'))
				{
					output = '<p id="erreur" class="red center">Une erreur est survenue : '+mess+'</p>';
					document.getElementById('main-panel').innerHTML=output;
				}
				
			}
			
			
		}
	};
	
	// On récupère les données fournies par le formulaire, on vérifie qu'elles existent toutes et on laissera APICommand nous délivrer un message en cas d'erreur
	// Données obligatoire

	var formData = new FormData();
	formData.append('username', username);
	// Ici on s'occupe des utilisateurs à rajouter directement
	
	xhr.open("POST", "api/giveAdminRights.php", true);
	xhr.send(formData);
}