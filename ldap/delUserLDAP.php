<?php
		$name = $_POST['nom'];
		$ds = ldap_connect($CONSTANTES['adresseIp'], $CONSTANTES['port']);  // on se connecte au serveur LDAP distant
		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
		if ($ds)
		{
			echo 'test de connection : succès';
			$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
			echo '<br />liaison avec le serveur effectuée';

			// On prépare les données du profil à ajouter

			 $dn="cn=$name,ou=users,dc=rBOX,dc=lan";
			 

			 // Supression de l'entrée de l'annuaire
			 $r=ldap_delete($ds, $dn);

			
			
			echo '<br />L\'utilisateur a été correctement supprimé !';
			
			ldap_close($ds);
		}
?>
