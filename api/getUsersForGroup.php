<?php
header("Content-Type: text/plain");	
/**
* get users for a certain group
*
* @param : group : the name of a group from which you want to get the list of users [required]
*
* @return : attributes of the users (JSON)
* */

// On vérifie qu'on a bien l'information nécessaire à la récupération des données utilisateurs pour un groupe donnée : le nom du groupe.
$group = (isset($_POST["group"])) ? $_POST["group"] : NULL;
$attributes = (isset($_POST["attributes"])) ? $_POST["attributes"] : NULL;
$attributes = explode('STOP',$attributes);

$CONSTANTES['cheminImages'] = 'theme/images/';

if ($group)
{
	
	include('../ldap/index.php');
	$ds = connectionLDAP();
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On récupère la liste des utilisateurs et des admins du groupe
	$membresGroupe = search($ds,'&(objectclass=posixGroup)(cn='.$group.')',array('memberUid','owner'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$infos = array();				
	
	// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
	for($nbusers=0;$nbusers<$membresGroupe[0]['memberuid']['count'];$nbusers++)
	{
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$infoUsers = search($ds,'&(objectclass=posixAccount)(cn='.$membresGroupe[0]['memberuid'][$nbusers].')',$attributes);
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$infoUser = array();
		$infoUser['photo'] = base64_encode($infoUsers[0]['jpegphoto'][0]);
		$infoUser['isAdmin'] = "false";
		if(!empty($membresGroupe[0]['owner']) AND strpos($membresGroupe[0]['owner'][0],$membresGroupe[0]['memberuid'][$nbusers]))
		{
			$infoUser['isAdmin'] = "true";
		}
		
		$infoUser['forname'] = $infoUsers[0]['givenname'][0];
		$infoUser['lastname'] = $infoUsers[0]['sn'][0];
		$infoUser['pseudo'] = $infoUsers[0]['cn'][0];
		if($group != 'all') $infoUser['isRemovable'] = "true";
		else $infoUser['isRemovable'] = "false";
		
		if($infoUser['isAdmin'] == "true") $infoUser['isAdminRemovable'] = "true";
		else $infoUser['isAdminRemovable'] = "false";
		
		array_push($infos,$infoUser);
	}
	echo json_encode($infos);
}
else
{
	echo json_encode(array("erreur" => "Le groupe n'existe pas"));
}

// FIN DE LINSTRUCTION getUsersForGroup
?>