<?php
// On importe le javascript qui permet de check/uncheck toutes les checkbox
echo '<script type="text/javascript" language="javascript" src="'.$CONSTANTES['cheminJs'].'checkAllCheckbox.js"></script>';
?>
	
<h3 class="center">Ajouter un nouvel utilisateur</h3>

<!-- Début du formulaire -->
<form method="post" action="" name="form" enctype="multipart/form-data" class="spe">
<fieldset>

	<legend>Ajouter un utilisateur :</legend>

	<label for="nom">Nom :</label>

	<input type="text" name="nom" id="nom" />*
	<br />
	(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
	<br />

	<label for="prenom">Prenom :</label>

	<input type="text" name="prenom" id="prenom" />*
	<br />
	(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
	<br />

	<label for="mail">Addresse email :</label>

	<input type="text" name="mail" id="mail" />*
	<br />
	(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
	<br />

	<label for="fichier">Image de profil :</label>
	<input type="file" name="fichier" id="fichier">

	<br />
	<br />

	<label for="mdp">Mot de passe :</label>

	<input type="password" name="mdp" id="mdp" />*

	<br />
	<br />
	<label for="confmdp">Confirmation du mot de passe :</label>

	<input type="password" name="confmdp" id="confmdp" />*
	<br />
	<br />
	<?php 
	if($infoGroupes['count'] > 1)
	{
	?>
		Ajouter un utilisateur à d'autres groupes : 

		<a onclick="javascript:checkAll('form', true);" href="javascript:void();">tout cocher</a> | 
		<a onclick="javascript:checkAll('form', false);" href="javascript:void();">tout décocher</a>
		<br />
		<?php
		// On affiche des checkbox pour chaque groupe sauf 'all' auquel on ajoute un nouvel utilisateur automatiquement
		for($i=1;$i<$infoGroupes['count'];$i++)
		{
			echo '<label for="'.$infoGroupes[$i]['cn'][0].'">Clicquer pour cocher le groupe \''.$infoGroupes[$i]['cn'][0].'\'</label><input type="checkbox" name="'.$infoGroupes[$i]['cn'][0].'" id="'.$infoGroupes[$i]['cn'][0].'" /><br />';
		}
	}
	?>
</fieldset>
<input type="submit" value="Envoyer" />
</form>
