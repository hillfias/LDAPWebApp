<?php
header("Content-Type: text/plain");	
/**
* get the page to modify a user
*
* @param : user : the name of a user you want to modify [required]
*
* @return : attributes of the user (JSON)
* */

// On vérifie qu'on a bien l'information nécessaire à la récupération des données utilisateurs : le nom de l'utilisateur.
$user = (isset($_POST["user"])) ? $_POST["user"] : NULL;
$username = (isset($_POST["username"])) ? $_POST["username"] : NULL;
$attributes = (isset($_POST["attributes"])) ? $_POST["attributes"] : NULL;
$attributes = explode('STOP',$attributes);
$CONSTANTES['cheminImages'] = 'theme/images/';

if ($user)
{
	
	include('../ldap/index.php');
	$ds = connectionLDAP();
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On récupère la liste des utilisateurs et des admins du groupe
	$membresGroupeAdmin = search($ds,'&(objectclass=posixGroup)(cn=admin)',array('memberUid'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	if(in_array($username,$membresGroupeAdmin[0]['memberuid']) || $user == $username || $username == 'admin')
	{
		$infos = array();	
	

		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$infoUsers = search($ds,'&(objectclass=posixAccount)(cn='.$user.')',$attributes);
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		$infoUser = array();
		
		$infoUser['forname'] = $infoUsers[0]['givenname'][0];
		$infoUser['lastname'] = $infoUsers[0]['sn'][0];
		$infoUser['pseudo'] = $infoUsers[0]['cn'][0];
		$infoUser['email'] = $infoUsers[0]['mail'][0];
		array_push($infos,$infoUser);
	}
	echo json_encode($infos);
}
else
{
	echo json_encode(array("erreur" => "L\'utilisateur n'existe pas"));
}

// FIN DE LINSTRUCTION getModUserPage
?>