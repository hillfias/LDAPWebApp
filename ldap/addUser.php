<?php
function addUser($ds,$info,$infoGroupes)
{
	// On ajoute le nouvel utilisateur
	$r = ldap_add($ds, "cn=".$info["cn"].",ou=users,dc=rBOX,dc=lan", $info);
	
	// On affiche un message d'erreur si l'utilisateur n'a pas pu être ajouté
	if(!$r)
	{
		echo '<p class="center red">L\'utilisateur n\'a pas pu être ajouté. Nous vous prions de nous excuser pour le désagrément.</p>';
		exit();
	}
	
	$entry['memberUid'] = $info["cn"];
	$res = add2Group($ds,$entry,$infoGroupes);
	$res2 = add2OtherGroup($ds,$entry,$infoGroupes);
	if(!$res OR !$res2)
	{
		return false;
	}
	return true;
}
function add2Group($ds,$info,$infoGroupes)
{
	$r = ldap_mod_add($ds, "cn=".$infoGroupes[0]['cn'][0].",ou=groups,dc=rBOX,dc=lan", $info);
	
	// On affiche un message d'erreur si l'utilisateur n'a pas pu être ajouté au groupe
	if(!$r)
	{
		echo '<p class="center red">L\'utilisateur n\'a pas pu être ajouté au groupe \'all\'. Un message sera envoyé à l\'administrateur.</p>';
		return false;
	}
	return true;
}
function add2OtherGroup($ds,$info,$infoGroupes)
{
	$erreur = false;
	for($i=1;$i<$infoGroupes['count'];$i++)
	{
		if(!empty($_POST[$infoGroupes[$i]['cn'][0]]))
		{
			$r = ldap_mod_add($ds, "cn=".$infoGroupes[$i]['cn'][0].",ou=groups,dc=rBOX,dc=lan", $info); 
			if(!$r)
			{
				if($erreur) $grp .= ', '.$infoGroupes[$i]['cn'][0];
				else
				{
					$erreur = true;
					$grp = $infoGroupes[$i]['cn'][0];
				}
			}
		}
	}
	
	// On affiche un message d'erreur si l'utilisateur n'a pas pu être ajouté a un groupe
	if($erreur)
	{
		echo '<p class="center red">L\'utilisateur n\'a pas pu être ajouté au(x) groupe(s) '.$grp.'. Un message sera envoyé à l\'administrateur.</p>';
		return false;
	}
	return true;
}
?>