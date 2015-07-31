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
		<title>Bienvenue !</title>
		<link rel="stylesheet" href="classic.css"> 
	</head>
	<body>
		<h1 class="center">Bienvenue sur le serveur LDAP <?php echo '[<span class="red">'.$CONSTANTES['adresseIp'].':'.$CONSTANTES['port'].'</span>]'; ?> !
		<!-- Si l'utilisateur est connecté, on lui affiche une petite croix à côté du titre de la page pour pouvoir se déconnecter -->
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
		// Si on est pas à la racine on récupère le nom du fichier
		if(preg_match('#^/.*/(.*)\.php$#',$_SERVER['REQUEST_URI'],$res))
		{
			$res1 = $res[1];
		}
		// Sinon on indique qu'on est à la racine
		else $res1 = 'index';
		
		// Si on est pas connecté, qu'on est pas à la racine et qu'on est pas en train d'essayer de se connecter, on coupe l'accès à la page
		if(!(!empty($_SESSION['connected']) AND $_SESSION['connected'] == 'Js%up£e58rP0w4;_a') AND $res1 != 'co' AND $res1 != 'index' AND $_SERVER['REQUEST_URI'] != '' )
		{
			include('menutopdeco.php');
			
			echo '<p class="center">Connectez-vous pour accéder aux options proposées.</p>';	
			exit();
		}
		// Sinon si on est pas connecté mais qu'on est à la racine ou qu'on essaye de se connecter on ne coupe pas l'accès à la page mais on affiche un menu restreint
		elseif(($res1 == 'co' OR $res1 == 'index' OR $_SERVER['REQUEST_URI'] == '') AND !isset($_SESSION['connected']))
		{
			include('menutopdeco.php');
		}
		// sinon on est connecté et on a le droit au menu complet pour visiter toutes les pages
		else
		{
			include('menutop.php');
		}
		?>