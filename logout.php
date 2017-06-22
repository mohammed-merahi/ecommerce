<?php
	session_start();

    unset($_COOKIE['ID']);              setcookie('ID', null, -1, '/');
    session_destroy();
	
    header("Location: connexion");exit;    
	
?>