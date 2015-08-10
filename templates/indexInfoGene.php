<div class="gene">
<?php
echo '<a href=""><img src="'.$CONSTANTES['cheminImages'].'addGroupe.svg" style="margin-right:5px;margin-top:5px;background:white;-moz-border-radius: 13px;-webkit-border-radius: 13px;border-radius: 13px;" alt="Ajouter un groupe" title="Ajouter un groupe" width="25px"/></a>';
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
if($infoUsers['count'] == 0) echo ' Utilisateur</a></form> : 0';
elseif ($infoUsers['count'] > 1)
{
	echo ' Utilisateurs</a></form> : '.$infoUsers['count'];
}
else
{
	echo ' Utilisateur</a></form> : '.$infoUsers['count'];
}
?>

<a href="">
<?php echo '<img src="'.$CONSTANTES['cheminImages'].'addUser.svg" style="margin-left:5px;margin-top:5px;background:white;-moz-border-radius: 13px;-webkit-border-radius: 13px;border-radius: 13px;" title="Ajouter un utilisateur" alt="Ajouter un utilisateur" width="25px"/>';
?>
</a>
</div>
<div class="accordion">
    <dl>
