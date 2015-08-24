<?php
header("Content-Type: text/plain");
/**
 * get the list of groups
 *
 * @return : list of groups (JSON)
 * */

// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
include('../ldap/index.php');
$ds = connectionLDAP();
$infoGroupes = search($ds,'objectclass=posixGroup',array('cn'));
// On termine la connection au serveur
kill($ds);
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$infos = array();
if($infoGroupes['count'] > 0)
{
	// On affiche des checkbox pour chaque groupe sauf 'all' auquel on ajoute un nouvel utilisateur automatiquement
	for($i=0;$i<$infoGroupes['count'];$i++)
	{
		$infoGroup['name'] = $infoGroupes[$i]['cn'][0];
		array_push($infos,$infoGroup);
	}
	echo json_encode($infos);
}
else
{
	echo json_encode(array("erreur" => "Il n'y a pas de groupes existant."));
}

// FIN DE LINSTRUCTION getAddUserPage
?>