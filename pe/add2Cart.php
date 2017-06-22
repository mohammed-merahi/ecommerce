<?php
    session_start();
    
    if( !isset($_SESSION['articles_count']) ){
        $_SESSION['articles_count'] = 0;    
        $_SESSION['articles_real'] = 0;    
    }
    
    $codeart = $_POST['codeart'];
    if( !isset( $_POST['qte'] ) ){
        $qte = 1;
    }else {
        $qte = $_POST['qte'];
    }

    //search codeart in the current cart
    $exists = false;
    for( $i=1;$i<=$_SESSION['articles_count'];$i++ ){
        if( $_SESSION['article_' . $i] == $_POST['codeart'] ){
            $exists = true;
            break;
        }
    }

    if( !$exists ){
        $_SESSION['articles_count'] += 1;
        $_SESSION['articles_real'] += 1;
        $_SESSION["article_" . $_SESSION['articles_count'] ] = $codeart;
        $_SESSION["qte_"     . $_SESSION['articles_count'] ] = $qte;
        $_SESSION["qte_"     . $codeart ] = $qte;
    }else{
        $_SESSION["qte_"     . $i ]         = $qte;    
        $_SESSION["qte_"     . $codeart ]   = $qte;    
    }

?>