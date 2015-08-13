<?php
include('header.php');

// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On se connecte au serveur LDAP
include($CONSTANTES['cheminModele'].'index.php');
$ds = connectionLDAP();

// On veut connaitre le nombre (et pour plus tard le nom) des groupes et le nombre d'utilisateurs
$infoNbGroupes = search($ds,'objectclass=posixGroup',array('count','cn'));
$infoNbUsers = search($ds,'objectclass=posixAccount',array('count'));
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
include($CONSTANTES['cheminVue'].'indexContainer.php');
include($CONSTANTES['cheminVue'].'indexInfoGene.php');
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		
// Gestion du bypass des renvois des données lors d'un rechargement de la page		
if(isset($_POST['supporttype']) AND !empty($_POST['supporttype']) AND $_POST['supporttype'] == 'groupe')
{
	$_SESSION['supporttype'] = 'groupe';
	header('Location: '.$nomfichier.'.php');
}
elseif(isset($_POST['supporttype']) AND !empty($_POST['supporttype']) AND $_POST['supporttype'] == 'users')
{
	$_SESSION['supporttype'] = 'users';
	header('Location: '.$nomfichier.'.php');
}
elseif(isset($_SESSION['supporttype']) AND !empty($_SESSION['supporttype']) AND $_SESSION['supporttype'] == 'groupe')
{
	$pass = 'groupe';
}
elseif(isset($_SESSION['supporttype']) AND !empty($_SESSION['supporttype']) AND $_SESSION['supporttype'] == 'users')
{
	$pass = 'users';
}

// On affiche soit les groupes soit les utilisateurs

if(!empty($pass) AND $pass == 'groupe')
{
	
	echo '<script type="text/javascript" src="'.$CONSTANTES['cheminJs'].'menuDeroulantPartiel.js"></script>';
	echo '<script type="text/javascript" src="'.$CONSTANTES['cheminJs'].'ajax_menuDeroulantSuite.js"></script>';
	
	
	for($nbgroup=0;$nbgroup<$infoNbGroupes['count'];$nbgroup++)
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'indexInfoGroup.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminVue'].'indexInfoGroupFermeture.php');
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

}
	
	
	
	
	
else
{
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminVue'].'indexInfoUserOuverture.php');
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On récupère la liste des utilisateurs et des admins du groupe
	$membresGroupe = search($ds,'&(objectclass=posixGroup)(cn='.$infoNbGroupes[0]['cn'][0].')',array('memberUid','owner'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
	for($nbusers=0;$nbusers<$membresGroupe[0]['memberuid']['count'];$nbusers++)
	{
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$infoUsers = search($ds,'&(objectclass=posixAccount)(cn='.$membresGroupe[0]['memberuid'][$nbusers].')',array('jpegphoto','givenname','sn'));
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'indexInfoUser.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminVue'].'indexInfoUserFermeture.php');
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
?>