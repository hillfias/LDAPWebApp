
	  <h3 class="center">Ajouter un nouvel utilisateur</h3>
	  
	  <!-- Début du formulaire -->
	  
		<form method="post" action="" class="spe">

		<fieldset>
		<legend>Ajouter un utilisateur :</legend>

		   <label for="nom">Votre nom :</label>

		   <input type="text" name="nom" id="nom" />
		   <br />
		   (Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
		   <br />
		   
		   <label for="prenom">Votre prenom :</label>

		   <input type="text" name="prenom" id="prenom" />
		   <br />
			(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
		   <br />

		   <label for="mdp">Votre mot de passe :</label>

		   <input type="password" name="mdp" id="mdp" />
		   
		   <br />
		   <br />
		   <label for="confmdp">Confirmation de votre mot de passe :</label>

		   <input type="password" name="confmdp" id="confmdp" />
			
		
		   

		</fieldset>
		
		<fieldset>
		<legend>Options avancées :</legend>
		
		   <label for="ip">Modifier l'adresse du serveur distant :</label>

		   <input type="text" name="ip" id="ip" />
		   <br />
		   (de la forme x.x.x.x où x se situe entre 0 et 255) 
		   <br />
		   
		   <label for="port">Modifier le port de connection du serveur distant :</label>

		   <input type="text" name="port" id="port" />
		   <br />
		   (Insérer un numéro entre 1 et 65535 inclus)
		   <br />
		   
		   <label for="gid">Modifier l'identifiant du groupe de l'utilisateur à ajouter :</label>

		   <input type="text" name="gid" id="gid" />
		   <br />
		   (<span class="red">Attention ! Le script garde la valeur '500' par défaut.</span>)
		   
		   <br />
		
		   <label for="uid">Modifier l'identifiant de l'utilisateur à ajouter :</label>

		   <input type="text" name="uid" id="uid" />
		   <br />
		   (<span class="red">Attention ! Le script autoincrémente déjà la valeur de l'identifiant de l'utilisateur précédemment ajouté.</span>)
		   
		   
		   </fieldset>
			<input type="submit" value="Envoyer" />
		</form>
	  </body>
	</html>
