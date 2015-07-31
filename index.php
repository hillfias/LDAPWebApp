<?php
include('header.php');
?>
<div class="centerblock">
<?php

// On se connecte au serveur LDAP
$ds=ldap_connect("80.240.136.144","389");  
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
// Si on est bien arrivé à se connecté
if($ds)
{
	// On effectue la liaison avec le serveur
	$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
	// Si la liaison est effectué
	if($r)
	{

		// Nous allons commencer par afficher des informations de bases concernant le domaine auquel on est connecté et son administrateur
		$dn = "dc=rBOX,dc=lan"; 			//Domaine
		$filtre='(cn=admin)';				//Filtre de recherche
		$sr=ldap_search($ds, $dn, $filtre);	//On effectue la recherche
		$info = ldap_get_entries($ds, $sr);	//On récupère les résultats
		
		echo '<p>Bienvenue sur le domaine '.ldap_dn2ufn($info[0]['dn']).' administré par <strong>'.$info[0]['cn'][0].'</strong> : <em>'.$info[0]['description'][0].'</em> (Groupe';
		
		// Nous allons maintenant rechercher des informations concernant les groupes et utilisateurs
		// On commence par les groupes
		$filtre='(objectclass=posixGroup)';
		$sr=ldap_search($ds, $dn, $filtre);	
		$infoGroupes = ldap_get_entries($ds, $sr);	
		
		if($infoGroupes['count'] == 0) echo ' : 0';
		elseif ($infoGroupes['count'] > 1)
		{
			echo 's : '.$infoGroupes['count'];
		}
		else
		{
			echo ' : '.$infoGroupes['count'];
		}
		
		// Puis les utilisateurs
		$filtre='(objectclass=posixAccount)';
		$sr=ldap_search($ds, $dn, $filtre);	
		$infoUsers = ldap_get_entries($ds, $sr);
		
		if($infoUsers['count'] == 0) echo ', Utilisateur : 0).';
		elseif ($infoUsers['count'] > 1)
		{
			echo ', Utilisateurs : '.$infoUsers['count'].').';
		}
		else
		{
			echo ', Utilisateur : '.$infoUsers['count'].').';
		}

		// Nous avons maintenant terminé d'afficher les informations de bases et nous allons travailler de façon hiérarchique en affichant groupe par groupe et en indiquant à chaque fois quel(s) utilisateur(s) appartien(es/nent) à ces groupe(s)
		for($nbgroup=0;$nbgroup<$infoGroupes['count'];$nbgroup++)
		{
			echo '<div class="group">';
			echo '<p>Nom du groupe : <strong>'.$infoGroupes[$nbgroup]['cn'][0].'</strong> (Nom de domaine complet : <em>'.ldap_dn2ufn($infoGroupes[$nbgroup]['dn']).'</em>)';
			preg_match('#^cn=([a-z-]+),#',$infoGroupes[$nbgroup]['owner'][0],$owner);
			
			$filtre='(cn='.$owner[1].')';
			$sr=ldap_search($ds, $dn, $filtre);	
			$infoAdmin = ldap_get_entries($ds, $sr);
			
			echo '<br />Groupe administré par : <strong>'.$infoAdmin[0]['givenname'][0].' '.$infoAdmin[0]['sn'][0].'</strong></p>';
			
			// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
			for($nbusers=0;$nbusers<$infoUsers['count'];$nbusers++)
			{
				// Si l'utilisateur appartient au groupe
				if(in_array($infoUsers[$nbusers]['cn'][0],$infoGroupes[$nbgroup]['memberuid']))
				{
					echo '<div class="user">';
					echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[$nbusers]['jpegphoto'][0]).'" width="75px"; />';
					echo '<strong>'.$infoUsers[$nbusers]['givenname'][0].' '.$infoUsers[$nbusers]['sn'][0].'</strong>';
					echo '<br />Adresse mail : '.$infoUsers[$nbusers]['mail'][0].'<br />';
					
					// Si l'utilisateur n'appartient à aucun groupe
					if($infoUsers[$nbusers]['gidnumber']['count'] == 0)
					{
						echo "N'appartient à aucun groupe.";
					}
					
					// Si l'utilisateur appartient à un groupe, c'est avant tout le groupe primaire 'all'
					elseif($infoUsers[$nbusers]['gidnumber']['count'] == 1)
					{
						echo 'Appartient au groupe <em>all</em> (Primaire)';
					}
					
					// Si il appartient à d'autres groupes (secondaires), on les affiches
					$res = array();
					
					for($j=0;$j<$infoGroupes['count'];$j++)
					{
						for($i=0;$i<$infoGroupes[$j]['memberuid']['count'];$i++)
						{
							
							if($infoGroupes[$j]['memberuid'][$i] == $infoUsers[$nbusers]['uid'][0] AND $infoGroupes[$j]['cn'][0] != 'all')
							{
								$res[] = $infoGroupes[$j]['cn'][0];
							}
						}
					}
					if($res != null)
					{
						if(count($res) == 1) echo '<br />Appartient au groupe :<em> ';
						else echo '<br />Appartient aux groupes :<em> ';
						for($i=0;$i<count($res);$i++)
						{
							echo $res[$i];
							if(count($res)-$i > 1) echo ', ';
						}
						if(count($res) == 1) echo '</em> (Secondaire)';
						else echo '</em> (Secondaires)';
					}
					echo '</p></div>';
				}
			}
			echo '</div>';
		}				
	}
	// Sinon on affiche un message d'erreur (liaison)
	else
	{
		echo 'La liaison au serveur n\'a pas pu être effectué';
	}

	// On termine la connection au serveur
	ldap_close($ds);
}
// Sinon on affiche un message d'erreur (connection)
else
{
	echo "Connexion au serveur LDAP impossible";
}
include ('bot.php');
?>