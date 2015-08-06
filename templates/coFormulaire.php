<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <title>rAdmin - Log-in</title>

    <link rel="stylesheet" href="<?php echo $CONSTANTES['cheminStylesheets'];?>background.css" media="screen" type="text/css" />

</head>

<body>

  <div class="page-content content-login">
    <h1>Log-in</h1><br>
    <?php     
	if(!empty($_SERVER['HTTP_REFERER']) AND preg_match('#/.*/(.*)\.php$#',$_SERVER['HTTP_REFERER'],$nomfichier))
	{
		$nomfichier = $nomfichier[1];
	}
	else $nomfichier = false;
	
    if(!empty($erreur)) echo $erreur;
	elseif(!empty($nomfichier) AND $nomfichier == 'accueil') echo 'Vous avez été déconnecté(e) avec succès.';
	?>
  <form action="" method="post">
    <input type="text" name="nom" placeholder="Username" <?php if(!empty($login)) echo 'value="'.$login.'"'; ?>>
    <input type="password" name="mdp" placeholder="Password">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>

  <div class="login-help">
   <a href="#">Forgot Password</a>
  </div>
</div>
</body>
</html>