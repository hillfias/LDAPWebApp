<?php

echo '<div class="group">';
// 
// <img src="'.$CONSTANTES['cheminImages'].'boutonRemove.png" title="Supprimer le groupe" alt="Supprimer le groupe" width="15px"/> <a href="" class="right"></a>
echo '<strong>'.$infoGroupes[$nbgroup]['cn'][0].'</strong>'; // (Nom de domaine complet : <em>'.ldap_dn2ufn($infoGroupes[$nbgroup]['dn']).'</em>)';
// echo '<br /><img src="'.$CONSTANTES['cheminImages'].'adminGroupe.png" alt="Administrateur" title="Administrateur" width="25px"/><strong>'.$infoAdmin[0]['givenname'][0].' '.$infoAdmin[0]['sn'][0].'</strong><a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'change.png" title="Changer l\'administrateur" alt="Changer l\'administrateur" width="15px"/></a></p>';

// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
for($nbusers=0;$nbusers<$infoUsers['count'];$nbusers++)
{
	// Si l'utilisateur appartient au groupe
	if(in_array($infoUsers[$nbusers]['cn'][0],$infoGroupes[$nbgroup]['memberuid']))
	{
		echo '<div class="user">';
		echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[$nbusers]['jpegphoto'][0]).'" width="25px"; />';
		echo '<strong>'.$infoUsers[$nbusers]['givenname'][0].' '.$infoUsers[$nbusers]['sn'][0].'</strong>';
		echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" title="Supprimer l\'utilisateur" alt="Supprimer l\'utilisateur" width="15px" /></a>';
		
		echo '</p>';	
		echo '</div>';
	}

}

echo '</div>';
$nbgroup = $infoGroupes['count'];
?>