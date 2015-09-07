<?php
include('../ldap/index.php');
$ds = connectionLDAP();
// to do : modifier utilisateur et mettre a jour le userid dans tous les groupes auxquels il appartient
$dn = "cn=wfuchs,ou=users,dc=rBOX,dc=lan";

$dn2 = "cn=wfo";
$res = ldap_rename($ds,$dn,$dn2,null, true);
if(!$res) echo ldap_error($ds);