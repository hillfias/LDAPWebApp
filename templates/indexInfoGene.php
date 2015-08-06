<div class="gene">
<?php
echo '<a href=""><img src="'.$CONSTANTES['cheminImages'].'boutonPlus.png"  alt="Ajouter un groupe" title="Ajouter un groupe" width="15px"/></a> Groupe';

if($infoGroupes['count'] == 0) echo ' : 0';
elseif ($infoGroupes['count'] > 1)
{
	echo 's : '.$infoGroupes['count'];
}
else
{
	echo ' : '.$infoGroupes['count'];
}
echo ' |';
if($infoUsers['count'] == 0) echo ' Utilisateur : 0';
elseif ($infoUsers['count'] > 1)
{
	echo ' Utilisateurs : '.$infoUsers['count'];
}
else
{
	echo ' Utilisateur : '.$infoUsers['count'];
}
?>

<a href="">
<?php echo '<img src="'.$CONSTANTES['cheminImages'].'boutonPlus.png" title="Ajouter un utilisateur" alt="Ajouter un utilisateur" width="15px"/>';
?>
</a>
</div>
