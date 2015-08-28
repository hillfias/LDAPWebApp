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
$adgr = array_keys(array_flip(json_decode($_POST['adgr'])));

if(count($adgr) > 0)
{
	for($i=0;$i<count($adgr);$i++)
	{
		if(!preg_match("#^[a-zA-Z-]+$#",$adgr[$i]))
		{
			echo 'Données non conformes.';
			exit();
		}	
	}
}
else 
{
	echo 'Données non conformes.';
	exit();
}
if(!empty($_POST['nom']) AND preg_match("#^[a-zA-Z]+$#",$_POST['nom']))
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
	$info["owner"] = "";
	for($i=0;$i<count($adgr);$i++)
	{
		$info["owner"] .= "cn=".$adgr[$i].",ou=users,dc=rBOX,dc=lan";
		
		if($i < (count($adgr)-1))
		{
			$info["owner"] .= ",";
		}
	}
	
	
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
	
	for($i=0;$i<count($adgr);$i++)
	{
		if(!in_array($adgr[$i],$info["memberUid"]))
		{
			$info["memberUid"][$j] = $adgr[$i];
			$j++;
		}
	}

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