<?php
include('header.php');

// Si l'utilisateur est admin, il peut ajouter un nouvel utilisateur
if($_SESSION['statut'] == 'admin')
{
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
	include($CONSTANTES['cheminModele'].'index.php');
	$ds = connectionLDAP();
	$infoGroupes = search($ds,'objectclass=posixGroup',array('cn'));
	// On termine la connection au serveur
	kill($ds);
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// Si on a reçu aucune données, on affiche le formulaire
	if (!isset($_POST['nom']) AND !isset($_POST['prenom']) AND !isset($_POST['mdp']) AND !isset($_POST['confmdp']) AND !isset($_POST['mail']))
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'addUserFormulaire.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}

	// Sinon si on a reçu les données nécessaires
	elseif(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mdp']) AND !empty($_POST['confmdp']) AND !empty($_POST['mail']))
	{
		$mdp = sha1($_POST['mdp']);
		$confmdp = sha1($_POST['confmdp']);
		
		// On vérifie le genre des données nom, prénom et mail et la concordance des mots de passes
		if(preg_match("#^[a-zA-Z-]+$#",$_POST['nom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['prenom']) AND preg_match("#^[a-zA-Z0-9.-]+@[a-z]+\.[a-z]{2,4}$#",$_POST['mail']) AND $mdp == $confmdp)
		{

			// On traite les données : nom et prénom
			$nom = ucfirst(strtolower($_POST['nom']));
			$prenom = ucfirst(strtolower($_POST['prenom']));
			
			// Si le nom ou le prénom contient un trait d'union, on met une majuscule juste après			
			$lettre = array();
			if(preg_match("#\-([a-z])#",$nom,$lettre))
			{
				$lettre = strtoupper($lettre[1]);
				$nom = preg_replace("#-[a-z]#","-$lettre",$nom); 
			}
			$lettre = array();
			if(preg_match("#\-([a-z])#",$prenom,$lettre))
			{
				$lettre = strtoupper($lettre[1]);
				$prenom = preg_replace("#-[a-z]#","-$lettre",$prenom); 
			}

			// On initialise le gid à 500 par défaut (groupe 'all' Primaire) et on récupère un uid approprié
			$gid = '500';
			$uid = (int) file_get_contents($CONSTANTES['cheminData']."uid.txt");
			if(!$uid)
			{
				echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.</p>';
				exit();
			}
			
			// On supprime le trait d'union s'il existe, et on créer le pseudo avec la première lettre du prénom et le nom
			$nomtmp = preg_replace("#-#","",$nom);
			$diminutif = strtolower(substr($prenom,0,1)).strtolower($nomtmp);
						
			// Si une image a été posté, on récupère le chemin vers l'image			
			if(!empty($_FILES['fichier']['type']))
			{
				$content_dir = 'tmp/'; 
				$tmp_file = $_FILES['fichier']['tmp_name'];
				$type_file = $_FILES['fichier']['type'];
				
				// On vérifie que l'image a bien été uploadé temporairement, si ce n'est pas le cas on redirige vers le formulaire avec un message d'erreur et les champs pré-remplis
				if( !is_uploaded_file($tmp_file) )
				{
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$erreurImage = "Une erreur s'est produite : l'image est introuvable. Nous vous prions de nous excuser pour le désagrément.";
					include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
					exit();
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

				}
				
				// on vérifie maintenant l'extension
				if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
				{
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$erreurImage = "Le fichier n'est pas une image.";
					include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
					exit();
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

				}

				// On renomme le fichier pour éviter les conflits
				$type = substr(strrchr($type_file, "/"), 1);
				$name_file = md5(rand().rand().rand().rand()).'.'.$type;

				// On vérifie que personne ne veut uploader un script en le faisant passer pour une image
				if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $_FILES['fichier']['name']) )
				{
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$erreurImage = "Nom de fichier non valide.";
					include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
					exit();
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
				
				}
				
				// on copie le fichier dans le dossier de destination temporaire
				if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
				{
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					$erreurImage = "Impossible de copier le fichier dans le dossier temporaire : $content_dir. Nous vous prions de nous excuser pour le désagrément.";
					include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
					exit();
					// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

				}
				$img = $content_dir . $name_file;
			}
			
			// Sinon, si aucune image n'a été posté, on prend le chemin de celle par défaut
			else
			{
				$img = $CONSTANTES['cheminImages']."profil.png";
			}
			
			// On récupère l'image
			$fp=fopen($img,"r"); 
			if(!$fp)
			{
				echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.</p>';
				exit();
			}
			$image=fread($fp,filesize($img)); 
			if(!$image)
			{
				echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.</p>';
				exit();
			}
			fclose($fp);
			
			// Si une image a été uploadé, on la supprime
			if(!empty($content_dir))
			{
				if(!unlink($img))
				{
					echo '<p class="center red">Une erreur est survenue lors de la tentative de suppression de l\'image que vous uploadé. Un message sera envoyé à l\'administrateur.</p>';
					exit();
				}
			}
			
			// On crypte le mot de passe
			$password = $_POST['mdp'];
			$salt = 'sMr812.!5@HWwhtvG{?8L';
			$encrypted_password = '{SSHA}' . base64_encode(sha1( $password.$salt, TRUE ). $salt);

			// On prépare les données du profil à ajouter
			$info["cn"] = "$diminutif";
			$info["gidNumber"] = "$gid";
			$info["gn"] = "$prenom";
			$info["homeDirectory"] = "/home/users/$diminutif";
			$info["objectClass"][0] = "inetOrgPerson";
			$info["objectClass"][1] = "posixAccount";
			$info["objectClass"][2] = "top";
			$info["sn"] = "$nom";
			$info['jpegPhoto']=$image; 
			$info['mail'] = $_POST['mail'];
			$info["userPassword"] = $encrypted_password;
			$info["userid"] = "$diminutif";
			$info["uidNumber"] = "$uid";

			
			// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			// On ajoute le nouvel utilisateur
			$ds = connectionLDAP();
			include($CONSTANTES['cheminModele'].'addUser.php');
			$res = addUser($ds,$info,$infoGroupes);
			if(!$res)
			{
				echo '<p class="center red">L\'utilisateur a été ajouté mais certaines erreures persistent. Un message sera envoyé à l\'administrateur.</p>';
			}
			else
			{
				echo '<p class="center success">L\'utilisateur a été correctement ajouté.</p>';
			}
			
			// On termine la connection au serveur
			kill($ds);
			// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

			// On incrémente automatiquement l'uid 
			$uid++;
			$monfichier2 = fopen($CONSTANTES['cheminData'].'uid.txt', 'w+');
			if(!$monfichier2)
			{
				echo '<p class="center red">La tentative de récupération de données contenues dans un fichier a échoué. Un message sera envoyé à l\'administrateur.</p>';
				exit();
			}
			fseek($monfichier2, 0); // On remet le curseur au début du fichier
			fputs($monfichier2, $uid); // On écrit le nouveau uid
			fclose($monfichier2);
		}
		
		// Sinon on affiche un formulaire d'erreur
		else
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		}
	}
	
	// Sinon on affiche un formulaire d'erreur
	else
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'addUserFormulaireErreur.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	}
}
else echo '<p class="center red">Erreur : vous n\'avez pas les droits requis.</p>';
?>