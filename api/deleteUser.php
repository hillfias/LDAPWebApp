<?php
header("Content-Type: text/plain");
/**
 * get the list of users
 * @param : attributes : get different users' attributes [optional]
 * @return : list of users (JSON)
 * */
 
if(!empty($_POST['user']))
{
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include('../ldap/index.php');
	$ds = connectionLDAP();
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	$name = $_POST['user'];
	$dn="cn=$name,ou=users,dc=rBOX,dc=lan";

	 // Supression de l'entrée de l'annuaire
	 $r=ldap_delete($ds, $dn);
	 
	 // to do : supprimer l'utilisateur de tous les groupes auxquels il appartient
	 $Groupes = search($ds,'objectclass=posixGroup',array('memberUid','owner','cn'));
	for($nbgroupes=0;$nbgroupes<$Groupes['count'];$nbgroupes++)
	{
		for($nbusers=0;$nbusers<$Groupes[$nbgroupes]['memberuid']['count'];$nbusers++)
		{
			if($name == $Groupes[$nbgroupes]['memberuid'][$nbusers])
			{
				$dn="cn=".$Groupes[$nbgroupes]['cn'][0].",ou=groups,dc=rBOX,dc=lan";
				$entry['memberuid'] = $name;
				ldap_mod_del($ds,$dn,$entry);
			}
		}
	}
	 
	 
	 
	 
	 
	 
	 if($r) echo 'L\'utilisateur a été correctement supprimé.';
	 else echo 'Données non conformes.';

	
	
	kill($ds);
}