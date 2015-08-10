<?php
include('header.php');

// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On se connecte au serveur LDAP
include($CONSTANTES['cheminModele'].'index.php');
$ds = connectionLDAP();

// Recherche des infos admin
$info = search($ds,'cn=admin');

// Nous allons maintenant rechercher des informations concernant les groupes et utilisateurs
// On commence par les groupes
$infoGroupes = search($ds,'objectclass=posixGroup');

// Puis les utilisateurs
$infoUsers = search($ds,'objectclass=posixAccount');
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
include($CONSTANTES['cheminVue'].'indexContainer.php');
include($CONSTANTES['cheminVue'].'indexInfoGene.php');
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
										
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






										
// Nous avons maintenant terminé d'afficher les informations de bases et nous allons travailler de façon hiérarchique en affichant groupe par groupe et en indiquant à chaque fois quel(s) utilisateur(s) appartien(es/nent) à ces groupe(s)
for($nbgroup=0;$nbgroup<$infoGroupes['count'];$nbgroup++)
{

	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On récupère les infos sur l'administrateur du groupe
	preg_match('#^cn=([a-z-]+),#',$infoGroupes[$nbgroup]['owner'][0],$owner);
	$infoAdmin = search($ds,'cn='.$owner[1]);
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	if(!empty($pass) AND $pass == 'groupe')
	include($CONSTANTES['cheminVue'].'indexInfoGroupUser.php');
	else
	include($CONSTANTES['cheminVue'].'indexInfoUser.php');
	
	
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

}
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
include($CONSTANTES['cheminVue'].'indexContent.php');
// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// On termine la connection au serveur
kill($ds);
// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

include ('bot.php');
?>
