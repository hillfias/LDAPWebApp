<?php
echo '<p>';
$true = false;

echo '<img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[0]['jpegphoto'][0]).'" width="25px" />';
if(strpos($membresGroupe[0]['owner'][0],$membresGroupe[0]['memberuid'][$nbusers]))
{
	echo '<img  src="'.$CONSTANTES['cheminImages'].'admin.svg" width="20px" style="position:relative;left:-25px;margin-right:-20px;" />';
	$true = true;
}
echo "\n";
echo '<strong>'.$infoUsers[0]['givenname'][0].' '.$infoUsers[0]['sn'][0].'</strong>';
echo "\n";
if($nbgroup > 0) echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'removeUser.svg" title="Enlever du groupe" alt="Enlever du groupe" width="15px"/></a>';
else // echo '<a href="" class="right" onclick="deleteUser(\''.$infoUsers[0]['cn'][0].'\'); return false;"><img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" title="Supprimer l\'utilisateur" alt="Supprimer l\'utilisateur" width="15px"/></a>';
echo "\n";
if($true) echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'removeAdmin.svg" title="Enlever l\'admin du groupe" alt="Enlever l\'admin du groupe" width="15px"/></a>';

echo '</p>';	
?>