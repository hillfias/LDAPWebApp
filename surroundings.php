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
/*
echo $_SESSION['statut'];
print_r($_SESSION['groupes']);
print_r($_SESSION['groupesAdmin']);
*/
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

echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'autoSubmit.js"></script>';

if($_SESSION['statut'] == 'admin')
{
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'getAddUserPage.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'getAddGroupPage.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'deleteUser.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'deleteGroup.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'giveAdminRights.js"></script>';
}
if($_SESSION['statut'] == 'admin' || $_SESSION['statut'] == 'adminGroupe')
{
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'kickUser.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'getAddAdminPage.js"></script>';
	echo '<script language="JavaScript" type="text/javascript" src="'.$CONSTANTES['cheminJs'].'deleteAdmin.js"></script>';
}
include($CONSTANTES['cheminJs'].'getModUserPage.php');

// On affiche soit les groupes soit les utilisateurs

if(!empty($pass) AND $pass == 'groupe')
{
	
	echo '<script type="text/javascript" src="'.$CONSTANTES['cheminJs'].'menuDeroulantPartiel.js"></script>';
	// echo '<script type="text/javascript" src="'.$CONSTANTES['cheminJs'].'getUsersForGroup.js"></script>';
	include($CONSTANTES['cheminJs'].'getUsersForGroup.php');
	
	
	

	
	
	for($nbgroup=0;$nbgroup<$infoNbGroupes['count'];$nbgroup++)
	{
		if($_SESSION['statut'] == 'admin')
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			include($CONSTANTES['cheminVue'].'indexInfoGroup.php');
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		}
		elseif(($_SESSION['statut'] == 'adminGroupe' || $_SESSION['statut'] == 'membre') AND in_array($infoNbGroupes[$nbgroup]['cn'][0],$_SESSION['groupes']))
		{
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
			include($CONSTANTES['cheminVue'].'indexInfoGroup.php');
			// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		}
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
	$membresAdmin = search($ds,'&(objectclass=posixGroup)(cn=admin)',array('memberUid'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
	for($nbusers=0;$nbusers<$membresGroupe[0]['memberuid']['count'];$nbusers++)
	{
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$infoUsers = search($ds,'&(objectclass=posixAccount)(cn='.$membresGroupe[0]['memberuid'][$nbusers].')',array('jpegphoto','givenname','sn','cn'));
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		include($CONSTANTES['cheminVue'].'indexInfoUser.php');
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	}
	
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	include($CONSTANTES['cheminVue'].'indexInfoUserFermeture.php');
	// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}

kill($ds);
?>
	 </dl>
  </div>
		</div>
		<div class="main-panel" id="main-panel"><!--large-9 columns-->
			<!--main panel, ici c'est les commandes et tout ... -->