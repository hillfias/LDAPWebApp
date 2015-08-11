<?php
session_start();

// Si on est pas à la racine on récupère le nom du fichier
if(preg_match('#^/.*/(.*)\.php$#',$_SERVER['REQUEST_URI'],$nomfichier))
{
	$nomfichier = $nomfichier[1];
}
// Sinon on indique qu'on est à la racine
else $nomfichier = 'index';

// Constantes qui serviront au cours du script.
// -------------------------------------------
$CONSTANTES['adresseIp'] = "80.240.136.144";
$CONSTANTES['port'] = "389";
$CONSTANTES['cheminModele'] = "ldap/";
$CONSTANTES['cheminVue'] = "templates/";
$CONSTANTES['cheminImages'] = "theme/images/";
$CONSTANTES['cheminStylesheets'] = "theme/stylesheets/";
$CONSTANTES['cheminData'] = "data/";
$CONSTANTES['cheminJs'] = "theme/javascript/";
$CONSTANTES['nomFichier'] = $nomfichier;
// -------------------------------------------

if(!isset($_POST['mdp']) AND !isset($_POST['nom']))
{
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Si rien n'a été envoyé on affiche le formulaire de connection
include($CONSTANTES['cheminVue'].'coFormulaire.php');
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
else
{
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On se connecte au serveur LDAP
	include($CONSTANTES['cheminModele'].'index.php');
	$ds = connectionLDAP();
	
	// On récupère les informations sur l'utilisateur qui souhaite se connecter
	$info = search($ds,'cn='.$_POST['nom'],array('userpassword'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// Si l'utilisateur existe
	if(!empty($info[0]['userpassword'][0]))
	{
		$passwordClair = $_POST['mdp'];
		$salt = 'sMr812.!5@HWwhtvG{?8L';
		$encryptedPassword = $info[0]['userpassword'][0];
		
		// Si le mot de passe est correct
		if($encryptedPassword == '{SSHA}' . base64_encode(sha1( $passwordClair.$salt, TRUE ). $salt))
		{
			// On connecte l'utilisateur
			$_SESSION['connected'] = 'Js%up£e58rP0w4;_a';
			
			// Selon son rang, il aura différents droits. On aimerait donc savoir s'il est admin ou administrateur d'un groupe (sinon c'est un simple membre et on connait ses droits)
			
			// S'il est admin
			if($info[0]['cn'][0] == 'admin')
			{
				$_SESSION ['statut'] = 'admin';
				header('Location: accueil.php');
			}
			// Sinon on récupère les infos des groupes
			else
			{
				// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
				$infoGroupes = search($ds,'objectclass=posixGroup',array('owner'));
				// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

				for($nbgroup=0;$nbgroup<$infoGroupes['count'];$nbgroup++)
				{
					// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					// On récupère les infos sur l'administrateur du groupe
					preg_match('#^cn=([a-z-]+),#',$infoGroupes[$nbgroup]['owner'][0],$owner);
					
					$infoAdmin = search($ds,'cn='.$owner[1],array('userpassword'));
					// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
					
					// S'il est admin d'un groupe
					if(!empty($infoAdmin[0]['userpassword'][0]))
					{
						$_SESSION ['statut'] = 'adminGroupe';
						header('Location: accueil.php');
					}
					else
					{
						$_SESSION ['statut'] = 'membre';
						header('Location: accueil.php');
					}
				}
			}
		}
		// Sinon on affiche denouveau le formulaire avec une erreur de mot de passe
		else
		{
			$erreur = 'Erreur lors de la saisie du mot de passe.';
			$login = $_POST['nom'];
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			include($CONSTANTES['cheminVue'].'coFormulaire.php');
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		}
	}
	// Sinon on affiche denouveau le formulaire avec une erreur 'profil inexistant'/'mauvais pseudo'
	else
	{
		$erreur = 'Erreur lors de la saisie du pseudo ou profil inexistant';
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'coFormulaire.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
}
?>