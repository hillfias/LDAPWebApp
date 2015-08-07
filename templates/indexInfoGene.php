<div class="gene">
<?php
echo '<a href=""><img src="'.$CONSTANTES['cheminImages'].'boutonPlus.png"  alt="Ajouter un groupe" title="Ajouter un groupe" width="15px"/></a>';
echo '<form name="supportform" method="post" action=""><input type="hidden" name="supporttype" /><a href="javascript:getsupport(\'groupe\')">Groupe';

if($infoGroupes['count'] == 0) echo ' : 0';
elseif ($infoGroupes['count'] > 1)
{
	echo 's</a> : '.$infoGroupes['count'];
}
else
{
	echo '</a> : '.$infoGroupes['count'];
}
echo ' | <a href="javascript:getsupport(\'users\')">';
if($infoUsers['count'] == 0) echo ' Utilisateur</a> : 0';
elseif ($infoUsers['count'] > 1)
{
	echo ' Utilisateurs</a> : '.$infoUsers['count'];
}
else
{
	echo ' Utilisateur</a> : '.$infoUsers['count'];
}
?>

<a href="">
<?php echo '<img src="'.$CONSTANTES['cheminImages'].'boutonPlus.png" title="Ajouter un utilisateur" alt="Ajouter un utilisateur" width="15px"/>';
?>
</a>
</div>
<div class="accordion">
    <dl>
