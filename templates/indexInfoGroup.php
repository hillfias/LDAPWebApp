<?php
echo '<dt>';
if($nbgroup > 1 && $_SESSION['statut'] == 'admin')
echo '<a href="" onclick="deleteGroup(\''.$infoNbGroupes[$nbgroup]['cn'][0].'\'); return false;" title="Supprimer le groupe" class="deleteGroupe icon-delete-group"></a>';
else
echo '<div id="spaceImage"></div>';
if($nbgroup > 1 && ($_SESSION['statut'] == 'admin' || ($_SESSION['statut'] == 'adminGroupe' && in_array($infoNbGroupes[$nbgroup]['cn'][0],$_SESSION['groupesAdmin'])))) echo '<a href="#" class="deleteGroupe icon-add-admin" title="Ajouter un administrateur pour ce groupe" onclick="getAddAdminPage(\''.$infoNbGroupes[$nbgroup]['cn'][0].'\');"></a>';


echo '<a class="accordionTitle" href="#" title="Afficher la liste des utilisateurs de ce groupe" id="title'.$infoNbGroupes[$nbgroup]['cn'][0].'" onclick="getUsersForGroup(\''.$infoNbGroupes[$nbgroup]['cn'][0].'\');" >';
if($nbgroup > 1 && ($_SESSION['statut'] == 'admin' || ($_SESSION['statut'] == 'adminGroupe' && in_array($infoNbGroupes[$nbgroup]['cn'][0],$_SESSION['groupesAdmin'])))) echo '<span onclick="alert(\'yo !\');" title="Modifier ce groupe">';
echo '<strong>'.$infoNbGroupes[$nbgroup]['cn'][0].'</strong>';
if($nbgroup > 1 && ($_SESSION['statut'] == 'admin' || ($_SESSION['statut'] == 'adminGroupe' && in_array($infoNbGroupes[$nbgroup]['cn'][0],$_SESSION['groupesAdmin'])))) echo '</span>';
echo '</a>';


echo '</dt>';
echo "\n";
echo '<dd class="accordionItem accordionItemCollapsed" id="'.$infoNbGroupes[$nbgroup]['cn'][0].'">';
?>