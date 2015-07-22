<?php
$ds = ldap_connect("80.240.136.144", 389);  // on suppose que le serveur LDAP est sur le serveur local
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
if ($ds) {

echo 'test de connection : succès';
$r = ldap_bind($ds, "cn=admin,dc=rBOX,dc=lan", "root");
echo '<br />binding effectué';

	// On prépare les données de ton profil à ajouter
	
	$info["entry"]["dn"] = "cn=oripart,ou=users,dc=reactor,dc=lan";
	$info["entry"]["controls"] = array();
	$info["entry"]["givenName"] = "Olivier";
	$info["entry"]["gidNumber"] = "502";
	$info["entry"]["homeDirectory"] = "/home/users/oripart";
	$info["entry"]["sn"] = "Ripart";
	$info["entry"]["objectClass"][0] = "inetOrgPerson";
	$info["entry"]["objectClass"][1] = "posixAccount";
	$info["entry"]["objectClass"][2] = "top";
	$info["entry"]["userPassword"] = "{MD5}jGTJ6SGWvN12k1kSohZIvA==";
	$info["entry"]["uidNumber"] = "1000";
	$info["entry"]["uid"] = "oripart";
	$info["entry"]["cn"] = "oripart";
	$info["entry"]["mail"] = "olivier.ripart@live.fr";
	
    // On ajoute les données au dossier
    $r = ldap_add($ds, "ou=users,dc=rBOX,dc=lan", $info);

    ldap_close($ds);
} else {
    echo "Impossible de se connecter au serveur LDAP";
}

// ci-dessous les infos que tu m'as données

/*
{"dn":"","code":20,"name":"AttributeOrValueExistsError","message":"modify/add: mail: value #0 already exists"}
entry: {"dn":"cn=oripart,ou=users,dc=reactor,dc=lan","controls":[],"givenName":"Olivier","gidNumber":"502","homeDirectory":"/home/users/oripart","sn":"Ripart","objectClass": ["inetOrgPerson","posixAccount","top"],"userPassword":"{MD5}jGTJ6SGWvN12k1kSohZIvA==","uidNumber":"1000","uid":"oripart","cn":"oripart","mail":"olivier.ripart@live.fr"}

{"dn":"cn=all,ou=groups,dc=reactor,dc=lan","controls":[],"gidNumber":"501","cn":"all","objectClass":["posixGroup","top"],"memberUid": ["oripart","valves","llancelin"]}
*/
?>