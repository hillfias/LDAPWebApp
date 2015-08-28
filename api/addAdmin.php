<?php
header("Content-Type: text/plain");
/**
 * add an admin
 * @param : group name [required]
 * @param : user names(pseudo) [required]
 * @return : success/fail message (txt)
 * */

if(!empty($_POST['group']) AND count($_POST) > 1)
{
	$group = $_POST['group'];
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include('../ldap/index.php');
	$ds = connectionLDAP();
	$infoGroup = search($ds,'&(objectclass=posixGroup)(cn='.$group.')',array('owner'));
	$infoUsers = search($ds,'objectclass=posixAccount',array('cn'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



	$j=0;
	$owner = array();
	for($i=0;$i<$infoUsers['count'];$i++)
	{
		if(!empty($_POST[$infoUsers[$i]['cn'][0]]))
		{
			$owner[$j] = $infoUsers[$i]['cn'][0];
			$j++;
		}
	}
	
	$entry['owner'] = $infoGroup[0]['owner'][0].',';
	for($i=0;$i<count($owner);$i++)
	{
		$entry['owner'] .= "cn=".$owner[$i].",ou=users,dc=rBOX,dc=lan";
		if($i < (count($owner)-1)) $entry['owner'] .= ',';
	}
	
	$dn="cn=$group,ou=groups,dc=rBOX,dc=lan";

	$r = ldap_modify($ds,$dn,$entry);
	 
	 if($r) echo 'L\'admin a été correctement ajouté.';
	 else echo 'Données non conformes.';

	
	
	kill($ds);
}