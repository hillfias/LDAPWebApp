<?php

header("Content-Type: text/plain");


$group = (isset($_POST["group"])) ? $_POST["group"] : NULL;
$CONSTANTES['cheminImages'] = 'theme/images/';

if ($group) {
	
	include('../ldap/index.php');
	$ds = connectionLDAP();
	
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// On récupère la liste des utilisateurs et des admins du groupe
	$membresGroupe = search($ds,'&(objectclass=posixGroup)(cn='.$group.')',array('memberUid','owner'));
	// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	echo '{
	items: [';
	
	
	// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
	for($nbusers=0;$nbusers<$membresGroupe[0]['memberuid']['count'];$nbusers++)
	{
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$infoUsers = search($ds,'&(objectclass=posixAccount)(cn='.$membresGroupe[0]['memberuid'][$nbusers].')',array('jpegphoto','givenname','sn'));
		// LDAP ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

		echo '
		{
		photo: "'.base64_encode($infoUsers[0]['jpegphoto'][0]).'",';
		$true = false;
		if(strpos($membresGroupe[0]['owner'][0],$membresGroupe[0]['memberuid'][$nbusers]))
		{
			echo 'yes: "<img  src=\"'.$CONSTANTES['cheminImages'].'admin.svg\" width=\"20px\" style=\"position:relative;left:-25px;margin-right:-20px;\" />",';
			$true = true;
		}
		else echo 'yes: "",';
		
		echo 'forname: "'.$infoUsers[0]['givenname'][0].'",
		lastname: "'.$infoUsers[0]['sn'][0].'",';
		
		
		if($group != 'all') echo 'yes2: "<a href=\"\" class=\"right\"><img src=\"'.$CONSTANTES['cheminImages'].'removeUser.svg\" title=\"Enlever du groupe\" alt=\"Enlever du groupe\" width=\"15px\"/></a>",';
		else echo 'yes2: "<a href=\"\" class=\"right\"><img src=\"'.$CONSTANTES['cheminImages'].'deleteUser.svg\" title=\"Supprimer l\'utilisateur\" alt=\"Supprimer l\'utilisateur\" width=\"15px\"/></a>",';
		
		if($true) echo 'yes3: "<a href=\"\" class=\"right\"><img src=\"'.$CONSTANTES['cheminImages'].'removeAdmin.svg\" title=\"Enlever l\'admin du groupe\" alt=\"Enlever l\'admin du groupe\" width=\"15px\"/></a>"';
		else echo 'yes3: ""';
		echo '
		}';
		
		if(($nbusers+1)<$membresGroupe[0]['memberuid']['count']) echo ',';
		
		
		
	}	

	
	echo ']

	}';

} else {

    echo "FAIL";

}