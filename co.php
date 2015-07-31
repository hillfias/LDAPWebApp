<?php
include ('header.php');
if(!isset($_POST['mdp']))
{
// Si rien n'a été envoyé on affiche le formulaire de connection
?>
<form method="post" action="" class="spe">

	<fieldset>
    <legend>S'authentifier</legend>

		<label for="nom">Pseudo : (première lettre du prénom suivis du nom, sans espaces)</label>

		<input type="text" name="nom" id="nom" value="Ex: jsmith pour John Smith"/>
		<br />
		
		<label for="mdp">Mot de passe :</label>

		<input type="password" name="mdp" id="mdp" />
	   
		<br />
		<input type="submit" value="S'authentifier" />

    </fieldset>
	</form>
<?php
}
else
{
	// On se connecte au serveur LDAP
	$ds=ldap_connect("80.240.136.144","389");  
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
	// Si on est bien arrivé à se connecté
	if($ds)
	{
		// On effectue la liaison avec le serveur
		$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
		// Si la liaison est effectué
		if($r)
		{
			$dn = "dc=rBOX,dc=lan"; 			//Domaine
			$filtre='(cn=admin)';				//Filtre de recherche
			$sr=ldap_search($ds, $dn, $filtre);	//On effectue la recherche
			$info = ldap_get_entries($ds, $sr);	//On récupère les résultats
			
			if($_POST['mdp'] == 'root' AND $_POST['nom']== 'admin') // to do : récupérer le vrai mdp admin sur le ldap pour vérification
			{
				$_SESSION['connected'] = 'Js%up£e58rP0w4;_a';
				$_SESSION ['statut'] = 'admin';
				header('Location: ./'); 
			}
			else
			{
				// formulaire avec message d'erreur
				?>
				<form method="post" action="" class="spe">
				<fieldset>
				<legend>S'authentifier</legend>

					<label for="nom">Pseudo</label>

					<input type="text" name="nom" id="nom" value="cn=admin,dc=rBOX,dc=lan"/>
					<br />

					<p class="red">Erreur lors de la saisie du mot de passe.</p>
					<label for="mdp">Mot de passe :</label>

					<input type="password" name="mdp" id="mdp" />
				   
					<br />
					<input type="submit" value="S'authentifier" />

				</fieldset>
				</form>
				<?php
			}
		}
		else
		{
			echo 'La liaison au serveur n\'a pas pu être effectué';
		}
	}
	else
	{
		echo "Connexion au serveur LDAP impossible";
	}
}
?>