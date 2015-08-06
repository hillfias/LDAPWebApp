<?php
session_start();

// On détruit toutes les variables de session
$_SESSION = array();

// On efface le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// On détruit la session.
session_destroy();

header('Location: ./'); 
?>