<?php
echo '<div class="centerblock">';
echo '<p>Bienvenue sur le domaine '.ldap_dn2ufn($info[0]['dn']).' administré par <strong>'.$info[0]['cn'][0].'</strong> : <em>'.$info[0]['description'][0].'</em> (Groupe';

if($infoGroupes['count'] == 0) echo ' : 0';
elseif ($infoGroupes['count'] > 1)
{
	echo 's : '.$infoGroupes['count'];
}
else
{
	echo ' : '.$infoGroupes['count'];
}

if($infoUsers['count'] == 0) echo ', Utilisateur : 0).';
elseif ($infoUsers['count'] > 1)
{
	echo ', Utilisateurs : '.$infoUsers['count'].').';
}
else
{
	echo ', Utilisateur : '.$infoUsers['count'].').';
}
?>