<?php
// On importe le javascript qui permet de check/uncheck toutes les checkbox
echo '<script type="text/javascript" language="javascript" src="'.$CONSTANTES['cheminJs'].'checkAllCheckbox.js"></script>';
?>
	
<h3 class="center">Ajouter un nouvel utilisateur</h3>
<?php
// S'il y a une erreur relative à l'upload d'image, on l'affiche en haut
if(isset($erreurImage))	echo '<p class="center red">'.$erreurImage.'</p>';
?>
<!-- Début du formulaire -->
<form method="post" action="" name="form" enctype="multipart/form-data" class="spe">
<fieldset>

	<legend>Ajouter un utilisateur :</legend>

	<label for="nom">Nom :</label>

	<input type="text" name="nom" id="nom" value="<?php if(!empty($_POST['nom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['nom'])) echo $_POST['nom']; else echo '" class="bred'; ?>"/>*
	<br />
	(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
	<br />

	<label for="prenom">Prenom :</label>

	<input type="text" name="prenom" id="prenom" value="<?php if(!empty($_POST['prenom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['prenom'])) echo $_POST['prenom']; else echo '" class="bred';?>"/>*
	<br />
	(Utiliser uniquement les lettres de l'alphabets (sans accents) et le trait d'union '-', touche 6 du clavier )
	<br />

	<label for="mail">Addresse email :</label>

	<input type="text" name="mail" id="mail" value="<?php if(!empty($_POST['mail']) AND preg_match("#^[a-zA-Z0-9.-]+@[a-z]+\.[a-z]{2,4}$#",$_POST['mail'])) echo $_POST['mail']; else echo '" class="bred';?>"/>*
	<br />
	(Utiliser une vraie addresse email)
	<br />

	<label for="fichier">Image de profil :</label>
	<input type="file" name="fichier" id="fichier">

	<br />
	<br />

	<label for="mdp">Mot de passe :</label>

	<input type="password" name="mdp" id="mdp" value="<?php if(!empty($_POST['mdp']) AND !(!empty($_POST['confmdp']) AND !empty($_POST['mdp']) AND $_POST['mdp'] != $_POST['confmdp'])) echo $_POST['mdp']; else echo '" class="bred';?>"/>*

	<br />
	<br />
	<label for="confmdp">Confirmation du mot de passe :</label>

	<input type="password" name="confmdp" id="confmdp" value="<?php if(!empty($_POST['confmdp']) AND !(!empty($_POST['confmdp']) AND !empty($_POST['mdp']) AND $_POST['mdp'] != $_POST['confmdp'])) echo $_POST['confmdp']; else echo '" class="bred';?>"/>*
	<br />
	<br />

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
	?>
</fieldset>
<input type="submit" value="Envoyer" />
</form>
