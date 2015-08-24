<?php
header("Content-Type: text/plain"); 
/**
* create new group
* @param : name : group's name [required]
* @param : admin : group's admin [required]
* @param : users : a list of all the users to add to the group being created [optional] 
*
* @return : a confirmation or error message (text)
* */

if(!empty($_POST['nom']) AND !empty($_POST['adgr']) AND preg_match("#^[a-zA-Z]+$#",$_POST['nom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['adgr']))
{
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include('../ldap/index.php');
	$ds = connectionLDAP();
	$infoUsers = search($ds,'objectclass=posixAccount',array('cn'));
	// On termine la connection au serveur
	kill($ds);
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	
	
	// On traite les données : nom et diminutif de l'admin du groupe
	$nom = $_POST['nom'];
	$adgr = $_POST['adgr'];
	$gid = (int) file_get_contents('../data/gid.txt');
	if(!$gid)
	{
		echo 'La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
		exit();
	}
	
	// On incrémente automatiquement le gid
	$gid++;
	$monfichier2 = fopen('../data/gid.txt', 'w+');
	if(!$monfichier2)
	{
		echo 'La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
		exit();
	}
	fseek($monfichier2, 0); // On remet le curseur au début du fichier
	fputs($monfichier2, $gid); // On écrit le nouveau gid
	fclose($monfichier2);
	
	// On prépare les données du groupe à ajouter
	$info["cn"] = "$nom";
	$info["gidNumber"] = "$gid";
	$info["objectClass"][0] = "posixGroup";
	$info["objectClass"][1] = "top";
	$info["objectClass"][2] = "extensibleObject";
	$info["owner"] = "cn=$adgr,ou=users,dc=rBOX,dc=lan";
	
	$j=0;
	$info["memberUid"] = array();
	for($i=0;$i<$infoUsers['count'];$i++)
	{
		if(!empty($_POST[$infoUsers[$i]['cn'][0]]))
		{
			$info["memberUid"][$j] = $infoUsers[$i]['cn'][0];
			$j++;
		}
	}
	
	if(!in_array($adgr,$info["memberUid"])) $info["memberUid"][$j] = $adgr;

	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On ajoute les données au dossier
	$ds = connectionLDAP();
	include('../ldap/addGroup.php');
	addGroup($ds,$info);
	echo 'Le groupe a été correctement ajouté.';
	
	kill($ds);
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}

// Sinon on affiche un formulaire d'erreur
else
{
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	echo 'Données non conformes.';
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
?>