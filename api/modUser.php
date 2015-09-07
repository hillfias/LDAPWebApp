<?php
header("Content-Type: text/plain"); 
/**
* modify user
* @param : surName : surname of the creating user [required]
* @param : firstName : firstname of the creating user [required]
* @param : password : password for the crating user [optional]
* @param : passwordConfirm : confirming password [optional]
* @param : mail : e-mail of the creating user [required]
* @param : photo : picture of the creating user [optional]
*
* @return : a confirmation or error message (text)
* */



// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On a besoin de récupérer les infos sur les groupes pour le formulaire/ pour ajouter un nouvel utilisateur
include('../ldap/index.php');
$ds = connectionLDAP();
$infoUser = search($ds,'&(objectclass=posixAccount)(cn='.$_POST['user'].')',array('sn','givenname','mail','cn'));
// On termine la connection au serveur
kill($ds);
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

$CONSTANTES['cheminImages'] = "theme/images/";
$CONSTANTES['cheminModele'] = "ldap/";
$CONSTANTES['cheminData'] = "data/";


if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['mail']))
{
	if($infoUser[0]['sn'][0] != $_POST['nom'])
	{
		if(preg_match("#^[a-zA-Z-]+$#",$_POST['nom']))
		{
			$nom = ucfirst(strtolower($_POST['nom']));
			$lettre = array();
			if(preg_match("#\-([a-z])#",$nom,$lettre))
			{
				$lettre = strtoupper($lettre[1]);
				$nom = preg_replace("#-[a-z]#","-$lettre",$nom); 
			}
			$info["sn"] = "$nom";
			$nomtmp = preg_replace("#-#","",$_POST['nom']);
			$diminutif = strtolower(substr($_POST['prenom'],0,1)).strtolower($nomtmp);
			$info["homeDirectory"] = "/home/users/$diminutif";
			$info["userid"] = "$diminutif";
			
			
		}
		else
		{
			echo 'nom';
			exit();
		}
	}
	
	if($infoUser[0]['givenname'][0] != $_POST['prenom'])
	{
		if(preg_match("#^[a-zA-Z-]+$#",$_POST['prenom']))
		{
			$prenom = ucfirst(strtolower($_POST['prenom']));
			$lettre = array();
			if(preg_match("#\-([a-z])#",$prenom,$lettre))
			{
				$lettre = strtoupper($lettre[1]);
				$prenom = preg_replace("#-[a-z]#","-$lettre",$prenom); 
			}
			$info["gn"] = "$prenom";
			$nomtmp = preg_replace("#-#","",$_POST['nom']);
			$diminutif = strtolower(substr($_POST['prenom'],0,1)).strtolower($nomtmp);
			$info["homeDirectory"] = "/home/users/$diminutif";
			$info["userid"] = "$diminutif"; 
		}
		else
		{
			echo 'prenom';
			exit();
		}
	}
	
	if($infoUser[0]['mail'][0] != $_POST['mail'])
	{
		if(preg_match("#^[a-zA-Z0-9.-]+@[a-z]+\.[a-z]{2,4}$#",$_POST['mail']))
		{
			$info["mail"] = $_POST['mail'];
		}
		else
		{
			echo 'mail';
			exit();
		}
	}
	
	if(!empty($_POST['mdp']) && !empty($_POST['confmdp']) && $_POST['mdp'] == $_POST['confmdp'])
	{
		// On crypte le mot de passe
		$password = $_POST['mdp'];
		$salt = 'sMr812.!5@HWwhtvG{?8L';
		$encrypted_password = '{SSHA}' . base64_encode(sha1( $password.$salt, TRUE ). $salt);
		$info["userPassword"] = $encrypted_password;
	}
					
	// Si une image a été posté, on récupère le chemin vers l'image			
	if(!empty($_FILES['fichier']['type']))
	{
		if ($_FILES['fichier']['error'] > 0)
		{
			echo 'Erreur lors de l\'upload image';
			exit();
		}
		
		$content_dir = 'tmp/'; 
		$tmp_file = $_FILES['fichier']['tmp_name'];
		$type_file = $_FILES['fichier']['type'];
		
		// On vérifie que l'image a bien été uploadé temporairement, si ce n'est pas le cas on redirige vers le formulaire avec un message d'erreur et les champs pré-remplis
		if( !is_uploaded_file($tmp_file) )
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			$erreurImage = "Une erreur s'est produite : l'image est introuvable. Nous vous prions de nous excuser pour le désagrément.";
			echo $erreurImage;
			exit();
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		}
		
		// on vérifie maintenant l'extension
		if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			$erreurImage = "Le fichier n'est pas une image.";
			echo $erreurImage;
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
			echo $erreurImage;
			exit();
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		}
		
		// on copie le fichier dans le dossier de destination temporaire
		if( !move_uploaded_file($tmp_file, '../'.$content_dir . $name_file) )
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			$erreurImage = "Impossible de copier le fichier dans le dossier temporaire : $content_dir. Nous vous prions de nous excuser pour le désagrément.";
			echo $erreurImage;
			exit();
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		}
		$img = '../'.$content_dir . $name_file;
		
		if ($type == 'jpg' || $type == 'jpeg')
		{
			$ImageNews = getimagesize($img);
			$ImageChoisie = imagecreatefromjpeg($img);

			$TailleImageChoisie = getimagesize($img);

			$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
			
			if($NouvelleHauteur > 128)
			{
				$NouvelleHauteur = 128;
				$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
			}

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

			imagedestroy($ImageChoisie);

			imagejpeg($NouvelleImage , $img, 100);
		}
		elseif ($type == 'png')
		{
			$ImageNews = getimagesize($img);
			$ImageChoisie = imagecreatefrompng($img);

			$TailleImageChoisie = getimagesize($img);

			$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
			
			if($NouvelleHauteur > 128)
			{
				$NouvelleHauteur = 128;
				$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
			}

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

			imagedestroy($ImageChoisie);

			imagepng($NouvelleImage , $img, 9);
		}
		elseif ($type == 'gif')
		{
			$ImageNews = getimagesize($img);
			$ImageChoisie = imagecreatefromgif($img);

			$TailleImageChoisie = getimagesize($img);

			$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

			$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
			
			if($NouvelleHauteur > 128)
			{
				$NouvelleHauteur = 128;
				$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
			}

			$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");

			imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

			imagedestroy($ImageChoisie);

			imagegif($NouvelleImage , $img);
		}
		
		if($img)
		{
			// On récupère l'image
			$fp=fopen($img,"r"); 
			if(!$fp)
			{
				echo 'La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
				exit();
			}
			$image=fread($fp,filesize($img)); 
			if(!$image)
			{
				echo 'La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
				exit();
			}
			fclose($fp);
			
			// Si une image a été uploadé, on la supprime
			if(!empty($content_dir))
			{
				if(!unlink($img))
				{
					echo 'Une erreur est survenue lors de la tentative de suppression de l\'image que vous avez uploadé. Un message sera envoyé à l\'administrateur.';
					exit();
				}
			}
		}
		$info['jpegPhoto']=$image; 
	}
	
	
	if(!empty($info))
	{
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		// On ajoute le nouvel utilisateur
		$ds = connectionLDAP();
		// to do : modifier utilisateur et mettre a jour le userid dans tous les groupes auxquels il appartient
		$dn = "cn=".$infoUser[0]['cn'][0].",ou=users,dc=rBOX,dc=lan";
		$res = ldap_mod_replace($ds,$dn,$info);
		
		if(!$res)
		{
			echo 'L\'utilisateur n\'a pas été successivement modifié.';
			exit();
		}
		else
		{
			echo 'L\'utilisateur a été correctement modifié.';
		}
		
		if($diminutif)
		{
			$dn2 = "cn=$diminutif";
			$res = ldap_rename($ds,$dn,$dn2,null, true);
		
			if(!$res)
			{
				echo 'L\'utilisateur n\'a pas été successivement modifié.';
				exit();
			}
		

			if(!empty($info["sn"]) OR !empty($info["gn"]))
			{	
				
				$membresGroupe = search($ds,'objectclass=posixGroup',array('memberUid','owner','cn'));
				for($nbgroupes=0;$nbgroupes<$membresGroupe['count'];$nbgroupes++)
				{
					if(in_array($infoUser[0]['cn'][0],$membresGroupe[$nbgroupes]['memberuid']))
					{
						
						$infosGroupes['memberUid'] = array();
						
						for($i=0;$i<$membresGroupe[$nbgroupes]['memberuid']['count'];$i++)
						{
							if($infoUser[0]['cn'][0] == $membresGroupe[$nbgroupes]['memberuid'][$i])
							{
								$infosGroupes['memberUid'][] = $diminutif;
							}
							else
							{
								$infosGroupes['memberUid'][] = $membresGroupe[$nbgroupes]['memberuid'][$i];
							}
						}
						
						
						
						$dn = "cn=".$membresGroupe[$nbgroupes]['cn'][0].",ou=groups,dc=rBOX,dc=lan";
						
						$res = ldap_mod_replace($ds,$dn,$infosGroupes);
						if(!$res)
						{
							echo 'Le groupe'.$nbgroupes.' auquel appartient l\'utilisateur n\'a pas été successivement modifié.';
							kill($ds);
							exit();
						}
						
					}
				}
			}
		}
		// On termine la connection au serveur
		kill($ds);
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	else
	{
		echo 'Veuillez effectuer une modification';
	}
}

// Sinon on affiche un formulaire d'erreur
else
{
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	echo 'Données non conformes.';
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

}
// FIN DE LINSTRUCTION modUser
?>