<?php
    session_start();
    $codeart = $_POST['codeart'];
    $qte     = $_POST['qte'];

    $_SESSION["qte_" . $codeart ] = $qte;

    //updating qte_i ...
    
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

    $_SESSION["qte_" . $j ] = $_SESSION["qte_" . $codeart ];

?>