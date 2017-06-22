<?php
    session_start();

    $codeart = $_POST["codeart"];
    if( isset( $_SESSION["qte_" . $codeart] ) ){
        echo $_SESSION["qte_" . $codeart];
    }else{
        echo "0";
    }
?>