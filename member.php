<?php
include('header.php');
$ds=ldap_connect("80.240.136.144","389");  // On suppose que le serveur LDAP est sur cet hote
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
if ($ds) {

 $r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");

 $dn = "dc=rBOX,dc=lan";

 $filtre='(cn=*)';



 $sr=ldap_search($ds, $dn, $filtre);

 $info = ldap_get_entries($ds, $sr);
 echo '<div class="centerblock">';
 for($i=0;$i<$info['count'];$i++)
 {
	if(!empty($info[$i]['givenname']))
	{
		echo '<strong>'.$info[$i]['givenname'][0].' '.$info[$i]['sn'][0].'</strong>';
		echo '<br />';
		echo '<p style="margin-left:10%;">Diminutif : '.$info[$i]['cn'][0].'<br />';
		
		echo 'Groupe : '.$info[$i]['gidnumber'][0];
		echo '<br />';
		echo 'Dossier utilisateur : '.$info[$i]['homedirectory'][0];
		echo '<br />';
		echo 'Identifiant utilisateur unique : '.$info[$i]['uidnumber'][0];
		echo '</p><br />';
	}
 }
  echo '</div>';

 ldap_close($ds);

} else {
 echo "Connexion au serveur LDAP impossible";

}

?>