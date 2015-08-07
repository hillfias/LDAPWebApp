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

// echo '<div class="group">';
// <img src="'.$CONSTANTES['cheminImages'].'iconeGroupe.png" alt="Groupe" title="groupe" width="25px"/>
// <img src="'.$CONSTANTES['cheminImages'].'boutonRemove.png" title="Supprimer le groupe" alt="Supprimer le groupe" width="15px"/> <a href="" class="right"></a>
echo '<dt><a class="accordionTitle" href="#"><strong>'.$infoGroupes[$nbgroup]['cn'][0].'</strong></a></dt>'; // (Nom de domaine complet : <em>'.ldap_dn2ufn($infoGroupes[$nbgroup]['dn']).'</em>)';
echo "\n";
echo '<dd class="accordionItem accordionItemCollapsed">';
// On affiche maintenant les utilisateurs qui appartiennent au groupe avec leurs données respectives 
for($nbusers=0;$nbusers<$infoUsers['count'];$nbusers++)
{
	
	// Si l'utilisateur appartient au groupe
	if(in_array($infoUsers[$nbusers]['cn'][0],$infoGroupes[$nbgroup]['memberuid']))
	{
		// echo '<div class="user">';
		echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[$nbusers]['jpegphoto'][0]).'" width="25px" />';
		echo "\n";
		echo '<strong>'.$infoUsers[$nbusers]['givenname'][0].' '.$infoUsers[$nbusers]['sn'][0].'</strong>';
		echo "\n";
		if($nbgroup == 0) echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'boutonRemove.png" title="Supprimer l\'utilisateur" alt="Supprimer l\'utilisateur" width="15px" /></a>';
		else echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'kick2.png" title="Enlever du groupe" alt="Enlever du groupe" width="15px"/></a>';
		echo "\n";
		
		echo '</p>';	
		
	}

}
echo '</dd>';
// echo '</div>';
?>