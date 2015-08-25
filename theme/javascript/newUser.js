function newUser()
{
	function remove(id) {
	var elem=document.getElementById(id);
    return elem.parentNode.removeChild(elem);
	}
	
	if(document.getElementById('erreur')) remove('erreur');
	
	var xhr = new XMLHttpRequest();

	
	
	// progress bar
		xhr.upload.addEventListener("progress", function(e) {
			var pc = 100 - (e.loaded / e.total) * 100;
			if(document.getElementById("progressSpace"))
			{
				progress.style.backgroundPosition = pc + "% 0";
			}
		}, false);
	
	
	xhr.onreadystatechange = function()
	{
		
	
		if (xhr.readyState == 4 && document.getElementById("progressSpace"))
		{
			progress.className = (xhr.status == 200 ? "success" : "failure");
		} 
	
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
		
			
		
			
		
			var mess = xhr.responseText; //retrieve result as an JavaScript object
			
			if (mess == 'L\'utilisateur a été ajouté mais certaines erreures persistent. Un message sera envoyé à l\'administrateur.' || mess == 'L\'utilisateur a été correctement ajouté.')
			{
				if (confirm('Voulez-vous ajouter un nouvel utilisateur ?'))
				{
					// sans aucun ID, attribut ou contenu
					var p = document.createElement("p");

					// lui donne un attribut id appelé 'nouveauSpan'
					p.setAttribute("class", "success center");

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
					
					var o = document.getElementById("progress");
					if(o.firstElementChild)
					{
						remove('progressPara');
						remove('progressSpace');
					}
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
					var sp1_content = document.createTextNode("Veuillez vérifier que les données soient bien conformes (mots de passe identiques/adresse email valide/nom-prenom conformes).");

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
	var prenom = document.getElementById('prenom').value;
	var mail = document.getElementById('mail').value;
	var mdp = document.getElementById('mdp').value;
	var confmdp = document.getElementById('confmdp').value;
	
	if(nom.length > 0 && prenom.length > 0 && mail.length > 0 && mdp.length > 0 && confmdp.length > 0)
	{
		
		// Si celles-ci sont non vides on les ajoutent et on regarde si les autres existent
		var formData = new FormData();
		formData.append('nom', nom);
		formData.append('prenom', prenom);
		formData.append('mail', mail);
		formData.append('mdp', mdp);
		formData.append('confmdp', confmdp);
  
		// Ici on s'occupe des groupes
		var group = document.querySelectorAll('input[type="checkbox"]');
		for (var i=0; i<group.length; i++)
		{
			if(group[i].checked)
			{
				formData.append(group[i].getAttribute("name"), 'on');
			}
		}
		
		
		// et la de l'upload d'image
		var file = document.getElementById('fichier').files;
		if(file.length > 0)
		{
			file = file[0];
			
			// Si l'image a la bonne extension
			if(file.name.toLowerCase().lastIndexOf('jpg') >= 0 ||  file.name.toLowerCase().lastIndexOf('jpeg') >= 0 || file.name.toLowerCase().lastIndexOf('png') >= 0 || file.name.toLowerCase().lastIndexOf('bmp') >= 0 || file.name.toLowerCase().lastIndexOf('gif') >= 0)
			{
			
				var res = file.name.toLowerCase().match(/(jpg|jpeg|png|gif|bmp)$/); 
				var ext = res[0];
				
				if(ext)
				{
					formData.append('fichier', file);
					
					//create progress bar
					var o = document.getElementById("progress");
					
					
					if(o.firstElementChild)
					{
						remove('progressPara');
					}

					var progress = o.appendChild(document.createElement("p"));
					progress.setAttribute("id", "progressPara");
					progress.appendChild(document.createTextNode("Uploading " + file.name + "..."));
					
					var div = o.appendChild(document.createElement("div"));
					div.setAttribute("id", "progressSpace");

					
			
					xhr.open("POST", "api/newUser.php", true);
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
						var sp1_content = document.createTextNode("Une erreur est survenue : votre fichier n'est pas une image.");

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
			else if(!document.getElementById('erreur'))
			{
				// sans aucun ID, attribut ou contenu
				var sp1 = document.createElement("p");

				// lui donne un attribut id appelé 'nouveauSpan'
				sp1.setAttribute("class", "red center");
				sp1.setAttribute("id", "erreur");

				// crée un peu de contenu pour cet élément.
				var sp1_content = document.createTextNode("Une erreur est survenue : votre fichier n'est pas une image.");

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

			xhr.open("POST", "api/newUser.php", true);
			xhr.send(formData);
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