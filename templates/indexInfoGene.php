<div class="gene">
<?php
if($_SESSION['statut'] == 'admin') echo '<span class="icon-add-group" title="Ajouter un nouveau groupe" onclick="getAddGroupPage();"></span>';


echo '<form name="supportform" method="post" action=""><input type="hidden" name="supporttype" /><a href="javascript:getsupport(\'groupe\')">Groupe';

if($infoNbGroupes['count'] == 0) echo ' : 0';
elseif ($infoNbGroupes['count'] > 1)
{
	echo 's</a> : '.$infoNbGroupes['count'];
}
else
{
	echo '</a> : '.$infoNbGroupes['count'];
}
echo ' | <a href="javascript:getsupport(\'users\')">';
if($infoNbUsers['count'] == 0) echo ' Utilisateur</a></form> : 0';
elseif ($infoNbUsers['count'] > 1)
{
	echo ' Utilisateurs</a></form> : '.$infoNbUsers['count'];
}
else
{
	echo ' Utilisateur</a></form> : '.$infoNbUsers['count'];
}

if($_SESSION['statut'] == 'admin')
echo '<span class="icon-add-user" title="Ajouter un nouvel utilisateur" onclick="getAddUserPage();"></span>';


?>
</div>
<div class="accordion">
    <dl>
