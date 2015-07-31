	  <h3 class="center">Ajouter un nouveau groupe</h3>
	  
	  <!-- Début du formulaire -->
	  
		<form method="post" action="" class="spe">

		<fieldset>
		<legend>Ajouter un groupe :</legend>

		   <label for="nom">Nom du groupe :</label>

		   <input type="text" name="nom" id="nom" />
		   <br />
		   (Utiliser uniquement les lettres de l'alphabets (sans accents))
		   <br />
		   
		   <label for="adgr">Membre administrateur du groupe ? :</label>

		   <input type="text" name="adgr" id="adgr" />
		   <br />
			(Utiliser uniquement les diminutifs des membres. Ex : jsmith pour l'utilisateur John Smith. )
		   <br />
 

		</fieldset>
		
		<fieldset>
		<legend>Option avancée :</legend>
		
		   
		   
		   <label for="gid">Modifier l'identifiant du groupe de l'utilisateur à ajouter :</label>

		   <input type="text" name="gid" id="gid" />
		   <br />
		   (<span class="red">Attention ! Le script autoincrémente déjà la valeur de l'identifiant du groupe précédemment ajouté.</span>)
		   
		   <br />
		
		  
		   
		   
		   
		   </fieldset>
			<input type="submit" value="Envoyer" />
		</form>
	  </body>
	</html>
