<?php
	echo '<dt><a href="bla" class="deleteGroupe"><img src="'.$CONSTANTES['cheminImages'].'deleteGroupe.svg" alt="Supprimer Groupe" title="Supprimer Groupe" width="25px"/></a><a class="accordionTitle" href="#">';
	if($nbgroup > 0 ) echo '<span href="yoyo" title="Modifier ce groupe">';
	echo '<strong>'.$infoNbGroupes[$nbgroup]['cn'][0].'</strong>';
	if($nbgroup > 0 ) echo '</span>';
	echo '</a></dt>';
	echo "\n";
	echo '<dd class="accordionItem accordionItemCollapsed">';
?>