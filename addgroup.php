<?php
include('header.php');
// Constantes supplémentaires qui serviront au cours du script.
// -------------------------------------------
$CONSTANTES['gid'] = (int) file_get_contents("data/gid.txt"); // Ici on récupère le gid incrémenté par rapport au dernier groupe ajouté.
// -------------------------------------------
if(!isset($_SESSION['connected']))
{
}
else
{
	if (!isset($_POST['nom']))
	{
		// Si on n'a pas reçu de données, on affiche le formulaire
		include('templates/forms/newgroup.php');
	}
	else
	{
		//Si on a reçu des données, On ajoute le groupe
		include('ldap/newgroup.php');
	}
}
?>
