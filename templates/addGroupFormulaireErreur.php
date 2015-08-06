<?php
// On importe le javascript qui permet de check/uncheck toutes les checkbox
echo '<script type="text/javascript" language="javascript" src="'.$CONSTANTES['cheminJs'].'checkAllCheckbox.js"></script>';
?>

<h3 class="center">Ajouter un nouveau groupe</h3>

<!-- Début du formulaire -->

<form method="post" name="form" action="" class="spe">

<fieldset>
<legend>Ajouter un groupe :</legend>

<label for="nom">Nom du groupe :</label>*

<input type="text" name="nom" id="nom" value="<?php if(!empty($_POST['nom']) AND preg_match("#^[a-zA-Z]+$#",$_POST['nom'])) echo $_POST['nom']; else echo '" class="bred';?>"/>
<br />
(Utiliser uniquement les lettres de l'alphabets (sans accents))
<br />

<label for="adgr">Membre administrateur du groupe ? :</label>*

<select name="adgr" id="adgr">
<?php
	for($i=0;$i<$infoUsers['count'];$i++)
	{
		echo '<option value="'.$infoUsers[$i]["cn"][0].'">'.$infoUsers[$i]["givenname"][0].' '.$infoUsers[$i]["sn"][0].'</option>';
	}
?>
</select>
<br />

Ajouter des membres au groupe : 

<a onclick="javascript:checkAll('form', true);" href="javascript:void();">tout cocher</a> | 
<a onclick="javascript:checkAll('form', false);" href="javascript:void();">tout décocher</a>
<br />
<?php
	// On affiche des checkbox pour chaque utilisateur
	for($i=0;$i<$infoUsers['count'];$i++)
	{
		echo '<label for="'.$infoUsers[$i]['cn'][0].'">Cliquer pour cocher l\'utilisateur \''.$infoUsers[$i]['cn'][0].'\'</label><input type="checkbox" name="'.$infoUsers[$i]['cn'][0].'" id="'.$infoUsers[$i]['cn'][0].'" /><br />';
	}
	?>

</fieldset>
<input type="submit" value="Envoyer" />
</form>