<?php
header("Content-Type: text/plain");
/**
 * add an admin (to the 'admin' group)
 * @param : user names(pseudo) [required]
 * @return : success/fail message (txt)
 * */

if(!empty($_POST['username']))
{
	$username = $_POST['username'];
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include_once('../ldap/index.php');
	$ds = connectionLDAP();
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


	
	$entry['memberuid'] = $username;
	
	$dn="cn=admin,ou=groups,dc=rBOX,dc=lan";

	$r = ldap_mod_add($ds,$dn,$entry);
	 
	 if($r) echo 'L\'admin a été correctement ajouté.';
	 else echo 'Données non conformes.';

	
	
	kill($ds);
}