<?php
header("Content-Type: text/plain");
/**
 * delete a group
 * @param : group name [required]
 * @return : success/fail message (txt)
 * */
 
if(!empty($_POST['group']))
{
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include('../ldap/index.php');
	$ds = connectionLDAP();
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$name = $_POST['group'];
	$dn="cn=$name,ou=groups,dc=rBOX,dc=lan";

	 // Supression de l'entrée de l'annuaire
	 $r=ldap_delete($ds, $dn);
	 
	 if($r) echo 'Le groupe a été correctement supprimé.';
	 else echo 'Données non conformes.';
	 
	kill($ds);
}