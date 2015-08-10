<?php




	
		
	
	
	
		

		echo '<p><img class="imageprofil" src="data:image/jpeg;base64,'.base64_encode($infoUsers[0]['jpegphoto'][0]).'" width="25px" />';
		echo "\n";
		echo '<strong>'.$infoUsers[0]['givenname'][0].' '.$infoUsers[0]['sn'][0].'</strong>';
		echo "\n";
		if($nbgroup > 0) echo '<a href="" class="right"><img src="'.$CONSTANTES['cheminImages'].'removeUser.svg" title="Enlever du groupe" alt="Enlever du groupe" width="15px"/></a>';
		echo "\n";
		
		echo '</p>';	



?>