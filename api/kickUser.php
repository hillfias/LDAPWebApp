<?php
header("Content-Type: text/plain");
/**
 * kick a user
 * @param : user name(pseudo) [required]
 * @param : group name [required]
 * @return : success/fail message (txt)
 * */
 
if(!empty($_POST['user']) and !empty($_POST['group']))
{
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include('../ldap/index.php');
	$ds = connectionLDAP();
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$name = $_POST['user'];
	$group = $_POST['group'];

	$dn="cn=$group,ou=groups,dc=rBOX,dc=lan";
	$entry['memberuid'] = $name;
	$r = ldap_mod_del($ds,$dn,$entry);
	 
	 if($r) echo 'L\'utilisateur a été correctement enlever du groupe.';
	 else echo 'Données non conformes.';

	
	
	kill($ds);
}