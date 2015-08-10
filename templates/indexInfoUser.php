<?php
echo '<div class="user">';
echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[0]['jpegphoto'][0]).'" width="25px"; />';
echo '<strong>'.$infoUsers[0]['givenname'][0].' '.$infoUsers[0]['sn'][0].'</strong>';
echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'deleteUser.svg" title="Supprimer l\'utilisateur" alt="Supprimer l\'utilisateur" width="15px" /></a>';

echo '</p>';	
echo '</div>';
?>