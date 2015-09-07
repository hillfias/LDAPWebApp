<?php
echo '<div class="user">';
echo '<p>';
/*
if(strpos($membresGroupe[0]['owner'][0],$infoUsers[0]['sn'][0]))
{
	echo '<img class="imageprofil" src="'.$CONSTANTES['cheminImages'].'admin.svg" width="25px"; />';
}
else */
echo '<img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[0]['jpegphoto'][0]).'" width="25px"; />';
echo '<strong ';
if($_SESSION['username'] == $infoUsers[0]['cn'][0] || $_SESSION['statut'] == 'admin')
echo 'onclick="getModUserPage(\''.$infoUsers[0]['cn'][0].'\');" style="cursor:pointer;"';
echo '>'.$infoUsers[0]['givenname'][0].' '.$infoUsers[0]['sn'][0].'</strong>';
if($_SESSION['statut'] == 'admin')
{
	echo '<a href="" class="right" onclick="deleteUser(\''.$infoUsers[0]['cn'][0].'\')"><img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" title="Supprimer l\'utilisateur" alt="Supprimer l\'utilisateur" width="15px" /></a>';
	if(!in_array($infoUsers[0]['cn'][0],$membresAdmin[0]['memberuid'])) echo '<a href="" class="right icon-add-adminRights" title="Donner les droits admin" onclick="giveAdminRights(\''.$infoUsers[0]['cn'][0].'\'); return false;"></a>';
}
echo '</p>';	
echo '</div>';
?>