<?php
echo '<dt>';
if($nbgroup > 0 )
echo '<a href="#" class="deleteGroupe icon-delete-group"></a>';
else
echo '<div id="spaceImage"></div>';
echo '<a href="#" class="deleteGroupe icon-add-admin"></a>';


echo '<a class="accordionTitle" href="#" id="title'.$infoNbGroupes[$nbgroup]['cn'][0].'" onclick="getUsersForGroup(\''.$infoNbGroupes[$nbgroup]['cn'][0].'\');" >';
if($nbgroup > 0 ) echo '<span href="yoyo" title="Modifier ce groupe">';
echo '<strong>'.$infoNbGroupes[$nbgroup]['cn'][0].'</strong>';
if($nbgroup > 0 ) echo '</span>';
echo '</a>';


echo '</dt>';
echo "\n";
echo '<dd class="accordionItem accordionItemCollapsed" id="'.$infoNbGroupes[$nbgroup]['cn'][0].'">';
?>