<?php
include('header.php');
// Constantes supplémentaires qui serviront au cours du script.
// -------------------------------------------
$CONSTANTES['uid'] = (int) file_get_contents("uid.txt"); // Ici on récupère l'uid incrémenté par rapport au dernier utilisateur ajouté.
// -------------------------------------------
if(!isset($_SESSION['connected']))
{
}
else
{
	if (!isset($_POST['nom']))
	{
		// Si on n'a pas reçu de données, on affiche le formulaire
		include('templates/forms/newUserForm.php');
	}
	else
	{
		// Sinon si on a reçu des données (uniquement celles qui sont nécessaires)...
		include('ldap/newUserLDAP.php');
	}
}
?>
