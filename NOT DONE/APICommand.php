<?php
if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
	switch($_POST["action"]) { 
	/**
	 *  Switch case to manage depending on actiontype
	 * can be newUser, getUserInfo, delUser,
	 * 
	 */ 
	 
	/**
	 * create new user
	 * @param : surName : surname of the creating user [required]
	 * @param : firstName : firstname of the creating user [required]
	 * @param : password : password for the crating user [required]
	 * @param : passwordConfirm : confirming password [required]
	 * @param : mail : e-mail of the creating user [optional]
	 *					* @param : photo : picture of the creating user [optional]
	 * @param : groups : a list of all the gidNumber where the being created user is member of [optional, add to the list [500] ] 
	 *
	 * @return : a confirmation message (JSON)
	 * */
	case "newUser": ; break;


	/**
	 * get user infos
	 * @param : uidNumber : uidNumber of the user we want to get infos[required]
	 * @param : args : a list of all the arguments we want [required]
	 * 				can contain :
	 * 				sn :		 surname
	 * 				gn :		 given name
	 *				mail :		 e-mail
	 * 				groups :	 all gidNumber he is member of
	 * 				admin :		 all gidNumber he is admin of 
	 * 				managers :	 all uidNumber of the admin of the groups he is member of
	 * 				managed :	 all uidNumber of the member of the groups he is admin of
	 *				
	 * @return : a JSON object with all the datas
	 * */
	case "getUserInfo": ; break;



	/**
	 * change user infos
	 * @param : uidNumber : uidNumber of the user we want to changerequired]
	 * @param : args : a JSON object with the architecure "key" : value of all the arguments we want to change [required]
	 * 				key can be :
	 * 				sn :		 surname  			!!! CHANGE DN !!!
	 * 				gn :		 given name			!!! CHANGE DN !!!
	 *				mail :		 e-mail
	 * 				groups :	 all gidNumber he is member of
	 * 				admin :		 all gidNumber he is admin of 
	 *				
	 * @return : a JSON object with all the datas
	 * */
	case "changeUserInfo": ; break;



	/**
	 * delete user
	 * @param : uidNumber : uidNumber of the user we want to get infos[required]
	 * @return : confirmation message
	 * */
	case "delUser": ; break;
	
	case "newGroup": ; break;
	case "getGroupInfo": ; break;
	case "delGroup": ; break;
	
	case "addUserGroup": ; break;
	case "removeUserGroup": ; break;
	case "changeAdminGroup": ; break;
	}
}

function message(){

/*
 * STATUS :
 * OOO is SUCCESS (the operation has been completely done) : 000 is "ok".
 * OXX is WARNING (the operation has been completely done, but there is something, or not completely but almost) : 099 is "ok, but memory warning",
 * 1XX is WARNING(the operation has not been completely done but almost) :	110 is "user created, but the mail is invalid"
 * rest is ERROR (the operation has not been done at all) : 201 is "the request has not correct argument", 244 : "passwords do not match" 330:"the LDAPuser already exists" , 410 is "you don't have permission to delete the user"
 * 
 */
$return["STATUS"]=0;
$return["Message"]="hi";

echo json_encode($return);
}
?>
