 <!--class="large-3 columns"-->
			<!-- ici tu met la liste des éléments(utilisateur/groupes + bouton nouveau ?) :
			<div data-room-id="501" id="room-button501" class="room side-bar-link">
				<div class="element-image"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNPygCSDF8PVmoNV2RMqvs-nGEKRqEBcbQzYAbQ31K742ibWVonQ"></div>
				64x6
				
				<div class="element-activity"><div class="element-last-activity">14:55</div></div>
					je crois que ça ça te servira à rien
				
				<div class="element-text">
					<div class="element-title">Prenom nom</div>
					<div class="element-preview">useless info</div></div></div>
			 -->




<?php

echo '<div class="group">';
echo '<p><img src="'.$CONSTANTES['cheminImages'].'iconeGroupe.png" alt="Groupe" title="groupe" width="25px"/><strong>'.$infoGroupes[$nbgroup]['cn'][0].'</strong>'; // (Nom de domaine complet : <em>'.ldap_dn2ufn($infoGroupes[$nbgroup]['dn']).'</em>)';
echo '<br /><img src="'.$CONSTANTES['cheminImages'].'adminGroupe.png" alt="Administrateur" title="Administrateur" width="25px"/><strong>'.$infoAdmin[0]['givenname'][0].' '.$infoAdmin[0]['sn'][0].'</strong></p>';

// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
for($nbusers=0;$nbusers<$infoUsers['count'];$nbusers++)
{
	// Si l'utilisateur appartient au groupe
	if(in_array($infoUsers[$nbusers]['cn'][0],$infoGroupes[$nbgroup]['memberuid']))
	{
		echo '<div class="user">';
		echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[$nbusers]['jpegphoto'][0]).'" width="25px"; />';
		echo '<strong>'.$infoUsers[$nbusers]['givenname'][0].' '.$infoUsers[$nbusers]['sn'][0].'</strong>';
		//echo '<br />Adresse mail : '.$infoUsers[$nbusers]['mail'][0];
		//echo '<br />Pseudo : '.$infoUsers[$nbusers]['cn'][0].'<br />';
		/*
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
		
		// S'il appartient à d'autres groupes (secondaires), on les affiches
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
		*/
		echo '</p></div>';	
		
	}

}
echo '</div>';
?>