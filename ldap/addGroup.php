<?php
function addGroup($ds,$info)
{
	// On ajoute le nouveau groupe
	$r = ldap_add($ds, "cn=".$info['cn'].",ou=groups,dc=rBOX,dc=lan", $info);
	
	// On affiche un message d'erreur si l'utilisateur n'a pas pu être ajouté
	if(!$r)
	{
		echo '<p class="center red">Le groupe n\'a pas pu être ajouté. Nous vous prions de nous excuser pour le désagrément.</p>';
		exit();
	}	
	
}
?>