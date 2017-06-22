<?php
    session_start();
    $codeart = ( trim($_POST['codeart']) );

    //trouver 'i' pour cet article
    $trouv = false;
    $j = 1;
    while( (!$trouv) and ($j < $_SESSION['articles_count']) ){
        if( $_SESSION['article_' . $j] == $codeart ){
            $trouv = true;
            break;
        }
        $j++;
    }

    //$_SESSION["article_" . $_SESSION['articles_count'] ] = 0;
    //$_SESSION["qte_"     . $_SESSION['articles_count'] ] = 0;
    $_SESSION["article_" . $j ]         = '0';
    $_SESSION["qte_"     . $j ]         = 0;
    $_SESSION["qte_"     . $codeart ]   = 0;

    $_SESSION['articles_real'] -= 1;
    
?>