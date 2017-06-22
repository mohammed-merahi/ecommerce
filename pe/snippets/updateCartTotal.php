<?php
    session_start();    
    $_SESSION['total_panier'] = $_POST['total'];
    $_SESSION['total_ht']     = $_POST['total_ht'];
    $_SESSION['total_tva']    = $_POST['total_tva'];
?>