<?php
session_start();

// Si on est pas à la racine on récupère le nom du fichier
if(preg_match('#^/.*/(.*)\.php$#',$_SERVER['REQUEST_URI'],$nomfichier))
{
	$nomfichier = $nomfichier[1];
}
// Sinon on indique qu'on est à la racine
else $nomfichier = 'index';

// Constantes qui serviront au cours du script.
// -------------------------------------------
$CONSTANTES['adresseIp'] = "80.240.136.144";
$CONSTANTES['port'] = "389";
$CONSTANTES['cheminModele'] = "ldap/";
$CONSTANTES['cheminVue'] = "templates/";
$CONSTANTES['cheminImages'] = "theme/images/";
$CONSTANTES['cheminStylesheets'] = "theme/stylesheets/";
$CONSTANTES['cheminData'] = "data/";
$CONSTANTES['cheminJs'] = "theme/javascript/";
$CONSTANTES['nomFichier'] = $nomfichier;
// -------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>rAdmin</title>

<link rel="stylesheet" href="<?php echo $CONSTANTES['cheminStylesheets']; ?>foundation.min.css">
 <link rel="stylesheet" href="<?php echo $CONSTANTES['cheminStylesheets']; ?>background.css"> 
<link rel="stylesheet" href="<?php echo $CONSTANTES['cheminStylesheets']; ?>style.css">
<link rel="stylesheet" href="<?php echo $CONSTANTES['cheminStylesheets']; ?>font.css">
<!-- les includes js -->
</head>
<body>
<nav class="top-bar" data-topbar>
	<section class="top-bar-section">
		<ul class="left">
			<li class="divider"></li>
			<li class="has-dropdown">
				<a class="active" href="#"><span class="icon icon-admin"></span></a>
				<ul class="dropdown">
					<li><label>Your services</label></li>
					<li><a href="#"><span class="icon-git"></span>Git</a></li>
					<li><a href="#"><span class="icon-chat"></span>Chat</a></li>
					<li class="divider"></li>
                	<li><a href="#"><label>Others Services</label></a></li>
					<li><a href="#"><span class="icon-files"></span>Files</a></li>
                	<li><a href="#"><span class="icon-clients"></span>Clients</a></li>
               		<li class="divider"></li>
            	</ul>
            </li>
            <li class="divider"></li>
          	<li><a href="#"><span class="icon icon-settings"></span></a></li>
		</ul>
		<ul class="right menu-logs">
            		<li class="divider"></li>
					<li><a>Connecting</a></li>
            		<li class="divider"></li>
					<li><a class="logout-button" href="deco.php"><span class="icon icon-logout"></span></a></li>
        </ul>
	</section>
</nav>

		<?php 
		
		
		// Si on est pas connecté, qu'on est pas à l'accueil et qu'on est pas en train d'essayer de se connecter, on coupe l'accès à la page
		if(!(!empty($_SESSION['connected']) AND $_SESSION['connected'] == 'Js%up£e58rP0w4;_a') AND $nomfichier != 'index')
		{
			header('Location: ./');
		}
		// Sinon si on est pas connecté mais qu'on est à la racine ou qu'on essaye de se connecter on ne coupe pas l'accès à la page mais on affiche un menu restreint
		elseif($nomfichier == 'index' AND !isset($_SESSION['connected']))
		{
			// include('menutopdeco.php');
		}
		// sinon on est connecté et on a le droit au menu complet pour visiter toutes les pages
		else
		{
			// include('menutop.php');
			// TO DO: restreindre certaines pages en fonction des droits utilisateurs
		}
		?>