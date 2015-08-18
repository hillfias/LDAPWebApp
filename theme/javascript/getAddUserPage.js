function getAddUserPage()
{
	
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function()
	{
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			
			var jsondata=eval("("+xhr.responseText+")"); //retrieve result as an JavaScript object
			
			var mydata=jsondata.items;
			
			var head = document.getElementsByTagName("head")[0];
			
			var js = document.createElement("script");
			js.type = "text/javascript";
			js.src = "theme/javascript/checkAllCheckbox.js";

			head.appendChild(js);
			
			var js2 = document.createElement("script");
			js2.type = "text/javascript";
			js2.src = "theme/javascript/newUser.js";

			head.appendChild(js2);

			var output='';
			
			output+= '<h3 class="center">Ajouter un nouvel utilisateur</h3>';
			output+= '<form action="#" name="form" class="spe" onsubmit="newUser(); return false;">';
			
			output+= '<label for="nom">Nom :*</label>';
			output+= '<input type="text" name="nom" id="nom" required/>';
			output+= '<br />';
			output+= '(Utiliser uniquement les lettres de l\'alphabets (sans accents) et le trait d\'union \'-\', touche 6 du clavier )';
			output+= '<br />';

			output+= '<label for="prenom">Prenom :*</label>';

			output+= '<input type="text" name="prenom" id="prenom" required/>';
			output+= '<br />';
			output+= '(Utiliser uniquement les lettres de l\'alphabets (sans accents) et le trait d\'union \'-\', touche 6 du clavier )';
			output+= '<br />';

			output+= '<label for="mail">Addresse email :*</label>';

			output+= '<input type="text" name="mail" id="mail" required/>';
			output+= '<br />';
			output+= '(Utiliser une vrai adresse email )';
			output+= '<br />';

			output+= '<label for="fichier">Image de profil :</label>';
			output+= '<input type="file" name="fichier" id="fichier">';
			output += '<div id="progress"></div>';
			output+= '<br />';
			output+= '<br />';

			output+= '<label for="mdp">Mot de passe :*</label>';

			output+= '<input type="password" name="mdp" id="mdp" required/>';

			output+= '<br />';
			output+= '<br />';
			output+= '<label for="confmdp">Confirmation du mot de passe :*</label>';

			output+= '<input type="password" name="confmdp" id="confmdp" required/>';
			output+= '<br />';
			output+= '<br />';
			output+= '<br />';
			output+= '<br />';
			
			output+= 'Ajouter un utilisateur à d\'autres groupes :   ';
			output+= '<a onclick="javascript:checkAll(\'form\', true);" href="javascript:void();">tout cocher</a> |'; 
			output+= '<a onclick="javascript:checkAll(\'form\', false);" href="javascript:void();">tout décocher</a>';
			output+= '<br />';
			
			for (var i=0; i<mydata.length; i++)
			{
				
				output+='<label for="'+mydata[i].name+'">Clicquer pour cocher le groupe \''+mydata[i].name+'\'</label><input type="checkbox" name="'+mydata[i].name+'" id="'+mydata[i].name+'" /><br />';
				
			}
			
			
			output+= '<input type="submit" value="Envoyer" onclick=""/>';
			output+= '</form>';
			
			document.getElementById('main-panel').innerHTML=output;
		   
		}
	};
	
	xhr.open("POST", "api/APICommand.php", true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send("action=getAddUserPage");
}