<?php
header("Content-Type: text/plain");
/**
 * delete an admin
 * @param : group name [required]
 * @param : user names(pseudo) [required]
 * @return : success/fail message (txt)
 * */

if(!empty($_POST['group']) AND !empty($_POST['username']))
{
	$group = $_POST['group'];
	$username = $_POST['username'];
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include_once('../ldap/index.php');
	$ds = connectionLDAP();
	$infoGroup = search($ds,'&(objectclass=posixGroup)(cn='.$group.')',array('owner'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	
	$entry['owner'] = $infoGroup[0]['owner'][0];
	if($entry['owner'] == "cn=".$username.",ou=users,dc=rBOX,dc=lan")
	{
		echo 'Il doit y avoir au moins un admin par groupe. Veuillez en ajouter un autre avant de supprimer celui-ci.';
		exit();
	}
	else
	{
		$entry['owner'] = str_replace( "cn=".$username.",ou=users,dc=rBOX,dc=lan", '' , $entry['owner']);
		if(substr($entry['owner'],0,1) == ',')	$entry['owner'] = substr_replace( $entry['owner'] ,'' , 0 ,1 );
		else $entry['owner'] = substr_replace( $entry['owner'] ,'' , strlen($entry['owner'])-1 ,1 );
		$entry['owner'] = str_replace( ",,", ',' , $entry['owner']);
	}

	
	$dn="cn=$group,ou=groups,dc=rBOX,dc=lan";

	$r = ldap_modify($ds,$dn,$entry);
	 
	 if($r) echo 'L\'admin a été correctement supprimé.';
	 else echo 'Données non conformes.';
	
	kill($ds);
}