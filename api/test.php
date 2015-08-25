<!--
<h3 class="center">Ajouter un nouvel utilisateur</h3>
<form action="" method="post" name="form" class="spe" enctype="multipart/form-data">

<br />

<label for="fichier">Image de profil :</label>
<input type="file" name="fichier" id="fichier">
<div id="progress"></div>
<br />

<input type="submit" value="Envoyer"/>
</form>
-->
<?php
php_ini_loaded_file();
phpinfo();
echo "Vous avez PHP ".phpversion()."<br />";
$gd_info = gd_info();
if(!$gd_info)
	die("<br />La librairie GD n'est pas installée !");

echo "<br />Vous avez GD {$gd_info['GD Version']}";
/*
$CONSTANTES['cheminImages'] = "theme/images/";

if(!empty($_FILES['fichier']['type']))
{
	if ($_FILES['fichier']['error'] > 0)
	{
		echo $_FILES['fichier']['error'];
		exit();
	}
	
	$content_dir = 'tmp/'; 
	$tmp_file = $_FILES['fichier']['tmp_name'];
	$type_file = $_FILES['fichier']['type'];
	
	// On vérifie que l'image a bien été uploadé temporairement, si ce n'est pas le cas on redirige vers le formulaire avec un message d'erreur et les champs pré-remplis
	if( !is_uploaded_file($tmp_file) )
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$erreurImage = "Une erreur s'est produite : l'image est introuvable. Nous vous prions de nous excuser pour le désagrément.";
		echo $erreurImage;
		exit();
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	}
	else echo '<br />fichier uploadé de manière temporaire sur le serveur à l\'adresse : '.$tmp_file.'<br />Ce qui donne <img src="../'.$tmp_file.'" />';
	
	
	// on vérifie maintenant l'extension
	if( !strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png') )
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$erreurImage = "Le fichier n'est pas une image.";
		echo $erreurImage;
		exit();
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	}
	else echo '<br />bonne extension ! ('.$type_file.')';

	// On renomme le fichier pour éviter les conflits
	$type = substr(strrchr($type_file, "/"), 1);
	$name_file = md5(rand().rand().rand().rand()).'.'.$type;
	
	echo '<br />Plus précisément : '.$type;
	echo '<br />Nom officiel : '.$name_file;

	// On vérifie que personne ne veut uploader un script en le faisant passer pour une image
	if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $_FILES['fichier']['name']) )
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$erreurImage = "Nom de fichier non valide.";
		echo $erreurImage;
		exit();
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	}
	echo '<br />Nom valide.';
	// on copie le fichier dans le dossier de destination temporaire
	if( !move_uploaded_file($tmp_file, '../'.$content_dir . $name_file) )
	{
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$erreurImage = "Impossible de copier le fichier dans le dossier temporaire : $content_dir. Nous vous prions de nous excuser pour le désagrément.";
		echo $erreurImage;
		exit();
		// VUE ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	}
	else echo '<br />Le fichier a été déplacé vers ../'.$content_dir . $name_file;
	echo '<br />La on voit si un image a bien été posté avec le chemin vers cette dernière : <img src="../'.$content_dir . $name_file.'" />';
	$img = '../'.$content_dir . $name_file;
	echo '<br />Type: '.$type;
	if(strtolower($type) == "jpeg") echo '<br />youpiiiiiiiiiiiiiiiiiiiiiiiiiiii'; 
	if ($type == 'jpg' || $type == 'jpeg')
	{
		echo '<br />l\'image est de type jpeg donc on la miniaturise :';
		echo '<br />gdinfo : '.var_dump($gd_info);
		$ImageNews = getimagesize($img);
		echo '<br />ImageNews : '.$ImageNews;
		$ImageChoisie = imagecreatefromjpeg($img);
		echo '<br />'.$ImageChoisie;
		$TailleImageChoisie = getimagesize($img);
		echo '<br />'.$TailleImageChoisie;
		$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

		$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
		echo '<br />'.$NouvelleHauteur;
		if($NouvelleHauteur > 128)
		{
			$NouvelleHauteur = 128;
			$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
		}
		echo '<br />'.$NouvelleLargeur;
		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");
		echo '<br />'.$NouvelleImage;
		imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);
	
		imagedestroy($ImageChoisie);

		imagejpeg($NouvelleImage , $img, 100);
		echo '<br />'.$img;
		echo '<br />'.$NouvelleImage;
	}/*
	elseif ($type == 'png')
	{
		$ImageNews = getimagesize($img);
		$ImageChoisie = imagecreatefrompng($img);

		$TailleImageChoisie = getimagesize($img);

		$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

		$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
		
		if($NouvelleHauteur > 128)
		{
			$NouvelleHauteur = 128;
			$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
		}

		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");

		imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

		imagedestroy($ImageChoisie);

		imagepng($NouvelleImage , $img, 9);
	}
	elseif ($type == 'gif')
	{
		$ImageNews = getimagesize($img);
		$ImageChoisie = imagecreatefromgif($img);

		$TailleImageChoisie = getimagesize($img);

		$NouvelleLargeur = 128; //Largeur choisie à 128 px mais modifiable

		$NouvelleHauteur = ( ($TailleImageChoisie[1] * (($NouvelleLargeur)/$TailleImageChoisie[0])) );
		
		if($NouvelleHauteur > 128)
		{
			$NouvelleHauteur = 128;
			$NouvelleLargeur = ( ($TailleImageChoisie[0] * (($NouvelleHauteur)/$TailleImageChoisie[1])) );
		}

		$NouvelleImage = imagecreatetruecolor($NouvelleLargeur , $NouvelleHauteur) or die ("Erreur lors de la création de miniature.");

		imagecopyresampled($NouvelleImage , $ImageChoisie  , 0,0, 0,0, $NouvelleLargeur, $NouvelleHauteur, $TailleImageChoisie[0],$TailleImageChoisie[1]);

		imagedestroy($ImageChoisie);

		imagegif($NouvelleImage , $img);
	}
}		
// Sinon, si aucune image n'a été posté, on prend le chemin de celle par défaut
else
{
	$img = '../'.$CONSTANTES['cheminImages']."profil.png";
}
echo 'La on voit si un image a bien été posté avec le chemin vers cette dernière : <img src="'.$img.'" />';
// On récupère l'image
echo 'Maintenant on essaye de récupérer les données images';
$fp=fopen($img,"r"); 
var_dump($fp);
if(!$fp)
{
	echo $img.'<br />La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
	exit();
}
echo 'blablablablalblablablabablbalabl';
$image=fread($fp,filesize($img)); 
if(!$image)
{
	echo 'La tentative de récupération de données contenues dans un fichier a échoué. Nous vous prions de nous excuser pour le désagrément.';
	exit();
}
fclose($fp);
echo '<br />On a réussi à lire l\'image <img src="data:image/jpeg;base64,'.(base64_encode($image)).'" />';
echo '<br />On supprime l\'image !';
// Si une image a été uploadé, on la supprime

if(!empty($content_dir))
{
	if(!unlink($img))
	{
		echo 'Une erreur est survenue lors de la tentative de suppression de l\'image que vous avez uploadé. Un message sera envoyé à l\'administrateur.';
		exit();
	}
}
*/
