function newGroup()
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
			if (mess == 'Le groupe a été correctement ajouté.')
			{
				if (confirm('Voulez-vous ajouter un nouveau groupe ?'))
				{
					if(document.getElementById('mess')) remove('mess');
					// sans aucun ID, attribut ou contenu
					var p = document.createElement("p");

					// lui donne un attribut id appelé 'nouveauSpan'
					p.setAttribute("class", "success center");
					p.setAttribute("id", "mess");

					// crée un peu de contenu pour cet élément.
					var p_content = document.createTextNode(mess);

					// ajoute ce contenu au nouvel élément
					p.appendChild(p_content);
				
				
					// Obtient une référence de l'élément devant lequel on veut insérer notre nouveau span
					var sp2 = document.querySelectorAll('form[name="form"]');

					// Obtient une référence du nœud parent
					var parentDiv = sp2[0].parentNode;
					
					// insère le nouvel élément dans le DOM avant sp2
					parentDiv.insertBefore(p, sp2[0]);
					
					var fElements = sp2[0].elements;
					
					for(i=0; i<fElements.length; i++)
					{
						if(fElements[i].type.toLowerCase() != 'submit') fElements[i].value = '';
						if(fElements[i].type.toLowerCase() == 'checkbox' && fElements[i].checked)
						{
							fElements[i].checked = false;
						}
					}
				}
				else
				{
					var head = document.getElementsByTagName("head")[0];
				
					var js = document.createElement("script");
					js.type = "text/javascript";
					js.text = 'setTimeout("window.location=\'accueil.php\'",1000);';
					head.appendChild(js);
					
					output = '<p class="center success">'+mess+'</p>';
					document.getElementById('main-panel').innerHTML=output;
				}
				
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
					var sp1_content = document.createTextNode("Veuillez vérifier que les données soient bien conformes (Pas d'accents ni d'espaces etc...).");

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
					// sans aucun ID, attribut ou contenu
					var sp1 = document.createElement("p");

					// lui donne un attribut id appelé 'nouveauSpan'
					sp1.setAttribute("class", "red center");
					sp1.setAttribute("id", "erreur");

					// crée un peu de contenu pour cet élément.
					var sp1_content = document.createTextNode("Une erreur est survenue : "+mess);

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
			
			
		}
	};
	
	// On récupère les données fournies par le formulaire, on vérifie qu'elles existent toutes et on laissera APICommand nous délivrer un message en cas d'erreur
	// Données obligatoire
	
	var nom = document.getElementById('nom').value;
	var admins = new Array();
	var adgr = document.getElementById('adgr');
	admins.push(adgr.value);
	var otherAdgr = adgr;
	while(otherAdgr = otherAdgr.nextSibling)
	{
		if(otherAdgr == '[object HTMLSelectElement]')admins.push(otherAdgr.value);
	}
	
	
	if(nom.length > 0 && admins.length > 0 && admins[0].length > 0)
	{
		
		// Si celles-ci sont non vides on les ajoutent et on regarde si les autres existent
		var formData = new FormData();
		
		formData.append('nom', nom);
		var admins = JSON.stringify(admins);
		formData.append('adgr', admins);
		
		// Ici on s'occupe des utilisateurs à rajouter directement
		var group = document.querySelectorAll('input[type="checkbox"]');
		for (var i=0; i<group.length; i++)
		{
			if(group[i].checked)
			{
				formData.append(group[i].getAttribute("name"), 'on');
			}
		}
		xhr.open("POST", "api/newGroup.php", true);
		xhr.send(formData);
	}
	
	else
	{
		if(!document.getElementById('erreur'))
		{
			// sans aucun ID, attribut ou contenu
			var sp1 = document.createElement("p");

			// lui donne un attribut id appelé 'nouveauSpan'
			sp1.setAttribute("class", "red center");
			sp1.setAttribute("id", "erreur");

			// crée un peu de contenu pour cet élément.
			var sp1_content = document.createTextNode("Veuillez remplir le formulaire.");

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
}