<?php
include('header.php');
if(!isset($_SESSION['connected']))
{
}
else
{
	if(!isset($_POST['nom']))
	{	
		include('templates/forms/delUserForm.php');
	}
	else
	{
		//Si on reçoit les données (on del l'user)
		include('ldap/delUserLDAP.php');
	}
}
?>
