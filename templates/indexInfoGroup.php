<?php
echo '<dt>';
if($nbgroup > 0 )
echo '<a href="bla" class="deleteGroupe"><img src="'.$CONSTANTES['cheminImages'].'deleteGroupe.svg" alt="Supprimer Groupe" title="Supprimer Groupe" width="25px"/></a>';
else
echo '<div id="spaceImage"></div>';
echo '<a href="bla" class="deleteGroupe"><img src="'.$CONSTANTES['cheminImages'].'addAdmin.svg" alt="Ajouter un administrateur pour ce groupe" title="Ajouter un administrateur pour ce groupe" width="25px"/></a>';


echo '<a class="accordionTitle" href="#" id="title'.$infoNbGroupes[$nbgroup]['cn'][0].'" onclick="getUsersForGroup(\''.$infoNbGroupes[$nbgroup]['cn'][0].'\');" >';
if($nbgroup > 0 ) echo '<span href="yoyo" title="Modifier ce groupe">';
echo '<strong>'.$infoNbGroupes[$nbgroup]['cn'][0].'</strong>';
if($nbgroup > 0 ) echo '</span>';
echo '</a>';


echo '</dt>';
echo "\n";
echo '<dd class="accordionItem accordionItemCollapsed" id="'.$infoNbGroupes[$nbgroup]['cn'][0].'">';
?>