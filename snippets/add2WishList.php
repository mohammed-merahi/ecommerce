<?php
    session_start();
    $codeart = $_POST['codeart'];

    if( !isset($_SESSION['wishlist']) or trim($_SESSION['wishlist']) == "" ){
        $_SESSION['wishlist']  = $codeart;
    }else{ 
        if( strpos($_SESSION['wishlist'], $codeart) !== true ){
            $_SESSION['wishlist'] .= "," . $codeart;
        }        
    }    
?>