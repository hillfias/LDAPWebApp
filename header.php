<?php
session_start();
// Constantes qui serviront au cours du script.
// -------------------------------------------
$CONSTANTES['adresseIp'] = "80.240.136.144";
$CONSTANTES['port'] = "389";
// -------------------------------------------

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bienvenue sur le serveur LDAP <?php echo '[<span class="red">'.$CONSTANTES['adresseIp'].':'.$CONSTANTES['port'].'</span>]'; ?></title> <!-- On récupère simplement l'adresse ip du serveur et le port sur lequel on se connecte pour savoir de quoi on parle. -->
    <meta name="description" content="Ajouter un nouvel utilisateur au serveur LDAP">
    <link rel="stylesheet" href="classic.css"> 
  </head>
  <body>
  <h1 class="center">Bienvenue sur le serveur LDAP <?php echo '[<span class="red">'.$CONSTANTES['adresseIp'].':'.$CONSTANTES['port'].'</span>]'; ?> !
  <?php
  if(isset($_SESSION['connected']))
  {
  ?>
  <a href="deco.php"><img src="cross.png" alt="se deconnecter" title="se deconnecter" width="20px"/></a>
  <?php 
  }
  ?>
  
  </h1>


<?php 
if(!empty($_POST['mdp']) AND !isset($_SESSION['connected']))
{
	if($_POST['mdp'] == 'root' AND $_POST['nom']== 'cn=admin,dc=rBOX,dc=lan')
	{
		include('menutop.php');
		$_SESSION['connected'] = 'superpowaa';
	}
	else
	{
		// formulaire avec message d'erreur
?>
	<form method="post" action="" class="spe">

	<fieldset>
    <legend>S'authentifier</legend>

       <label for="nom">Domaine</label>

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
else if(!isset($_SESSION['connected']))
{
?>
	<form method="post" action="" class="spe">

	<fieldset>
    <legend>S'authentifier</legend>

       <label for="nom">Domaine</label>

       <input type="text" name="nom" id="nom" value="cn=admin,dc=rBOX,dc=lan"/>
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
	include('menutop.php');
}
?>
<br />
</body>
</html>