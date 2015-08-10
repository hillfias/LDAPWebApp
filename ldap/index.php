<?php
function connectionLDAP()
{
	$ds=ldap_connect("80.240.136.144","389");  
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
	// On affiche un message d'erreur si échec connection
	if(!$ds)
	{
		echo '<p class="center red">Connexion au serveur LDAP impossible. Nous vous prions de nous excuser pour le désagrément.</p>';
		exit();
	}
	// On effectue la liaison avec le serveur
	$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
	// Si la liaison n'est  pas effectué
	if(!$r)
	{
		echo '<p class="center red">La liaison au serveur LDAP n\'a pas pu être effectué. Nous vous prions de nous excuser pour le désagrément.</p>';
		kill($ds);
		exit();
	}
	return $ds;
}
function kill($ds)
{
	// On termine la connection au serveur
	ldap_close($ds);
}
function search($ds,$filter,$attributes)
{
	// Nous allons commencer par afficher des informations de bases concernant le domaine auquel on est connecté et son administrateur
	$dn = "dc=rBOX,dc=lan"; 			//Domaine
	$filtre="($filter)";				//Filtre de recherche
	$sr=ldap_search($ds, $dn, $filtre,$attributes);	//On effectue la recherche
	if(!$sr)
	{
		echo '<p class="center red">Le serveur LDAP n\'a pas pu effectuer la recherche . Nous vous prions de nous excuser pour le désagrément.</p>';
		kill($ds);
		exit();
	}

	$info = ldap_get_entries($ds, $sr);	//On récupère les résultats
	if(!$info)
	{
		echo '<p class="center red">Le serveur LDAP n\'a pas pu récupérer les résultats de la recherche . Nous vous prions de nous excuser pour le désagrément.</p>';
		kill($ds);
		exit();
	}
	
	return $info;
}