<?php
header("Content-Type: text/plain");
/**
 * get the list of users
 * @param : attributes : get different users' attributes [optional]
 * @return : list of users (JSON)
 * */

$attributes = (isset($_POST["attributes"])) ? $_POST["attributes"] : NULL;
$attributes = explode('STOP',$attributes);
 
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
include('../ldap/index.php');
$ds = connectionLDAP();
$infoUsers = search($ds,'objectclass=posixAccount',$attributes);
// On termine la connection au serveur
kill($ds);
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$infos = array();
if($infoUsers['count'] > 0)
{
	// On affiche des checkbox pour chaque groupe sauf 'all' auquel on ajoute un nouvel utilisateur automatiquement
	for($i=0;$i<$infoUsers['count'];$i++)
	{
		$infoUser['forname'] = $infoUsers[$i]['givenname'][0];
		$infoUser['lastname'] = $infoUsers[$i]['sn'][0];
		$infoUser['pseudo'] = $infoUsers[$i]['cn'][0];
		array_push($infos,$infoUser);
	}
	echo json_encode($infos);
}
else
{
	echo json_encode(array("erreur" => "Il n'y a pas d'utilisateurs existant."));
}

// FIN DE LINSTRUCTION getAddUserPage
?>