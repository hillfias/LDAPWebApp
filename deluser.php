<?php
include('header.php');
if(!isset($_SESSION['connected']))
{
}
else
{
	if(!empty($_POST['nom']))
	{
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
	}
	else
	{
	?>
	<h3 class="center">Supprimer un utilisateur</h3>

	<form method="post" action="" class="spe">

		<fieldset>
		<legend>Supprimer un utilisateur :</legend>

		   <label for="nom">Diminutif (première lettre du prénom suivis du nom tout en minuscules sans espaces)</label>

		   <input type="text" name="nom" id="nom" value="Ex : jsmith"/>
		   <br />
		  
		   <input type="submit" value="Supprimer" />
		
		   

		</fieldset>
	</form>
	<?php
	}
}
?>