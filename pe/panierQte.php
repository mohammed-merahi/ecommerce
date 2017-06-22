<?php
    session_start();

    $codeart = $_GET["codeart"];
    if( isset( $_SESSION["qte_" . $codeart] ) ){
        echo $_SESSION["qte_" . $codeart];
    }else{
        echo "1";
    }
?>