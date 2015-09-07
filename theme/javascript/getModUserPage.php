<script language="JavaScript" type="text/javascript">
function getModUserPage(username)
{
	
	var xhr = new XMLHttpRequest();
	
	xhr.onreadystatechange = function()
	{
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
		{
			
			var mydata=eval("("+xhr.responseText+")"); //retrieve result as an JavaScript object
			
			if(mydata.length == 0)
			{
				output+='<p>';
				output+='Erreur : '+mydata.erreur;
				output+='</p>';
			}
			else
			{
				var head = document.getElementsByTagName("head")[0];
				
				var js = document.createElement("script");
				js.type = "text/javascript";
				js.src = "theme/javascript/checkAllCheckbox.js";

				head.appendChild(js);
				
				var js2 = document.createElement("script");
				js2.type = "text/javascript";
				js2.src = "theme/javascript/modUser.js";

				head.appendChild(js2);

				var output='';
				
				output+= '<h3 class="center">Modifier le profil utilisateur de '+mydata[0].pseudo+'</h3>';
				output+= '<form action="#" name="form" class="spe" onsubmit="modUser(\''+mydata[0].pseudo+'\'); return false;">';
				
				output+= '<label for="nom">Nom :*</label>';
				output+= '<input type="text" name="nom" id="nom" value="'+mydata[0].lastname+'" required/>';
				output+= '<br />';
				output+= '(Utiliser uniquement les lettres de l\'alphabets (sans accents) et le trait d\'union \'-\', touche 6 du clavier )';
				output+= '<br />';

				output+= '<label for="prenom">Prenom :*</label>';

				output+= '<input type="text" name="prenom" id="prenom" value="'+mydata[0].forname+'" required/>';
				output+= '<br />';
				output+= '(Utiliser uniquement les lettres de l\'alphabets (sans accents) et le trait d\'union \'-\', touche 6 du clavier )';
				output+= '<br />';

				output+= '<label for="mail">Addresse email :*</label>';

				output+= '<input type="text" name="mail" id="mail" value="'+mydata[0].email+'" required/>';
				output+= '<br />';
				output+= '(Utiliser une vrai adresse email )';
				output+= '<br />';

				output+= '<label for="fichier">Image de profil :</label>';
				output+= '<input type="file" name="fichier" id="fichier">';
				output += '<div id="progress"></div>';
				output+= '<br />';
				output+= '<br />';

				output+= '<label for="mdp">Mot de passe :*</label>';

				output+= '<input type="password" name="mdp" id="mdp"/>';

				output+= '<br />';
				output+= '<br />';
				output+= '<label for="confmdp">Confirmation du mot de passe :*</label>';

				output+= '<input type="password" name="confmdp" id="confmdp"/>';
				output+= '<br />';
				output+= '<br />';
				output+= '<br />';
				output+= '<br />';
				
				output+= '<input type="submit" value="Envoyer" onclick=""/>';
				output+= '</form>';
			}
			document.getElementById('main-panel').innerHTML=output;
		   
		}
	};
	
	xhr.open("POST", "api/getUser.php", true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
	xhr.send("attributes=mailSTOPgivennameSTOPsnSTOPcn&user=" + username+"&username=<?php echo $_SESSION['username']; ?>");
}
</script>