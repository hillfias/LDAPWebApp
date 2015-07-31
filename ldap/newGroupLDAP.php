<?php 
		if(!empty($_POST['nom']) AND !empty($_POST['adgr']))
		{
			// ...on vérifie le genre des données nom et diminutif de l'admin du groupe
			if(preg_match("#^[a-zA-Z]+$#",$_POST['nom']) AND preg_match("#^[a-zA-Z-]+$#",$_POST['adgr']))
			{

				// On traite les données : nom et diminutif de l'admin du groupe
				$nom = $_POST['nom'];
				$adgr = $_POST['adgr'];
				
				
				
				
				// Si une nouvelle valeur pour le gid a été transmise, on met à jour le nombre MAIS on n'incrémentera PAS à partir de celui-là dorénavant
				if(!empty($_POST['gid']) AND preg_match("#^[0-9]{1,}$#",$_POST['gid']))
				{
					$gid = $_POST['gid'];
				}
				else $gid = $CONSTANTES['gid'];
				
				
				
				// On a maintenant toutes nos variables saines et on va vérifier que l'utilisateur admin est bien un utilisateur :
				// TO DO
				
				
				$ds = ldap_connect($CONSTANTES['adresseIp'], $CONSTANTES['port']);  // on se connecte au serveur LDAP distant
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				if ($ds)
				{

					echo 'test de connection : succès';
					$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
					echo '<br />liaison avec le serveur effectuée';

					// On prépare les données du profil à ajouter

					$info["cn"] = "$nom";
					$info["gidNumber"] = "$gid";
					$info["objectClass"][0] = "posixGroup";
					$info["objectClass"][1] = "top";
					$info["memberUid"] = "$adgr";

					// On ajoute les données au dossier
					$r = ldap_add($ds, "cn=$nom,ou=groups,dc=rBOX,dc=lan", $info);
					
					echo '<br />Les données ont été correctement ajoutées !';
					
					ldap_close($ds);
					
					// On incrémente automatiquement le gid
					$mf = (int) file_get_contents("gid.txt");
					$mf++;
					$monfichier2 = fopen('gid.txt', 'w+');
					fseek($monfichier2, 0); // On remet le curseur au début du fichier
					fputs($monfichier2, $mf); // On écrit le nouveau uid
					fclose($monfichier2);

				}
				else
				{
					echo "Impossible de se connecter au serveur LDAP";
				}
				
			}
		}
?>
