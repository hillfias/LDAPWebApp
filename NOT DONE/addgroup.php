<?php
include('header.php');

if($_SESSION['statut'] == 'admin')
{
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminModele'].'index.php');
	$ds = connectionLDAP();
	$infoUsers = search($ds,'objectclass=posixAccount');
	kill($ds);
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	if (!isset($_POST['nom']) AND !isset($_POST['adgr']))
	{
	// Si on n'a pas reçu de données, on affiche le formulaire.
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminVue'].'addGroupFormulaire.php');
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	
	// Sinon si on a reçu des données (uniquement celles qui sont nécessaires)on vérifie le genre des données nom et diminutif de l'admin du groupe
	elseif(!empty($_POST['nom']) AND !empty($_POST['adgr']) AND preg_match("#^[a-zA-Z]+$#",$_POST['nom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['adgr']))
	{
		// On traite les données : nom et diminutif de l'admin du groupe
		$nom = $_POST['nom'];
		$adgr = $_POST['adgr'];
		$gid = (int) file_get_contents($CONSTANTES['cheminData']."gid.txt");
		if(!$gid)
		{
			echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.</p>';
			exit();
		}
		
		// On incrémente automatiquement le gid
		$gid++;
		$monfichier2 = fopen($CONSTANTES['cheminData'].'gid.txt', 'w+');
		if(!$monfichier2)
		{
			echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.</p>';
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
		include($CONSTANTES['cheminModele'].'addGroup.php');
		addGroup($ds,$info);
		echo '<p class="center success">Le groupe a été correctement ajouté.</p>';
		
		kill($ds);
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	
	// Sinon on affiche un formulaire d'erreur
	else
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'addGroupFormulaireErreur.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	}
}
else echo '<p class="center red">Erreur : vous n\'avez pas les droits requis.</p>';
?>